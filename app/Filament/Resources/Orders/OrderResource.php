<?php

namespace App\Filament\Resources\Orders;

use App\Services\ABAPaywayService;
use App\Filament\Resources\Orders\Pages\CreateOrder;
use App\Filament\Resources\Orders\Pages\EditOrder;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\Schemas\OrderForm;
use App\Models\Order;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string | UnitEnum | null $navigationGroup = 'Shop Management';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;

    protected static ?string $recordTitleAttribute = 'order_number';

    public static function form(Schema $schema): Schema
    {
        return OrderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Order ID'),
                TextColumn::make('customer_name')->searchable(),
                TextColumn::make('total')->money('USD'),
                BadgeColumn::make('payment_status')
                    ->colors([
                        'danger' => 'unpaid',
                        'success' => 'paid',
                        'warning' => 'pending',
                    ]),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->actions([
                Action::make('abaPay')
                    ->label('ABA Pay')
                    ->icon('heroicon-o-qr-code')
                    ->color('success')
                    ->visible(fn(Order $record) => $record->payment_status !== 'paid')
                    ->modalHeading('Pay with ABA')
                    ->modalContent(function (Order $record) {
                        $abaService = app(ABAPaywayService::class);
                        $result = $abaService->getCheckoutPage($record->total, $record->id);
                        
                        if (!$result['success']) {
                            Notification::make()
                                ->title('Error')
                                ->body($result['error'])
                                ->danger()
                                ->send();
                            
                            return view('filament.modals.aba-qr-error', [
                                'error' => $result['error'],
                            ]);
                        }
                        
                        return view('filament.modals.aba-qr', [
                            'html' => $result['html'],
                            'amount' => $record->total,
                            'orderId' => $record->id,
                        ]);
                    })
                    ->modalSubmitAction(false)
                    ->modalWidth('md'),
                    
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }
}
