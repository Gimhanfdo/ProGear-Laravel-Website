<x-app-layout>
    <div class="flex items-center justify-center min-h-screen">
        <div class="flex flex-col items-center justify-center bg-white dark:bg-gray-900 shadow-2xl rounded-3xl p-10 max-w-md text-center">
            <h2 class="logo-text text-3xl font-extrabold text-gray-900 dark:text-white mb-4">PROGEAR</h2>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">Order Placed Successfully!</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-8 max-w-sm">
                We've sent you an email confirming your purchase.<br>
                Our delivery partner will contact you once your order is shipped.
            </p>
            <a href="{{ route('dashboard') }}" class="inline-block bg-teal-600 hover:bg-teal-500 text-white font-semibold py-3 px-8 rounded-full shadow-lg transition duration-300">
                Back to Dashboard
            </a>
        </div>
    </div>
</x-app-layout>
