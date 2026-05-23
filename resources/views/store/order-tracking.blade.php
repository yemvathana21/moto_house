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
