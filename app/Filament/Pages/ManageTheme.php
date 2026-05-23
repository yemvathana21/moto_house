<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Notifications\Notification;
use App\Models\Setting;
use BackedEnum;

class ManageTheme extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-paint-brush';

    protected string $view = 'filament.pages.manage-theme';

    protected static ?string $navigationLabel = 'Manage Theme';

    protected ?string $heading = 'Theme Settings';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public ?array $data = [];

    public function mount(): void
    {
        // Load initial values from your settings queries
        $this->schema->fill([
            'theme' => Setting::where('key', 'theme')->value('value') ?? 'light',
            'primary_color' => Setting::where('key', 'primary_color')->value('value') ?? '#3b82f6',
            'background_color' => Setting::where('key', 'background_color')->value('value') ?? '#ffffff',
            'sidebar_collapsed' => (bool) (Setting::where('key', 'sidebar_collapsed')->value('value') ?? false),
            'glassmorphism_blur' => Setting::where('key', 'glassmorphism_blur')->value('value') ?? '10',
            'glassmorphism_opacity' => Setting::where('key', 'glassmorphism_opacity')->value('value') ?? '0.45',
        ]);
    }

    public function schema(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Theme Selection')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('theme')
                            ->options([
                                'light' => 'Light Theme',
                                'dark' => 'Dark Theme',
                                'glassmorphism' => 'Glassmorphism Concept',
                                'minimal' => 'Minimal Aspect',
                            ])
                            ->required()
                            ->live(),

                        Forms\Components\ColorPicker::make('primary_color')
                            ->required(),

                        Forms\Components\ColorPicker::make('background_color'),

                        Forms\Components\Toggle::make('sidebar_collapsed'),
                    ]),

                Section::make('Glassmorphism Preferences')
                    ->visible(fn ($get) => $get('data.theme') === 'glassmorphism')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('glassmorphism_blur')
                            ->numeric()
                            ->suffix('px'),

                        Forms\Components\TextInput::make('glassmorphism_opacity')
                            ->numeric()
                            ->step(0.05),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->schema->getState();

        // Persist the configurations directly into the settings database table
        foreach ($state as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        Notification::make()
            ->title('Theme updated successfully!')
            ->success()
            ->send();
    }
}