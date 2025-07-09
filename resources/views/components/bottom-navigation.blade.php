<!-- Bottom Navigation - Mobile Friendly -->
<nav class="fixed bottom-0 left-0 right-0 z-50 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 shadow-lg md:hidden">
    <div class="flex justify-around items-center h-16">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('dashboard') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
            <i class="fa-solid fa-house-chimney text-lg mb-1"></i>
            <span class="text-xs">Dashboard</span>
        </a>
        
        <!-- Finanças -->
        <a href="{{ route('finance.dashboard') }}" class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('finance.*') ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-green-600 dark:hover:text-green-400 transition-colors">
            <i class="fa-solid fa-coins text-lg mb-1"></i>
            <span class="text-xs">Finanças</span>
        </a>
        
        <!-- Tarefas Domésticas -->
        <a href="{{ route('household-tasks.dashboard') }}" class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('household-tasks.*') ? 'text-orange-600 dark:text-orange-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-orange-600 dark:hover:text-orange-400 transition-colors">
            <i class="fa-solid fa-soap text-lg mb-1"></i>
            <span class="text-xs">Tarefas</span>
        </a>
        
        <!-- Projetos -->
        <a href="{{ route('projetos.index') }}" class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('projetos.*') || request()->routeIs('tarefas.*') || request()->routeIs('clientes.*') || request()->routeIs('faturas.*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
            <i class="fa-solid fa-briefcase text-lg mb-1"></i>
            <span class="text-xs">Projetos</span>
        </a>
        
        <!-- Previsibilidade -->
        <a href="{{ route('events.index') }}" class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('events.*') || request()->routeIs('previsibilidade.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
            <i class="fa-solid fa-calendar-days text-lg mb-1"></i>
            <span class="text-xs">Eventos</span>
        </a>
    </div>
</nav>

<!-- Desktop Sidebar (mantido para desktop) -->
<aside class="hidden md:block fixed left-0 top-0 h-full w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 shadow-lg z-40">
    <div class="flex flex-col h-full">
        <!-- Logo/Header da sidebar -->
        <div class="p-4 border-b border-gray-200 dark:border-gray-800">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Menu</h2>
        </div>
        
        <!-- Navegação -->
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            @include('layouts.navigation-items')
        </nav>
        
        <!-- Perfil do usuário -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-800">
            <div class="flex items-center space-x-3">
                @if(Auth::user()->photo)
                    <img src="{{ Storage::url(Auth::user()->photo) }}" alt="Foto de perfil" class="w-10 h-10 rounded-full object-cover border-2 border-blue-200 dark:border-blue-700">
                @else
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                @endif
                <div class="flex-1 min-w-0">
                    <div class="font-medium text-sm text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-red-600 dark:hover:text-red-400" title="Sair">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside> 