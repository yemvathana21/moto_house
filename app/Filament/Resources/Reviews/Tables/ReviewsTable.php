<?php

namespace App\Filament\Resources\Reviews\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\Review;

class ReviewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer_name')
                    ->searchable(),
                TextColumn::make('rating')
                    ->badge()
                    ->color(fn (int $state): string => match ($state) {
                        5 => 'success',
                        4 => 'info',
                        3 => 'warning',
                        default => 'danger',
                    }),
                TextColumn::make('comment')
                    ->limit(50)
                    ->toggleable(),
                // IconColumn::make('is_approved')
                //     ->boolean()
                //     ->sortable(),
                TextColumn::make('created_at')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(fn (Review $record) => $record->update(['is_approved' => true]))
                    ->visible(fn (Review $record) => !$record->is_approved && !$record->parent_id)
                    ->requiresConfirmation(),
                Action::make('reply')
                    ->label('Reply')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->color('gray')
                    ->modalHeading('Reply to Review')
                    ->modalButton('Submit Reply')
                    ->form([
                        Textarea::make('comment')
                            ->label('Your Reply')
                            ->required()
                            ->maxLength(2000),
                    ])
                    ->action(function (array $data, Review $record) {
                        $record->replies()->create([
                            'product_id' => $record->product_id,
                            'customer_name' => 'Store',
                            'customer_email' => auth()->user()->email,
                            'rating' => 0,
                            'comment' => $data['comment'],
                            'is_approved' => true,
                        ]);
                    })
                    ->visible(fn (Review $record) => !$record->parent_id),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
