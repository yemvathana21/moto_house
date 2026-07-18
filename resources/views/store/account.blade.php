<x-layouts.store title="{{ __('My Account') }}">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center gap-4 mb-8">
            @if($user->profile_photo)
                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}" class="w-14 h-14 rounded-2xl object-cover">
            @else
                <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center">
                    <span class="text-xl font-bold text-orange-600">{{ substr($user->name, 0, 1) }}</span>
                </div>
            @endif
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('My Account') }}</h1>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white rounded-2xl border border-gray-100 p-5 text-center hover:shadow-md transition">
                <p class="text-3xl font-extrabold text-orange-600">{{ $totalOrders }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ __('Total Orders') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 p-5 text-center hover:shadow-md transition">
                <p class="text-3xl font-extrabold text-emerald-600">{{ $deliveredCount }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ __('Delivered') }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 p-5 text-center hover:shadow-md transition">
                <p class="text-3xl font-extrabold text-amber-600">{{ $inProgressCount }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ __('In Progress') }}</p>
            </div>
            
        </div>

        <h2 class="text-xl font-bold text-gray-900 mb-4">{{ __('Order History') }}</h2>

        @if ($orders->count())
            <div class="space-y-4">
                @foreach ($orders as $order)
                    <a href="/order/track?order_number={{ $order->order_number }}" class="block bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-md hover:border-orange-100 transition-all duration-200">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <p class="font-semibold text-gray-900">{{ __('Order') }} #{{ $order->order_number }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                            <span class="px-3 py-1 rounded-lg text-xs font-semibold
                                @switch($order->status)
                                    @case('pending') bg-yellow-50 text-yellow-700 @break
                                    @case('processing') bg-blue-50 text-blue-700 @break
                                    @case('shipped') bg-purple-50 text-purple-700 @break
                                    @case('delivered') bg-emerald-50 text-emerald-700 @break
                                    @case('cancelled') bg-red-50 text-red-700 @break
                                    @default bg-gray-50 text-gray-700
                                @endswitch
                            ">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">{{ $order->items->count() }} {{ __('items') }}</span>
                            <span class="font-bold text-gray-900">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @else
            <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
                <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="text-lg font-semibold text-gray-900 mb-1">{{ __('No orders yet') }}</p>
                <p class="text-sm text-gray-500 mb-6">{{ __('Start shopping to see your orders here.') }}</p>
                <a href="/shop" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-orange-600 transition">
                    {{ __('Start Shopping') }}
                </a>
            </div>
        @endif
    </div>
</x-layouts.store>
