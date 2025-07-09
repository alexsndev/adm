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

        <!-- Scriptss -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Custom CSS -->
        <!-- FontAwesome CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        @stack('styles')
        <script>
            // Detecta o tema salvo e aplica a classe 'dark' no <html>
            (function() {
                const saved = localStorage.getItem('theme') || 'dark';
                if(saved === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="#2563eb">
        <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 overflow-x-hidden">
        <!-- Novo Header Moderno -->
        <header class="w-full fixed top-0 left-0 z-50 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 shadow-sm h-16 flex items-center justify-between px-6">
            <!-- Logo e nome -->
            <div class="flex items-center space-x-3">
                @if(Auth::user()->logo)
                    <img src="{{ Storage::url(Auth::user()->logo) }}" alt="Logo" class="h-10 w-auto rounded shadow max-w-[120px] object-contain">
                @else
                    <span class="text-xl font-extrabold tracking-tight text-gray-900 dark:text-white select-none">Alexandre <span class="text-blue-500">e</span> Liza <span class="text-blue-500">Gestão</span></span>
                @endif
            </div>
            <!-- Menu central (exemplo) -->
            <nav class="hidden md:flex space-x-8">
                <a href="/" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition">Dashboard</a>
                <a href="/accounts" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition">Contas</a>
                <a href="/transactions" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition">Transações</a>
                <a href="/projects" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition">Projetos</a>
            </nav>
            <!-- Perfil e ações -->
            <div class="flex items-center space-x-4">
                <a href="#" title="Notificações" class="relative">
                    <i class="fa-solid fa-bell text-2xl text-gray-400 dark:text-gray-500 hover:text-blue-500 transition-colors"></i>
                    <!-- Badge de notificação -->
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5">3</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center">
                    @if(Auth::user()->photo)
                        <img src="{{ Storage::url(Auth::user()->photo) }}" alt="Foto de perfil" class="w-10 h-10 rounded-full object-cover border-2 border-blue-200 dark:border-blue-700 shadow">
                    @else
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 font-bold text-lg">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    @endif
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-red-600 dark:hover:text-red-400 ml-2" title="Sair">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
            <!-- Menu mobile -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-gray-700 dark:text-gray-200 focus:outline-none">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
            </div>
        </header>
        <!-- Menu mobile dropdown (simples exemplo) -->
        <div id="mobile-menu" class="hidden fixed top-16 left-0 w-full bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 shadow-md z-40 md:hidden">
            <nav class="flex flex-col space-y-2 p-4">
                <a href="/" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition">Dashboard</a>
                <a href="/accounts" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition">Contas</a>
                <a href="/transactions" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition">Transações</a>
                <a href="/projects" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition">Projetos</a>
            </nav>
        </div>
        <script>
            // Script simples para abrir/fechar menu mobile
            document.addEventListener('DOMContentLoaded', function() {
                const btn = document.getElementById('mobile-menu-button');
                const menu = document.getElementById('mobile-menu');
                btn.addEventListener('click', function() {
                    menu.classList.toggle('hidden');
                });
            });
        </script>
        <!-- Fim do novo header -->
        <div class="pt-16">
        <div x-data="{ sidebarOpen: false, open: '' }" class="flex min-h-screen w-full">
            <!-- Sidebar sempre visível, nunca fixed -->
            <aside :class="sidebarOpen ? 'w-64' : 'w-10'" class="relative border-r border-gray-200 dark:border-[#21262d] flex flex-col transition-all duration-200 ease-in-out animated-gradient-sidebar">
                <!-- Botão de expandir/comprimir -->
                <button @click="sidebarOpen = !sidebarOpen"
                    :class="!sidebarOpen ? 'animate-pulse-arrow' : ''"
                    class="absolute top-2 right-2 z-20 bg-gray-100 dark:bg-[#161b22] rounded-full p-1 shadow-md focus:outline-none mb-4 transition-all">
                    <i :class="sidebarOpen ? 'fa-solid fa-chevron-left' : 'fa-solid fa-chevron-right'" class="text-gray-700 dark:text-gray-200"></i>
                </button>
                <!-- Espaço extra antes do menu -->
                <nav class="flex-1 py-6 space-y-1 mt-6">
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
        // Registrar o service worker para PWA
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js');
        }
        </script>
        @stack('scripts')
        <script src="https://unpkg.com/alpinejs" defer></script>
    </body>
</html>
