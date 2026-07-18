<?php

namespace App\Filament\Resources\FlashDealResource\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FlashDealForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->rows(3),
                DateTimePicker::make('starts_at')
                    ->required(),
                DateTimePicker::make('ends_at')
                    ->required()
                    ->afterOrEqual('starts_at'),
                Toggle::make('is_active')
                    ->default(true),
                Repeater::make('products')
                    ->relationship()
                    ->schema([
                        Select::make('product_id')
                            ->label('Product')
                            ->options(fn () => \App\Models\Product::pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        TextInput::make('flash_price')
                            ->required()
                            ->numeric()
                            ->prefix('$'),
                        TextInput::make('stock_limit')
                            ->required()
                            ->numeric()
                            ->default(50),
                    ])
                    ->columns(3)
                    ->defaultItems(1),
            ]);
    }
}
