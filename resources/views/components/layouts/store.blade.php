<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@100..700&display=swap" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? __('Moto House') }} - {{ __('Moto House') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
@livewireScripts
<body class="bg-gray-50 text-gray-900 antialiased font-sans">
    <header class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="/" class="text-2xl font-extrabold text-orange-600 tracking-tight flex items-center gap-2">
                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                    {{ __('Moto House') }}
                </a>
                <nav class="hidden md:flex items-center gap-1 text-sm font-medium">
                    <a href="/" class="px-3 py-2 rounded-lg hover:bg-orange-50 hover:text-orange-600 transition {{ request()->is('/') ? 'text-orange-600 bg-orange-50' : 'text-gray-700' }}">{{ __('Home') }}</a>
                    <a href="/shop" class="px-3 py-2 rounded-lg hover:bg-orange-50 hover:text-orange-600 transition {{ request()->is('shop') || request()->is('shop/*') ? 'text-orange-600 bg-orange-50' : 'text-gray-700' }}">{{ __('Shop') }}</a>
                    <a href="/wishlist" class="px-3 py-2 rounded-lg hover:bg-orange-50 hover:text-orange-600 transition {{ request()->is('wishlist') ? 'text-orange-600 bg-orange-50' : 'text-gray-700' }}">{{ __('Wishlist') }}</a>
                    <a href="/order/track" class="px-3 py-2 rounded-lg hover:bg-orange-50 hover:text-orange-600 transition {{ request()->is('order/*') ? 'text-orange-600 bg-orange-50' : 'text-gray-700' }}">{{ __('Track Order') }}</a>
                </nav>
                <div class="flex items-center gap-2">
                    <a href="/wishlist" class="p-2.5 rounded-xl text-gray-500 hover:text-orange-600 hover:bg-orange-50 transition hidden md:block" title="{{ __('Wishlist') }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </a>

                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 rounded-xl text-gray-700 hover:text-orange-600 hover:bg-orange-50 transition">
                                <div class="w-7 h-7 bg-orange-100 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-bold text-orange-600">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <span class="text-sm font-medium hidden lg:block">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50" x-cloak>
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="/order/track" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition">{{ __('Track Order') }}</a>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition">{{ __('Sign Out') }}</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-orange-600 hover:bg-orange-50 rounded-xl transition">{{ __('Sign In') }}</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-semibold bg-gray-900 text-white rounded-xl hover:bg-orange-600 transition">{{ __('Register') }}</a>
                    @endauth

                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="p-2.5 rounded-xl text-gray-500 hover:text-orange-600 hover:bg-orange-50 transition" title="{{ __('Language') }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-32 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50" x-cloak>
                            <a href="{{ url('language/en') }}" class="block px-4 py-2.5 text-sm {{ app()->getLocale() === 'en' ? 'text-orange-600 font-semibold' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }} transition">English</a>
                            <a href="{{ url('language/km') }}" class="block px-4 py-2.5 text-sm {{ app()->getLocale() === 'km' ? 'text-orange-600 font-semibold' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }} transition">ភាសាខ្មែរ</a>
                        </div>
                    </div>

                    <a href="/cart" class="relative p-2.5 rounded-xl text-gray-500 hover:text-orange-600 hover:bg-orange-50 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/>
                        </svg>
                        <livewire:cart-counter />
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif
        {{ $slot }}
    </main>

    @livewireScriptConfig
    <footer class="bg-gray-950 text-gray-400 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="md:col-span-1">
                    <a href="/" class="text-xl font-extrabold text-white tracking-tight flex items-center gap-2 mb-4">
                        <svg class="w-6 h-6 text-orange-500" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        {{ __('Moto House') }}
                    </a>
                    <p class="text-sm leading-relaxed">{{ __('Premium motorcycle accessories for riders who demand the best. Quality gear for every ride.') }}</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">{{ __('Shop') }}</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="/shop" class="hover:text-white transition">{{ __('All Products') }}</a></li>
                        @php $navCats = \App\Models\Category::where('is_active', true)->whereNull('parent_id')->get(); @endphp
                        @foreach ($navCats as $cat)
                            <li><a href="/shop?category_id={{ $cat->id }}" class="hover:text-white transition">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">{{ __('Support') }}</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="/contact" class="hover:text-white transition">{{ __('Contact Us') }}</a></li>
                        <li><a href="#" class="hover:text-white transition">{{ __('Shipping Info') }}</a></li>
                        <li><a href="#" class="hover:text-white transition">{{ __('Returns & Exchanges') }}</a></li>
                        <li><a href="/order/track" class="hover:text-white transition">{{ __('Track Order') }}</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">{{ __('Contact') }}</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            yemvathana86.com
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            +955 978 537 707
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-sm">
                <p>&copy; {{ date('Y') }} {{ __('Moto House') }}. {{ __('All rights reserved.') }}</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-white transition">{{ __('Privacy Policy') }}</a>
                    <a href="#" class="hover:text-white transition">{{ __('Terms of Service') }}</a>
                </div>
            </div>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>
