<x-admin-layout>
    <div class="max-w-6xl mx-auto py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manage Users</h1>
        </div>

        <!-- Table Container -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full text-sm border-collapse">
                <!-- Table Head -->
                <thead class="bg-gray-100 text-gray-700 text-sm">
                    <tr>
                        <th class="p-4 text-left">#</th>
                        <th class="p-4 text-left">Name</th>
                        <th class="p-4 text-left">Email</th>
                        <th class="p-4 text-left">Password</th>
                        <th class="p-4 text-left">Actions</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 text-gray-700 font-medium">{{ $user->id }}</td>
                            <td class="p-4 text-gray-900">{{ $user->name }}</td>
                            <td class="p-4 text-gray-600">{{ $user->email }}</td>
                            <td class="p-4 text-gray-600">Hashed Password</td>
                            <td class="p-4 flex gap-3">
                                <!-- Delete Button -->
                                <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this user?')">
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

                    @if($users->isEmpty())
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-500">
                                No users found.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
