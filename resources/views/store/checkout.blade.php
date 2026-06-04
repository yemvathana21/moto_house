<x-layouts.store title="Checkout">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ __('Checkout') }}</h1>

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-6">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
            <div class="md:col-span-3">
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">{{ __('Shipping Information') }}</h2>
                    <form action="/checkout" method="POST">
                        @csrf
                        <input type="hidden" name="coupon_code" id="coupon_code_input">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Full Name') }}</label>
                                <input type="text" name="name" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Email') }}</label>
                                    <input type="email" name="email" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Phone') }}</label>
                                    <input type="tel" name="phone" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Address') }}</label>
                                <textarea name="address" required rows="2" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none"></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('City') }}</label>
                                    <input type="text" name="city" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('State') }}</label>
                                    <input type="text" name="state" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Postal Code') }}</label>
                                    <input type="text" name="postal_code" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Country') }}</label>
                                    <input type="text" name="country" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Payment Method') }}</h3>
                            <div class="space-y-3">
                                <label class="flex items-center gap-4 p-4 border-2 border-gray-200 rounded-xl cursor-pointer transition-all has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50">
                                    <input type="radio" name="payment_method" value="cod" checked class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ __('Cash on Delivery') }}</p>
                                            <p class="text-sm text-gray-500">{{ __('Pay when you receive your order') }}</p>
                                        </div>
                                    </div>
                                </label>
                                <label class="flex items-center gap-4 p-4 border-2 border-gray-200 rounded-xl cursor-pointer transition-all has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50">
                                    <input type="radio" name="payment_method" value="khqr" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center text-white text-[10px] font-bold leading-tight text-center">KH<br>QR</div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ __('Bakong KHQR Pay') }}</p>
                                            <p class="text-sm text-gray-500">{{ __('Scan QR code with any Bakong-supported banking app') }}</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <button type="submit" id="place-order-btn" class="mt-8 w-full py-3.5 bg-gray-900 text-white font-semibold rounded-xl hover:bg-orange-600 transition text-lg">
                            {{ __('Place Order') }} - ${{ number_format($total, 2) }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="bg-white rounded-2xl border border-gray-100 p-6 sticky top-24">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Order Summary') }}</h2>

                    <div class="mb-5 p-4 bg-gray-50 rounded-xl">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Have a coupon?') }}</label>
                        <div class="flex gap-2">
                            <input type="text" id="coupon_input" placeholder="{{ __('Enter code') }}" class="flex-1 px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none uppercase">
                            <button type="button" id="apply_coupon" class="px-4 py-2 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-orange-600 transition whitespace-nowrap">{{ __('Apply') }}</button>
                        </div>
                        <p id="coupon_message" class="text-xs mt-2 hidden"></p>
                    </div>

                    <div class="space-y-3 divide-y divide-gray-100">
                        @foreach ($cart as $item)
                            <div class="flex items-center justify-between pt-3 first:pt-0">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $item['name'] }}</p>
                                    <p class="text-xs text-gray-400">Qty: {{ $item['quantity'] }}</p>
                                </div>
                                <p class="text-sm font-semibold text-gray-900">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5 pt-5 border-t border-gray-100 space-y-2">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">{{ __('Subtotal') }}</span>
                            <span class="font-medium text-gray-900">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">{{ __('Tax (10%)') }}</span>
                            <span class="font-medium text-gray-900">${{ number_format($tax, 2) }}</span>
                        </div>
                        <div id="discount_row" class="flex items-center justify-between text-sm text-emerald-600 hidden">
                            <span>{{ __('Discount') }}</span>
                            <span id="discount_amount">-$0.00</span>
                        </div>
                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                            <span class="font-bold text-gray-900">{{ __('Total') }}</span>
                            <span class="text-2xl font-extrabold text-orange-600">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-4 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        {{ __('Cash on delivery') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let appliedCoupon = null;
        const currentTotal = {{ $total }};
        const currentSubtotal = {{ $subtotal }};
        const currentTax = {{ $tax }};

        document.getElementById('apply_coupon').addEventListener('click', async function() {
            const code = document.getElementById('coupon_input').value.trim().toUpperCase();
            const msg = document.getElementById('coupon_message');
            const discountRow = document.getElementById('discount_row');
            const discountAmount = document.getElementById('discount_amount');

            if (!code) {
                msg.textContent = '{{ __("Please enter a coupon code") }}';
                msg.className = 'text-xs mt-2 text-red-500';
                msg.classList.remove('hidden');
                return;
            }

            try {
                const res = await fetch('/coupon/validate', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ code, subtotal: currentSubtotal })
                });
                const data = await res.json();

                if (data.valid) {
                    appliedCoupon = code;
                    document.getElementById('coupon_code_input').value = code;

                    let discount = data.discount;
                    let newTotal = currentTotal - discount;

                    discountRow.classList.remove('hidden');
                    discountAmount.textContent = '-$' + discount.toFixed(2);
                    document.querySelector('.text-2xl.font-extrabold.text-orange-600').textContent = '$' + newTotal.toFixed(2);
                    document.getElementById('place-order-btn').innerHTML = '{{ __("Place Order") }} - $' + newTotal.toFixed(2);

                    msg.textContent = '{{ __("Coupon applied! You saved") }} $' + discount.toFixed(2);
                    msg.className = 'text-xs mt-2 text-emerald-600';
                    msg.classList.remove('hidden');
                } else {
                    appliedCoupon = null;
                    document.getElementById('coupon_code_input').value = '';
                    msg.textContent = data.message || '{{ __("Invalid coupon") }}';
                    msg.className = 'text-xs mt-2 text-red-500';
                    msg.classList.remove('hidden');
                }
            } catch (e) {
                msg.textContent = '{{ __("Error validating coupon") }}';
                msg.className = 'text-xs mt-2 text-red-500';
                msg.classList.remove('hidden');
            }
        });
    </script>
    @endpush
</x-layouts.store>
