<x-layouts.store title="My Wishlist">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ __('My Wishlist') }}</h1>

        @if ($wishlistItems->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($wishlistItems as $item)
                    <div class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl hover:border-orange-100 transition-all duration-300">
                        <a href="/shop/{{ $item->product->slug }}" class="block aspect-square bg-gray-50 relative overflow-hidden">
                            @if ($item->product->images && count($item->product->images) > 0)
                                <img src="{{ asset('storage/' . $item->product->images[0]) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </a>
                        <div class="p-5">
                            @if ($item->product->brand)
                                <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">{{ $item->product->brand }}</p>
                            @endif
                            <a href="/shop/{{ $item->product->slug }}" class="font-semibold text-gray-900 hover:text-orange-600 transition line-clamp-2">{{ $item->product->name }}</a>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-lg font-bold text-orange-600">${{ number_format($item->product->price, 2) }}</span>
                                @if ($item->product->compare_price)
                                    <span class="text-sm text-gray-400 line-through">${{ number_format($item->product->compare_price, 2) }}</span>
                                @endif
                            </div>
                            <form action="/cart/add/{{ $item->product->id }}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit" class="w-full py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-orange-600 transition flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                                    {{ __('Add to Cart') }}
                                </button>
                            </form>
                            
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <svg class="w-24 h-24 text-gray-200 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __('Your wishlist is empty') }}</h2>
                <p class="text-gray-500 mb-8">{{ __('Save items you love by clicking the heart icon on any product.') }}</p>
                <a href="/shop" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-orange-600 transition">
                    {{ __('Browse Shop') }}
                    <!-- <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg> -->
                </a>
            </div>
        @endif
    </div>
</x-layouts.store>
