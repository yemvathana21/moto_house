<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Exports\ProductExporter;
use App\Filament\Imports\ProductImporter;
use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            ExportAction::make()
                ->exporter(ProductExporter::class)
                ->label('Export CSV')
                ->icon('heroicon-o-arrow-down-tray'),
            ImportAction::make()
                ->importer(ProductImporter::class)
                ->label('Import CSV')
                ->icon('heroicon-o-arrow-up-tray'),
        ];
    }
}
