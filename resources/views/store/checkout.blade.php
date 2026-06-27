<x-layouts.store title="Checkout">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ __('Checkout') }}</h1>

        @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-6">{{ session('error') }}</div>
        @endif

        <div x-data="checkoutSteps()" x-init="init()">
            <nav class="flex items-center justify-center gap-2 sm:gap-4 mb-10">
                <template x-for="(step, index) in steps" :key="index">
                    <div class="flex items-center gap-2 sm:gap-4">
                        <button @click="goTo(index)" type="button"
                            class="flex items-center gap-2 px-3 sm:px-4 py-2 rounded-xl text-sm font-semibold transition-all"
                            :class="currentStep === index ? 'bg-orange-50 text-orange-600 border-2 border-orange-500' : (completedSteps.includes(index) ? 'bg-emerald-50 text-emerald-600 border-2 border-emerald-500' : 'bg-gray-50 text-gray-400 border-2 border-gray-200')">
                            <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold"
                                :class="currentStep === index ? 'bg-orange-500 text-white' : (completedSteps.includes(index) ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-500')"
                                x-text="index + 1"></span>
                            <span class="hidden sm:inline" x-text="step"></span>
                        </button>
                        <template x-if="index < steps.length - 1">
                            <div class="w-8 sm:w-12 h-0.5 rounded" :class="completedSteps.includes(index) ? 'bg-emerald-500' : 'bg-gray-200'"></div>
                        </template>
                    </div>
                </template>
            </nav>

            <form action="/checkout" method="POST" @submit.prevent="submitForm">
                @csrf
                <input type="hidden" name="coupon_code" x-model="couponCode">
                <input type="hidden" name="payment_method" x-model="paymentMethod">

                <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
                    <div class="md:col-span-3">

                        {{-- Step 1: Shipping --}}
                        <div x-show="currentStep === 0" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ __('Shipping Information') }}
                                </h2>
                                <div class="space-y-5">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Full Name') }} *</label>
                                        <input type="text" name="name" x-model="form.name" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Email') }} *</label>
                                            <input type="email" name="email" x-model="form.email" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Phone') }}</label>
                                            <input type="tel" name="phone" x-model="form.phone" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Address') }} *</label>
                                        <textarea name="address" x-model="form.address" required rows="2" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none"></textarea>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('City') }} *</label>
                                            <input type="text" name="city" x-model="form.city" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('State') }}</label>
                                            <input type="text" name="state" x-model="form.state" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Postal Code') }}</label>
                                            <input type="text" name="postal_code" x-model="form.postalCode" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Country') }}</label>
                                            <input type="text" name="country" x-model="form.country" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Step 2: Review --}}
                        <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                    {{ __('Review Your Order') }}
                                </h2>

                                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                                    <h3 class="text-sm font-semibold text-gray-900 mb-3">{{ __('Shipping To') }}</h3>
                                    <div class="text-sm text-gray-600 space-y-1">
                                        <p><span class="font-medium" x-text="form.name"></span></p>
                                        <p x-text="form.email"></p>
                                        <p x-show="form.phone" x-text="form.phone"></p>
                                        <p x-text="form.address"></p>
                                        <p><span x-text="form.city"></span><span x-show="form.state">, <span x-text="form.state"></span></span></p>
                                        <p><span x-text="form.postalCode"></span><span x-show="form.postalCode && form.country">, </span><span x-text="form.country"></span></p>
                                    </div>
                                    <button @click="currentStep = 0" type="button" class="text-xs text-orange-600 hover:text-orange-500 font-medium mt-2 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                        {{ __('Edit') }}
                                    </button>
                                </div>

                                <div class="space-y-3 divide-y divide-gray-100">
                                    @foreach ($cart as $item)
                                    <div class="flex items-center justify-between pt-3 first:pt-0">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $item['name'] }}</p>
                                            <p class="text-xs text-gray-400">Qty: {{ $item['quantity'] }} &times; ${{ number_format($item['price'], 2) }}</p>
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
                                    <div x-show="discount > 0" class="flex items-center justify-between text-sm text-emerald-600">
                                        <span>{{ __('Discount') }}</span>
                                        <span x-text="'-$' + discount.toFixed(2)"></span>
                                    </div>
                                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                                        <span class="font-bold text-gray-900">{{ __('Total') }}</span>
                                        <span class="text-2xl font-extrabold text-orange-600" x-text="'$' + finalTotal.toFixed(2)"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Step 3: Payment --}}
                        <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    {{ __('Payment Method') }}
                                </h2>
                                <div class="space-y-3">
                                    <label class="flex items-center gap-4 p-4 border-2 rounded-xl cursor-pointer transition-all"
                                        :class="paymentMethod === 'cod' ? 'border-orange-500 bg-orange-50' : 'border-gray-200'">
                                        <input type="radio" name="payment_method_radio" value="cod" x-model="paymentMethod" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ __('Cash on Delivery') }}</p>
                                                <p class="text-sm text-gray-500">{{ __('Pay when you receive your order') }}</p>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="flex items-center gap-4 p-4 border-2 rounded-xl cursor-pointer transition-all"
                                        :class="paymentMethod === 'khqr' ? 'border-orange-500 bg-orange-50' : 'border-gray-200'">
                                        <input type="radio" name="payment_method_radio" value="khqr" x-model="paymentMethod" class="w-5 h-5 text-orange-600 border-gray-300 focus:ring-orange-500">
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
                        </div>

                        {{-- Navigation Buttons --}}
                        <div class="flex items-center justify-between mt-6">
                            <button @click="prevStep" type="button" x-show="currentStep > 0"
                                class="px-6 py-2.5 border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition text-sm flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7 7l-7-7 7-7" />
                                </svg>
                                {{ __('Back') }}
                            </button>
                            <button @click="nextStep" type="button" x-show="currentStep < 2"
                                class="ml-auto px-6 py-2.5 bg-gray-900 text-white font-semibold rounded-xl hover:bg-orange-600 transition text-sm flex items-center gap-2">
                                {{ __('Continue') }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7l7 7-7 7" />
                                </svg>
                            </button>
                            <button x-show="currentStep === 2" type="submit"
                                class="ml-auto px-8 py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-orange-600 transition text-base flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('Place Order') }}
                                <span x-text="'- $' + finalTotal.toFixed(2)"></span>
                            </button>
                        </div>
                    </div>

                    {{-- Sidebar: Order Summary --}}
                    <div class="md:col-span-2">
                        <div class="bg-white rounded-2xl border border-gray-100 p-6 sticky top-24">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Order Summary') }}</h2>

                            <div class="mb-5 p-4 bg-gray-50 rounded-xl">
                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('Have a coupon?') }}</label>
                                <div class="flex gap-2">
                                    <input type="text" x-model="couponInput" placeholder="{{ __('Enter code') }}" class="flex-1 px-3 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none uppercase">
                                    <button @click="applyCoupon" type="button" class="px-4 py-2 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-orange-600 transition whitespace-nowrap">{{ __('Apply') }}</button>
                                </div>
                                <p x-show="couponMessage" x-text="couponMessage" class="text-xs mt-2" :class="couponValid ? 'text-emerald-600' : 'text-red-500'"></p>
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
                                <div x-show="discount > 0" class="flex items-center justify-between text-sm text-emerald-600">
                                    <span>{{ __('Discount') }}</span>
                                    <span x-text="'-$' + discount.toFixed(2)"></span>
                                </div>
                                <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                                    <span class="font-bold text-gray-900">{{ __('Total') }}</span>
                                    <span class="text-2xl font-extrabold text-orange-600" x-text="'$' + finalTotal.toFixed(2)"></span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mt-4 flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                {{ __('Your information is secure') }}
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function checkoutSteps() {
            return {
                currentStep: 0,
                steps: ['{{ __("Shipping") }}', '{{ __("Review") }}', '{{ __("Payment") }}'],
                completedSteps: [],
                form: {
                    name: '',
                    email: '',
                    phone: '',
                    address: '',
                    city: '',
                    state: '',
                    postalCode: '',
                    country: '',
                },
                paymentMethod: 'cod',
                couponInput: '',
                couponCode: '',
                couponMessage: '',
                couponValid: false,
                discount: 0,
                subtotal: {{ $subtotal }},
                tax: {{ $tax }},
                get finalTotal() {
                    return Math.max(0, this.subtotal + this.tax - this.discount);
                },
                @auth
                init() {
                    this.form.name = '{{ auth()->user()->name }}';
                    this.form.email = '{{ auth()->user()->email }}';
                },
                @endauth
                goTo(index) {
                    if (this.completedSteps.includes(index) || index === this.currentStep + 1 && this.completedSteps.includes(this.currentStep)) {
                        this.currentStep = index;
                    }
                },
                nextStep() {
                    if (this.currentStep === 0 && !this.validateShipping()) return;
                    this.completedSteps.push(this.currentStep);
                    this.currentStep++;
                },
                prevStep() {
                    if (this.currentStep > 0) this.currentStep--;
                },
                validateShipping() {
                    if (!this.form.name || !this.form.email || !this.form.address || !this.form.city) {
                        alert('{{ __("Please fill in all required fields") }}');
                        return false;
                    }
                    return true;
                },
                async applyCoupon() {
                    const code = this.couponInput.trim().toUpperCase();
                    if (!code) {
                        this.couponMessage = '{{ __("Please enter a coupon code") }}';
                        this.couponValid = false;
                        return;
                    }
                    try {
                        const res = await fetch('/coupon/validate', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                code,
                                subtotal: this.subtotal
                            })
                        });
                        const data = await res.json();
                        if (data.valid) {
                            this.couponCode = code;
                            this.discount = data.discount;
                            this.couponMessage = '{{ __("Coupon applied! You saved") }} $' + data.discount.toFixed(2);
                            this.couponValid = true;
                        } else {
                            this.couponCode = '';
                            this.discount = 0;
                            this.couponMessage = data.message || '{{ __("Invalid coupon") }}';
                            this.couponValid = false;
                        }
                    } catch (e) {
                        this.couponMessage = '{{ __("Error validating coupon") }}';
                        this.couponValid = false;
                    }
                },
                submitForm() {
                    if (this.currentStep !== 2) return;
                    this.completedSteps = [0, 1, 2];
                    this.$el.submit();
                }
            };
        }
    </script>
    @endpush
</x-layouts.store>