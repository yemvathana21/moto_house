<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;

class SyncImagesToVercelBlob extends Command
{
    protected $signature = 'storage:sync-blob';
    protected $description = 'Upload existing local images to Vercel Blob';

    public function handle(): int
    {
        $local = Storage::disk('public');
        $blob = Storage::disk('vercel-blob');

        $directories = ['products', 'banners', 'categories', 'settings'];

        $count = 0;
        foreach ($directories as $dir) {
            if (! $local->exists($dir)) {
                continue;
            }

            $files = $local->files($dir);
            foreach ($files as $file) {
                try {
                    $blob->write($file, $local->read($file));
                    $this->info("UPLOADED {$file}");
                    $count++;
                } catch (\Exception $e) {
                    $this->warn("FAILED {$file}: {$e->getMessage()}");
                }
            }
        }

        $this->newLine();
        $this->info("Done! {$count} files uploaded to Vercel Blob.");

        return self::SUCCESS;
    }
}
