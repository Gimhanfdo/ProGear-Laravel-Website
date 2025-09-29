<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-10">
        <livewire:product-details :product="$product" />

        <!-- Customer Reviews -->
        <div class="mt-16">
            <livewire:reviews :productId="$product->id" />
        </div>

        {{-- Related Products Carousel --}}
        @if($relatedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold mb-6">You may also like</h2>
                <hr class= "mb-4">
                <div class="flex overflow-x-auto space-x-4 pb-4">
                    @foreach($relatedProducts as $related)
                        @php
                            $hasDiscount = $related->discountpercentage > 0;
                            $finalPrice = $hasDiscount
                                ? $related->price * (1 - $related->discountpercentage / 100)
                                : $related->price;
                        @endphp

                        <div class="min-w-[200px] max-w-[220px] bg-white rounded-xl shadow hover:shadow-lg transition flex-shrink-0 flex flex-col">
                            <a href="{{ route('products.show', $related->id) }}" class="block">
                                <img src="{{ $related->productimage }}" alt="{{ $related->name }}"
                                     class="w-full h-[160px] object-cover rounded-t-xl" loading="lazy" />
                            </a>
                            <div class="p-4 flex-1 flex justify-between flex-col">
                                <div>
                                    <h3 class="text-sm font-semibold truncate">{{ $related->name }}</h3>
                                    <p class="text-xs text-gray-500">{{ $related->brand }}</p>

                                    <div class="mt-2">
                                        @if($hasDiscount)
                                            <div class="flex items-baseline gap-2">
                                                <span class="text-red-600 font-bold text-sm">Rs {{ number_format($finalPrice, 2) }}</span>
                                                <span class="line-through text-gray-400 text-xs">Rs {{ number_format($related->price, 2) }}</span>
                                            </div>
                                            <span class="inline-block mt-1 text-xs bg-red-100 text-red-600 px-2 py-1 rounded">
                                                {{ $related->discountpercentage }}% OFF
                                            </span>
                                        @else
                                            <span class="text-gray-900 font-bold">Rs {{ number_format($related->price, 2) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif


    </div>
</x-app-layout>
