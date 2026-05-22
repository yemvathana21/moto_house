<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Mail\ShippingNotification;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $order = $this->record;
        $originalStatus = $order->getOriginal('status');

        if ($originalStatus !== 'shipped' && $order->status === 'shipped' && $order->customer?->email) {
            try {
                Mail::to($order->customer->email)->queue(new ShippingNotification($order));
            } catch (\Exception $e) {
            }
        }
    }
}
