<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->description('Product name, description, and branding')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($set, $state) {
                                $set('slug', str($state)->slug());
                            }),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('brand')
                            ->maxLength(255)
                            ->placeholder('e.g. Yamaha, Honda, Ducati'),
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->nullable()
                            ->searchable(),
                        RichEditor::make('description')
                            ->columnSpanFull(),
                    ]),
                Section::make('Pricing & Inventory')
                    ->description('Price, stock, and SKU')
                    ->columns(2)
                    ->schema([
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->minValue(0),
                        TextInput::make('compare_price')
                            ->numeric()
                            ->prefix('$')
                            ->minValue(0)
                            ->label('Compare Price (was)'),
                        TextInput::make('stock_quantity')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->label('Stock Quantity'),
                        TextInput::make('sku')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->label('SKU'),
                    ]),
                Section::make('Media & Attributes')
                    ->description('Images and specifications')
                    ->schema([
                        FileUpload::make('images')
                            ->multiple()
                            ->image()
                            ->disk('public')
                            ->directory('products')
                            ->reorderable()
                            ->columnSpanFull(),
                        KeyValue::make('specifications')
                            ->keyLabel('Specification')
                            ->valueLabel('Value')
                            ->addActionLabel('Add specification')
                            ->columnSpanFull(),
                    ]),
                Section::make('Status')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        Toggle::make('is_featured')
                            ->label('Featured'),
                    ]),
            ]);
    }
}
