<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Actions\Action;

class ManagePaymentSettings extends Page implements HasForms
{
    use InteractsWithForms;

    // លុបការប្រកាសអថេរ static $navigationIcon និង static $navigationGroup ចោល ដើម្បីកុំឱ្យទាស់ Typehint
    protected string $view = 'filament.pages.manage-payment-settings';

    protected static ?string $title = 'Payment Settings';

    public ?array $data = [];

    // ប្តូរមកប្រើមុខងារ Method ជំនួសវិញ (សុវត្ថិភាពខ្ពស់បំផុតសម្រាប់ PHP 8.4)
    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-credit-card';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Settings';
    }

    public function mount(): void
    {
        $this->form->fill([
            'payment_method' => Setting::getValue('payment_method', 'all'),
            'aba_merchant_name' => Setting::getValue('aba_merchant_name', 'Moto House'),
            'aba_merchant_id' => Setting::getValue('aba_merchant_id', ''),
            'aba_bakong_id' => Setting::getValue('aba_bakong_id', ''),
            'aba_bank' => Setting::getValue('aba_bank', 'ABA Bank'),
            'currency' => Setting::getValue('currency', 'USD'),
            'currency_position' => Setting::getValue('currency_position', 'before'),
        ]);
    }

    public function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form
            ->schema([
                Section::make('Payment Methods')
                    ->columns(2)
                    ->schema([
                        Select::make('payment_method')
                            ->options([
                                'cod' => 'Cash on Delivery',
                                'khqr' => 'ABA KHQR Pay',
                                'all' => 'COD + ABA KHQR',
                            ])
                            ->required(),
                    ]),

                Section::make('ABA KHQR Settings')
                    ->description('Enter your ABA Bank account details to generate KHQR codes for payment. Customers will scan the QR code with their ABA Mobile app.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('aba_merchant_name')
                            ->label('Account Holder Name')
                            ->placeholder('e.g. YEM VATHANA')
                            ->helperText('The name on your ABA bank account')
                            ->required(),
                        TextInput::make('aba_merchant_id')
                            ->label('ABA Account ID')
                            ->placeholder('e.g. 000123456')
                            ->helperText('Your ABA account number')
                            ->required(),
                        TextInput::make('aba_bakong_id')
                            ->label('Bakong KHQR ID (optional)')
                            ->placeholder('e.g. bakong@id')
                            ->helperText('If using Bakong instead of ABA account ID'),
                        TextInput::make('aba_bank')
                            ->label('Bank Name')
                            ->default('ABA Bank')
                            ->helperText('Displayed on the payment page'),
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

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->submit('form')
                ->color('warning'),
        ];
    }

    public function save(): void
    {
        $state = $this->form->getState();

        foreach ($state as $key => $value) {
            Setting::setValue($key, $value);
        }

        Notification::make()
            ->title('Payment settings saved successfully')
            ->success()
            ->send();
    }
}
