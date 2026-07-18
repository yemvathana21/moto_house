<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FlashDealResource\Pages\CreateFlashDeal;
use App\Filament\Resources\FlashDealResource\Pages\EditFlashDeal;
use App\Filament\Resources\FlashDealResource\Pages\ListFlashDeals;
use App\Filament\Resources\FlashDealResource\Schemas\FlashDealForm;
use App\Filament\Resources\FlashDealResource\Tables\FlashDealsTable;
use App\Models\FlashDeal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class FlashDealResource extends Resource
{
    protected static ?string $model = FlashDeal::class;

    protected static string | UnitEnum | null $navigationGroup = 'Shop Management';
    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedBolt;
    protected static ?string $navigationLabel = 'Flash Deals';
    protected static ?string $modelLabel = 'Flash Deal';
    protected static ?string $modelLabelPlural = 'Flash Deals';

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return FlashDealForm::configure($schema);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return FlashDealsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFlashDeals::route('/'),
            'create' => CreateFlashDeal::route('/create'),
            'edit' => EditFlashDeal::route('/{record}/edit'),
        ];
    }
}
