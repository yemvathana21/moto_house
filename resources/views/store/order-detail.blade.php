<x-layouts.store title="Order #{{ $order->order_number }}">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-2xl border border-gray-100 p-6 md:p-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Order #{{ $order->order_number }}</h1>
                    <p class="text-sm text-gray-500 mt-1">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                </div>
                <span class="px-4 py-1.5 rounded-xl text-sm font-semibold inline-flex items-center gap-1.5
                    @switch($order->status)
                        @case('pending') bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200 @break
                        @case('processing') bg-blue-50 text-blue-700 ring-1 ring-blue-200 @break
                        @case('shipped') bg-purple-50 text-purple-700 ring-1 ring-purple-200 @break
                        @case('delivered') bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200 @break
                        @case('cancelled') bg-red-50 text-red-700 ring-1 ring-red-200 @break
                        @default bg-gray-50 text-gray-700 ring-1 ring-gray-200
                    @endswitch
                ">
                    <span class="w-1.5 h-1.5 rounded-full
                        @switch($order->status)
                            @case('pending') bg-yellow-500 @break
                            @case('processing') bg-blue-500 @break
                            @case('shipped') bg-purple-500 @break
                            @case('delivered') bg-emerald-500 @break
                            @case('cancelled') bg-red-500 @break
                            @default bg-gray-500
                        @endswitch
                    "></span>
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            @if ($order->customer)
                <div class="mb-8 p-5 bg-gray-50 rounded-xl">
                    <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ __('Shipping Address') }}
                    </h3>
                    <p class="text-sm text-gray-600">{{ $order->customer->name }}</p>
                    <p class="text-sm text-gray-600">{{ $order->shipping_address }}</p>
                    <p class="text-sm text-gray-600">{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}</p>
                </div>
            @endif

            <div class="divide-y divide-gray-100">
                @foreach ($order->items as $item)
                    <div class="flex items-center justify-between py-4 first:pt-0 last:pb-0">
                        <div>
                            <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
                            <p class="text-sm text-gray-500 mt-0.5">{{ $item->quantity }} x ${{ number_format($item->unit_price, 2) }}</p>
                        </div>
                        <p class="font-bold text-gray-900">${{ number_format($item->subtotal, 2) }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100 space-y-1.5 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">{{ __('Subtotal') }}</span>
                    <span class="font-medium text-gray-900">${{ number_format($order->subtotal, 2) }}</span>
                </div>
                @if ($order->discount > 0)
                    <div class="flex justify-between text-emerald-600">
                        <span>{{ __('Discount') }}</span>
                        <span class="font-medium">-${{ number_format($order->discount, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-600">{{ __('Tax') }}</span>
                    <span class="font-medium text-gray-900">${{ number_format($order->tax, 2) }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold pt-3 border-t border-gray-100 mt-3">
                    <span>{{ __('Total') }}</span>
                    <span class="text-orange-600">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-100">
                <h3 class="font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ __('Order Timeline') }}
                </h3>
                <div class="relative pl-8 space-y-6 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-0.5 before:bg-gray-200">
                    <div class="relative">
                        <div class="absolute -left-8 top-0.5 w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <p class="font-medium text-gray-900">{{ __('Order Placed') }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    @if (in_array($order->status, ['processing', 'shipped', 'delivered']))
                        <div class="relative">
                            <div class="absolute -left-8 top-0.5 w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <p class="font-medium text-gray-900">{{ __('Processing') }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ __('Your order is being prepared') }}</p>
                        </div>
                    @endif
                    @if (in_array($order->status, ['shipped', 'delivered']))
                        <div class="relative">
                            <div class="absolute -left-8 top-0.5 w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <p class="font-medium text-gray-900">{{ __('Shipped') }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ __('Your order is on the way') }}</p>
                        </div>
                    @endif
                    @if ($order->status === 'delivered')
                        <div class="relative">
                            <div class="absolute -left-8 top-0.5 w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <p class="font-medium text-gray-900">{{ __('Delivered') }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ __('Your order has been delivered') }}</p>
                        </div>
                    @endif
                    @if ($order->status === 'cancelled')
                        <div class="relative">
                            <div class="absolute -left-8 top-0.5 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                            </div>
                            <p class="font-medium text-red-600">{{ __('Cancelled') }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ __('This order has been cancelled') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.store>
