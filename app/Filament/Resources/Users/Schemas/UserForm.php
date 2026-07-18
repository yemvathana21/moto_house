<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->required()
                    ->email()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->password()
                    ->required(fn ($livewire) => $livewire instanceof \App\Filament\Resources\Users\Pages\CreateUser)
                    ->minLength(8)
                    ->same('passwordConfirmation')
                    ->dehydrated(fn ($state) => filled($state)),
                TextInput::make('passwordConfirmation')
                    ->password()
                    ->label('Confirm Password')
                    ->dehydrated(false),
                Section::make('Roles')
                    ->schema([
                        Select::make('roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->options(fn () => Role::pluck('name', 'id')),
                    ]),
                FileUpload::make('profile_photo')
                    ->image()
                    ->directory('profile-photos')
                    ->columnSpanFull(),
            ]);
    }
}
