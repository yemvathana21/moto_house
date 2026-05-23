<x-layouts.store title="{{ __('Track Order') }}">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Track Your Order') }}</h1>
            <p class="text-gray-500">{{ __('Enter your order number to see the current status and details.') }}</p>
        </div>

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-6">{{ session('error') }}</div>
        @endif

        <form action="/order/track" method="GET" class="flex gap-3 max-w-lg mx-auto mb-12">
            <input type="text" name="order_number" placeholder="e.g. MH-ABC123" required
                   class="flex-1 px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-center uppercase text-lg font-medium placeholder:text-base">
            <button type="submit" class="px-6 py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-orange-600 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                {{ __('Track') }}
            </button>
        </form>

        @if (request('order_number'))
            @if ($order)
                <div class="max-w-3xl mx-auto mb-12">
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 md:p-8">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">{{ __('Order') }} #{{ $order->order_number }}</h1>
                                <p class="text-sm text-gray-500 mt-1">{{ __('Placed on') }} {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
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
                                <h3 class="font-semibold text-gray-900 mb-3">{{ __('Shipping Address') }}</h3>
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
                            <h3 class="font-bold text-gray-900 mb-6">{{ __('Order Timeline') }}</h3>
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
            @else
                <div class="text-center mb-12">
                    <p class="text-red-500 font-medium">{{ __('Order not found.') }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ __('Please check your order number and try again.') }}</p>
                </div>
            @endif
        @endif

        @if ($orders->count())
            <div class="border-t border-gray-100 pt-10">
                <h2 class="text-xl font-bold text-gray-900 mb-6">{{ __('Your Orders') }}</h2>
                <div class="space-y-4">
                    @foreach ($orders as $order)
                        <a href="/order/track?order_number={{ $order->order_number }}" class="block bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-md hover:border-orange-100 transition-all duration-200">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ __('Order') }} #{{ $order->order_number }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-lg text-xs font-semibold
                                    @switch($order->status)
                                        @case('pending') bg-yellow-50 text-yellow-700 @break
                                        @case('processing') bg-blue-50 text-blue-700 @break
                                        @case('shipped') bg-purple-50 text-purple-700 @break
                                        @case('delivered') bg-emerald-50 text-emerald-700 @break
                                        @case('cancelled') bg-red-50 text-red-700 @break
                                        @default bg-gray-50 text-gray-700
                                    @endswitch
                                ">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500">{{ $order->items->count() }} {{ __('items') }}</span>
                                <span class="font-bold text-gray-900">${{ number_format($order->total, 2) }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center py-10 border-t border-gray-100">
                <p class="text-gray-500">{{ __("You don't have any orders yet.") }}</p>
                <a href="/shop" class="inline-flex items-center gap-2 mt-4 px-6 py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-orange-600 transition">
                    {{ __('Start Shopping') }}
                </a>
            </div>
        @endif
    </div>
</x-layouts.store>
