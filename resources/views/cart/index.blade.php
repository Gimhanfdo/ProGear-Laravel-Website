<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-2xl">My Cart</h1>
        <br>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 px-4 py-2 bg-red-100 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

        @if ($cart && $cart->items->count() > 0)
            @php
                $grandTotal = 0;
            @endphp
            @foreach ($cart->items as $item)
                @php
                    $price = $item->product->price;
                    if ($item->product->discountpercentage > 0) {
                        $price *= (1 - $item->product->discountpercentage / 100);
                    }
                    $total = $price * $item->quantity;
                    $grandTotal += $total;
                @endphp
            @endforeach

            @php
                $vat = $grandTotal * 0.18;
                $finalTotal = $grandTotal + $vat;
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Cart Items --}}
                <div class="lg:col-span-2 overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-3 text-left">Product</th>
                                <th class="p-3 text-center">Price</th>
                                <th class="p-3 text-center">Quantity</th>
                                <th class="p-3 text-center">Total</th>
                                <th class="p-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart->items as $item)
                                @php
                                    $price = $item->product->price;
                                    if ($item->product->discountpercentage > 0) {
                                        $price *= (1 - $item->product->discountpercentage / 100);
                                    }
                                    $total = $price * $item->quantity;
                                @endphp
                                <tr class="border-b">
                                    <td class="p-3 flex items-center gap-4">
                                        <img src="{{ $item->product->productimage }}" alt="{{ $item->product->name }}"
                                            class="w-16 h-16 object-cover rounded">
                                        <div>
                                            <p class="font-semibold">{{ $item->product->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $item->product->brand }}</p>
                                        </div>
                                    </td>
                                    <td class="p-3 text-right whitespace-nowrap">Rs {{ number_format($price, 2) }}</td>
                                    <td class="p-3 text-center">
                                        <form action="{{ route('cart.update', $item) }}" method="POST"
                                            class="flex items-center justify-center gap-2">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}"
                                                class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">-</button>
                                            <span>{{ $item->quantity }}</span>
                                            <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}"
                                                class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">+</button>
                                        </form>
                                    </td>
                                    <td class="p-3 text-right whitespace-nowrap">Rs {{ number_format($total, 2) }}</td>
                                    <td class="p-3 text-center">
                                        <form action="{{ route('cart.remove', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-6 py-3 bg-orange-600 text-white rounded hover:bg-red-700">Clear
                                Cart</button>
                        </form>
                    </div>
                </div>

                {{-- Cart Summary --}}
                <div class="p-6 bg-gray-100 rounded-lg shadow">
                    <h2 class="text-lg font-semibold mb-4">Cart Summary</h2>
                    <div class="flex justify-between mb-2">
                        <span>Subtotal:</span>
                        <span>Rs {{ number_format($grandTotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>VAT (18%):</span>
                        <span>Rs {{ number_format($vat, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg border-t pt-2">
                        <span>Total:</span>
                        <span>Rs {{ number_format($finalTotal, 2) }}</span>
                    </div>

                    <a href="{{ route('checkout.index') }}"
                        class="mt-4 block w-full text-center px-6 py-3 bg-teal-600 hover:bg-teal-500 text-white rounded">Proceed to Checkout</a>
                </div>
            </div>
        @else
            <p class="text-center text-gray-500 text-lg">Your cart is empty.</p>
        @endif
    </div>

</x-app-layout>