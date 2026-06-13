<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VercelDeploy extends Command
{
    protected $signature = 'vercel:deploy {--push : Automatically commit and push to GitHub}';

    protected $description = 'Sync images, export database, and upload to Vercel Blob';

    public function handle(): int
    {
        $this->info('🚀 Starting Vercel deployment...');
        $this->newLine();

        // Step 1: Sync images
        $this->info('Step 1/3: Syncing images to Vercel Blob...');
        try {
            $exitCode = Artisan::call('storage:sync-blob', [], $this->getOutput());
            if ($exitCode !== Command::SUCCESS) {
                $this->warn('Image sync completed with warnings.');
            }
        } catch (\Exception $e) {
            $this->warn("Image sync skipped: {$e->getMessage()}");
        }
        $this->newLine();

        // Step 2: Export MySQL to SQLite
        $this->info('Step 2/3: Exporting MySQL to SQLite...');
        try {
            $this->exportDatabase();
        } catch (\Exception $e) {
            $this->error("Database export failed: {$e->getMessage()}");

            return self::FAILURE;
        }
        $this->newLine();

        // Step 3: Upload SQLite to Vercel Blob
        $this->info('Step 3/3: Uploading SQLite to Vercel Blob...');
        try {
            $this->uploadToBlob();
        } catch (\Exception $e) {
            $this->error("Upload failed: {$e->getMessage()}");

            return self::FAILURE;
        }
        $this->newLine();

        $this->info('✅ Deployment complete!');

        // Optional: git push
        if ($this->option('push')) {
            $this->newLine();
            $this->info('Pushing to GitHub...');
            try {
                $this->gitPush();
                $this->info('✅ Changes pushed to GitHub. Vercel will auto-deploy.');
            } catch (\Exception $e) {
                $this->warn("Git push skipped: {$e->getMessage()}");
            }
        } else {
            $this->newLine();
            $this->warn('Don\'t forget to commit and push to GitHub to trigger Vercel deployment.');
            $this->line('  Run: git add -A && git commit -m "deploy: sync" && git push');
        }

        return self::SUCCESS;
    }

    protected function exportDatabase(): void
    {
        $mysql = DB::connection('mysql')->getPdo();
        $mysql->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $sqlitePath = database_path('database.sqlite');
        if (file_exists($sqlitePath)) {
            unlink($sqlitePath);
        }

        $sqlite = new \PDO('sqlite:' . $sqlitePath);
        $sqlite->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $sqlite->exec('PRAGMA foreign_keys=OFF');
        $sqlite->exec('PRAGMA journal_mode=OFF');

        $skipTables = ['cache', 'cache_locks', 'jobs', 'job_batches', 'failed_jobs', 'sessions', 'password_reset_tokens', 'personal_access_tokens'];

        $allTables = $mysql->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);
        $tables = array_values(array_diff($allTables, $skipTables));

        $this->line('Found ' . count($tables) . ' tables to export');

        foreach ($tables as $table) {
            $this->line("  Exporting {$table}...");

            $stmt = $mysql->query("SHOW CREATE TABLE `{$table}`");
            $sql = $stmt->fetch(\PDO::FETCH_ASSOC)['Create Table'];

            $sql = preg_replace(
                [
                    '/\s+CHARACTER\s+SET\s+\S+/i',
                    '/\s+COLLATE\s*[= ]\s*[^\s,)]+/i',
                    '/\bENGINE\s*=\s*\S+/i',
                    '/\bDEFAULT\s+CHARSET\s*=\s*\S+/i',
                    '/\bAUTO_INCREMENT\s*=\s*\S+/i',
                    '/\bROW_FORMAT\s*=\s*\S+/i',
                    '/\bunsigned\b/i',
                    '/\bON UPDATE CURRENT_TIMESTAMP\b/i',
                    '/\bint\(\d+\)/i',
                    '/\btinyint\(\d+\)/i',
                    '/\bsmallint\(\d+\)/i',
                    '/\bbigint\(\d+\)/i',
                    '/\bvarchar\(\d+\)/i',
                    '/\bchar\(\d+\)/i',
                    '/\bdatetime\b/i',
                    '/\btimestamp\b/i',
                    '/\bdouble(?:\(\d+(?:,\d+)?\))?/i',
                    '/\bdecimal(?:\(\d+(?:,\d+)?\))?/i',
                    '/\bfloat(?:\(\d+(?:,\d+)?\))?/i',
                    '/\blongtext\b/i',
                    '/\bmediumtext\b/i',
                    '/\benum\([^)]+\)/i',
                    '/\bjson\b/i',
                    '/\s+COMMENT\s+\'[^\']*\'/',
                ],
                [
                    '', '', '', '', '', '', '', '',
                    'INTEGER', 'INTEGER', 'INTEGER', 'INTEGER',
                    'TEXT', 'TEXT', 'TEXT', 'TEXT',
                    'REAL', 'REAL', 'REAL',
                    'TEXT', 'TEXT', 'TEXT', 'TEXT', '',
                ],
                $sql
            );

            $sql = str_replace('`', '"', $sql);
            $sql = preg_replace('/\bAUTO_INCREMENT\b/i', '', $sql);
            $sql = preg_replace('/,\s*\n\s*(?:UNIQUE\s+)?(?:KEY|INDEX)\s+"[^"]*"\s*\([^)]+\)/i', '', $sql);
            $sql = preg_replace('/,\s*\n\s*CONSTRAINT\s+"[^"]*"[^,\n]*/i', '', $sql);
            $sql = preg_replace('/,\s*\)/s', ')', $sql);

            try {
                $sqlite->exec($sql);
            } catch (\PDOException $e) {
                $minimal = preg_replace(
                    '/,\s*\n\s*(?:PRIMARY\s+KEY|UNIQUE|KEY|INDEX|CONSTRAINT|FULLTEXT|FOREIGN|CHECK|REFERENCES)\s*\([^)]+\)[^,)]*\)?/i',
                    '',
                    $sql
                );
                $minimal = preg_replace('/,\s*\)/s', ')', $minimal);
                $sqlite->exec($minimal);
            }

            $rows = $mysql->query("SELECT * FROM `{$table}`")->fetchAll(\PDO::FETCH_ASSOC);
            if (empty($rows)) {
                continue;
            }

            $cols = implode(', ', array_map(fn($c) => '"' . $c . '"', array_keys($rows[0])));
            $vals = implode(', ', array_fill(0, count($rows[0]), '?'));

            $insertStmt = $sqlite->prepare("INSERT INTO \"{$table}\" ({$cols}) VALUES ({$vals})");

            foreach ($rows as $row) {
                try {
                    $insertStmt->execute(array_values($row));
                } catch (\PDOException $e) {
                    // skip problematic rows
                }
            }
        }

        $sqlite->exec('PRAGMA foreign_keys=ON');

        $size = round(filesize($sqlitePath) / 1024, 1);
        $this->info("  Done: {$size} KB");
    }

    protected function uploadToBlob(): void
    {
        $sqlitePath = database_path('database.sqlite');

        Storage::disk('vercel-blob')->write('moto-house-blob', file_get_contents($sqlitePath));

        $publicUrl = Storage::disk('vercel-blob')->url('moto-house-blob');
        $this->info("  Uploaded: {$publicUrl}");
    }

    protected function gitPush(): void
    {
        $cwd = base_path();

        $gitDir = $cwd . '/.git';
        if (!is_dir($gitDir)) {
            throw new \RuntimeException('Not a git repository');
        }

        $commands = [
            ['git', 'add', '-A'],
            ['git', 'commit', '--allow-empty', '-m', 'deploy: auto-sync ' . date('Y-m-d H:i')],
            ['git', 'push'],
        ];

        foreach ($commands as $cmd) {
            $process = new \Symfony\Component\Process\Process($cmd, $cwd);
            $process->setTimeout(30);
            $process->run(function ($type, $buffer) {
                $this->line('  ' . trim($buffer));
            });

            if (!$process->isSuccessful()) {
                $output = trim($process->getErrorOutput());
                if (str_contains($output, 'nothing to commit') || str_contains($output, 'up-to-date')) {
                    $this->line('  Nothing to commit, branch is up to date.');
                    return;
                }
                if (str_contains($output, 'nothing added')) {
                    $this->line('  No changes to commit.');
                    return;
                }
                throw new \RuntimeException("Git command failed: {$output}");
            }
        }
    }
}
