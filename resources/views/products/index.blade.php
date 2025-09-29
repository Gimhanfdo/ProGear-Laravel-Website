<x-app-layout>
    <section class="relative bg-gradient-to-r from-gray-900 via-gray-700 to-gray-500 text-white py-16">
        <div class="max-w-4xl mx-auto text-center">
            @php
                $displayName = $category === 'Other' ? 'Other Equipment' : "Cricket {$category}s";
            @endphp

            <h1 class="text-4xl font-extrabold tracking-wide drop-shadow-lg">
                {{ $displayName }}
            </h1>
        </div>
    </section>

    {{-- Product Grid --}}
    <div class="max-w-7xl mx-auto px-4 py-12">
        <livewire:product-grid :category="$category" />
    </div>
</x-app-layout>
