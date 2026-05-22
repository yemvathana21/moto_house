<?php

namespace App\Filament\Resources\Coupons\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CouponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignoreRecord: true)
                    ->uppercase(),
                Select::make('type')
                    ->options([
                        'fixed' => 'Fixed Amount',
                        'percentage' => 'Percentage',
                    ])
                    ->required(),
                TextInput::make('value')
                    ->required()
                    ->numeric()
                    ->prefix(fn ($get) => $get('type') === 'percentage' ? '%' : '$'),
                TextInput::make('min_order_amount')
                    ->numeric()
                    ->prefix('$')
                    ->helperText('Minimum order subtotal required'),
                TextInput::make('max_uses')
                    ->numeric()
                    ->label('Max Uses')
                    ->helperText('Leave empty for unlimited'),
                TextInput::make('used_count')
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->dehydrated(),
                DateTimePicker::make('starts_at')
                    ->label('Start Date'),
                DateTimePicker::make('expires_at')
                    ->label('Expiry Date'),
                Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}
