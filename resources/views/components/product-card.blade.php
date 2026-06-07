@props(['product'])
<div class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl hover:border-orange-100 transition-all duration-300">
    <div class="relative aspect-square bg-gray-50 overflow-hidden">
        <a href="/shop/{{ $product->slug }}">
            @if ($product->images && count($product->images) > 0)
                <img src="{{ Storage::url($product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-102 transition-transform duration-500">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-300">
                    <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif
        </a>
        @if ($product->compare_price)
            <span class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded-lg">{{ __('SALE') }}</span>
        @endif
        <div class="absolute top-3 right-3 z-10">
            @livewire('wishlist-button', ['productId' => $product->id], key($product->id))
        </div>
        <button @click="$dispatch('open-quick-view', {{ $product->id }})"
                class="absolute inset-x-4 bottom-4 py-2 bg-white/90 backdrop-blur-sm text-gray-900 text-xs font-semibold rounded-xl opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0 hover:bg-white shadow-lg">
            {{ __('Quick View') }}
        </button>
        @if ($product->stock_quantity < 1)
            <div class="absolute inset-0 bg-white/60 flex items-center justify-center">
                <span class="bg-gray-900 text-white text-sm font-semibold px-4 py-2 rounded-lg">{{ __('Out of Stock') }}</span>
            </div>
        @endif
    </div>
    <div class="p-3 md:p-5">
        <div class="flex items-start justify-between gap-2 mb-1 md:mb-2">
            <div class="min-w-0">
                @if ($product->brand)
                    <p class="text-[10px] md:text-xs text-gray-400 uppercase tracking-wider mb-0.5 md:mb-1">{{ $product->brand }}</p>
                @endif
                <a href="/shop/{{ $product->slug }}" class="text-sm md:font-semibold text-gray-900 hover:text-orange-600 transition line-clamp-2 leading-snug">{{ $product->name }}</a>
            </div>
        </div>
        <div class="flex items-center gap-1 md:gap-2 mt-0.5 md:mt-1">
            <span class="text-sm md:text-xl font-bold text-orange-600">${{ number_format($product->price, 2) }}</span>
            @if ($product->compare_price)
                <span class="text-[11px] md:text-sm text-gray-400 line-through">${{ number_format($product->compare_price, 2) }}</span>
            @endif
            @if ($product->stock_quantity > 0 && $product->stock_quantity < 10)
                <span class="text-[9px] md:text-xs bg-red-50 text-red-600 px-1.5 md:px-2 py-0.5 rounded-full font-semibold whitespace-nowrap">{{ __('Only') }} {{ $product->stock_quantity }} {{ __('left') }}</span>
            @endif
        </div>
        <div class="mt-2 md:mt-4 flex gap-2">
            <form action="/cart/add/{{ $product->id }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" {{ $product->stock_quantity < 1 ? 'disabled' : '' }} class="w-full py-2 md:py-2.5 bg-gray-900 text-white text-[11px] md:text-sm font-semibold rounded-lg md:rounded-xl hover:bg-orange-600 transition disabled:opacity-40 disabled:cursor-not-allowed flex items-center justify-center gap-1 md:gap-2">
                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    {{ __('Cart') }}
                </button>
            </form>
            <form action="/buy-now/{{ $product->id }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" {{ $product->stock_quantity < 1 ? 'disabled' : '' }} class="w-full py-2 md:py-2.5 bg-orange-600 text-white text-[11px] md:text-sm font-semibold rounded-lg md:rounded-xl hover:bg-orange-700 transition disabled:opacity-40 disabled:cursor-not-allowed flex items-center justify-center gap-1 md:gap-2">
                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    {{ __('Buy Now') }}
                </button>
            </form>
        </div>
    </div>
</div>
