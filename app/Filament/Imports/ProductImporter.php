<?php

namespace App\Filament\Imports;

use App\Models\Category;
use App\Models\Product;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ProductImporter extends Importer
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('slug')
                ->rules(['max:255']),
            ImportColumn::make('sku')
                ->rules(['max:100']),
            ImportColumn::make('brand')
                ->rules(['max:100']),
            ImportColumn::make('price')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'numeric', 'min:0']),
            ImportColumn::make('compare_price')
                ->numeric()
                ->rules(['nullable', 'numeric', 'min:0']),
            ImportColumn::make('stock_quantity')
                ->numeric()
                ->rules(['integer', 'min:0']),
            ImportColumn::make('is_active')
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('is_featured')
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('category_name')
                ->label('Category')
                ->rules(['max:255']),
            ImportColumn::make('description'),
        ];
    }

    public function resolveRecord(): ?Product
    {
        if ($sku = $this->data['sku'] ?? null) {
            return Product::firstOrNew(['sku' => $sku]);
        }

        if ($slug = $this->data['slug'] ?? null) {
            return Product::firstOrNew(['slug' => $slug]);
        }

        return new Product();
    }

    public function fillRecord(): void
    {
        $data = $this->data;

        if ($categoryName = $data['category_name'] ?? null) {
            $category = Category::firstOrCreate(['name' => $categoryName]);
            $data['category_id'] = $category->id;
        }

        unset($data['category_name']);

        $this->record->fill($data);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = "Your product import has completed with {$import->successful_rows} rows imported.";

        if ($failed = $import->getFailedRowsCount()) {
            $body .= " {$failed} rows failed.";
        }

        return $body;
    }
}
