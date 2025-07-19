@extends('layouts.app')

@section('nav-classes', 'bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800')
@section('background')
    <div class="fixed inset-0 z-0 bg-[#181c20] transition-colors duration-300"></div>
@endsection

@section('header-classes', 'bg-white dark:bg-gray-900 shadow-none')
@section('main-classes', 'relative z-10')

@section('content')
    <style>
        .draggable-sidebar {
            transition: opacity 0.2s, box-shadow 0.2s;
            cursor: grab;
            user-select: none;
        }
        .draggable-sidebar.dragging {
            opacity: 1 !important;
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
            cursor: grabbing;
        }
        @media (max-width: 640px) {
            .draggable-sidebar {
                width: 40px;
                min-width: 40px;
                max-width: 40px;
                height: 85vh;
                min-height: 0;
                max-height: 85vh;
                border-radius: 1.5rem;
                padding: 0.75rem 0;
                right: 0.75rem !important;
                top: 36vh !important;
                z-index: 50;
                box-shadow: 0 4px 16px rgba(0,0,0,0.15);
                display: flex !important;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
                overflow-y: auto;
                scrollbar-width: thin;
                scrollbar-color: #cbd5e1 #f1f5f9;
            }
            .draggable-sidebar::-webkit-scrollbar {
                width: 4px;
            }
            .draggable-sidebar::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 8px;
            }
            .draggable-sidebar .sidebar-toggle {
                display: none !important;
            }
            .draggable-sidebar .sidebar-content {
                display: flex !important;
                flex-direction: column;
                gap: 0.75rem;
                align-items: center;
                justify-content: space-evenly;
                width: 100%;
                height: 100%;
                padding: 0.5rem 0;
            }
            .draggable-sidebar .sidebar-content a {
                width: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 0.5rem 0;
                min-height: 2.5rem;
            }
            .draggable-sidebar .sidebar-content i {
                font-size: 1.25rem;
            }
            .draggable-sidebar .sidebar-content span {
                display: none;
            }
        }
        @media (min-width: 641px) {
            .draggable-sidebar .sidebar-toggle {
                display: none;
            }
        }
        /* Indicador de seção ativa */
        .draggable-sidebar .sidebar-content a.active-section {
            opacity: 1 !important;
            transform: scale(1.1);
        }
        .draggable-sidebar .sidebar-content a.active-section i {
            opacity: 1 !important;
        }
        .draggable-sidebar .sidebar-content a.active-section span {
            opacity: 1 !important;
        }
        /* Transições suaves para o indicador ativo */
        .draggable-sidebar .sidebar-content a {
            transition: opacity 0.3s ease, transform 0.3s ease;
            min-height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .draggable-sidebar .sidebar-content a i,
        .draggable-sidebar .sidebar-content a span {
            transition: opacity 0.3s ease;
        }
        /* Melhor espaçamento vertical para desktop */
        @media (min-width: 641px) {
            .draggable-sidebar .sidebar-content {
                gap: 0.25rem;
                padding: 0.25rem 0;
            }
            .draggable-sidebar .sidebar-content a {
                padding: 0.25rem 0;
            }
        }
        /* Ajuste para telas pequenas */
        @media (max-width: 480px) {
            .draggable-sidebar {
                right: 0.5rem;
                top: calc(50% + 40px) !important;
            }
        }
        /* Ajuste para considerar sidebar lateral (desktop) */
        @media (min-width: 641px) {
            .draggable-sidebar {
                right: 1rem;
                top: calc(50% + 120px);
            }
        }
        /* Ajuste para telas muito grandes */
        @media (min-width: 1024px) {
            .draggable-sidebar {
                right: 1.5rem;
                top: calc(50% + 140px);
            }
        }
    </style>
    <div id="draggableSidebar" class="draggable-sidebar fixed top-1/2 right-4 z-40 flex flex-col gap-1 bg-white/80 dark:bg-gray-900/80 rounded-2xl shadow-lg p-3 border border-gray-200 dark:border-gray-800 backdrop-blur-md opacity-20 transition min-w-0 max-w-full transform -translate-y-1/2">
        <div class="sidebar-content flex flex-col gap-1">
            <a href="#dashboard-top" class="group flex flex-col items-center text-blue-600 dark:text-blue-300 hover:text-blue-800 dark:hover:text-blue-100 transition py-0.5" title="Topo">
                <i class="fa-solid fa-chart-line text-lg opacity-20 group-hover:opacity-100 group-focus:opacity-100 transition"></i>
                <span class="text-xs mt-1 opacity-0 group-hover:opacity-100 transition">Topo</span>
            </a>
            <a href="#dashboard-goals" class="group flex flex-col items-center text-green-600 dark:text-green-300 hover:text-green-800 dark:hover:text-green-100 transition py-0.5" title="Metas">
                <i class="fa-solid fa-bullseye text-lg opacity-20 group-hover:opacity-100 group-focus:opacity-100 transition"></i>
                <span class="text-xs mt-1 opacity-0 group-hover:opacity-100 transition">Metas</span>
            </a>
            <a href="#dashboard-debts" class="group flex flex-col items-center text-red-600 dark:text-red-300 hover:text-red-800 dark:hover:text-red-100 transition py-0.5" title="Dívidas">
                <i class="fa-solid fa-money-bill-wave text-lg opacity-20 group-hover:opacity-100 group-focus:opacity-100 transition"></i>
                <span class="text-xs mt-1 opacity-0 group-hover:opacity-100 transition">Dívidas</span>
            </a>
            <a href="#dashboard-events" class="group flex flex-col items-center text-blue-500 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-200 transition py-0.5" title="Eventos">
                <i class="fa-solid fa-calendar-days text-lg opacity-20 group-hover:opacity-100 group-focus:opacity-100 transition"></i>
                <span class="text-xs mt-1 opacity-0 group-hover:opacity-100 transition">Eventos</span>
            </a>
            <a href="#dashboard-holidays" class="group flex flex-col items-center text-yellow-500 dark:text-yellow-300 hover:text-yellow-700 dark:hover:text-yellow-100 transition py-0.5" title="Feriados">
                <i class="fa-solid fa-umbrella-beach text-lg opacity-20 group-hover:opacity-100 group-focus:opacity-100 transition"></i>
                <span class="text-xs mt-1 opacity-0 group-hover:opacity-100 transition">Feriados</span>
            </a>
            <a href="#dashboard-birthdays" class="group flex flex-col items-center text-pink-500 dark:text-pink-300 hover:text-pink-700 dark:hover:text-pink-100 transition py-0.5" title="Aniversariantes">
                <i class="fa-solid fa-cake-candles text-lg opacity-20 group-hover:opacity-100 group-focus:opacity-100 transition"></i>
                <span class="text-xs mt-1 opacity-0 group-hover:opacity-100 transition">Aniversários</span>
            </a>
        </div>
    </div>
    <script>
        // Drag and drop sidebar (desktop/tablet only)
        const sidebar = document.getElementById('draggableSidebar');
        let isDragging = false, startX, startY, startTop, startRight;
        function isMobile() {
            return window.innerWidth <= 640;
        }
        if (!isMobile()) {
            sidebar.addEventListener('pointerdown', function(e) {
                if (e.target.closest('.sidebar-toggle')) return; // don't drag on toggle btn
                isDragging = true;
                sidebar.classList.add('dragging');
                startX = e.clientX;
                startY = e.clientY;
                const rect = sidebar.getBoundingClientRect();
                startTop = rect.top;
                startRight = window.innerWidth - rect.right;
                document.body.style.userSelect = 'none';
            });
            window.addEventListener('pointermove', function(e) {
                if (!isDragging) return;
                let newTop = startTop + (e.clientY - startY);
                let newRight = startRight - (e.clientX - startX);
                newTop = Math.max(0, Math.min(window.innerHeight - sidebar.offsetHeight, newTop));
                newRight = Math.max(0, Math.min(window.innerWidth - 56, newRight));
                sidebar.style.top = newTop + 'px';
                sidebar.style.right = newRight + 'px';
            });
            window.addEventListener('pointerup', function() {
                isDragging = false;
                sidebar.classList.remove('dragging');
                document.body.style.userSelect = '';
            });
        }
        // Opacity on hover/focus/touch
        function setSidebarOpacity(val) {
            sidebar.style.opacity = val;
        }
        sidebar.addEventListener('mouseenter', () => setSidebarOpacity(1));
        sidebar.addEventListener('mouseleave', () => setSidebarOpacity(0.2));
        sidebar.addEventListener('touchstart', () => setSidebarOpacity(1));
        sidebar.addEventListener('touchend', () => setSidebarOpacity(0.2));
        // Mobile: toggle open/close
        function toggleSidebarMobile(e) {
            e.stopPropagation();
            sidebar.classList.toggle('open');
            // Ajusta posição do menu para não sair da tela
            if (sidebar.classList.contains('open')) {
                const content = sidebar.querySelector('.sidebar-content');
                const rect = sidebar.getBoundingClientRect();
                let left = rect.right + 10;
                let right = 'auto';
                if (left + 200 > window.innerWidth) { // se passar da tela, abre para a esquerda
                    left = 'auto';
                    right = rect.width + 10 + 'px';
                } else {
                    left = rect.width + 10 + 'px';
                    right = 'auto';
                }
                content.style.left = left;
                content.style.right = right;
            }
        }
        document.addEventListener('click', function(e) {
            if(isMobile() && sidebar.classList.contains('open')) {
                if (!e.target.closest('#draggableSidebar')) {
                    sidebar.classList.remove('open');
                }
            }
        });

        // Smooth scroll para as âncoras da sidebar
        document.querySelectorAll('#draggableSidebar a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    const headerOffset = 80; // Ajuste conforme necessário
                    const elementPosition = targetElement.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Indicador de seção ativa na sidebar
        function updateActiveSection() {
            const sections = ['dashboard-top', 'dashboard-goals', 'dashboard-debts', 'dashboard-events', 'dashboard-holidays', 'dashboard-birthdays'];
            const sidebarLinks = document.querySelectorAll('#draggableSidebar a[href^="#"]');
            
            let activeSection = 'dashboard-top';
            const scrollPosition = window.scrollY + 100; // Offset para melhor detecção
            
            sections.forEach(sectionId => {
                const element = document.querySelector(`#${sectionId}`);
                if (element) {
                    const elementTop = element.offsetTop;
                    const elementBottom = elementTop + element.offsetHeight;
                    
                    if (scrollPosition >= elementTop && scrollPosition < elementBottom) {
                        activeSection = sectionId;
                    }
                }
            });
            
            // Remove classe ativa de todos os links
            sidebarLinks.forEach(link => {
                link.classList.remove('active-section');
            });
            
            // Adiciona classe ativa ao link correspondente
            const activeLink = document.querySelector(`#draggableSidebar a[href="#${activeSection}"]`);
            if (activeLink) {
                activeLink.classList.add('active-section');
            }
        }
        
        // Atualiza seção ativa no scroll
        window.addEventListener('scroll', updateActiveSection);
        window.addEventListener('load', updateActiveSection);
    </script>
    <div id="dashboard-top"></div>
    <div class="min-h-screen w-full">
        <div class="w-full px-0 py-4 md:py-8" style="max-width:100%;">
            
            <!-- Cards de resumo -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8 fade-in-up w-full">
                <!-- Saldo Total -->
                <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-800">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <i class="fa-solid fa-wallet text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Saldo Total</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">R$ {{ number_format($totalBalance ?? 0, 2, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('accounts.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                            Ver contas <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Receitas do Mês -->
                <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-800">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                            <i class="fa-solid fa-arrow-up text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Receitas do Mês</p>
                            <p class="text-2xl font-bold text-green-600">R$ {{ number_format($monthlyIncome ?? 0, 2, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('transactions.index') }}" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 text-sm font-medium">
                            Ver transações <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Despesas do Mês -->
                <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-800">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 dark:bg-red-900 rounded-lg">
                            <i class="fa-solid fa-arrow-down text-red-600 dark:text-red-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Despesas do Mês</p>
                            <p class="text-2xl font-bold text-red-600">R$ {{ number_format($monthlyExpenses ?? 0, 2, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('transactions.index') }}" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium">
                            Ver transações <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Total de Transações -->
                <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-800">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                            <i class="fa-solid fa-list text-purple-600 dark:text-purple-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Transações</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalTransactions ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('transactions.index') }}" class="text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300 text-sm font-medium">
                            Ver todas <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Tabela de Transações Recentes -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 mb-8 fade-in-up flex flex-col items-center w-full overflow-x-auto">
                <h2 class="text-lg font-semibold mb-4 text-slate-700 dark:text-slate-200 w-full">Transações Recentes</h2>
                <div class="w-full flex justify-center">
                    <div class="overflow-x-auto w-full">
                        <table class="min-w-full text-xs sm:text-sm divide-y divide-gray-200 dark:divide-gray-800">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Data</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Conta</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Categoria</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tipo</th>
                                    <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTransactions ?? [] as $transaction)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ $transaction->account->name ?? '-' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ $transaction->category->name ?? '-' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">
                                            <span class="px-2 py-1 rounded-full text-xs font-bold {{ $transaction->type === 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $transaction->type === 'income' ? 'Receita' : 'Despesa' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-right font-bold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                            R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-gray-500 dark:text-gray-400 py-8">Nenhuma transação recente.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Seção Financeira Organizada: Receitas e Despesas Fixas -->
            <div class="mb-8">
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center mb-6">
                        <i class="fa-solid fa-chart-pie text-blue-500 mr-2"></i>
                        Fluxo Financeiro Mensal
                    </h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Receitas Fixas -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-md font-semibold text-green-700 dark:text-green-300 flex items-center">
                                    <i class="fa-solid fa-arrow-up text-green-500 mr-2"></i>
                                    Receitas Fixas
                                </h4>
                                <a href="{{ route('finance.fixed-incomes.index') }}" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 text-sm font-medium">
                                    Ver todas <i class="fa-solid fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                            
                            <div class="space-y-3">
                                @forelse($fixedIncomes as $income)
                                    <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800 hover:shadow-md transition-shadow">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <div class="font-semibold text-green-900 dark:text-green-200 text-sm">{{ $income->description }}</div>
                                                <div class="text-xs text-green-700 dark:text-green-300 mt-1">
                                                    <i class="fa-solid fa-calendar-day mr-1"></i>
                                                    Dia {{ \Carbon\Carbon::parse($income->date)->format('d') }} do mês
                                                </div>
                                                <div class="text-xs text-green-600 dark:text-green-400 mt-1">
                                                    <i class="fa-solid fa-tag mr-1"></i>
                                                    {{ $income->category->name ?? 'Sem categoria' }}
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="font-bold text-green-700 dark:text-green-300 text-lg">
                                                    R$ {{ number_format($income->amount, 2, ',', '.') }}
                                                </div>
                                                <div class="text-xs text-green-600 dark:text-green-400">
                                                    {{ $income->account->name ?? 'Sem conta' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-6 border border-green-200 dark:border-green-800 text-center">
                                        <i class="fa-solid fa-arrow-up text-green-400 text-2xl mb-2"></i>
                                        <div class="text-green-700 dark:text-green-300 font-medium">Nenhuma receita fixa cadastrada</div>
                                        <div class="text-green-600 dark:text-green-400 text-sm mt-1">Cadastre suas receitas recorrentes</div>
                                        <a href="{{ route('finance.fixed-incomes.create') }}" class="inline-block mt-3 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm">
                                            <i class="fa-solid fa-plus mr-1"></i>
                                            Cadastrar Receita Fixa
                                        </a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        
                        <!-- Despesas Fixas -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-md font-semibold text-red-700 dark:text-red-300 flex items-center">
                                    <i class="fa-solid fa-arrow-down text-red-500 mr-2"></i>
                                    Despesas Fixas
                                </h4>
                                <a href="{{ route('finance.fixed-expenses.index') }}" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium">
                                    Ver todas <i class="fa-solid fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                            
                            <div class="space-y-3">
                                @forelse($fixedExpenses as $expense)
                                    <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-4 border border-red-200 dark:border-red-800 hover:shadow-md transition-shadow">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <div class="font-semibold text-red-900 dark:text-red-200 text-sm">{{ $expense->description }}</div>
                                                <div class="text-xs text-red-700 dark:text-red-300 mt-1">
                                                    <i class="fa-solid fa-calendar-day mr-1"></i>
                                                    Dia {{ \Carbon\Carbon::parse($expense->date)->format('d') }} do mês
                                                </div>
                                                <div class="text-xs text-red-600 dark:text-red-400 mt-1">
                                                    <i class="fa-solid fa-tag mr-1"></i>
                                                    {{ $expense->category->name ?? 'Sem categoria' }}
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="font-bold text-red-700 dark:text-red-300 text-lg">
                                                    R$ {{ number_format($expense->amount, 2, ',', '.') }}
                                                </div>
                                                <div class="text-xs text-red-600 dark:text-red-400">
                                                    {{ $expense->account->name ?? 'Sem conta' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-6 border border-red-200 dark:border-red-800 text-center">
                                        <i class="fa-solid fa-arrow-down text-red-400 text-2xl mb-2"></i>
                                        <div class="text-red-700 dark:text-red-300 font-medium">Nenhuma despesa fixa cadastrada</div>
                                        <div class="text-red-600 dark:text-red-400 text-sm mt-1">Cadastre suas despesas recorrentes</div>
                                        <a href="{{ route('finance.fixed-expenses.create') }}" class="inline-block mt-3 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm">
                                            <i class="fa-solid fa-plus mr-1"></i>
                                            Cadastrar Despesa Fixa
                                        </a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <!-- Botões de Diárias -->
                    <div class="flex flex-col sm:flex-row gap-3 mt-8 justify-end">
                        <a href="{{ route('daily-forecasts.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold shadow transition flex items-center gap-2">
                            <i class="fa-solid fa-list"></i> Gerenciar Diárias
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Metas Financeiras -->
            <div id="dashboard-goals" class="mb-8">
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center mb-4">
                        <i class="fa-solid fa-bullseye text-green-500 mr-2"></i>
                        Metas Financeiras
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        @forelse($goals as $goal)
                            <div class="flex flex-col items-center text-center bg-green-50 dark:bg-green-900/30 rounded-lg p-4 shadow">
                                <div class="font-bold text-green-900 dark:text-green-200 mb-1">{{ $goal->name }}</div>
                                <div class="text-sm text-green-700 dark:text-green-300 mb-1">Meta: R$ {{ number_format($goal->target_amount, 2, ',', '.') }}</div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mb-2">
                                    <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ min(100, ($goal->current_amount / max(1, $goal->target_amount)) * 100) }}%"></div>
                                </div>
                                <div class="text-xs text-green-800 dark:text-green-400">Progresso: R$ {{ number_format($goal->current_amount, 2, ',', '.') }}</div>
                            </div>
                        @empty
                            <div class="col-span-4 text-center text-green-500 dark:text-green-300 py-8">
                                Nenhuma meta cadastrada.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Dívidas -->
            <div id="dashboard-debts" class="mb-8">
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center mb-4">
                        <i class="fa-solid fa-money-bill-wave text-red-500 mr-2"></i>
                        Dívidas
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        @forelse($debts as $debt)
                            <div class="flex flex-col items-center text-center bg-red-50 dark:bg-red-900/30 rounded-lg p-4 shadow">
                                <div class="font-bold text-red-900 dark:text-red-200 mb-1">{{ $debt->name }}</div>
                                <div class="debt-amount-row text-sm text-red-700 dark:text-red-300 mb-1 flex items-center justify-center gap-2">
                                    <span class="debt-value" style="display: none;">R$ {{ number_format($debt->original_amount, 2, ',', '.') }}</span>
                                    <span class="debt-hidden">••••••</span>
                                    <button type="button" class="toggle-debt-visibility ml-2 text-red-500 hover:text-red-700 dark:hover:text-red-300" title="Mostrar/Ocultar valor">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                                <div class="text-xs text-red-800 dark:text-red-400">Status: {{ $debt->status ?? 'Pendente' }}</div>
                            </div>
                        @empty
                            <div class="col-span-4 text-center text-red-500 dark:text-red-300 py-8">
                                Nenhuma dívida cadastrada.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Blocos de Destaque: Próximos Eventos, Aniversariantes e Feriados -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
                <!-- Próximos Eventos -->
                <div id="dashboard-events" class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-semibold text-blue-700 dark:text-blue-300 flex items-center mb-3 sm:mb-4">
                        <i class="fa-solid fa-calendar-days text-blue-500 mr-2"></i> Próximos Eventos
                    </h3>
                    <ul class="space-y-3 sm:space-y-4">
                        @forelse($nextEvents as $occurrence)
                            <li class="flex items-center gap-2 sm:gap-3">
                                @if($occurrence->event->image)
                                    <img src="{{ Str::startsWith($occurrence->event->image, 'http') ? $occurrence->event->image : Storage::url($occurrence->event->image) }}" alt="Foto Evento" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover border-2 border-blue-200 dark:border-blue-700 shadow">
                                @else
                                    <span class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 font-bold text-lg sm:text-xl">
                                        <i class="fa-solid fa-calendar-days"></i>
                                    </span>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <div class="font-bold text-gray-900 dark:text-white flex items-center gap-1 sm:gap-2 text-sm sm:text-base truncate">
                                        {{ $occurrence->event->title }}
                                        <a href="{{ route('events.edit', $occurrence->event->id) }}" title="Ver evento" class="text-blue-500 hover:text-blue-700 dark:hover:text-blue-300 ml-1">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-300 truncate">{{ \Carbon\Carbon::parse($occurrence->occurrence_date)->format('d/m/Y') }}
                                        @if($occurrence->occurrence_time)
                                            às {{ \Carbon\Carbon::parse($occurrence->occurrence_time)->format('H:i') }}
                                        @endif
                                    </div>
                                    @if($occurrence->event->location)
                                        <div class="text-xs text-gray-400 truncate"><i class="fa-solid fa-location-dot mr-1"></i> {{ $occurrence->event->location }}</div>
                                    @endif
                                </div>
                            </li>
                        @empty
                            <li class="text-gray-400 text-sm">Nenhum evento próximo.</li>
                        @endforelse
                    </ul>
                </div>
                <!-- Próximos Aniversariantes -->
                <div id="dashboard-birthdays" class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-semibold text-pink-700 dark:text-pink-300 flex items-center mb-3 sm:mb-4">
                        <i class="fa-solid fa-cake-candles text-pink-500 mr-2"></i> Próximos Aniversariantes
                    </h3>
                    <ul class="space-y-3 sm:space-y-4">
                        @forelse($nextBirthdays as $person)
                            <li class="flex items-center gap-2 sm:gap-3">
                                @if($person->photo)
                                    <img src="{{ Str::startsWith($person->photo, 'http') ? $person->photo : Storage::url($person->photo) }}" alt="Foto" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover border-2 border-pink-200 dark:border-pink-700 shadow">
                                @else
                                    <span class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-pink-100 dark:bg-pink-900 text-pink-600 dark:text-pink-300 font-bold text-lg sm:text-xl">
                                        <i class="fa-solid fa-cake-candles"></i>
                                    </span>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <div class="font-bold text-gray-900 dark:text-white text-sm sm:text-base truncate">{{ $person->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-300 truncate">{{ \Carbon\Carbon::parse($person->birthdate)->format('d/m') }}</div>
                                </div>
                            </li>
                        @empty
                            <li class="text-gray-400 text-sm">Nenhum aniversariante próximo.</li>
                        @endforelse
                    </ul>
                </div>
                <!-- Próximos Feriados -->
                <div id="dashboard-holidays" class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-semibold text-yellow-700 dark:text-yellow-300 flex items-center mb-3 sm:mb-4">
                        <i class="fa-solid fa-umbrella-beach text-yellow-500 mr-2"></i> Próximos Feriados
                    </h3>
                    <ul class="space-y-3 sm:space-y-4">
                        @forelse($nextHolidays as $occurrence)
                            <li class="flex items-center gap-2 sm:gap-3">
                                <span class="inline-flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300 font-bold text-lg sm:text-xl">
                                    <i class="fa-solid fa-umbrella-beach"></i>
                                </span>
                                <div class="flex-1 min-w-0">
                                    <div class="font-bold text-gray-900 dark:text-white text-sm sm:text-base truncate">{{ $occurrence->event->title }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-300 truncate">{{ \Carbon\Carbon::parse($occurrence->occurrence_date)->format('d/m/Y') }}</div>
                                </div>
                            </li>
                        @empty
                            <li class="text-gray-400 text-sm">Nenhum feriado próximo.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.toggle-debt-visibility').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const parent = btn.closest('.debt-amount-row');
                const value = parent.querySelector('.debt-value');
                const hidden = parent.querySelector('.debt-hidden');
                if (value.style.display === 'none' || value.style.display === '') {
                    value.style.display = 'inline';
                    hidden.style.display = 'none';
                    btn.querySelector('i').classList.remove('fa-eye');
                    btn.querySelector('i').classList.add('fa-eye-slash');
                } else {
                    value.style.display = 'none';
                    hidden.style.display = '';
                    btn.querySelector('i').classList.remove('fa-eye-slash');
                    btn.querySelector('i').classList.add('fa-eye');
                }
            });
        });
    </script>

    <style>
        .animate-fade-in-up {
            animation: fadeInUp 0.3s ease-out;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('pieChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Receitas', 'Despesas'],
                    datasets: [{
                        data: [{{ $monthlyIncome }}, {{ $monthlyExpenses }}],
                        backgroundColor: [
                            'rgba(34,197,94,0.8)', // verde
                            'rgba(239,68,68,0.8)'  // vermelho
                        ],
                        borderColor: [
                            'rgba(34,197,94,1)',
                            'rgba(239,68,68,1)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                color: document.documentElement.classList.contains('dark') ? '#fff' : '#222',
                                font: { size: 16 }
                            }
                        }
                    }
                }
            });
        }

        // AJAX exclusão transação
        document.querySelectorAll('.btn-excluir-transacao').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if (!confirm('Tem certeza que deseja excluir esta transação?')) return;
                const url = this.dataset.url;
                const card = this.closest('.transacao-card');
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: new URLSearchParams({ _method: 'DELETE' })
                })
                .then(resp => resp.ok ? resp.json().catch(()=>({success:true})) : Promise.reject())
                .then(() => {
                    card.remove();
                    showDashMsg('Transação excluída com sucesso!', 'success');
                })
                .catch(() => showDashMsg('Erro ao excluir transação!', 'error'));
            });
        });
        // Mensagem dinâmica
        window.showDashMsg = function(msg, type) {
            let el = document.getElementById('dash-msg');
            if (!el) {
                el = document.createElement('div');
                el.id = 'dash-msg';
                el.className = 'fixed top-6 right-6 z-50 px-6 py-3 rounded-xl font-bold shadow-lg text-white';
                document.body.appendChild(el);
            }
            el.textContent = msg;
            el.style.background = type === 'success' ? '#22c55e' : '#ef4444';
            el.style.display = 'block';
            setTimeout(()=>{ el.style.display='none'; }, 2500);
        }

        // Toggle Resumo Visual
        const toggleBtn = document.getElementById('toggle-resumo-visual');
        const resumoSection = document.getElementById('resumo-visual-section');
        const toggleIcon = toggleBtn.querySelector('i');
        const floatingBtn = document.getElementById('floating-toggle-resumo');
        
        // Verificar estado salvo
        const resumoHidden = localStorage.getItem('resumo-visual-hidden') === 'true';
        if (resumoHidden) {
            resumoSection.style.display = 'none';
            toggleIcon.className = 'fa-solid fa-eye text-sm';
            toggleBtn.title = 'Mostrar Resumo Visual';
            floatingBtn.classList.remove('hidden');
        }
        
        toggleBtn.addEventListener('click', function() {
            const isHidden = resumoSection.style.display === 'none';
            
            if (isHidden) {
                // Mostrar
                resumoSection.style.display = 'block';
                resumoSection.style.animation = 'fadeIn 0.3s ease-in-out';
                toggleIcon.className = 'fa-solid fa-eye-slash text-sm';
                toggleBtn.title = 'Ocultar Resumo Visual';
                floatingBtn.classList.add('hidden');
                localStorage.setItem('resumo-visual-hidden', 'false');
            } else {
                // Ocultar
                resumoSection.style.display = 'none';
                toggleIcon.className = 'fa-solid fa-eye text-sm';
                toggleBtn.title = 'Mostrar Resumo Visual';
                floatingBtn.classList.remove('hidden');
                localStorage.setItem('resumo-visual-hidden', 'true');
            }
        });

        // Botão flutuante
        floatingBtn.querySelector('button').addEventListener('click', function() {
            resumoSection.style.display = 'block';
            resumoSection.style.animation = 'fadeIn 0.3s ease-in-out';
            toggleIcon.className = 'fa-solid fa-eye-slash text-sm';
            toggleBtn.title = 'Ocultar Resumo Visual';
            floatingBtn.classList.add('hidden');
            localStorage.setItem('resumo-visual-hidden', 'false');
        });
    });
</script>
@endpush
