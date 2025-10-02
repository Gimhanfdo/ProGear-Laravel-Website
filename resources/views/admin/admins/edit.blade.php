<x-admin-layout>
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Edit Admin</h1>

        @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium">Name</label>
                <input type="text" name="name" value="{{ $admin->name }}" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="text" name="email" value="{{ $admin->email }}" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="password" value="" class="w-full border rounded p-2">
            </div>

            <div>
                <label class="block text-sm font-medium">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded p-2">
            </div>

            <button type="submit" 
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Update
            </button>
        </form>
    </div>
</x-admin-layout>
