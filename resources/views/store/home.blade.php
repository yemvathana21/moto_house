<x-layouts.store title="Home">
    @if ($banners->count())
        <section class="relative overflow-hidden bg-gray-950">
            <div class="relative">
                @foreach ($banners as $banner)
                    <div class="banner-slide {{ $loop->first ? 'block' : 'hidden' }}">
                        <div class="relative h-[420px] md:h-[560px]">
                            <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-r from-gray-950/80 via-gray-950/50 to-transparent"></div>
                            <div class="absolute inset-0 flex items-center">
                                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                                    <div class="max-w-lg">
                                        @if ($banner->subtitle)
                                            <p class="text-orange-400 font-semibold text-sm uppercase tracking-[0.2em] mb-3">{{ $banner->subtitle }}</p>
                                        @endif
                                        @if ($banner->title)
                                            <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-4">{{ $banner->title }}</h1>
                                        @endif
                                        @if ($banner->link)
                                            <a href="{{ $banner->link }}" class="inline-flex items-center gap-2 px-6 py-3 bg-orange-600 text-white font-semibold rounded-xl hover:bg-orange-500 transition shadow-lg shadow-orange-600/25">
                                                {{ __('Shop Now') }}
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($banners->count() > 1)
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                    @foreach ($banners as $i => $banner)
                        <button class="w-2.5 h-2.5 rounded-full transition-all {{ $i === 0 ? 'bg-orange-500 w-6' : 'bg-white/40' }} banner-dot" data-index="{{ $i }}"></button>
                    @endforeach
                </div>
            @endif
        </section>
        @push('scripts')
        <script>
            (function() {
                let current = 0;
                const slides = document.querySelectorAll('.banner-slide');
                const dots = document.querySelectorAll('.banner-dot');
                if (!slides.length) return;
                setInterval(() => {
                    slides[current].classList.add('hidden');
                    slides[current].classList.remove('block');
                    if (dots[current]) { dots[current].classList.replace('bg-orange-500', 'bg-white/40'); dots[current].classList.remove('w-6'); }
                    current = (current + 1) % slides.length;
                    slides[current].classList.remove('hidden');
                    slides[current].classList.add('block');
                    if (dots[current]) { dots[current].classList.replace('bg-white/40', 'bg-orange-500'); dots[current].classList.add('w-6'); }
                }, 5000);
            })();
        </script>
        @endpush
    @else
        <section class="relative bg-gray-950 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-600/20 via-gray-950 to-gray-950"></div>
            <div class="absolute top-20 -right-20 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-orange-500/10 rounded-full blur-3xl"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-36">
                <div class="max-w-2xl">
                    <p class="text-orange-400 font-semibold text-sm uppercase tracking-[0.2em] mb-4">{{ __('Premium Motorcycle Gear') }}</p>
                    <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-6">{{ __('Gear Up for the Ride Ahead') }}</h1>
                    <p class="text-lg text-gray-300 leading-relaxed mb-8">{{ __('Discover premium motorcycle accessories engineered for performance, safety, and style. Ride with confidence.') }}</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="/shop" class="inline-flex items-center gap-2 px-6 py-3 bg-orange-600 text-white font-semibold rounded-xl hover:bg-orange-500 transition shadow-lg shadow-orange-600/25">
                            {{ __('Shop Now') }}
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="/shop" class="inline-flex items-center gap-2 px-6 py-3 border border-gray-700 text-gray-300 font-semibold rounded-xl hover:border-orange-600 hover:text-orange-400 transition">
                            {{ __('Browse Categories') }}
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($categories->count())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center mb-12">
                <p class="text-orange-600 font-semibold text-sm uppercase tracking-[0.2em] mb-2">{{ __('Categories') }}</p>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">{{ __('Shop by Category') }}</h2>
                <p class="text-gray-500 mt-2">{{ __('Find exactly what you need for your ride') }}</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach ($categories as $category)
                    <a href="/shop?category_id={{ $category->id }}" class="group relative bg-white rounded-2xl border border-gray-100 p-6 text-center hover:border-orange-200 hover:shadow-xl hover:shadow-orange-500/5 transition-all duration-300">
                        @if ($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-20 h-20 object-cover rounded-2xl mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                        @else
                            <div class="w-20 h-20 bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-9 h-9 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                        @endif
                        <h3 class="font-semibold text-gray-900 group-hover:text-orange-600 transition-colors">{{ $category->name }}</h3>
                        <p class="text-xs text-gray-400 mt-1">{{ $category->products->count() }} {{ __('items') }}</p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    @if ($featuredProducts->count())
        <section class="bg-gray-50 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between mb-10">
                    <div>
                        <p class="text-orange-600 font-semibold text-sm uppercase tracking-[0.2em] mb-2">{{ __('Featured') }}</p>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">{{ __('Our Top Picks') }}</h2>
                    </div>
                    <a href="/shop" class="hidden sm:inline-flex items-center gap-1 text-orange-600 font-medium hover:text-orange-500 transition">
                        {{ __('View All') }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach ($featuredProducts as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
                <div class="mt-8 text-center sm:hidden">
                    <a href="/shop" class="inline-flex items-center gap-2 px-6 py-3 bg-orange-600 text-white font-semibold rounded-xl hover:bg-orange-500 transition">{{ __('View All Products') }}</a>
                </div>
            </div>
        </section>
    @endif

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-2xl border border-gray-100 p-8 text-center hover:shadow-lg hover:border-orange-100 transition-all duration-300">
                <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('Free Shipping') }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ __('Free shipping on all orders over $100. We deliver free to your doorstep.') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 p-8 text-center hover:shadow-lg hover:border-orange-100 transition-all duration-300">
                <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('Easy Returns') }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ __("Not satisfied? Return within 30 days for a full refund. No questions asked.") }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 p-8 text-center hover:shadow-lg hover:border-orange-100 transition-all duration-300">
                <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('Quality Guarantee') }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ __('Every product is tested and certified. We stand behind our quality.') }}</p>
            </div>
        </div>
    </section>

    <section class="bg-gray-950 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">{{ __('Join the Moto House Community') }}</h2>
            <p class="text-gray-400 text-lg mb-8 max-w-xl mx-auto">{{ __('Subscribe to get exclusive deals, new arrivals, and riding tips straight to your inbox.') }}</p>
            <form class="max-w-md mx-auto flex gap-3">
                <input type="email" placeholder="{{ __('Enter your email') }}" class="flex-1 px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                <button type="submit" class="px-6 py-3 bg-orange-600 text-white font-semibold rounded-xl hover:bg-orange-500 transition shrink-0">{{ __('Subscribe') }}</button>
            </form>
        </div>
    </section>
</x-layouts.store>
