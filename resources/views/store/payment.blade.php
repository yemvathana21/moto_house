<x-layouts.store title="{{ __('Payment') }}">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Complete Your Payment') }}</h1>
            <p class="text-gray-500">{{ __('Please complete your payment for the order below.') }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-6 md:p-8">
            <div class="text-center mb-6">
                <p class="text-sm text-gray-500 mb-1">{{ __('Order') }} #{{ $order->order_number }}</p>
                <p class="text-4xl font-extrabold text-orange-600">${{ number_format($order->total, 2) }}</p>
            </div>

            @if ($deepLink)
                <div class="flex flex-col gap-3 mb-8">
                    <a href="{{ $deepLink }}"
                       class="w-full py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition flex items-center justify-center gap-2 text-base">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        {{ __('Pay with ABA Mobile') }}
                    </a>
                </div>

                <div class="bg-gray-50 rounded-xl p-5 mb-8">
                    <h4 class="font-semibold text-gray-900 mb-3 text-sm">{{ __('Instructions') }}:</h4>
                    <ol class="space-y-2 text-sm text-gray-600 list-decimal list-inside">
                        <li>{{ __('Tap "Pay with ABA Mobile" above') }}</li>
                        <li>{{ __('ABA Mobile will open with payment details pre-filled') }}</li>
                        <li>{{ __('Enter your password and confirm the payment') }}</li>
                    </ol>
                </div>
            @else
                <div class="flex justify-center mb-6">
                    <div class="bg-white rounded-2xl p-4 shadow-lg border border-gray-100">
                        {!! $qrSvg !!}
                    </div>
                </div>

                <div class="text-center space-y-2 mb-8">
                    <p class="font-semibold text-gray-900">{{ __('Pay with ABA KHQR') }}</p>
                    <p class="text-sm text-gray-500">{{ __('Merchant') }}: <span class="font-medium text-gray-900">{{ $merchantName }}</span></p>
                    @if ($merchantId || $bakongId)
                        <p class="text-sm text-gray-500">{{ __('Account') }}: <span class="font-medium text-gray-900">{{ $bakongId ?: $merchantId }}</span></p>
                    @endif
                    <p class="text-sm text-gray-500">{{ __('Bank') }}: <span class="font-medium text-gray-900">{{ $bankName }}</span></p>
                    <div class="flex items-center justify-center gap-2 text-sm text-gray-500">
                        <span class="inline-flex items-center gap-1">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ __('Secure payment') }}
                        </span>
                        <span class="text-gray-300">|</span>
                        <span class="inline-flex items-center gap-1">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            {{ __('Powered by ABA Bank') }}
                        </span>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-5 mb-8">
                    <h4 class="font-semibold text-gray-900 mb-3 text-sm">{{ __('Instructions') }}:</h4>
                    <ol class="space-y-2 text-sm text-gray-600 list-decimal list-inside">
                        <li>{{ __('Scan the QR code above with ABA Mobile') }}</li>
                        <li>{{ __('Confirm the amount and complete payment') }}</li>
                    </ol>
                </div>

                @if ($qrString)
                    <div class="text-center border-t border-gray-100 pt-6 mt-6">
                        <p class="text-xs text-gray-400 mb-3">{{ __('If scanning does not work, copy the payment info below:') }}</p>
                        <div class="flex items-center justify-center gap-2">
                            <input type="text" value="{{ $qrString }}" readonly id="khqr-input"
                                   class="w-full max-w-md px-3 py-2 text-xs border border-gray-200 rounded-lg bg-gray-50 text-gray-500 font-mono">
                            <button onclick="copyKHQR()"
                                    class="shrink-0 px-4 py-2 bg-gray-900 text-white text-xs font-semibold rounded-lg hover:bg-orange-600 transition">
                                {{ __('Copy') }}
                            </button>
                        </div>
                    </div>
                @endif
            @endif

            <div class="text-center mt-6 pt-6 border-t border-gray-100">
                <p class="text-sm text-gray-500 mb-4">{{ __('After payment, your order will be processed. You can track your order status below.') }}</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="/order/track?order_number={{ $order->order_number }}" class="px-6 py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-orange-600 transition">
                        {{ __('Track Order') }}
                    </a>
                    <a href="/" class="px-6 py-3 border-2 border-gray-200 text-gray-600 font-semibold rounded-xl hover:border-gray-300 hover:bg-gray-50 transition">
                        {{ __('Back to Home') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if (!$deepLink)
    @push('scripts')
    <script>
        function copyKHQR() {
            const input = document.getElementById('khqr-input');
            input.select();
            navigator.clipboard.writeText(input.value).then(() => {
                const btn = input.nextElementSibling;
                const original = btn.textContent;
                btn.textContent = '{{ __("Copied!") }}';
                setTimeout(() => btn.textContent = original, 2000);
            });
        }
    </script>
    @endpush
    @endif
</x-layouts.store>
