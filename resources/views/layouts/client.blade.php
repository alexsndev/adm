<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Painel do Cliente - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-[#18181b] text-gray-100 min-h-screen">
    <!-- Sidebar do Cliente -->
    <nav id="side-nav-client" class="fixed top-0 left-0 h-full w-52 bg-[#23232a] shadow-lg z-40 flex flex-col py-6 px-2 hidden md:flex">
        <a href="{{ route('cliente.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded text-purple-200 hover:bg-[#2d2d3a] hover:text-white font-semibold mb-2 {{ request()->routeIs('cliente.dashboard') ? 'bg-[#2d2d3a] text-white' : '' }}">
            <i class="fa-solid fa-house-chimney"></i> <span>Dashboard</span>
        </a>
        <a href="{{ route('cliente.projetos') }}" class="flex items-center gap-3 px-4 py-3 rounded text-purple-200 hover:bg-[#2d2d3a] hover:text-white font-semibold mb-2 {{ request()->routeIs('cliente.projetos') ? 'bg-[#2d2d3a] text-white' : '' }}">
            <i class="fa-solid fa-briefcase"></i> <span>Projetos</span>
        </a>
        <a href="{{ route('cliente.tarefas') }}" class="flex items-center gap-3 px-4 py-3 rounded text-purple-200 hover:bg-[#2d2d3a] hover:text-white font-semibold mb-2 {{ request()->routeIs('cliente.tarefas') ? 'bg-[#2d2d3a] text-white' : '' }}">
            <i class="fa-solid fa-list-check"></i> <span>Tarefas</span>
        </a>
        <a href="{{ route('cliente.chat') }}" class="flex items-center gap-3 px-4 py-3 rounded text-purple-200 hover:bg-[#2d2d3a] hover:text-white font-semibold mb-2 {{ request()->routeIs('cliente.chat') ? 'bg-[#2d2d3a] text-white' : '' }}">
            <i class="fa-solid fa-comments"></i> <span>Chat</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="mt-auto px-4">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded text-red-300 hover:bg-red-800 hover:text-white font-semibold">
                <i class="fa-solid fa-right-from-bracket"></i> <span>Sair</span>
            </button>
        </form>
    </nav>
    <div class="md:ml-52">
        <header class="w-full flex items-center justify-between px-6 py-4 bg-[#23232b] shadow-md">
            <!-- Logo à esquerda -->
            <div class="flex items-center min-w-[56px]">
                @if(isset($client) && $client->logo)
                    <img src="{{ Storage::url($client->logo) }}" alt="Logo do Cliente" class="h-10 w-auto max-w-[120px] object-contain rounded bg-white/10 p-1">
                @else
                    <span class="inline-flex items-center justify-center h-10 w-10 rounded bg-purple-700 text-white font-bold text-xl">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </span>
                @endif
            </div>
            <!-- Nome do cliente centralizado -->
            <div class="flex-1 text-center">
                <h1 class="text-2xl font-bold text-purple-300 truncate">
                    {{ isset($client) ? $client->name : 'Cliente' }}
                </h1>
            </div>
            <!-- Foto do cliente à direita -->
            <div class="flex items-center min-w-[56px] justify-end">
                @if(isset($client) && $client->photo)
                    <img src="{{ Storage::url($client->photo) }}" alt="Foto do Cliente" class="h-10 w-10 rounded-full object-cover border-2 border-purple-400 shadow">
                @else
                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-700 text-white font-bold text-xl">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </span>
                @endif
            </div>
        </header>
        <main class="max-w-5xl mx-auto w-full py-8 px-4">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html> 