<div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white dark:bg-gray-800 px-6 pb-4 border-r border-gray-200 dark:border-gray-700">
    <!-- Logo -->
    <div class="flex h-16 shrink-0 items-center">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600">
                <i class="fa-solid fa-chart-line text-white text-sm"></i>
            </div>
            <span class="text-xl font-bold text-gray-900 dark:text-gray-100">
                {{ config('app.name', 'Laravel') }}
            </span>
        </a>
    </div>
    
    <!-- Navigation -->
    <nav class="flex flex-1 flex-col">
        <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <!-- Main Navigation -->
            <li>
                <ul role="list" class="-mx-2 space-y-1">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('dashboard') }}" 
                           class="{{ request()->routeIs('dashboard') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                            <i class="fa-solid fa-chart-line text-lg w-6 h-6"></i>
                            Dashboard
                        </a>
                    </li>
                    
                    <!-- Finanças -->
                    <li x-data="{ open: {{ request()->routeIs('accounts.*', 'transactions.*', 'categories.*', 'financial-goals.*', 'debts.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" 
                                class="{{ request()->routeIs('accounts.*', 'transactions.*', 'categories.*', 'financial-goals.*', 'debts.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20' }} group flex w-full gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                            <i class="fa-solid fa-wallet text-lg w-6 h-6"></i>
                            Finanças
                            <i class="fa-solid fa-chevron-down ml-auto text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <ul x-show="open" 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="mt-1 space-y-1">
                            <li>
                                <a href="{{ route('accounts.index') }}" 
                                   class="{{ request()->routeIs('accounts.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20' }} group flex gap-x-3 rounded-md py-2 pl-9 pr-2 text-sm leading-6">
                                    <i class="fa-solid fa-piggy-bank text-sm w-4 h-4"></i>
                                    Contas
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('transactions.index') }}" 
                                   class="{{ request()->routeIs('transactions.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20' }} group flex gap-x-3 rounded-md py-2 pl-9 pr-2 text-sm leading-6">
                                    <i class="fa-solid fa-exchange-alt text-sm w-4 h-4"></i>
                                    Transações
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('categories.index') }}" 
                                   class="{{ request()->routeIs('categories.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20' }} group flex gap-x-3 rounded-md py-2 pl-9 pr-2 text-sm leading-6">
                                    <i class="fa-solid fa-tags text-sm w-4 h-4"></i>
                                    Categorias
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('financial-goals.index') }}" 
                                   class="{{ request()->routeIs('financial-goals.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20' }} group flex gap-x-3 rounded-md py-2 pl-9 pr-2 text-sm leading-6">
                                    <i class="fa-solid fa-bullseye text-sm w-4 h-4"></i>
                                    Metas
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('debts.index') }}" 
                                   class="{{ request()->routeIs('debts.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20' }} group flex gap-x-3 rounded-md py-2 pl-9 pr-2 text-sm leading-6">
                                    <i class="fa-solid fa-credit-card text-sm w-4 h-4"></i>
                                    Dívidas
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('finance.fixed-incomes.index') }}" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-green-700/30 transition">
                                    <i class="fa-solid fa-money-bill-wave"></i>
                                    <span>Receitas Fixas</span>
                                </a>
                                <!-- Submenu Próximas Receitas -->
                                <ul class="ml-8 mt-1 space-y-1">
                                    @php
                                        $proximasReceitas = \App\Models\Transaction::where('user_id', auth()->id())
                                            ->where('type', 'income')
                                            ->where('is_recurring', true)
                                            ->whereDate('date', '>=', now()->startOfMonth())
                                            ->orderByRaw('DAY(date) ASC')
                                            ->take(3)
                                            ->get();
                                    @endphp
                                    @forelse($proximasReceitas as $receita)
                                        <li class="flex items-center gap-2 text-green-700 dark:text-green-300 text-xs py-1">
                                            <i class="fa-solid fa-circle-dot text-green-400"></i>
                                            <span class="truncate max-w-[100px]">{{ $receita->description }}</span>
                                            <span class="ml-auto text-green-600 dark:text-green-400 font-bold">{{ \Carbon\Carbon::parse($receita->date)->format('d') }}</span>
                                        </li>
                                    @empty
                                        <li class="text-gray-400 text-xs italic">Nenhuma próxima receita</li>
                                    @endforelse
                                </ul>
                            </li>
                            <li>
                                <a href="{{ route('finance.fixed-expenses.index') }}" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-red-700/30 transition">
                                    <i class="fa-solid fa-money-bill-trend-up"></i>
                                    <span>Despesas Fixas</span>
                                </a>
                                <!-- Submenu Próximas Despesas -->
                                <ul class="ml-8 mt-1 space-y-1">
                                    @php
                                        $proximasDespesas = \App\Models\Transaction::where('user_id', auth()->id())
                                            ->where('type', 'expense')
                                            ->where('is_recurring', true)
                                            ->whereDate('date', '>=', now()->startOfMonth())
                                            ->orderByRaw('DAY(date) ASC')
                                            ->take(3)
                                            ->get();
                                    @endphp
                                    @forelse($proximasDespesas as $despesa)
                                        <li class="flex items-center gap-2 text-red-700 dark:text-red-300 text-xs py-1">
                                            <i class="fa-solid fa-circle-dot text-red-400"></i>
                                            <span class="truncate max-w-[100px]">{{ $despesa->description }}</span>
                                            <span class="ml-auto text-red-600 dark:text-red-400 font-bold">{{ \Carbon\Carbon::parse($despesa->date)->format('d') }}</span>
                                        </li>
                                    @empty
                                        <li class="text-gray-400 text-xs italic">Nenhuma próxima despesa</li>
                                    @endforelse
                                </ul>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Eventos -->
                    <li x-data="{ open: {{ request()->routeIs('events.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" 
                                class="{{ request()->routeIs('events.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20' }} group flex w-full gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                            <i class="fa-solid fa-calendar-days text-lg w-6 h-6"></i>
                            Eventos
                            <i class="fa-solid fa-chevron-down ml-auto text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <ul x-show="open" 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="mt-1 space-y-1">
                            <li>
                                <a href="{{ route('events.index') }}" 
                                   class="{{ request()->routeIs('events.index') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20' }} group flex gap-x-3 rounded-md py-2 pl-9 pr-2 text-sm leading-6">
                                    <i class="fa-solid fa-calendar text-sm w-4 h-4"></i>
                                    Todos os Eventos
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('events.create') }}" 
                                   class="{{ request()->routeIs('events.create') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20' }} group flex gap-x-3 rounded-md py-2 pl-9 pr-2 text-sm leading-6">
                                    <i class="fa-solid fa-plus text-sm w-4 h-4"></i>
                                    Novo Evento
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Projetos -->
                    <li x-data="{ open: {{ request()->routeIs('projetos.*', 'tarefas.*') ? 'true' : 'false' }} }">
                        <button @click="open = !open" 
                                class="{{ request()->routeIs('projetos.*', 'tarefas.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20' }} group flex w-full gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                            <i class="fa-solid fa-briefcase text-lg w-6 h-6"></i>
                            Projetos
                            <i class="fa-solid fa-chevron-down ml-auto text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <ul x-show="open" 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="mt-1 space-y-1">
                            <li>
                                <a href="{{ route('projetos.index') }}" 
                                   class="{{ request()->routeIs('projetos.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20' }} group flex gap-x-3 rounded-md py-2 pl-9 pr-2 text-sm leading-6">
                                    <i class="fa-solid fa-folder text-sm w-4 h-4"></i>
                                    Projetos
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('tarefas.index') }}" 
                                   class="{{ request()->routeIs('tarefas.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20' }} group flex gap-x-3 rounded-md py-2 pl-9 pr-2 text-sm leading-6">
                                    <i class="fa-solid fa-list-check text-sm w-4 h-4"></i>
                                    Tarefas
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Tarefas Domésticas -->
                    <li>
                        <a href="{{ route('household-tasks.index') }}" 
                           class="{{ request()->routeIs('household-tasks.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                            <i class="fa-solid fa-home text-lg w-6 h-6"></i>
                            Tarefas Domésticas
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div> 