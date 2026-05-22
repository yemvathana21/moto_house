<x-layouts.store title="{{ $page->meta_title ?? $page->title }}">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8">
            <a href="/" class="hover:text-orange-600 transition">Home</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 font-medium">{{ $page->title }}</span>
        </nav>

        <div class="bg-white rounded-2xl border border-gray-100 p-8 md:p-12 prose prose-lg max-w-none">
            <h1 class="text-3xl font-bold text-gray-900 !mt-0">{{ $page->title }}</h1>
            {!! $page->content !!}
        </div>
    </div>
</x-layouts.store>
