<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order Information')
                    ->columns(2)
                    ->schema([
                        TextInput::make('order_number')
                            ->required()
                            ->maxLength(255)
                            ->default(fn () => \App\Models\Order::generateOrderNumber())
                            ->disabled()
                            ->dehydrated(),
                        Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'shipped' => 'Shipped',
                                'delivered' => 'Delivered',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->default('pending'),
                        Select::make('payment_method')
                            ->options([
                                'cash' => 'Cash',
                                'bank_transfer' => 'Bank Transfer',
                                'credit_card' => 'Credit Card',
                                'e_wallet' => 'E-Wallet',
                            ]),
                        Select::make('payment_status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'failed' => 'Failed',
                                'refunded' => 'Refunded',
                            ])
                            ->default('pending'),
                    ]),
                Section::make('Order Items')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Select::make('product_id')
                                    ->relationship('product', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->afterStateUpdated(function ($set, $state) {
                                        $product = \App\Models\Product::find($state);
                                        if ($product) {
                                            $set('product_name', $product->name);
                                            $set('unit_price', $product->price);
                                        }
                                    })
                                    ->reactive()
                                    ->columnSpan(3),
                                TextInput::make('product_name')
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->columnSpan(3),
                                TextInput::make('unit_price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('$')
                                    ->columnSpan(2),
                                TextInput::make('quantity')
                                    ->required()
                                    ->numeric()
                                    ->minValue(1)
                                    ->default(1)
                                    ->reactive()
                                    ->afterStateUpdated(function ($set, $get) {
                                        $qty = (int) $get('quantity');
                                        $price = (float) $get('unit_price');
                                        $set('subtotal', $qty * $price);
                                    })
                                    ->columnSpan(1),
                                TextInput::make('subtotal')
                                    ->required()
                                    ->numeric()
                                    ->prefix('$')
                                    ->disabled()
                                    ->dehydrated()
                                    ->columnSpan(2),
                            ])
                            ->columns(11)
                            ->defaultItems(1)
                            ->reorderable(false),
                    ]),
                Section::make('Totals')
                    ->columns(4)
                    ->schema([
                        TextInput::make('subtotal')
                            ->required()
                            ->numeric()
                            ->prefix('$'),
                        TextInput::make('tax')
                            ->numeric()
                            ->prefix('$')
                            ->default(0),
                        TextInput::make('shipping')
                            ->numeric()
                            ->prefix('$')
                            ->default(0),
                        TextInput::make('discount')
                            ->numeric()
                            ->prefix('$')
                            ->default(0),
                        TextInput::make('total')
                            ->required()
                            ->numeric()
                            ->prefix('$'),
                    ]),
                Section::make('Shipping Information')
                    ->columns(2)
                    ->schema([
                        Textarea::make('shipping_address')
                            ->columnSpanFull(),
                        TextInput::make('shipping_city'),
                        TextInput::make('shipping_state'),
                        TextInput::make('shipping_postal_code'),
                        TextInput::make('shipping_country'),
                    ]),
                Section::make('Notes')
                    ->schema([
                        Textarea::make('notes')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
