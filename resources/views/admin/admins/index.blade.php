<x-admin-layout>
    <div class="max-w-6xl mx-auto py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Manage Admins</h1>
            <a href="{{ route('admin.admins.create') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Add Admin
            </a>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">#</th>
                        <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">Password</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                        <tr class="border-b">
                            <td class="p-3">{{ $admin->id }}</td>
                            <td class="p-3">{{ $admin->name }}</td>
                            <td class="p-3">{{ $admin->email }}</td>
                            <td class="p-3">{{ $admin->password }}</td>
                            <td class="p-3 flex gap-2">
                                <a href="{{ route('admin.admins.edit', $admin->id) }}" 
                                   class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                    Edit
                                </a>
                                <form action="{{ route('admin.admins.destroy', $admin->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
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
