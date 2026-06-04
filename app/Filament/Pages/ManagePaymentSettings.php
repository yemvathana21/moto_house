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
            'bakong_merchant_name' => Setting::getValue('bakong_merchant_name', 'Moto House'),
            'bakong_merchant_id' => Setting::getValue('bakong_merchant_id', ''),
            'bakong_bakong_id' => Setting::getValue('bakong_bakong_id', ''),
            'bakong_bank' => Setting::getValue('bakong_bank', 'Bakong'),
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
                                'khqr' => 'Bakong KHQR Pay',
                                'all' => 'COD + Bakong KHQR',
                            ])
                            ->required(),
                    ]),

                Section::make('Bakong KHQR Settings')
                    ->description('Enter your Bakong account details to generate KHQR codes for payment. Customers can scan the QR code with any Bakong-supported banking app.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('bakong_merchant_name')
                            ->label('Account Holder Name')
                            ->placeholder('e.g. YEM VATHANA')
                            ->helperText('The name on your bank account')
                            ->required(),
                        TextInput::make('bakong_merchant_id')
                            ->label('Account ID')
                            ->placeholder('e.g. 000123456')
                            ->helperText('Your Bakong account ID or bank account number')
                            ->required(),
                        TextInput::make('bakong_bakong_id')
                            ->label('Bakong KHQR ID (optional)')
                            ->placeholder('e.g. bakong@id')
                            ->helperText('If using a dedicated Bakong KHQR ID'),
                        TextInput::make('bakong_bank')
                            ->label('Bank Name')
                            ->default('Bakong')
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
