<x-admin-layout>
    <div class="max-w-3xl mx-auto py-10">
        <div class="bg-white shadow rounded-lg p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8 border-b pb-4">Add Product</h1>

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-md bg-red-50 border border-red-200">
                    <ul class="list-disc list-inside text-red-600 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Name</label>
                    <input type="text" name="name"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 p-3"
                        required>
                </div>

                {{-- Brand --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Brand</label>
                    <input type="text" name="brand"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 p-3"
                        required>
                </div>

                {{-- Category (Dropdown) --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
                    <select name="category"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 p-3"
                        required>
                        <option value="">-- Select Category --</option>
                        <option value="Bat">Bat</option>
                        <option value="Ball">Ball</option>
                        <option value="Helmet">Helmet</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                {{-- Price --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Price</label>
                    <input type="number" step="0.01" name="price"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 p-3"
                        required>
                </div>

                {{-- Product Image --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Product Image (URL)</label>
                    <input type="text" name="productimage"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 p-3"
                        required>
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 p-3"
                        required></textarea>
                </div>

                {{-- Discount --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Discount (%)</label>
                    <input type="number" name="discountpercentage"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 p-3">
                </div>

                {{-- Quantity --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Quantity Available</label>
                    <input type="number" name="quantityavailable"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 p-3"
                        required>
                </div>

                {{-- Submit Button --}}
                <div class="pt-4">
                    <button type="submit"
                        class="w-full sm:w-auto px-6 py-3 bg-teal-600 text-white font-semibold rounded-lg shadow-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
