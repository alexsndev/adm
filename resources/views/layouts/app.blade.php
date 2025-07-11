<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- FontAwesome 6.5.0 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Fallback para produção sem Vite -->
        <script type="module" src="https://unpkg.com/vite@5/dist/vite.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2/dist/tailwind.min.css">
    @endif
    <link rel="stylesheet" href="/css/frases-motivacionais.css">
    <link rel="stylesheet" href="/css/notifications.css">
    <link rel="stylesheet" href="/css/header.css">
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 overflow-x-hidden min-h-screen w-full">
    @include('components.header')
    <div class="flex w-full min-h-screen">
        <div class="hidden md:block">
            @include('components.sidebar')
        </div>
        <main class="main-content-padding flex-1 w-full max-w-full min-h-screen flex flex-col bg-white dark:bg-[#0d1117] p-0 m-0 relative z-10">
            <main class="flex-1 w-full max-w-full overflow-x-auto pb-16 md:pb-0">
                @yield('content')
            </main>
        </main>
    </div>
    <div class="md:hidden">
        @include('components.bottom-nav')
    </div>
</body>
</html>
