<x-layouts.store title="{{ __('Payment') }}">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Complete Your Payment') }}</h1>
            <p class="text-gray-500">{{ __('Scan the QR code below with your ABA Mobile app to pay.') }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-8">
            <div class="text-center mb-6">
                <p class="text-sm text-gray-500 mb-1">{{ __('Order') }} #{{ $order->order_number }}</p>
                <p class="text-4xl font-extrabold text-orange-600">${{ number_format($order->total, 2) }}</p>
            </div>

            <div class="flex justify-center mb-6">
                <div class="bg-white rounded-2xl p-4 shadow-lg border border-gray-100">
                    {!! $qrSvg !!}
                </div>
            </div>

            <div class="text-center space-y-2 mb-8">
                <p class="font-semibold text-gray-900">{{ __('Pay with ABA KHQR') }}</p>
                <p class="text-sm text-gray-500">{{ __('Merchant') }}: <span class="font-medium text-gray-900">{{ $merchantName }}</span></p>
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
                    <li>{{ __('Open your ABA Mobile app') }}</li>
                    <li>{{ __('Tap on "Scan & Pay" or "KHQR"') }}</li>
                    <li>{{ __('Scan the QR code above') }}</li>
                    <li>{{ __('Confirm the amount and complete payment') }}</li>
                </ol>
            </div>

            <div class="text-center">
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
</x-layouts.store>
