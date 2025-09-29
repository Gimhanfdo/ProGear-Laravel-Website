<button 
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => '
            inline-flex justify-center items-center
            px-5 py-2.5
            bg-teal-500 dark:bg-indigo-600
            text-white font-medium text-sm
            rounded-lg shadow-md
            hover:bg-teal-600 dark:hover:bg-indigo-700
            focus:outline-none focus:ring-2 focus:ring-teal-400 dark:focus:ring-indigo-500
            focus:ring-offset-1 dark:focus:ring-offset-gray-900
            transition duration-200 ease-in-out
        '
    ]) }}
>
    {{ $slot }}
</button>
