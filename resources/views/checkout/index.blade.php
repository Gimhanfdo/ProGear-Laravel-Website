<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold mb-6">Checkout</h1>

        @if(session('success'))
            <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-2 bg-red-100 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8" x-data="{ payment: 'cash' }">
            <!-- Left: Delivery Details & Payment -->
            <div class="bg-white p-6 rounded-lg shadow">
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf

                    <!-- Delivery Details -->
                    <h2 class="text-lg font-semibold mb-4">Delivery Details</h2>
                    <div class="mb-4">
                        <label for="shippingaddress" class="block text-sm font-medium">Shipping Address</label>
                        <input type="text" name="shippingaddress" id="shippingaddress"
                            class="w-full border rounded p-2 focus:ring focus:ring-green-300"
                            value="{{ old('shippingaddress') }}" required>
                    </div>

                    <!-- Payment Method -->
                    <h2 class="text-lg font-semibold mb-4">Payment Method</h2>
                    <div class="flex gap-6 mb-6">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="paymentmethod" value="cash" x-model="payment" checked>
                            Cash on Delivery
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="paymentmethod" value="card" x-model="payment">
                            Card Payment
                        </label>
                    </div>

                    <!-- Card Details -->
                    <div x-show="payment === 'card'" class="space-y-4 border-t pt-4">
                        <div>
                            <label for="cardnumber" class="block text-sm font-medium">Card Number</label>
                            <input type="text" name="cardnumber" id="cardnumber" maxlength="16" pattern="\d{16}"
                                x-bind:required="payment === 'card'"
                                class="w-full border rounded p-2 focus:ring focus:ring-green-300">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="expirydate" class="block text-sm font-medium">Expiry Date</label>
                                <input type="month" name="expirydate" id="expirydate"
                                    x-bind:required="payment === 'card'"
                                    class="w-full border rounded p-2 focus:ring focus:ring-green-300">
                            </div>
                            <div>
                                <label for="cvv" class="block text-sm font-medium">CVV</label>
                                <input type="text" name="cvv" id="cvv" maxlength="3" pattern="\d{3}"
                                    x-bind:required="payment === 'card'"
                                    class="w-full border rounded p-2 focus:ring focus:ring-green-300">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="mt-6 w-full bg-teal-600 hover:bg-teal-500 text-white py-2 rounded">
                        Confirm & Place Order
                    </button>
                </form>
            </div>

            <!-- Right: Order Summary -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4">Order Summary</h2>

                @php $subtotal = 0; @endphp
                <div class="space-y-4">
                    @foreach ($cart->items as $item)
                        @php
                            $price = $item->product->price;
                            if ($item->product->discountpercentage > 0) {
                                $price *= (1 - $item->product->discountpercentage / 100);
                            }
                            $total = $price * $item->quantity;
                            $subtotal += $total;
                        @endphp
                        <div class="flex justify-between items-center border-b pb-2">
                            <div>
                                <p class="font-semibold">{{ $item->product->name }}</p>
                                <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                                <p class="text-sm text-gray-600">Unit Price: Rs {{ number_format($price, 2) }}</p>
                            </div>
                            <p class="font-bold">Rs {{ number_format($total, 2) }}</p>
                        </div>
                    @endforeach
                </div>

                @php
                    $vat = $subtotal * 0.18;
                    $finalTotal = $subtotal + $vat;
                @endphp

                <div class="mt-4 space-y-2">
                    <div class="flex justify-between">
                        <span>Subtotal:</span>
                        <span>Rs {{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>VAT (18%):</span>
                        <span>Rs {{ number_format($vat, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg border-t pt-2">
                        <span>Total:</span>
                        <span>Rs {{ number_format($finalTotal, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js CDN for dynamic card fields -->
    <script src="//unpkg.com/alpinejs" defer></script>
</x-app-layout>