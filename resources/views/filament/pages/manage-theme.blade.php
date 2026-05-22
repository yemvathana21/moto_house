<x-filament-panels::page>
    <form wire:submit.prevent="save" class="space-y-6">
        {{ $this->schema }}

        <div class="flex flex-wrap items-center gap-4 justify-start">
            <button 
                type="submit" 
                class="fi-btn fi-btn-size-m fi-btn-color-primary fi-color-custom relative inline-grid grid-flow-col items-center justify-center gap-1.5 rounded-lg px-3 py-2 text-sm font-semibold shadow-sm ring-1 ring-inset ring-transparent bg-custom-600 text-white hover:bg-custom-500 transition duration-75"
                style="--c-400:var(--primary-400); --c-500:var(--primary-500); --c-600:var(--primary-600);"
            >
                <span>Save General Settings</span>
            </button>
        </div>
    </form>
</x-filament-panels::page>