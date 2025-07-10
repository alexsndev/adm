<!-- Bottom Navigation - Mobile Friendly -->
<nav class="fixed bottom-0 left-0 right-0 z-50 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 shadow-lg md:hidden" style="position: fixed !important; bottom: 0 !important; left: 0 !important; right: 0 !important; z-index: 9999 !important;">
    <div class="flex justify-around items-center h-16 relative">
        <!-- Dashboard -->
        <div class="relative flex-1 flex flex-col items-center">
            <button type="button" class="flex flex-col items-center justify-center w-full h-full focus:outline-none nav-btn {{ request()->routeIs('dashboard') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-blue-600 dark:hover:text-blue-400 transition-colors" data-dropdown="dashboard-dropdown">
                <i class="fa-solid fa-house-chimney text-lg mb-1"></i>
                <span class="text-xs">Dashboard</span>
            </button>
            <ul id="dashboard-dropdown" class="dropdown-menu hidden absolute bottom-28 left-0 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg shadow-lg py-2 min-w-[140px] z-50">
                <li><a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-blue-800"><i class='fa-solid fa-gauge-high text-blue-500'></i> Visão Geral</a></li>
            </ul>
        </div>
        <!-- Finanças -->
        <div class="relative flex-1 flex flex-col items-center">
            <button type="button" class="flex flex-col items-center justify-center w-full h-full focus:outline-none nav-btn {{ request()->routeIs('finance.*') ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-green-600 dark:hover:text-green-400 transition-colors" data-dropdown="finance-dropdown">
                <i class="fa-solid fa-coins text-lg mb-1"></i>
                <span class="text-xs">Finanças</span>
            </button>
            <ul id="finance-dropdown" class="dropdown-menu hidden absolute bottom-28 left-1/2 transform -translate-x-1/2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg shadow-lg py-2 min-w-[140px] z-50">
                <li><a href="{{ route('finance.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-green-100 dark:hover:bg-green-800"><i class='fa-solid fa-chart-pie text-green-500'></i> Resumo</a></li>
                <li><a href="{{ route('accounts.index') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-green-100 dark:hover:bg-green-800"><i class='fa-solid fa-wallet text-green-400'></i> Contas</a></li>
                <li><a href="{{ route('transactions.index') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-green-100 dark:hover:bg-green-800"><i class='fa-solid fa-arrow-right-arrow-left text-green-400'></i> Transações</a></li>
                <li><a href="{{ route('credit-cards.index') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-green-100 dark:hover:bg-green-800"><i class='fa-solid fa-credit-card text-green-400'></i> Cartões</a></li>
                <li><a href="{{ route('debts.index') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-green-100 dark:hover:bg-green-800"><i class='fa-solid fa-money-bill-trend-up text-green-400'></i> Dívidas</a></li>
            </ul>
        </div>
        <!-- Tarefas Domésticas -->
        <div class="relative flex-1 flex flex-col items-center">
            <button type="button" class="flex flex-col items-center justify-center w-full h-full focus:outline-none nav-btn {{ request()->routeIs('household-tasks.*') ? 'text-orange-600 dark:text-orange-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-orange-600 dark:hover:text-orange-400 transition-colors" data-dropdown="tasks-dropdown">
                <i class="fa-solid fa-soap text-lg mb-1"></i>
                <span class="text-xs">Tarefas</span>
            </button>
            <ul id="tasks-dropdown" class="dropdown-menu hidden absolute bottom-28 left-1/2 transform -translate-x-1/2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg shadow-lg py-2 min-w-[140px] z-50">
                <li><a href="{{ route('household-tasks.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-orange-100 dark:hover:bg-orange-800"><i class='fa-solid fa-list-check text-orange-500'></i> Painel</a></li>
                <li><a href="{{ route('household-tasks.index') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-orange-100 dark:hover:bg-orange-800"><i class='fa-solid fa-broom text-orange-400'></i> Todas Tarefas</a></li>
            </ul>
        </div>
        <!-- Projetos -->
        <div class="relative flex-1 flex flex-col items-center">
            <button type="button" class="flex flex-col items-center justify-center w-full h-full focus:outline-none nav-btn {{ request()->routeIs('projetos.*') || request()->routeIs('tarefas.*') || request()->routeIs('clientes.*') || request()->routeIs('faturas.*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-purple-600 dark:hover:text-purple-400 transition-colors" data-dropdown="projects-dropdown">
                <i class="fa-solid fa-briefcase text-lg mb-1"></i>
                <span class="text-xs">Projetos</span>
            </button>
            <ul id="projects-dropdown" class="dropdown-menu hidden absolute bottom-28 left-1/2 transform -translate-x-1/2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg shadow-lg py-2 min-w-[140px] z-50">
                <li><a href="{{ route('projetos.index') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-purple-100 dark:hover:bg-purple-800">Projetos</a></li>
                <li><a href="{{ route('tarefas.index') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-purple-100 dark:hover:bg-purple-800">Tarefas</a></li>
                <li><a href="{{ route('clientes.index') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-purple-100 dark:hover:bg-purple-800">Clientes</a></li>
                <li><a href="{{ route('faturas.index') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-purple-100 dark:hover:bg-purple-800">Faturas</a></li>
            </ul>
        </div>
        <!-- Eventos/Previsibilidade -->
        <div class="relative flex-1 flex flex-col items-center">
            <button type="button" class="flex flex-col items-center justify-center w-full h-full focus:outline-none nav-btn {{ request()->routeIs('events.*') || request()->routeIs('previsibilidade.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-blue-600 dark:hover:text-blue-400 transition-colors" data-dropdown="events-dropdown">
                <i class="fa-solid fa-calendar-days text-lg mb-1"></i>
                <span class="text-xs">Eventos</span>
            </button>
            <ul id="events-dropdown" class="dropdown-menu hidden absolute bottom-28 right-0 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg shadow-lg py-2 min-w-[160px] z-50">
                <li><a href="{{ route('events.calendar') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-blue-800"><i class='fa-solid fa-calendar-days text-blue-500'></i> Calendário</a></li>
                <li><a href="{{ route('events.index') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-blue-800"><i class='fa-solid fa-list-ul text-blue-400'></i> Todos Eventos</a></li>
                <li><a href="{{ route('previsibilidade.index') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-blue-800"><i class='fa-solid fa-user-group text-blue-300'></i> Previsibilidade</a></li>
            </ul>
        </div>
    </div>
    <script>
        // Dropdown logic padrão
        document.querySelectorAll('.nav-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                // Fecha todos os outros dropdowns
                document.querySelectorAll('.dropdown-menu').forEach(menu => menu.classList.add('hidden'));
                // Abre o dropdown correspondente
                const dropdown = document.getElementById(this.dataset.dropdown);
                if (dropdown.classList.contains('hidden')) {
                    dropdown.classList.remove('hidden');
                } else {
                    dropdown.classList.add('hidden');
                }
            });
        });
        // Fecha dropdown ao clicar fora
        document.addEventListener('click', function() {
            document.querySelectorAll('.dropdown-menu').forEach(menu => menu.classList.add('hidden'));
        });
    </script>
</nav> 