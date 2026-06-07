<?php

namespace App\Filament\Resources\Banners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->maxLength(255),
                        TextInput::make('subtitle')
                            ->maxLength(255),
                        TextInput::make('link')
                            ->label('Link URL')
                            ->maxLength(255),
                        Select::make('position')
                            ->options([
                                'hero' => 'Hero Banner',
                                'promo' => 'Promo Bar',
                                'sidebar' => 'Sidebar',
                            ])
                            ->default('hero'),
                        TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->default(true),
                    ]),
                FileUpload::make('image')
                    ->image()
                    ->required()
                    ->disk('public')
                    ->directory('banners')
                    ->columnSpanFull(),
            ]);
    }
}
