<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-x-hidden" x-data="{ sidebarOpen: true }">
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
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 overflow-x-hidden min-h-screen w-full">
    <header class="site-header">
        <div class="header-container">
            <!-- Botão hambúrguer desktop -->
            <button class="hidden md:inline-flex items-center justify-center text-white text-2xl mr-4 focus:outline-none" @click="sidebarOpen = !sidebarOpen">
                <i class="fa-solid fa-bars"></i>
            </button>
            <!-- Restante do header -->
            @include('components.header')
        </div>
    </header>
    <div class="flex w-full min-h-screen">
        <div :class="sidebarOpen ? 'md:flex' : 'md:hidden'" class="hidden transition-all duration-200">
            @include('components.side-nav')
        </div>
        <main :class="sidebarOpen ? 'md:ml-56' : 'md:ml-0'" class="main-content-padding flex-1 w-full max-w-full min-h-screen flex flex-col bg-white dark:bg-[#0d1117] p-0 m-0 relative z-10 transition-all duration-200">
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
