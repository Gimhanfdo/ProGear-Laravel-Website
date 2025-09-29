<nav x-data="{ open: false }" class="bg-gradient-to-r from-gray-100 to-gray-300 dark:from-gray-800 dark:to-gray-900 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <!-- Logo / Brand -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}" class="text-gray-900 dark:text-gray-100 font-bold text-xl sm:text-xl">
                    PROGEAR
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden sm:flex sm:space-x-6">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    Home
                </x-nav-link>
                <x-nav-link :href="route('products.category', ['category' => 'bats'])" :active="request()->is('products/category/bats')">
                    Cricket Bats
                </x-nav-link>
                <x-nav-link :href="route('products.category', ['category' => 'balls'])" :active="request()->is('products/category/balls')">
                    Cricket Balls
                </x-nav-link>
                <x-nav-link :href="route('products.category', ['category' => 'helmets'])" :active="request()->is('products/category/helmets')">
                    Cricket Helmets
                </x-nav-link>
                <x-nav-link :href="route('products.category', ['category' => 'other'])" :active="request()->is('products/category/other')">
                    Other Equipment
                </x-nav-link>
                <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                    My Cart
                </x-nav-link>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center px-4 py-2 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-lg text-sm font-medium text-gray-700 dark:text-gray-200 transition-all duration-200">
                            {{ Auth::user()->name }}
                            <svg class="ml-2 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger -->
            <div class="-mr-2 flex sm:hidden">
                <button @click="open = !open" 
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none transition-all">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-gray-100 dark:bg-gray-900">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Home</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.category', ['category' => 'bats'])" :active="request()->is('products/category/bats')">Cricket Bats</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.category', ['category' => 'balls'])" :active="request()->is('products/category/balls')">Cricket Balls</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.category', ['category' => 'helmets'])" :active="request()->is('products/category/helmets')">Cricket Helmets</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.category', ['category' => 'other'])" :active="request()->is('products/category/other')">Other Equipment</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">Cart</x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-3 border-t border-gray-300 dark:border-gray-700">
            <div class="px-4">
                <div class="font-medium text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-600 dark:text-gray-400">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
