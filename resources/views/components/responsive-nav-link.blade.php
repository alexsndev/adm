@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block w-full ps-3 pe-4 py-2 rounded-lg bg-blue-600 dark:bg-blue-500/30 text-white dark:text-blue-100 font-bold shadow transition duration-150 ease-in-out'
    : 'block w-full ps-3 pe-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-blue-600/10 dark:hover:bg-blue-500/10 hover:text-blue-700 dark:hover:text-blue-200 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
