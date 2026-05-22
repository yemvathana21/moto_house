<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Form;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use UnitEnum;
use Filament\Support\Icons\Heroicon;

class ManageSettings extends Page
{
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected string $view = 'filament.pages.manage-settings';

    protected static string | UnitEnum | null $navigationGroup = 'Settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'site_name' => Setting::getValue('site_name', 'Moto House'),
            'site_description' => Setting::getValue('site_description', 'Premium Motorcycle Accessories'),
            'contact_email' => Setting::getValue('contact_email', 'hello@motohouse.com'),
            'contact_phone' => Setting::getValue('contact_phone', '+1 234 567 890'),
            'address' => Setting::getValue('address', ''),
            'currency' => Setting::getValue('currency', 'USD'),
            'tax_rate' => Setting::getValue('tax_rate', '0'),
            'logo' => Setting::getValue('logo', ''),
        ]);
    }

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
                            ->directory('settings'),
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
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
