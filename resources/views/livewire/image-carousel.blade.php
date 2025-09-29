<div class="relative w-full h-96 md:h-[500px] overflow-hidden rounded-xl shadow-lg">
    @foreach($images as $index => $image)
        <div class="absolute inset-0 transition-opacity duration-700"
             style="opacity: {{ $currentSlide === $index ? '1' : '0' }}">
            <img src="{{ asset($image['src']) }}" class="w-full h-full object-cover" />

            @if(isset($image['caption']))
                <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                    <h2 class="text-white text-2xl md:text-4xl font-bold text-center px-4 md:px-0">
                        {{ $image['caption'] }}
                    </h2>
                </div>
            @endif
        </div>
    @endforeach

    <!-- Navigation Arrows -->
    <button wire:click="prevSlide"
            class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-70 transition">
        &#10094;
    </button>
    <button wire:click="nextSlide"
            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-70 transition">
        &#10095;
    </button>

    <!-- Indicators -->
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2">
        @foreach($images as $index => $image)
            <span wire:click="goToSlide({{ $index }})"
                  class="w-3 h-3 md:w-4 md:h-4 rounded-full cursor-pointer transition
                         {{ $currentSlide === $index ? 'bg-white' : 'bg-gray-400 hover:bg-white' }}">
            </span>
        @endforeach
    </div>
</div>
