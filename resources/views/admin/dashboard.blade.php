<x-admin-layout>
    <div class="container mx-auto mt-12 px-4 text-center">
        <!-- Header -->
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-gray-100 mb-4">
            PROGEAR Admin Dashboard
        </h1>
        <p class="text-lg sm:text-xl text-gray-700 dark:text-gray-300 mb-8">
            Welcome back, <span class="font-semibold">{{ auth()->user()->name }}</span>!
        </p>

        <!-- Big Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <!-- Products Card -->
            <a href="{{ route('admin.products.index') }}"
               class="flex flex-col items-center justify-center p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="p-4 sm:p-6 bg-green-100 dark:bg-green-900 rounded-full mb-4">
                    <ion-icon name="cube-outline" class="text-4xl sm:text-5xl text-green-600 dark:text-green-400"></ion-icon>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 mb-1">Products</h2>
                <p class="text-gray-500 dark:text-gray-400 text-center">View, add, or update products.</p>
            </a>

            <!-- Users Card -->
            <a href="{{ route('admin.users.index') }}"
               class="flex flex-col items-center justify-center p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="p-4 sm:p-6 bg-blue-100 dark:bg-blue-900 rounded-full mb-4">
                    <ion-icon name="people-outline" class="text-4xl sm:text-5xl text-blue-600 dark:text-blue-400"></ion-icon>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 mb-1">Users</h2>
                <p class="text-gray-500 dark:text-gray-400 text-center">Manage all registered users.</p>
            </a>

            <!-- Admins Card -->
            <a href="{{ route('admin.admins.index') }}"
               class="flex flex-col items-center justify-center p-6 sm:p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                <div class="p-4 sm:p-6 bg-purple-100 dark:bg-purple-900 rounded-full mb-4">
                    <ion-icon name="shield-checkmark-outline" class="text-4xl sm:text-5xl text-purple-600 dark:text-purple-400"></ion-icon>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 mb-1">Admins</h2>
                <p class="text-gray-500 dark:text-gray-400 text-center">Manage platform administrators.</p>
            </a>
        </div>
    </div>
</x-admin-layout>
