<?php

namespace App\Filament\Imports;

use App\Models\Customer;
use App\Models\Order;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class OrderImporter extends Importer
{
    protected static ?string $model = Order::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('order_number')
                ->requiredMapping()
                ->rules(['required', 'max:50']),
            ImportColumn::make('customer_email')
                ->label('Customer Email')
                ->rules(['email', 'max:255']),
            ImportColumn::make('status')
                ->rules(['max:50']),
            ImportColumn::make('subtotal')
                ->numeric()
                ->rules(['numeric', 'min:0']),
            ImportColumn::make('tax')
                ->numeric()
                ->rules(['numeric', 'min:0']),
            ImportColumn::make('shipping')
                ->numeric()
                ->rules(['numeric', 'min:0']),
            ImportColumn::make('discount')
                ->numeric()
                ->rules(['numeric', 'min:0']),
            ImportColumn::make('total')
                ->numeric()
                ->rules(['numeric', 'min:0']),
            ImportColumn::make('payment_method')
                ->rules(['max:50']),
            ImportColumn::make('payment_status')
                ->rules(['max:50']),
            ImportColumn::make('shipping_city')
                ->rules(['max:100']),
            ImportColumn::make('shipping_country')
                ->rules(['max:100']),
        ];
    }

    protected function resolveRecord(): ?Order
    {
        return Order::firstOrNew(['order_number' => $this->data['order_number']]);
    }

    protected function fillRecord(): void
    {
        $data = $this->data;

        if ($email = $data['customer_email'] ?? null) {
            $customer = Customer::firstOrCreate(
                ['email' => $email],
                ['name' => explode('@', $email)[0]]
            );
            $data['customer_id'] = $customer->id;
        }

        unset($data['customer_email']);

        $this->record->fill($data);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = "Your order import has completed with {$import->successful_rows} rows imported.";

        if ($failed = $import->getFailedRowsCount()) {
            $body .= " {$failed} rows failed.";
        }

        return $body;
    }
}
