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
        <div x-data="{ sidebarOpen: false, open: '' }" class="flex min-h-screen w-full">
            <!-- Sidebar sempre visível, nunca fixed -->
            <aside :class="sidebarOpen ? 'w-64' : 'w-10'" class="relative bg-white dark:bg-[#0d1117] border-r border-gray-200 dark:border-[#21262d] flex flex-col transition-all duration-200 ease-in-out">
                <!-- Botão de expandir/comprimir -->
                <button @click="sidebarOpen = !sidebarOpen" class="absolute top-2 right-2 z-20 bg-gray-100 dark:bg-[#161b22] rounded-full p-1 shadow-md focus:outline-none">
                    <i :class="sidebarOpen ? 'fa-solid fa-chevron-left' : 'fa-solid fa-chevron-right'" class="text-gray-700 dark:text-gray-200"></i>
                </button>
                <div class="flex items-center justify-center pt-2 pb-2 px-2 md:px-6 border-b border-gray-200 dark:border-[#21262d] relative min-h-[40px]">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <span class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white drop-shadow-lg select-none" x-show="sidebarOpen">Alexandre <span class="text-blue-500">e</span> Liza <span class="text-blue-500">Gestão</span></span>
                    </a>
                </div>
                <nav class="flex-1 px-2 md:px-4 py-6 space-y-1">
                    <div>
                        @include('layouts.navigation-items')
                    </div>
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
            <div class="flex-1 flex flex-col bg-white dark:bg-[#0d1117] min-h-screen p-0 m-0 relative z-10">
                <main class="flex-1 w-full max-w-full overflow-x-auto">
                    @yield('content')
                </main>
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
