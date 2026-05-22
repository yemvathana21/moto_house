<x-layouts.store title="{{ $product->name }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8">
            <a href="/" class="hover:text-orange-600 transition">{{ __('Home') }}</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="/shop" class="hover:text-orange-600 transition">{{ __('Shop') }}</a>
            @if ($product->category)
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="/shop?category_id={{ $product->category->id }}" class="hover:text-orange-600 transition">{{ $product->category->name }}</a>
            @endif
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 font-medium truncate">{{ $product->name }}</span>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="relative">
                <div class="aspect-square bg-gray-50 rounded-2xl overflow-hidden">
                    @if ($product->images && count($product->images) > 0)
                        <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg class="w-32 h-32" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="absolute top-4 right-4">
                    @livewire('wishlist-button', ['productId' => $product->id], key('wishlist-' . $product->id))
                </div>
                @if ($product->compare_price)
                    <span class="absolute top-4 left-4 bg-red-500 text-white text-sm font-bold px-3 py-1.5 rounded-lg">{{ __('SALE') }}</span>
                @endif
            </div>

            <div class="md:pt-4">
                @if ($product->brand)
                    <p class="text-sm text-orange-600 font-semibold uppercase tracking-[0.15em] mb-2">{{ $product->brand }}</p>
                @endif
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-4">{{ $product->name }}</h1>

                <div class="flex items-baseline gap-3 mb-4">
                    <span class="text-4xl font-extrabold text-orange-600">${{ number_format($product->price, 2) }}</span>
                    @if ($product->compare_price)
                        <span class="text-xl text-gray-400 line-through">${{ number_format($product->compare_price, 2) }}</span>
                        <span class="text-sm bg-red-50 text-red-600 px-2.5 py-1 rounded-lg font-semibold">Save ${{ number_format($product->compare_price - $product->price, 2) }}</span>
                    @endif
                </div>

                <div class="flex items-center gap-4 mb-6">
                    @if ($avgRating)
                        <div class="flex items-center gap-1.5">
                            <div class="flex">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm text-gray-500">({{ $reviewsCount }} {{ $reviewsCount === 1 ? __('review') : __('reviews') }})</span>
                        </div>
                        <span class="text-gray-300">|</span>
                    @endif
                    <span class="text-sm flex items-center gap-1.5 {{ $product->isInStock() ? 'text-emerald-600' : 'text-red-500' }}">
                        <span class="w-2 h-2 rounded-full {{ $product->isInStock() ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                        {{ $product->isInStock() ? __('In Stock') . ' (' . $product->stock_quantity . ' ' . __('available') . ')' : __('Out of Stock') }}
                    </span>
                </div>

                @if ($product->description)
                    <div class="prose prose-sm max-w-none text-gray-600 mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ __('Description') }}</h3>
                        {!! $product->description !!}
                    </div>
                @endif

                <div class="flex gap-3 mb-8">
                    <form action="/cart/add/{{ $product->id }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" {{ $product->stock_quantity < 1 ? 'disabled' : '' }} class="w-full px-8 py-3.5 bg-gray-900 text-white font-semibold rounded-xl hover:bg-orange-600 transition disabled:opacity-40 disabled:cursor-not-allowed flex items-center justify-center gap-2 text-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                            {{ __('Add to Cart') }}
                        </button>
                    </form>
                </div>

                @if ($product->specifications)
                    <div class="bg-gray-50 rounded-2xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Specifications') }}</h3>
                        <dl class="divide-y divide-gray-200">
                            @foreach ($product->specifications as $key => $value)
                                <div class="flex justify-between py-3">
                                    <dt class="text-sm font-medium text-gray-600 capitalize">{{ $key }}</dt>
                                    <dd class="text-sm text-gray-900 font-medium">{{ $value }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                @endif
            </div>
        </div>

        <section class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">{{ __('Customer Reviews') }}</h2>
            @if ($reviews->count())
                <div class="space-y-4">
                    @foreach ($reviews as $review)
                        <div class="bg-white rounded-2xl border border-gray-100 p-6">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $review->customer_name }}</p>
                                    <div class="flex items-center gap-0.5 mt-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <span class="text-sm text-gray-400">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            @if ($review->comment)
                                <p class="text-gray-600 leading-relaxed">{{ $review->comment }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-2xl border border-gray-100">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <p class="text-gray-500">{{ __('No reviews yet. Be the first to review this product!') }}</p>
                </div>
            @endif
        </section>
    </div>
</x-layouts.store>
