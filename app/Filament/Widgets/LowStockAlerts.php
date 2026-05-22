<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStockAlerts extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::where('is_active', true)
                    ->where('stock_quantity', '<', 10)
                    ->orderBy('stock_quantity')
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('brand')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('stock_quantity')
                    ->label('Stock')
                    ->numeric()
                    ->color(fn ($state) => $state < 5 ? 'danger' : 'warning')
                    ->sortable(),
                TextColumn::make('price')
                    ->money('USD'),
            ]);
    }
}
