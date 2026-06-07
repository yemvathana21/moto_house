<?php

namespace App\Filament\Exports;

use App\Models\Product;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProductExporter extends Exporter
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id'),
            ExportColumn::make('name'),
            ExportColumn::make('slug'),
            ExportColumn::make('sku'),
            ExportColumn::make('brand'),
            ExportColumn::make('category.name'),
            ExportColumn::make('price'),
            ExportColumn::make('compare_price'),
            ExportColumn::make('stock_quantity'),
            ExportColumn::make('is_active'),
            ExportColumn::make('is_featured'),
            ExportColumn::make('created_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = "Your product export has completed with {$export->successful_rows} rows.";

        if ($failed = $export->getFailedRowsCount()) {
            $body .= " {$failed} rows failed.";
        }

        return $body;
    }
}
