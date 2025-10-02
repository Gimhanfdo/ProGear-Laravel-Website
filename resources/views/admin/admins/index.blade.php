<x-admin-layout>
    <div class="max-w-6xl mx-auto py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Manage Admins</h1>
            <a href="{{ route('admin.admins.create') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Add Admin
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-100 text-gray-700 text-sm">
                    <tr>
                        <th class="p-4 text-left">#</th>
                        <th class="p-4 text-left">Name</th>
                        <th class="p-4 text-left">Email</th>
                        <th class="p-4 text-left">Password</th>
                        <th class="p-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($admins as $admin)
                        <tr class="border-b">
                            <td class="p-4 text-gray-700 font-medium">{{ $admin->id }}</td>
                            <td class="p-4 text-gray-900">{{ $admin->name }}</td>
                            <td class="p-4 text-gray-600">{{ $admin->email }}</td>
                            <td class="p-4 text-gray-600">Hashed Password</td>
                            <td class="p-4 flex gap-3">
                                <a href="{{ route('admin.admins.edit', $admin->id) }}" 
                                   class="px-3 py-1 bg-teal-500 text-white rounded hover:bg-teal-600">
                                    Edit
                                </a>
                                <form action="{{ route('admin.admins.destroy', $admin->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-1.5 bg-red-500 text-white rounded-lg shadow-sm hover:bg-red-600 transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
