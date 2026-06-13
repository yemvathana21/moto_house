<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;

class Deploy extends Page
{
    protected string $view = 'filament.pages.deploy';

    protected static ?string $title = 'Deploy to Vercel';

    public ?string $log = null;

    public bool $running = false;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-rocket-launch';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Settings';
    }

    public function deploy(): void
    {
        $this->running = true;
        $this->log = '';

        try {
            $exitCode = Artisan::call('vercel:deploy --push');

            $this->log = Artisan::output();

            if ($exitCode === 0) {
                Notification::make()
                    ->title('Deployed successfully!')
                    ->success()
                    ->send();
            } else {
                Notification::make()
                    ->title('Deploy completed with warnings')
                    ->warning()
                    ->body('Check the log below for details.')
                    ->send();
            }
        } catch (\Exception $e) {
            $this->log .= "\nERROR: {$e->getMessage()}\n";

            Notification::make()
                ->title('Deploy failed')
                ->danger()
                ->body($e->getMessage())
                ->send();
        } finally {
            $this->running = false;
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('deploy')
                ->label('Deploy to Vercel')
                ->icon('heroicon-o-rocket-launch')
                ->color('warning')
                ->action('deploy')
                ->disabled(fn () => $this->running),
        ];
    }
}
