<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('Create Account') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Join us and start shopping!') }}</p>
        </div>

        <form wire:submit="register" class="bg-white rounded-2xl border border-gray-100 p-8 space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Full Name') }}</label>
                <input type="text" wire:model="name" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none" placeholder="John Doe">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Email') }}</label>
                <input type="email" wire:model="email" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none" placeholder="you@example.com">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Password') }}</label>
                <input type="password" wire:model="password" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none" placeholder="Min. 8 characters">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Confirm Password') }}</label>
                <input type="password" wire:model="password_confirmation" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none" placeholder="Repeat your password">
            </div>

            <button type="submit" class="w-full py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-orange-600 transition flex items-center justify-center gap-2" wire:loading.attr="disabled">
                <svg wire:loading class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                {{ __('Create Account') }}
            </button>

            <p class="text-center text-sm text-gray-500">
                {{ __('Already have an account?') }}
                <a href="{{ route('login') }}" class="text-orange-600 hover:text-orange-500 font-medium">{{ __('Sign In') }}</a>
            </p>
        </form>
    </div>
</div>
