@props(['disabled' => false])

<input 
    @disabled($disabled) 
    {{ $attributes->merge([
        'class' => '
            w-full px-3 py-2 
            border border-gray-300 dark:border-gray-600 
            rounded-lg shadow-sm 
            bg-white dark:bg-gray-800 
            text-gray-700 dark:text-gray-100 
            placeholder-gray-400 dark:placeholder-gray-500
            focus:outline-none 
            focus:ring-2 focus:ring-teal-500 dark:focus:ring-teal-500 
            focus:border-teal-500 dark:focus:border-teal-500
            transition duration-200
        '
    ]) }}
>
