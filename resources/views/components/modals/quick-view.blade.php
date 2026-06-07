<div x-data="quickViewModal()" x-show="open"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[60] flex items-center justify-center p-4"
     x-cloak>
    <div class="fixed inset-0 bg-black/50" @click="open = false"></div>
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto z-10">

        <button @click="open = false" class="absolute top-4 right-4 z-10 w-8 h-8 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-gray-100 transition shadow-sm">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        <div x-show="loading" class="flex items-center justify-center py-20">
            <svg class="animate-spin w-8 h-8 text-orange-600" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
        </div>

        <div x-show="!loading && product" class="grid grid-cols-1 md:grid-cols-2">
            <div class="aspect-square bg-gray-50 overflow-hidden">
                <img :src="product.image" :alt="product.name" class="w-full h-full object-cover">
            </div>
            <div class="p-6 md:p-8 flex flex-col">
                <p x-show="product.brand" x-text="product.brand" class="text-xs text-orange-600 font-semibold uppercase tracking-wider mb-1"></p>
                <h3 x-text="product.name" class="text-xl font-bold text-gray-900 leading-tight mb-2"></h3>

                <div class="flex items-center gap-2 mb-1">
                    <div class="flex items-center gap-0.5">
                        <template x-for="i in 5">
                            <svg class="w-3.5 h-3.5" :class="i <= Math.round(product.avgRating) ? 'text-yellow-400' : 'text-gray-200'" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </template>
                    </div>
                    <span class="text-xs text-gray-400" x-text="'(' + product.reviewsCount + ')'"></span>
                </div>

                <div class="flex items-baseline gap-2 mt-2">
                    <span class="text-3xl font-extrabold text-orange-600" x-text="'$' + product.price.toFixed(2)"></span>
                    <span x-show="product.compare_price" class="text-base text-gray-400 line-through" x-text="'$' + product.compare_price.toFixed(2)"></span>
                    <span x-show="product.compare_price" class="text-xs bg-red-50 text-red-600 px-2 py-0.5 rounded-full font-semibold">SALE</span>
                </div>

                <div class="mt-1 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full" :class="product.stock_quantity > 0 ? 'bg-emerald-500' : 'bg-red-500'"></span>
                    <span class="text-xs" :class="product.stock_quantity > 0 ? 'text-emerald-600' : 'text-red-500'" x-text="product.stock_quantity > 0 ? 'In Stock (' + product.stock_quantity + ' available)' : 'Out of Stock'"></span>
                </div>

                <p x-show="product.description" x-text="product.description" class="text-sm text-gray-600 mt-4 line-clamp-3 leading-relaxed"></p>

                <div x-show="Object.keys(product.specifications).length > 0" class="mt-4 bg-gray-50 rounded-xl p-4">
                    <h4 class="text-xs font-semibold text-gray-900 uppercase tracking-wider mb-2">Specifications</h4>
                    <dl class="space-y-1">
                        <template x-for="(value, key) in product.specifications" :key="key">
                            <div class="flex justify-between text-xs">
                                <dt class="text-gray-500 capitalize" x-text="key"></dt>
                                <dd class="text-gray-900 font-medium" x-text="value"></dd>
                            </div>
                        </template>
                    </dl>
                </div>

                <div class="mt-auto pt-4 space-y-2">
                    <form :action="'/cart/add/' + product.id" method="POST">
                        @csrf
                        <button type="submit" :disabled="product.stock_quantity < 1" class="w-full py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-orange-600 transition disabled:opacity-40 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                            Add to Cart
                        </button>
                    </form>
                    <a :href="'/shop/' + product.slug" class="block text-center text-xs text-gray-500 hover:text-orange-600 transition font-medium">View Full Details</a>
                </div>
            </div>
        </div>

        <div x-show="!loading && !product" class="text-center py-20">
            <p class="text-gray-500">Product not found.</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
function quickViewModal() {
    return {
        open: false,
        loading: false,
        product: null,
        async show(productId) {
            this.open = true;
            this.loading = true;
            this.product = null;
            try {
                const res = await fetch('/quick-view/' + productId);
                const data = await res.json();
                this.product = {
                    ...data,
                    image: data.images && data.images.length > 0
                        ? '{{ asset('storage') }}/' + data.images[0]
                        : ''
                };
            } catch (e) {
                this.product = null;
            } finally {
                this.loading = false;
            }
        }
    };
}
</script>
@endpush