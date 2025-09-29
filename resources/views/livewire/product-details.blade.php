<div class="flex flex-col md:flex-row gap-10">
    <!-- Product Image -->
    <div class="md:w-1/2">
        <img src="{{ $product->productimage }}" alt="{{ $product->name }}"
            class="w-full h-[400px] object-cover rounded-xl shadow-lg" />
    </div>

    <!-- Product Details -->
    <div class="md:w-1/2 flex flex-col justify-start">
        <h1 class="text-3xl font-bold mb-2 truncate">{{ $product->name }}</h1>
        <p class="text-gray-500 text-lg font-semibold mb-1">Brand: {{ $product->brand }}</p>

        @php
            if ($product->quantityavailable > 5) {
                $stockStatus = 'In Stock';
                $stockClass = 'text-green-600';
            } elseif ($product->quantityavailable > 0) {
                $stockStatus = 'Limited Stock';
                $stockClass = 'text-orange-600';
            } else {
                $stockStatus = 'Out of Stock';
                $stockClass = 'text-red-600';
            }
        @endphp

        <p class="text-base {{ $stockClass }} mb-4">{{ $stockStatus }}</p>

        @php
            $hasDiscount = $product->discountpercentage > 0;
            $finalPrice = $hasDiscount
                ? $product->price * (1 - $product->discountpercentage / 100)
                : $product->price;
        @endphp

        <div class="mb-6">
            @if($hasDiscount)
                <div class="flex items-baseline gap-3">
                    <span class="text-red-600 text-2xl font-bold">Rs {{ number_format($finalPrice, 2) }}</span>
                    <span class="line-through text-gray-400">Rs {{ number_format($product->price, 2) }}</span>
                </div>
                <span class="mt-1 inline-block text-sm bg-red-100 text-red-600 px-2 py-1 rounded">
                    {{ $product->discountpercentage }}% OFF
                </span>
            @else
                <span class="text-gray-900 text-2xl font-bold">Rs {{ number_format($product->price, 2) }}</span>
            @endif
        </div>

        <p class="text-gray-700 leading-relaxed mb-6">{{ $product->description }}</p>

        <!-- Quantity Selector -->
        <div class="flex items-center gap-4 mb-6">
            <button wire:click="decrement" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">-</button>
            <span class="text-lg font-semibold">{{ $quantity }}</span>
            <button wire:click="increment" @if($quantity >= $product->quantityavailable) disabled @endif
                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 disabled:opacity-50">
                +</button>
        </div>

        <!-- Add to Cart Button -->
        <button wire:click="addToCart" @if($product->quantityavailable == 0 || $addedToCart) disabled @endif
            class="bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 transition w-max disabled:opacity-50">
            @if($addedToCart)
                Added to Cart
            @else
                Add to Cart
            @endif
        </button>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <p class="mt-4 px-4 py-2 bg-green-100 text-green-800 rounded">{{ session('success') }}</p>
        @elseif (session()->has('error'))
            <p class="mt-4 px-4 py-2 bg-red-100 text-red-800 rounded">{{ session('error') }}</p>
        @endif
    </div>
</div>