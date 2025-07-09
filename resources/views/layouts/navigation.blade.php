{{-- Sidebar Lateral Esquerda --}}
<aside class="fixed inset-y-0 left-0 w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 flex flex-col z-50 transition-all duration-300" id="main-sidebar">
    <div class="relative flex justify-center items-end pb-2 pt-4 select-none">
        <img 
            src="{{ asset('img/perfil.jpg') }}" 
            alt="Foto de Perfil" 
            class="w-28 h-28 object-cover sidebar-content sidebar-logo"
            style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); pointer-events: none; z-index: 0;"
        >
    </div>
    <div class="flex items-center h-16 px-6 border-b border-gray-200 dark:border-gray-800 sidebar-content sidebar-logo">
        <a href="{{ route('dashboard') }}" class="sidebar-content">
            <span class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white select-none sidebar-text">Alexandre <span class="text-blue-500">e</span> Liza <span class="text-blue-500">Gestão</span></span>
        </a>
    </div>
    <nav class="flex-1 px-4 py-6 space-y-2 sidebar-content" x-data="{ open: '', submenus: { 'financas': false, 'contas': false, 'projetos': false, 'domesticas': false } }">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 hover:bg-gray-100 dark:hover:bg-gray-800 rounded transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' : '' }}">
            <i class="fa-solid fa-chart-line"></i> <span class="sidebar-text">Dashboard</span>
        </a>

        <!-- Eventos -->
        <button @click="open = open === 'eventos' ? '' : 'eventos'" class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 focus:outline-none">
            <i class='fa-solid fa-calendar-days'></i> <span class="sidebar-text">Eventos</span>
            <svg class="ml-auto h-4 w-4 sidebar-arrow" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
        </button>
        <div x-show="open === 'eventos'" x-transition class="ml-6 mt-1 space-y-1">
            <a href="{{ route('dashboard-geral') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded">Dashboard Geral</a>
            <a href="{{ route('events.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded">Lista de Eventos</a>
            <a href="{{ route('events.calendar') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded">Calendário</a>
            <a href="{{ route('events.create') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded">Novo Evento</a>
            <a href="{{ route('previsibilidade.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded">Pessoas</a>
        </div>

        <!-- Finanças -->
        <button @click="open = open === 'financas' ? '' : 'financas'" class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 focus:outline-none">
            <i class='fa-solid fa-coins'></i> <span class="sidebar-text">Finanças</span>
            <svg class="ml-auto h-4 w-4 sidebar-arrow" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
        </button>
        <div x-show="open === 'financas'" x-transition class="ml-6 mt-1 space-y-1">
            <a href="{{ route('finance.dashboard') }}" class="block px-4 py-2 text-sm text-blue-700 dark:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded flex items-center">
                <i class="fa-solid fa-chart-pie mr-2"></i> Visão Geral
            </a>
            <a href="{{ route('accounts.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded">Contas</a>
            <a href="{{ route('credit-cards.index') }}" class="block px-4 py-2 text-sm text-blue-700 dark:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded flex items-center"><i class="fa-solid fa-credit-card mr-2"></i> Cartões de Crédito</a>
            <a href="{{ route('transactions.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded flex items-center"><i class="fa-solid fa-right-left mr-2"></i> Transações</a>
            <a href="{{ route('categories.index') }}" class="block px-4 py-2 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded flex items-center"><i class="fa-solid fa-tags mr-2"></i> Categorias</a>
            <a href="{{ route('debts.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded">Dívidas</a>
            <a href="{{ route('financial-goals.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded">Metas</a>
            <a href="{{ route('goal-contributions.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded">Contribuições</a>
        </div>

        <!-- Tarefas Domésticas -->
        <button @click="open = open === 'domesticas' ? '' : 'domesticas'" class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 focus:outline-none">
            <i class='fa-solid fa-house-chimney'></i> <span class="sidebar-text">Tarefas Domésticas</span>
            <svg class="ml-auto h-4 w-4 sidebar-arrow" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
        </button>
        <div x-show="open === 'domesticas'" x-transition class="ml-6 mt-1 space-y-1">
            <a href="{{ route('household-tasks.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded">Tarefas</a>
            <a href="{{ route('household-tasks.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded">Dashboard</a>
        </div>

        <!-- Projetos -->
        <button @click="open = open === 'projetos' ? '' : 'projetos'" class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 focus:outline-none">
            <i class='fa-solid fa-briefcase'></i> <span class="sidebar-text">Projetos</span>
            <svg class="ml-auto h-4 w-4 sidebar-arrow" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
        </button>
        <div x-show="open === 'projetos'" x-transition class="ml-6 mt-1 space-y-1">
            <a href="{{ route('projetos.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded">Projetos</a>
            <a href="{{ route('tarefas.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded">Tarefas Profissionais</a>
            <a href="{{ route('task-categories.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded">Categorias</a>
            <a href="{{ route('clientes.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded">Clientes</a>
        </div>
    </nav>
    <div class="mt-auto px-4 py-4 border-t border-gray-200 dark:border-gray-800 sidebar-content">
        <div class="flex items-center space-x-3">
            <span class="inline-flex items-center justify-center w-10 h-10 sidebar-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
            <div class="flex-1 min-w-0 sidebar-text">
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

{{-- Espaço para o conteúdo principal --}}
<div class="ml-64">
    @yield('content')
</div>
