<x-guest-layout>
    <div
        class="max-w-md mx-auto bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700">

        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 text-center mb-6">
            Create Account
        </h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" class="text-gray-700 dark:text-gray-300 font-medium" />
                <x-text-input id="name"
                    class="block mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-lg 
                           focus:ring-2 focus:ring-teal-500 focus:border-teal-500
                           dark:bg-gray-800 dark:text-gray-100 dark:focus:ring-teal-500 dark:focus:border-teal-500"
                    type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 dark:text-red-400" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-700 dark:text-gray-300 font-medium" />
                <x-text-input id="email"
                    class="block mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-lg 
                           focus:ring-2 focus:ring-teal-500 focus:border-teal-500
                           dark:bg-gray-800 dark:text-gray-100 dark:focus:ring-teal-500 dark:focus:border-teal-500"
                    type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 dark:text-red-400" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-gray-700 dark:text-gray-300 font-medium" />
                <x-text-input id="password"
                    class="block mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-lg 
                           focus:ring-2 focus:ring-teal-500 focus:border-teal-500
                           dark:bg-gray-800 dark:text-gray-100 dark:focus:ring-teal-500 dark:focus:border-teal-500"
                    type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 dark:text-red-400" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 dark:text-gray-300 font-medium" />
                <x-text-input id="password_confirmation"
                    class="block mt-1 w-full border border-gray-300 dark:border-gray-600 rounded-lg 
                           focus:ring-2 focus:ring-teal-500 focus:border-teal-500
                           dark:bg-gray-800 dark:text-gray-100 dark:focus:ring-teal-500 dark:focus:border-teal-500"
                    type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 dark:text-red-400" />
            </div>

            <!-- Register Button -->
            <div class="flex items-center justify-between">
                <a href="{{ route('login') }}" class="text-sm text-teal-600 font-bold hover:underline dark:text-indigo-400">
                    Already registered?
                </a>
                <x-primary-button class="px-5 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-lg shadow 
                                        dark:bg-indigo-600 dark:hover:bg-indigo-700">
                    {{ __('Register') }}
                </x-primary-button>
            </div>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <span class="w-full border-t border-gray-200 dark:border-gray-700"></span>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="bg-white dark:bg-gray-900 px-2 text-gray-400 dark:text-gray-500">or</span>
                </div>
            </div>

            <!-- Google Register -->
            <a href="{{ url('login/google') }}"
                class="flex items-center justify-center gap-2 px-4 py-2 rounded-lg border border-gray-300 bg-white 
                       hover:bg-gray-50 shadow-sm transition
                       dark:bg-gray-800 dark:border-gray-600 dark:hover:bg-gray-700">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google logo"
                    class="w-5 h-5">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Sign up with Google</span>
            </a>

        </form>
    </div>
</x-guest-layout>
