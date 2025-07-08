<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

        <!-- FontAwesome CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 overflow-x-hidden">
        <div class="min-h-screen w-full flex flex-col">
            <div x-data="{ sidebarOpen: true, open: '' }" class="min-h-screen flex bg-white dark:bg-[#0d1117]">
                <!-- Sidebar -->
                <aside :class="sidebarOpen ? 'w-64' : 'w-16'" class="fixed inset-y-0 left-0 bg-white dark:bg-[#0d1117] border-r border-gray-200 dark:border-[#21262d] flex flex-col z-50 transition-all duration-200 ease-in-out">
                    <div class="flex items-center pt-2 pb-2 px-2 md:px-6 border-b border-gray-200 dark:border-[#21262d] relative">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                            <span class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white drop-shadow-lg select-none" x-show="sidebarOpen">Alexandre <span class="text-blue-500">e</span> Liza <span class="text-blue-500">Gestão</span></span>
                            <span class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white select-none" x-show="!sidebarOpen"><i class='fa-solid fa-bars'></i></span>
                        </a>
                        <button @click="sidebarOpen = !sidebarOpen" class="ml-auto p-2 rounded hover:bg-gray-100 dark:hover:bg-[#161b22] focus:outline-none hidden sm:inline-flex">
                            <i :class="sidebarOpen ? 'fa-solid fa-chevron-left' : 'fa-solid fa-chevron-right'" class="text-gray-700 dark:text-gray-200"></i>
                        </button>
                        <!-- Botão fechar mobile -->
                        <button @click="sidebarOpen = false" x-show="sidebarOpen" class="absolute right-2 top-2 sm:hidden inline-flex items-center justify-center p-2 rounded hover:bg-gray-100 dark:hover:bg-[#161b22] focus:outline-none" style="display: none;">
                            <i class="fa-solid fa-xmark text-xl text-gray-700 dark:text-gray-200"></i>
                        </button>
                    </div>
                    <nav class="flex-1 px-2 md:px-4 py-6 space-y-2" :class="sidebarOpen ? '' : 'px-0'">
                        @include('layouts.navigation-items')
                    </nav>
                    <div class="mt-auto px-2 md:px-4 py-4 border-t border-gray-200 dark:border-[#21262d]" x-show="sidebarOpen">
                        <div class="flex items-center space-x-3">
                            @if(Auth::user()->photo)
                                <img src="{{ Storage::url(Auth::user()->photo) }}" alt="Foto de perfil" class="w-10 h-10 rounded-full object-cover border-2 border-blue-200 dark:border-blue-700">
                            @else
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            @endif
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                                <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-400 hover:text-red-600 dark:hover:text-red-400" title="Sair">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </aside>
                <!-- Conteúdo principal -->
                <div :class="sidebarOpen ? 'ml-64' : 'ml-16'" class="flex-1 flex flex-col transition-all duration-200 bg-white dark:bg-[#0d1117] min-h-screen p-0 m-0">
                    <main class="flex-1 w-full max-w-full overflow-x-auto">
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>
        <script>
        function setTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
        }
        window.onload = function() {
            const saved = localStorage.getItem('theme') || 'dark';
            setTheme(saved);
        };
        </script>
        @stack('scripts')
        <script src="https://unpkg.com/alpinejs" defer></script>
    </body>
</html>
