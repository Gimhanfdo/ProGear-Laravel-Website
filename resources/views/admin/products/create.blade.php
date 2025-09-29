<x-admin-layout>
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Add Product</h1>

        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium">Name</label>
                <input type="text" name="name" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium">Brand</label>
                <input type="text" name="brand" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium">Category</label>
                <input type="text" name="category" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium">Price</label>
                <input type="number" step="0.01" name="price" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium">Product Image</label>
                <input type="text" name="productimage" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium">Description</label>
                <input type="text" name="description" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium">Discount (%)</label>
                <input type="number" name="discountpercentage" class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Quantity Available</label>
                <input type="number" name="quantityavailable" class="w-full border rounded p-2" required>
            </div>

            <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Save
            </button>
        </form>
    </div>
</x-admin-layout>
