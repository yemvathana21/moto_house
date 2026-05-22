<?php

namespace App\Filament\Resources\Coupons\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CouponsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'percentage' ? 'info' : 'success'),
                TextColumn::make('value')
                    ->formatStateUsing(fn ($record) => $record->type === 'percentage' ? $record->value . '%' : '$' . number_format($record->value, 2))
                    ->sortable(),
                TextColumn::make('used_count')
                    ->label('Used')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('max_uses')
                    ->label('Max')
                    ->numeric()
                    ->default('∞'),
                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
