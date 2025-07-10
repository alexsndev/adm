<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="/css/frases-motivacionais.css">
    <link rel="stylesheet" href="/css/bottom-navigation.css">
    <link rel="stylesheet" href="/css/notifications.css">
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 overflow-x-hidden">
    <div class="main-content-padding">
        <div class="flex min-h-screen w-full">
            @component('components.bottom-navigation') @endcomponent
            <div class="flex-1 flex flex-col bg-white dark:bg-[#0d1117] min-h-screen p-0 m-0 relative z-10">
                <main class="flex-1 w-full max-w-full overflow-x-auto pb-16 md:pb-0">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>
</html>
