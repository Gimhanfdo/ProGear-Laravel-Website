<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-200 dark:text-gray-200 leading-tight">
            {{ __('Everything Cricket. All in One Spot.') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <livewire:image-carousel :images="[
        ['src' => 'images/landinghero1.webp', 'caption' => 'Greatness is Contagious.'],
        ['src' => 'images/landinghero2.webp', 'caption' => 'Nothing is Impossible.'],
        ['src' => 'images/landinghero3.jpeg', 'caption' => 'Strive for Success.']
    ]" />

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-start items-center py-4 px-4">
                <h1 class="font-semibold text-lg tracking-wide">Flash Discounts</h1>
                <img class="mx-5 w-10 h-10" src="animations/icons8-flash.gif" alt="flash-on" />
            </div>

            <livewire:product-grid :discounted-only="true" />
        </div>

            <section class="relative mt-4">
                <!-- Overlay -->
                <div class="absolute inset-0 bg-black bg-opacity-90 rounded-lg"></div>

                <!-- Content -->
                <div class="relative z-10 max-w-6xl mx-auto px-0 py-20 text-white">
                    <h2 class="text-4xl md:text-5xl font-bold leading-tight mb-4">Trusted by thousands
                        of<br />cricketers worldwide
                    </h2>
                    <p class="text-lg text-gray-300 max-w-4xl mb-12">
                        From beginners to professionals, we provide top-quality cricket gear to suit every player. Our
                        commitment to
                        quality and service has made us a trusted name in the game.
                    </p>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-8 text-center">
                        <div>
                            <p class="text-2xl font-bold">5,000+</p>
                            <p class="text-sm text-gray-300 mt-1">Happy Customers</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold">1000+</p>
                            <p class="text-sm text-gray-300 mt-1">Products</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold">24/7</p>
                            <p class="text-sm text-gray-300 mt-1">Customer Support</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold">30-Day</p>
                            <p class="text-sm text-gray-300 mt-1">Return Policy</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-white py-24 sm:py-10">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <h2 class="text-center text-xl font-semibold text-gray-900">Home to the brands trusted by champions
                    </h2>
                    <div
                        class="mx-auto mt-10 grid max-w-lg grid-cols-4 items-center gap-x-8 gap-y-10 sm:max-w-xl sm:grid-cols-6 sm:gap-x-10 lg:mx-0 lg:max-w-none lg:grid-cols-5">
                        <img class="col-span-2 max-h-12 w-full object-contain lg:col-span-1"
                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQJExpJo3Dw_KB8_rsyxAqIHxQTat8-mlvFhQ&s"
                            alt="New Balance" width="158" height="48">
                        <img class="col-span-2 max-h-12
         w-full object-contain lg:col-span-1"
                            src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b1/Asics_Logo.svg/2560px-Asics_Logo.svg.png"
                            alt="Asics" width="158" height="48">
                        <img class="col-span-2 max-h-12 w-full object-contain lg:col-span-1"
                            src="https://upload.wikimedia.org/wikipedia/commons/2/20/Adidas_Logo.svg" alt="Adidas"
                            width="158" height="48">
                        <img class="col-span-2 max-h-12 w-full object-contain sm:col-start-2 lg:col-span-1"
                            src="https://upload.wikimedia.org/wikipedia/en/d/dd/Sanspareils_Greenlands_logo.png"
                            alt="SG" width="158" height="48">
                        <img class="col-span-2 col-start-2 max-h-12 w-full object-contain sm:col-start-auto lg:col-span-1"
                            src="https://help.gray-nicolls.co.uk/hc/theming_assets/01HZPM93D3HMQW0W7VQAYGW9DZ" alt="GN"
                            width="158" height="48">
                    </div>
                </div>
            </section>
        
    </div>
</x-app-layout>