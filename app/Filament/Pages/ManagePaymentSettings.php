<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManagePaymentSettings extends Page
{
    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedCreditCard;

    protected string $view = 'filament.pages.manage-settings';

    protected static string | UnitEnum | null $navigationGroup = 'Settings';

    protected static ?string $title = 'Payment Settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'payment_method' => Setting::getValue('payment_method', 'cash'),
            'stripe_key' => Setting::getValue('stripe_key', ''),
            'stripe_secret' => Setting::getValue('stripe_secret', ''),
            'paypal_client_id' => Setting::getValue('paypal_client_id', ''),
            'paypal_secret' => Setting::getValue('paypal_secret', ''),
            'currency' => Setting::getValue('currency', 'USD'),
            'currency_position' => Setting::getValue('currency_position', 'before'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Payment Methods')
                    ->columns(2)
                    ->schema([
                        Select::make('payment_method')
                            ->options([
                                'cash' => 'Cash on Delivery',
                                'stripe' => 'Stripe',
                                'paypal' => 'PayPal',
                                'all' => 'All Methods',
                            ])
                            ->required(),
                        TextInput::make('stripe_key')
                            ->label('Stripe Publishable Key')
                            ->visible(fn ($get) => in_array($get('payment_method'), ['stripe', 'all'])),
                        TextInput::make('stripe_secret')
                            ->label('Stripe Secret Key')
                            ->password()
                            ->visible(fn ($get) => in_array($get('payment_method'), ['stripe', 'all'])),
                        TextInput::make('paypal_client_id')
                            ->label('PayPal Client ID')
                            ->visible(fn ($get) => in_array($get('payment_method'), ['paypal', 'all'])),
                        TextInput::make('paypal_secret')
                            ->label('PayPal Secret')
                            ->password()
                            ->visible(fn ($get) => in_array($get('payment_method'), ['paypal', 'all'])),
                    ]),
                Section::make('Currency Settings')
                    ->columns(2)
                    ->schema([
                        TextInput::make('currency')
                            ->label('Currency Code')
                            ->default('USD'),
                        Select::make('currency_position')
                            ->options(['before' => '$100', 'after' => '100$'])
                            ->default('before'),
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
            ->title('Payment settings saved successfully')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
