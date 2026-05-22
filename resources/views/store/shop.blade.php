<x-layouts.store title="Shop">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ __('Shop') }}</h1>
                <p class="text-sm text-gray-500 mt-1">{{ $products->total() }} {{ $products->total() === 1 ? __('product') : __('products') }} {{ __('found') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <form method="GET" action="/shop" class="relative">
                    @if (request('category_id')) <input type="hidden" name="category_id" value="{{ request('category_id') }}"> @endif
                    @if (request('brand')) <input type="hidden" name="brand" value="{{ request('brand') }}"> @endif
                    <input type="text" name="search" placeholder="{{ __('Search products...') }}" value="{{ request('search') }}" class="w-56 pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </form>
                <select onchange="window.location.href=this.value" class="px-3 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => 'desc']) }}" {{ request('sort') === 'created_at' || !request('sort') ? 'selected' : '' }}>{{ __('Newest') }}</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price', 'direction' => 'asc']) }}" {{ request('sort') === 'price' && request('direction') === 'asc' ? 'selected' : '' }}>{{ __('Price: Low to High') }}</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price', 'direction' => 'desc']) }}" {{ request('sort') === 'price' && request('direction') === 'desc' ? 'selected' : '' }}>{{ __('Price: High to Low') }}</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'name', 'direction' => 'asc']) }}" {{ request('sort') === 'name' ? 'selected' : '' }}>{{ __('Name: A-Z') }}</option>
                </select>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <aside class="lg:w-64 shrink-0">
                <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-6 sticky top-24">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                            {{ __('Categories') }}
                        </h3>
                        <ul class="space-y-0.5">
                            <li>
                                <a href="/shop" class="text-sm {{ !request('category_id') ? 'bg-orange-50 text-orange-600 font-semibold' : 'text-gray-600 hover:text-orange-600 hover:bg-orange-50' }} transition block px-3 py-2 rounded-lg">{{ __('All Categories') }}</a>
                            </li>
                            @php $parentCategories = $categories->whereNull('parent_id'); @endphp
                            @foreach ($parentCategories as $category)
                                <li>
                                    <a href="/shop?category_id={{ $category->id }}" class="text-sm {{ request('category_id') == $category->id ? 'bg-orange-50 text-orange-600 font-semibold' : 'text-gray-600 hover:text-orange-600 hover:bg-orange-50' }} transition block px-3 py-2 rounded-lg">
                                        {{ $category->name }}
                                    </a>
                                    @php $children = $categories->where('parent_id', $category->id); @endphp
                                    @if ($children->count())
                                        <ul class="ml-3 space-y-0.5 mt-0.5">
                                            @foreach ($children as $child)
                                                <li>
                                                    <a href="/shop?category_id={{ $child->id }}" class="text-sm {{ request('category_id') == $child->id ? 'bg-orange-50 text-orange-600 font-semibold' : 'text-gray-500 hover:text-orange-600 hover:bg-orange-50' }} transition block px-3 py-1.5 rounded-lg">
                                                        {{ $child->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @if ($brands->count())
                        <div class="pt-4 border-t border-gray-100">
                            <h3 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                {{ __('Brands') }}
                            </h3>
                            <ul class="space-y-0.5">
                                <li>
                                    <a href="/shop" class="text-sm {{ !request('brand') ? 'bg-orange-50 text-orange-600 font-semibold' : 'text-gray-600 hover:text-orange-600 hover:bg-orange-50' }} transition block px-3 py-2 rounded-lg">{{ __('All Brands') }}</a>
                                </li>
                                @foreach ($brands as $brand)
                                    <li>
                                        <a href="/shop?brand={{ $brand }}" class="text-sm {{ request('brand') == $brand ? 'bg-orange-50 text-orange-600 font-semibold' : 'text-gray-600 hover:text-orange-600 hover:bg-orange-50' }} transition block px-3 py-2 rounded-lg">
                                            {{ $brand }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </aside>

            <div class="flex-1 min-w-0">
                @if ($products->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach ($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                    <div class="mt-10">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-20">
                        <svg class="w-20 h-20 text-gray-200 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <h2 class="text-xl font-bold text-gray-900 mb-2">{{ __('No products found') }}</h2>
                        <p class="text-gray-500 mb-6">{{ __('Try adjusting your filters or search terms.') }}</p>
                        <a href="/shop" class="inline-flex px-6 py-3 bg-orange-600 text-white font-semibold rounded-xl hover:bg-orange-500 transition">{{ __('Clear Filters') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.store>
