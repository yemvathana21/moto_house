<x-layouts.store title="Contact Us">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ __('Get in Touch') }}</h1>
            <p class="text-gray-500">{{ __("Have a question? We'd love to hear from you.") }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center hover:shadow-lg transition">
                <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Email</h3>
                <p class="text-gray-500 text-sm">yamvathana86@gmail.com</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center hover:shadow-lg transition">
                <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Phone</h3>
                <p class="text-gray-500 text-sm">+855 978 537 707</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center hover:shadow-lg transition">
                <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Location</h3>
                <p class="text-gray-500 text-sm">Phnom Penh, Cambodia</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">{{ __('Send Us a Message') }}</h2>
            <form action="/contact" method="POST">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Your Name') }}</label>
                        <input type="text" name="name" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Your Email') }}</label>
                        <input type="email" name="email" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                    </div>
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Subject') }}</label>
                    <input type="text" name="subject" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Message') }}</label>
                    <textarea name="message" required rows="5" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none"></textarea>
                </div>
                <button type="submit" class="px-8 py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-orange-600 transition">{{ __('Send Message') }}</button>
            </form>
        </div>
    </div>
</x-layouts.store>