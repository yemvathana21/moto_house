<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use UnitEnum;
use Filament\Pages\Page;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected string $view = 'filament.pages.manage-settings';

    protected static string | UnitEnum | null $navigationGroup = 'Settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'site_name' => Setting::getValue('site_name', 'Moto House'),
            'site_description' => Setting::getValue('site_description', 'Premium Motorcycle Accessories'),
            'contact_email' => Setting::getValue('contact_email', 'yemvathana86@gmail.com'),
            'contact_phone' => Setting::getValue('contact_phone', '+855 978 537 707'),
            'address' => Setting::getValue('address', ''),
            'currency' => Setting::getValue('currency', 'USD'),
            'tax_rate' => Setting::getValue('tax_rate', '0'),
            'logo' => Setting::getValue('logo', ''),
        ]);
    }

    /**
     * Configures the form layout container using standard Filament forms engine
     */
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General')
                    ->columns(2)
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Site Name')
                            ->required(),
                        TextInput::make('site_description')
                            ->label('Site Description'),
                        TextInput::make('contact_email')
                            ->label('Contact Email')
                            ->email(),
                        TextInput::make('contact_phone')
                            ->label('Contact Phone'),
                        Textarea::make('address')
                            ->columnSpanFull(),
                    ]),
                Section::make('Store Settings')
                    ->columns(2)
                    ->schema([
                        TextInput::make('currency')
                            ->label('Currency')
                            ->default('USD'),
                        TextInput::make('tax_rate')
                            ->label('Tax Rate (%)')
                            ->numeric()
                            ->default(0),
                        FileUpload::make('logo')
                            ->label('Site Logo')
                            ->image()
                            ->disk('public')
                            ->directory('settings'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        foreach ($state as $key => $value) {
            Setting::setValue($key, $value);
        }

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }
}