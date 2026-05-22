<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Schemas\Components\Livewire;
use UnitEnum;

use Filament\Forms;
use Filament\Forms\Form;

use Filament\Pages\Page;

use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;

class ManageTheme extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedSwatch;

    protected static string | UnitEnum | null $navigationGroup = 'Settings';

    protected static ?string $title = 'Theme';

    protected string $view = 'filament.pages.manage-theme';
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'theme' => Setting::getValue('theme', 'light'),

            'primary_color' => Setting::getValue(
                'primary_color',
                '#ea580c'
            ),

            'background_color' => Setting::getValue(
                'background_color',
                '#f3f4f6'
            ),

            'glassmorphism_blur' => Setting::getValue(
                'glassmorphism_blur',
                '12'
            ),

            'glassmorphism_opacity' => Setting::getValue(
                'glassmorphism_opacity',
                '0.15'
            ),

            'sidebar_collapsed' => filter_var(
                Setting::getValue('sidebar_collapsed', false),
                FILTER_VALIDATE_BOOLEAN
            ),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('Theme Selection')
                    ->columns(2)
                    ->schema([

                        Forms\Components\Select::make('theme')
                            ->options([
                                'light' => 'Light',
                                'dark' => 'Dark',
                                'glassmorphism' => 'Glassmorphism',
                                'minimal' => 'Minimal',
                            ])
                            ->required()
                            ->live(),

                        Forms\Components\ColorPicker::make('primary_color')
                            ->required(),

                        Forms\Components\ColorPicker::make('background_color'),

                        Forms\Components\Toggle::make('sidebar_collapsed'),

                    ]),

                Forms\Components\Section::make('Glassmorphism Settings')
                    ->visible(fn ($get) => $get('theme') === 'glassmorphism')
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
        foreach ($this->form->getState() as $key => $value) {

            Setting::setValue($key, $value);
        }

        Notification::make()
            ->title('Theme saved successfully')
            ->success()
            ->send();
    }
}