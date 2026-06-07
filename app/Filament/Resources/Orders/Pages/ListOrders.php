<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Exports\OrderExporter;
use App\Filament\Imports\OrderImporter;
use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            ExportAction::make()
                ->exporter(OrderExporter::class)
                ->label('Export CSV')
                ->icon('heroicon-o-arrow-down-tray'),
            ImportAction::make()
                ->importer(OrderImporter::class)
                ->label('Import CSV')
                ->icon('heroicon-o-arrow-up-tray'),
        ];
    }
}
