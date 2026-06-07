<x-layouts.store title="Cart">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ __('Shopping Cart') }}</h1>

        @if (empty($cart))
            <div class="text-center py-20">
                <svg class="w-24 h-24 text-gray-200 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __('Your cart is empty') }}</h2>
                <p class="text-gray-500 mb-8">{{ __("Looks like you haven't added anything yet. Start exploring our collection!") }}</p>
                <a href="/shop" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-orange-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    {{ __('Start Shopping') }}
                </a>
            </div>
        @else
            <div class="bg-white rounded-2xl border border-gray-100 divide-y divide-gray-100">
                @foreach ($cart as $item)
                    <div class="flex items-center gap-4 p-5">
                        <div class="w-20 h-20 bg-gray-50 rounded-xl overflow-hidden shrink-0">
                            @if ($item['image'])
                                <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-900 truncate">{{ $item['name'] }}</h3>
                            <p class="text-orange-600 font-bold mt-0.5">${{ number_format($item['price'], 2) }}</p>
                        </div>
                        <form action="/cart/update/{{ $item['id'] }}" method="POST" class="flex items-center gap-2 bg-gray-50 rounded-xl p-1">
                            @csrf
                            <button type="submit" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}" class="w-9 h-9 rounded-lg flex items-center justify-center hover:bg-white hover:shadow-sm transition font-medium text-gray-600">-</button>
                            <span class="w-8 text-center font-semibold text-gray-900">{{ $item['quantity'] }}</span>
                            <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="w-9 h-9 rounded-lg flex items-center justify-center hover:bg-white hover:shadow-sm transition font-medium text-gray-600">+</button>
                        </form>
                        <p class="font-bold text-gray-900 w-24 text-right">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                        <form action="/cart/remove/{{ $item['id'] }}" method="POST">
                            @csrf
                            <button type="submit" class="p-2 text-gray-300 hover:text-red-500 transition" title="{{ __('Remove') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 bg-white rounded-2xl border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <span class="text-gray-600">{{ __('Subtotal') }}</span>
                    <span class="text-2xl font-bold text-gray-900">${{ number_format($total, 2) }}</span>
                </div>
                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <form action="/cart/clear" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-6 py-3 border-2 border-gray-200 text-gray-600 font-semibold rounded-xl hover:border-gray-300 hover:bg-gray-50 transition">{{ __('Clear Cart') }}</button>
                    </form>
                    <a href="/checkout" class="flex-1 text-center px-6 py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-orange-600 transition flex items-center justify-center gap-2">
                        {{ __('Proceed to Checkout') }}
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-layouts.store>
