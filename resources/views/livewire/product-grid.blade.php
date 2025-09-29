<div class="p-4">

    {{-- Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
            @php
                $hasDiscount = $product->discountpercentage > 0;
                $finalPrice = $hasDiscount ? $product->price * (1 - $product->discountpercentage / 100) : $product->price;
            @endphp

            <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden flex flex-col">
                {{-- Image --}}
                <a href="{{ route('products.show', $product->id) }}" class="block">
                    <img src="{{ $product->productimage }}" alt="{{ $product->name }}"
                        class="w-full h-48 object-cover" loading="lazy" />
                </a>

                <div class="p-4 flex-1 flex flex-col">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $product->brand }}</p>
                    </div>

                    <div class="mt-3 flex items-center justify-between">
                        <div>
                            @if($hasDiscount)
                                <div class="flex items-baseline gap-2">
                                    <span class="text-red-600 font-bold">LKR {{ number_format($finalPrice, 2) }}</span>
                                    <span class="line-through text-gray-400 text-sm">LKR {{ number_format($product->price, 2) }}</span>
                                </div>
                                <span class="inline-block mt-1 text-xs bg-red-100 text-red-600 px-2 py-1 rounded">
                                    {{ $product->discountpercentage }}% OFF
                                </span>
                            @else
                                <span class="text-gray-900 font-bold">LKR</span> {{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>

                        <!-- <button wire:click="addToCart({{ $product->id }})"
                            class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                            Add
                        </button> -->
                    </div>

                    <!-- <p class="text-gray-600 text-sm mt-3">{{ $product->description }}</p> -->
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500">No products found.</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>