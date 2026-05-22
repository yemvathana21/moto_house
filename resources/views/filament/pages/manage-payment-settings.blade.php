<x-filament-panels::page>
    <form wire:submit="save" class="space-y-6">
        {{ $this->form }}

        <!-- ប្រើប្រាស់ style="margin-top: 2.5rem;" ដើម្បីបង្ខំរុញប៊ូតុងឱ្យចុះក្រោមដាច់ខាត -->
        <div class="flex flex-wrap items-center gap-3 pt-6 border-t border-gray-200/50" style="margin-top: 1.5rem; margin-bottom: 1rem;">
            <!-- ហៅប្រើប្រាស់ Blade Component ផ្លូវការរបស់ Filament -->
            <x-filament::button type="submit" color="warning" size="md" icon="heroicon-m-check">
                {{ __('Save Settings') }}
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>