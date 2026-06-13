<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center shrink-0">
                    <x-filament::icon name="heroicon-o-rocket-launch" class="w-6 h-6 text-orange-600" />
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-lg font-semibold text-gray-900">Deploy to Vercel</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Syncs local images to Vercel Blob, exports MySQL to SQLite, uploads the database,
                        and pushes changes to GitHub. Vercel will auto-deploy from the <code>main</code> branch.
                    </p>
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <x-filament::icon name="heroicon-o-check-circle" class="w-4 h-4 text-emerald-500 shrink-0" />
                            <span>Sync product images</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <x-filament::icon name="heroicon-o-check-circle" class="w-4 h-4 text-emerald-500 shrink-0" />
                            <span>Export MySQL → SQLite</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <x-filament::icon name="heroicon-o-check-circle" class="w-4 h-4 text-emerald-500 shrink-0" />
                            <span>Push to GitHub</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($this->running)
            <div class="bg-orange-50 border border-orange-200 rounded-xl p-4 text-sm text-orange-800 flex items-center gap-3">
                <svg class="animate-spin w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                <span>Deploying... this may take a minute.</span>
            </div>
        @endif

        @if ($this->log)
            <div class="bg-gray-950 rounded-xl overflow-hidden">
                <div class="px-4 py-2 bg-gray-900 border-b border-gray-800 flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-400 uppercase tracking-wider">Deploy Log</span>
                    <button onclick="this.closest('div').nextElementSibling.querySelector('pre').scrollTop = 0"
                            class="text-xs text-gray-500 hover:text-gray-300 transition">
                        Scroll to Top
                    </button>
                </div>
                <div class="p-4 overflow-auto max-h-96">
                    <pre class="text-sm text-gray-300 font-mono leading-relaxed whitespace-pre-wrap">{{ $this->log }}</pre>
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
