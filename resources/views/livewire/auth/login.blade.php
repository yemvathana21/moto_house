<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('Sign In') }}</h1>
            <p class="text-gray-500 mt-2">{{ __('Welcome back! Sign in to your account.') }}</p>
        </div>

        @if (session('status'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm mb-6">{{ session('status') }}</div>
        @endif

        <form wire:submit="login" class="bg-white rounded-2xl border border-gray-100 p-8 space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Email') }}</label>
                <input type="email" wire:model="email" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none" placeholder="you@example.com">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Password') }}</label>
                <input type="password" wire:model="password" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none" placeholder="••••••••">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" wire:model="remember" class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                    {{ __('Remember me') }}
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-orange-600 hover:text-orange-500 font-medium">{{ __('Forgot password?') }}</a>
                @endif
            </div>

            <button type="submit" class="w-full py-3 bg-gray-900 text-white font-semibold rounded-xl hover:bg-orange-600 transition flex items-center justify-center gap-2" wire:loading.attr="disabled">
                <svg wire:loading class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                {{ __('Sign In') }}
            </button>

            <p class="text-center text-sm text-gray-500">
                {{ __("Don't have an account?") }}
                <a href="{{ route('register') }}" class="text-orange-600 hover:text-orange-500 font-medium">{{ __('Create one') }}</a>
            </p>
        </form>
    </div>
</div>
