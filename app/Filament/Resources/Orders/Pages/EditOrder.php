<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Mail\ShippingNotification;
use App\Models\CustomerNotification;
use App\Models\OrderStatusHistory;
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

        if ($originalStatus !== $order->status) {
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => $order->status,
            ]);

            if ($order->customer_id) {
                $statusLabels = [
                    'pending' => 'Pending',
                    'processing' => 'Processing',
                    'shipped' => 'Shipped',
                    'delivered' => 'Delivered',
                    'cancelled' => 'Cancelled',
                ];
                $label = $statusLabels[$order->status] ?? $order->status;
                CustomerNotification::create([
                    'customer_id' => $order->customer_id,
                    'title' => "Order {$order->order_number} Updated",
                    'body' => "Your order status has been changed to {$label}.",
                    'type' => 'order',
                    'data' => ['order_id' => $order->id, 'status' => $order->status],
                ]);
            }

            if ($order->status === 'shipped' && $order->customer?->email) {
                try {
                    Mail::to($order->customer->email)->queue(new ShippingNotification($order));
                } catch (\Exception $e) {
                }
            }
        }
    }
}
