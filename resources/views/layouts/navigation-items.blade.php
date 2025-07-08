<!-- Itens do menu lateral (sidebar) -->
<!-- Finanças -->
<button @click="open = open === 'financas' ? '' : 'financas'" class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 focus:outline-none">
    <i class='fa-solid fa-coins mr-2'></i>
    <span x-show="sidebarOpen">Finanças</span>
    <svg class="ml-auto h-4 w-4" fill="currentColor" viewBox="0 0 20 20" x-show="sidebarOpen"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
</button>
<div x-show="open === 'financas' && sidebarOpen" x-transition class="ml-6 mt-1 space-y-1">
    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded"><i class="fa-solid fa-chart-pie mr-2"></i> Visão Geral</a>
    <div x-data="{ openContas: false }">
        <button @click="openContas = !openContas" class="w-full flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:text-blue-600 focus:outline-none">
            <i class="fa-solid fa-wallet mr-2"></i> Contas
            <svg :class="{'rotate-180': openContas}" class="ml-auto h-4 w-4 transition-transform" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
        </button>
        <div x-show="openContas" x-transition class="ml-6 mt-1 space-y-1">
            <a href="{{ route('accounts.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded"><i class="fa-solid fa-building-columns mr-2"></i> Listar Contas</a>
            <a href="{{ route('credit-cards.index') }}" class="block px-4 py-2 text-sm text-blue-700 dark:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded flex items-center"><i class="fa-solid fa-credit-card mr-2"></i> Cartões de Crédito</a>
        </div>
    </div>
    <a href="{{ route('transactions.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded"><i class="fa-solid fa-arrow-right-arrow-left mr-2"></i> Transações</a>
    <a href="{{ route('debts.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded"><i class="fa-solid fa-money-bill-wave mr-2"></i> Dívidas</a>
    <a href="{{ route('financial-goals.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded"><i class="fa-solid fa-bullseye mr-2"></i> Metas</a>
    <a href="{{ route('goal-contributions.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded"><i class="fa-solid fa-hand-holding-dollar mr-2"></i> Contribuições</a>
</div>
<!-- Tarefas Domésticas -->
<button @click="open = open === 'domesticas' ? '' : 'domesticas'" class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 focus:outline-none">
    <i class='fa-solid fa-house-chimney mr-2'></i>
    <span x-show="sidebarOpen">Tarefas Domésticas</span>
    <svg class="ml-auto h-4 w-4" fill="currentColor" viewBox="0 0 20 20" x-show="sidebarOpen"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
</button>
<div x-show="open === 'domesticas' && sidebarOpen" x-transition class="ml-6 mt-1 space-y-1">
    <a href="{{ route('household-tasks.dashboard') }}" class="block px-4 py-2 text-sm text-blue-700 font-semibold bg-blue-50 hover:bg-blue-100 rounded flex items-center"><i class="fa-solid fa-chart-pie mr-2"></i> Dashboard</a>
    <a href="{{ route('household-tasks.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded"><i class="fa-solid fa-list-check mr-2"></i> Tarefas</a>
    <a href="{{ route('task-categories.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded"><i class="fa-solid fa-tags mr-2"></i> Categorias</a>
</div>
<!-- Projetos -->
<button @click="open = open === 'projetos' ? '' : 'projetos'" class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 focus:outline-none">
    <i class='fa-solid fa-briefcase mr-2'></i>
    <span x-show="sidebarOpen">Projetos</span>
    <svg class="ml-auto h-4 w-4" fill="currentColor" viewBox="0 0 20 20" x-show="sidebarOpen"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
</button>
<div x-show="open === 'projetos' && sidebarOpen" x-transition class="ml-6 mt-1 space-y-1">
    <a href="{{ route('projetos.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded"><i class="fa-solid fa-diagram-project mr-2"></i> Projetos</a>
    <a href="{{ route('tarefas.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded"><i class="fa-solid fa-clipboard-list mr-2"></i> Tarefas Profissionais</a>
    <a href="{{ route('clientes.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded"><i class="fa-solid fa-user-tie mr-2"></i> Clientes</a>
    <a href="{{ route('faturas.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded"><i class="fa-solid fa-file-invoice-dollar mr-2"></i> Faturas</a>
    <a href="{{ route('task-categories.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded"><i class="fa-solid fa-tags mr-2"></i> Categorias</a>
</div>
<!-- Previsibilidade -->
<button @click="open = open === 'previsibilidade' ? '' : 'previsibilidade'" class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 focus:outline-none">
    <i class='fa-solid fa-calendar-days mr-2'></i>
    <span x-show="sidebarOpen">Previsibilidade</span>
    <svg class="ml-auto h-4 w-4" fill="currentColor" viewBox="0 0 20 20" x-show="sidebarOpen"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
</button>
<div x-show="open === 'previsibilidade' && sidebarOpen" x-transition class="ml-6 mt-1 space-y-1">
    <a href="{{ route('events.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded"><i class="fa-solid fa-calendar-check mr-2"></i> Eventos</a>
    <a href="{{ route('events.calendar') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded"><i class="fa-solid fa-calendar-days mr-2"></i> Calendário</a>
    <a href="{{ route('previsibilidade.index') }}" class="block px-4 py-2 text-sm text-blue-700 font-semibold bg-blue-50 hover:bg-blue-100 rounded"><i class="fa-solid fa-users mr-2"></i> Pessoas</a>
</div>
<!-- Perfil -->
<button @click="open = open === 'perfil' ? '' : 'perfil'" class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 focus:outline-none">
    <i class='fa-solid fa-user mr-2'></i>
    <span x-show="sidebarOpen">Perfil</span>
    <svg class="ml-auto h-4 w-4" fill="currentColor" viewBox="0 0 20 20" x-show="sidebarOpen"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
</button>
<div x-show="open === 'perfil' && sidebarOpen" x-transition class="ml-6 mt-1 space-y-1">
    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded"><i class="fa-solid fa-user-pen mr-2"></i> Editar Perfil</a>
    <a href="{{ route('profile.edit') }}#password" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded"><i class="fa-solid fa-key mr-2"></i> Alterar Senha</a>
</div> 