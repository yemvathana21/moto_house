<?php

namespace App\Filament\Exports;

use App\Models\Order;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class OrderExporter extends Exporter
{
    protected static ?string $model = Order::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id'),
            ExportColumn::make('order_number'),
            ExportColumn::make('customer.name'),
            ExportColumn::make('customer.email'),
            ExportColumn::make('subtotal'),
            ExportColumn::make('tax'),
            ExportColumn::make('shipping'),
            ExportColumn::make('discount'),
            ExportColumn::make('total'),
            ExportColumn::make('status'),
            ExportColumn::make('payment_method'),
            ExportColumn::make('payment_status'),
            ExportColumn::make('shipping_city'),
            ExportColumn::make('shipping_country'),
            ExportColumn::make('created_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = "Your order export has completed with {$export->successful_rows} rows.";

        if ($failed = $export->getFailedRowsCount()) {
            $body .= " {$failed} rows failed.";
        }

        return $body;
    }
}
