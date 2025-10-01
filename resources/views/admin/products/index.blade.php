<x-admin-layout>
    <div class="max-w-6xl mx-auto py-10">
        {{-- Header --}}
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Manage Products</h1>
            <a href="{{ route('admin.products.create') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-teal-600 text-white font-medium rounded-lg shadow-md hover:bg-teal-700 transition">
                + Add Product
            </a>
        </div>

        {{-- Table --}}
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 font-semibold">#</th>
                        <th class="px-6 py-3 font-semibold">Name</th>
                        <th class="px-6 py-3 font-semibold">Brand</th>
                        <th class="px-6 py-3 font-semibold">Category</th>
                        <th class="px-6 py-3 font-semibold">Price</th>
                        <th class="px-6 py-3 font-semibold">Quantity</th>
                        <th class="px-6 py-3 font-semibold text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-600">{{ $product->id }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                            <td class="px-6 py-4">{{ $product->brand }}</td>
                            <td class="px-6 py-4">{{ $product->category }}</td>
                            <td class="px-6 py-4">LKR {{ number_format($product->price, 2) }}</td>
                            <td class="px-6 py-4">{{ $product->quantityavailable }}</td>
                            <td class="px-6 py-4 flex items-center justify-center gap-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}" 
                                   class="px-3 py-1.5 text-sm bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition shadow-sm">
                                    Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-1.5 text-sm bg-red-500 text-white rounded-lg hover:bg-red-600 transition shadow-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if ($products->isEmpty())
                        <tr>
                            <td colspan="7" class="px-6 py-6 text-center text-gray-500">
                                No products found. <a href="{{ route('admin.products.create') }}" class="text-teal-600 hover:underline">Add one</a>.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
