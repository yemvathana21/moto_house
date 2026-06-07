<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Select::make('parent_id')
                    ->label('Parent Category')
                    ->options(function (?Category $record = null) {
                        $query = Category::where('is_active', true);
                        if ($record && $record->exists) {
                            $excludeIds = [$record->id];
                            $excludeIds = array_merge($excludeIds, $record->children()->pluck('id')->toArray());
                            $query->whereNotIn('id', $excludeIds);
                        }
                        return $query->pluck('name', 'id');
                    })
                    ->nullable(),
                RichEditor::make('description')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('categories'),
                Toggle::make('is_active')
                    ->default(true),
                TextInput::make('id')
                    ->label('ID')
                    ->disabled()
                    ->dehydrated(false),
            ]);
    }
}
