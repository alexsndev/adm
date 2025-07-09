<!-- Itens do menu lateral (sidebar) -->
<!-- Dashboard Geral -->
<button @click="sidebarOpen ? (open = open === 'dashboard' ? '' : 'dashboard') : window.location.href='{{ route('dashboard') }}'" class="w-full flex items-center py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 focus:outline-none">
    <span class="flex items-center justify-center w-10 h-10">
        <i class='fa-solid fa-house-chimney text-lg text-white dark:text-white'></i>
    </span>
    <span x-show="sidebarOpen" class="ml-2">Dashboard</span>
</button>
<!-- Finanças -->
<button @click="if(!sidebarOpen){ sidebarOpen = true; open = 'financas'; } else { open = open === 'financas' ? '' : 'financas'; }" class="w-full flex items-center py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 focus:outline-none">
    <span class="flex items-center justify-center w-10 h-10">
        <i class='fa-solid fa-coins text-lg text-green-600 dark:text-green-400'></i>
    </span>
    <span x-show="sidebarOpen" class="ml-2">Finanças</span>
    <svg class="ml-auto h-4 w-4" fill="currentColor" viewBox="0 0 20 20" x-show="sidebarOpen"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
</button>
<div x-show="open === 'financas' && sidebarOpen" x-transition class="ml-6 mt-1 space-y-1">
    <a href="{{ route('finance.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded flex items-center">
        <span class="flex items-center justify-center w-10 h-10">
            <i class="fa-solid fa-chart-pie text-green-600 dark:text-green-400"></i>
        </span>
        <span class="ml-2">Visão Geral</span>
    </a>
    <div x-data="{ openContas: false }">
        <button @click="openContas = !openContas" class="w-full flex items-center py-2 text-sm text-gray-700 dark:text-gray-200 hover:text-blue-600 focus:outline-none">
            <span class="flex items-center justify-center w-10 h-10">
                <i class="fa-solid fa-wallet text-green-600 dark:text-green-400"></i>
            </span>
            <span class="ml-2">Contas</span>
            <svg :class="{'rotate-180': openContas}" class="ml-auto h-4 w-4 transition-transform" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
        </button>
        <div x-show="openContas" x-transition class="ml-6 mt-1 space-y-1">
            <a href="{{ route('accounts.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded flex items-center" @click="$dispatch('close-sidebar')">
                <span class="flex items-center justify-center w-10 h-10">
                    <i class="fa-solid fa-building-columns text-green-600 dark:text-green-400"></i>
                </span>
                <span class="ml-2">Listar Contas</span>
            </a>
            <a href="{{ route('credit-cards.index') }}" class="block px-4 py-2 text-sm text-blue-700 dark:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded flex items-center" @click="$dispatch('close-sidebar')">
                <span class="flex items-center justify-center w-10 h-10">
                    <i class="fa-solid fa-credit-card text-purple-600 dark:text-purple-400"></i>
                </span>
                <span class="ml-2">Cartões de Crédito</span>
            </a>
        </div>
    </div>
    <a href="{{ route('transactions.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded flex items-center" @click="$dispatch('close-sidebar')">
        <span class="flex items-center justify-center w-10 h-10">
            <i class="fa-solid fa-arrow-right-arrow-left text-blue-600 dark:text-blue-400"></i>
        </span>
        <span class="ml-2">Transações</span>
    </a>
    <a href="{{ route('debts.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded flex items-center" @click="$dispatch('close-sidebar')">
        <span class="flex items-center justify-center w-10 h-10">
            <i class="fa-solid fa-money-bill-wave text-red-500 dark:text-red-400"></i>
        </span>
        <span class="ml-2">Dívidas</span>
    </a>
    <a href="{{ route('financial-goals.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded flex items-center" @click="$dispatch('close-sidebar')">
        <span class="flex items-center justify-center w-10 h-10">
            <i class="fa-solid fa-bullseye text-pink-600 dark:text-pink-400"></i>
        </span>
        <span class="ml-2">Metas</span>
    </a>
    <a href="{{ route('goal-contributions.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded flex items-center" @click="$dispatch('close-sidebar')">
        <span class="flex items-center justify-center w-10 h-10">
            <i class="fa-solid fa-hand-holding-dollar text-yellow-600 dark:text-yellow-400"></i>
        </span>
        <span class="ml-2">Contribuições</span>
    </a>
</div>
<!-- Tarefas Domésticas -->
<button @click="if(!sidebarOpen){ sidebarOpen = true; open = 'domesticas'; } else { open = open === 'domesticas' ? '' : 'domesticas'; }" class="w-full flex items-center py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 focus:outline-none">
    <span class="flex items-center justify-center w-10 h-10">
        <i class='fa-solid fa-soap text-lg text-orange-600 dark:text-orange-400'></i>
    </span>
    <span x-show="sidebarOpen" class="ml-2">Tarefas Domésticas</span>
    <svg class="ml-auto h-4 w-4" fill="currentColor" viewBox="0 0 20 20" x-show="sidebarOpen"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
</button>
<div x-show="open === 'domesticas' && sidebarOpen" x-transition class="ml-6 mt-1 space-y-1">
    <a href="{{ route('household-tasks.dashboard') }}" class="block px-4 py-2 text-sm text-blue-700 font-semibold bg-blue-50 hover:bg-blue-100 rounded flex items-center">
        <span class="flex items-center justify-center w-10 h-10">
            <i class="fa-solid fa-chart-pie text-orange-600 dark:text-orange-400"></i>
        </span>
        <span class="ml-2">Dashboard</span>
    </a>
    <a href="{{ route('household-tasks.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded flex items-center" @click="$dispatch('close-sidebar')">
        <span class="flex items-center justify-center w-10 h-10">
            <i class="fa-solid fa-list-check text-orange-600 dark:text-orange-400"></i>
        </span>
        <span class="ml-2">Tarefas</span>
    </a>
    <a href="{{ route('task-categories.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded flex items-center" @click="$dispatch('close-sidebar')">
        <span class="flex items-center justify-center w-10 h-10">
            <i class="fa-solid fa-tags text-orange-600 dark:text-orange-400"></i>
        </span>
        <span class="ml-2">Categorias</span>
    </a>
</div>
<!-- Projetos -->
<button @click="if(!sidebarOpen){ sidebarOpen = true; open = 'projetos'; } else { open = open === 'projetos' ? '' : 'projetos'; }" class="w-full flex items-center py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 focus:outline-none">
    <span class="flex items-center justify-center w-10 h-10">
        <i class='fa-solid fa-briefcase text-lg text-purple-600 dark:text-purple-400'></i>
    </span>
    <span x-show="sidebarOpen" class="ml-2">Projetos</span>
    <svg class="ml-auto h-4 w-4" fill="currentColor" viewBox="0 0 20 20" x-show="sidebarOpen"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
</button>
<div x-show="open === 'projetos' && sidebarOpen" x-transition class="ml-6 mt-1 space-y-1">
    <a href="{{ route('projetos.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded flex items-center">
        <span class="flex items-center justify-center w-10 h-10">
            <i class="fa-solid fa-diagram-project text-purple-600 dark:text-purple-400"></i>
        </span>
        <span class="ml-2">Projetos</span>
    </a>
    <a href="{{ route('tarefas.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded flex items-center" @click="$dispatch('close-sidebar')">
        <span class="flex items-center justify-center w-10 h-10">
            <i class="fa-solid fa-clipboard-list text-purple-600 dark:text-purple-400"></i>
        </span>
        <span class="ml-2">Tarefas Profissionais</span>
    </a>
    <a href="{{ route('clientes.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded flex items-center" @click="$dispatch('close-sidebar')">
        <span class="flex items-center justify-center w-10 h-10">
            <i class="fa-solid fa-user-tie text-purple-600 dark:text-purple-400"></i>
        </span>
        <span class="ml-2">Clientes</span>
    </a>
    <a href="{{ route('faturas.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded flex items-center" @click="$dispatch('close-sidebar')">
        <span class="flex items-center justify-center w-10 h-10">
            <i class="fa-solid fa-file-invoice-dollar text-purple-600 dark:text-purple-400"></i>
        </span>
        <span class="ml-2">Faturas</span>
    </a>
    <a href="{{ route('task-categories.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded flex items-center" @click="$dispatch('close-sidebar')">
        <span class="flex items-center justify-center w-10 h-10">
            <i class="fa-solid fa-tags text-purple-600 dark:text-purple-400"></i>
        </span>
        <span class="ml-2">Categorias</span>
    </a>
</div>
<!-- Previsibilidade -->
<button @click="if(!sidebarOpen){ sidebarOpen = true; open = 'previsibilidade'; } else { open = open === 'previsibilidade' ? '' : 'previsibilidade'; }" class="w-full flex items-center py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 focus:outline-none">
    <span class="flex items-center justify-center w-10 h-10">
        <i class='fa-solid fa-calendar-days text-lg text-blue-600 dark:text-blue-400'></i>
    </span>
    <span x-show="sidebarOpen" class="ml-2">Previsibilidade</span>
    <svg class="ml-auto h-4 w-4" fill="currentColor" viewBox="0 0 20 20" x-show="sidebarOpen"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
</button>
<div x-show="open === 'previsibilidade' && sidebarOpen" x-transition class="ml-6 mt-1 space-y-1">
    <a href="{{ route('events.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded flex items-center">
        <span class="flex items-center justify-center w-10 h-10">
            <i class="fa-solid fa-calendar-check text-blue-600 dark:text-blue-400"></i>
        </span>
        <span class="ml-2">Eventos</span>
    </a>
    <a href="{{ route('events.calendar') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded flex items-center" @click="$dispatch('close-sidebar')">
        <span class="flex items-center justify-center w-10 h-10">
            <i class="fa-solid fa-calendar-days text-blue-600 dark:text-blue-400"></i>
        </span>
        <span class="ml-2">Calendário</span>
    </a>
    <a href="{{ route('previsibilidade.index') }}" class="block px-4 py-2 text-sm text-blue-700 font-semibold bg-blue-50 hover:bg-blue-100 rounded flex items-center" @click="$dispatch('close-sidebar')">
        <span class="flex items-center justify-center w-10 h-10">
            <i class="fa-solid fa-users text-blue-600 dark:text-blue-400"></i>
        </span>
        <span class="ml-2">Pessoas</span>
    </a>
</div>
<!-- Perfil -->
<button @click="if(!sidebarOpen){ sidebarOpen = true; open = 'perfil'; } else { open = open === 'perfil' ? '' : 'perfil'; }" class="w-full flex items-center py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 focus:outline-none">
    <span class="flex items-center justify-center w-10 h-10">
        <i class='fa-solid fa-user text-lg text-gray-600 dark:text-gray-300'></i>
    </span>
    <span x-show="sidebarOpen" class="ml-2">Perfil</span>
    <svg class="ml-auto h-4 w-4" fill="currentColor" viewBox="0 0 20 20" x-show="sidebarOpen"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
</button>
<div x-show="open === 'perfil' && sidebarOpen" x-transition class="ml-6 mt-1 space-y-1">
    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded flex items-center" @click="$dispatch('close-sidebar')">
        <span class="flex items-center justify-center w-10 h-10">
            <i class="fa-solid fa-user-pen text-gray-600 dark:text-gray-300"></i>
        </span>
        <span class="ml-2">Editar Perfil</span>
    </a>
    <a href="{{ route('profile.edit') }}#password" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded flex items-center" @click="$dispatch('close-sidebar')">
        <span class="flex items-center justify-center w-10 h-10">
            <i class="fa-solid fa-key text-gray-600 dark:text-gray-300"></i>
        </span>
        <span class="ml-2">Alterar Senha</span>
    </a>
</div> 