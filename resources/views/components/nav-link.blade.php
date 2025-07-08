@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center px-3 py-2 rounded-lg bg-blue-600 dark:bg-blue-500/30 text-white dark:text-blue-100 shadow font-bold transition duration-150 ease-in-out'
    : 'inline-flex items-center px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-blue-600/10 dark:hover:bg-blue-500/10 hover:text-blue-700 dark:hover:text-blue-200 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
