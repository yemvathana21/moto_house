<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Schemas\Schema; // <--- MAKE SURE THIS TYPE IS IMPORTED
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageEmailSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected string $view = 'filament.pages.manage-email-settings';

    protected static string | UnitEnum | null $navigationGroup = 'Settings';

    protected static ?string $title = 'Email Settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'mail_driver' => Setting::getValue('mail_driver', 'log'),
            'mail_host' => Setting::getValue('mail_host', ''),
            'mail_port' => Setting::getValue('mail_port', '587'),
            'mail_username' => Setting::getValue('mail_username', ''),
            'mail_password' => Setting::getValue('mail_password', ''),
            'mail_encryption' => Setting::getValue('mail_encryption', 'tls'),
            'mail_from_address' => Setting::getValue('mail_from_address', 'noreply@motohouse.com'),
            'mail_from_name' => Setting::getValue('mail_from_name', 'Moto House'),
            'order_confirmation' => Setting::getValue('order_confirmation', 'true'),
            'order_shipped' => Setting::getValue('order_shipped', 'true'),
        ]);
    }

    /**
     * Swapped out Form arguments with Schema constraints to safely catch core components
     */
    public function form(Schema $form): Schema
    {
        return $form
            ->components([ // <--- Changed ->schema() to ->components() to align with Schema structures
                Section::make('Mail Configuration')
                    ->columns(2)
                    ->schema([
                        Select::make('mail_driver')
                            ->options([
                                'smtp' => 'SMTP',
                                'mailgun' => 'Mailgun',
                                'postmark' => 'Postmark',
                                'ses' => 'Amazon SES',
                                'sendmail' => 'Sendmail',
                                'log' => 'Log (Development)',
                            ])
                            ->required()
                            ->live(),
                        
                        TextInput::make('mail_host')
                            ->label('SMTP Host')
                            ->visible(fn ($get) => $get('data.mail_driver') === 'smtp'),
                        
                        TextInput::make('mail_port')
                            ->label('SMTP Port')
                            ->numeric()
                            ->visible(fn ($get) => $get('data.mail_driver') === 'smtp'),
                        
                        TextInput::make('mail_username')
                            ->label('SMTP Username')
                            ->visible(fn ($get) => $get('data.mail_driver') === 'smtp'),
                        
                        TextInput::make('mail_password')
                            ->label('SMTP Password')
                            ->password()
                            ->visible(fn ($get) => $get('data.mail_driver') === 'smtp'),
                        
                        Select::make('mail_encryption')
                            ->options(['tls' => 'TLS', 'ssl' => 'SSL'])
                            ->visible(fn ($get) => $get('data.mail_driver') === 'smtp'),
                    ]),

                Section::make('From Address')
                    ->columns(2)
                    ->schema([
                        TextInput::make('mail_from_address')
                            ->label('From Email')
                            ->email(),
                        TextInput::make('mail_from_name')
                            ->label('From Name'),
                    ]),

                Section::make('Notifications')
                    ->columns(2)
                    ->schema([
                        Select::make('order_confirmation')
                            ->label('Order Confirmation')
                            ->options(['true' => 'Enabled', 'false' => 'Disabled'])
                            ->default('true'),
                        Select::make('order_shipped')
                            ->label('Order Shipped')
                            ->options(['true' => 'Enabled', 'false' => 'Disabled'])
                            ->default('true'),
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
            ->title('Email settings saved successfully')
            ->success()
            ->send();
    }
}