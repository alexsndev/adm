<aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-gray-900 text-white shadow-lg z-40 flex flex-col transition-transform duration-300 transform -translate-x-0 md:translate-x-0">
    <!-- Logo e botão mobile -->
    <div class="flex items-center justify-between h-16 px-4 border-b border-gray-800">
        <span class="text-xl font-bold tracking-wide flex items-center gap-2">
            <i class="fa-solid fa-layer-group"></i> Grow
        </span>
        <button class="md:hidden text-gray-400 hover:text-white focus:outline-none" onclick="toggleSidebar()">
            <i class="fa-solid fa-xmark text-2xl"></i>
        </button>
    </div>
    <nav class="flex-1 overflow-y-auto py-4 px-2">
        <ul class="space-y-2">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
            </li>
            <!-- Profissional -->
            <li class="mt-4 mb-1 text-xs text-gray-400 uppercase px-3">Profissional</li>
            <li>
                <a href="{{ route('tarefas.create') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-plus"></i> Nova Tarefa
                </a>
            </li>
            <li>
                <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-tags"></i> Categorias
                </a>
            </li>
            <li>
                <a href="{{ route('projetos.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-briefcase"></i> Projetos
                </a>
            </li>
            <li>
                <a href="{{ route('projetos.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-list"></i> Todos Projetos
                </a>
            </li>
            <li>
                <a href="{{ route('projetos.create') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-plus"></i> Novo Projeto
                </a>
            </li>
            <li>
                <a href="{{ route('tarefas.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-tasks"></i> Tarefas Profissionais
                </a>
            </li>
            <li>
                <a href="{{ route('clientes.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-users"></i> Clientes
                </a>
            </li>
            <li>
                <a href="{{ route('faturas.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-file-invoice-dollar"></i> Faturas
                </a>
            </li>
            <li>
                <a href="{{ route('registros-horas.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-clock"></i> Registros de Horas
                </a>
            </li>
            <!-- Finanças -->
            <li class="mt-4 mb-1 text-xs text-gray-400 uppercase px-3">Finanças</li>
            <li>
                <a href="{{ route('finance.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-chart-pie"></i> Dashboard Financeiro
                </a>
            </li>
            <li>
                <a href="{{ route('accounts.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-wallet"></i> Contas
                </a>
            </li>
            <li>
                <a href="{{ route('transactions.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-arrow-right-arrow-left"></i> Transações
                </a>
            </li>
            <li>
                <a href="{{ route('debts.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-money-bill-trend-up"></i> Dívidas
                </a>
            </li>
            <li>
                <a href="{{ route('financial-goals.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-bullseye"></i> Metas Financeiras
                </a>
            </li>
            <li>
                <a href="{{ route('faturas.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-file-invoice"></i> Faturas
                </a>
            </li>
            <li>
                <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-layer-group"></i> Categorias de Transação
                </a>
            </li>
            <li>
                <a href="{{ route('credit-cards.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-credit-card"></i> Cartões de Crédito
                </a>
            </li>
            <li>
                <a href="{{ route('clientes.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-users"></i> Clientes
                </a>
            </li>
            <!-- Eventos -->
            <li class="mt-4 mb-1 text-xs text-gray-400 uppercase px-3">Eventos</li>
            <li>
                <a href="{{ route('events.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-list-ul"></i> Todos Eventos
                </a>
            </li>
            <li>
                <a href="{{ route('events.create') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-plus"></i> Novo Evento
                </a>
            </li>
            <li>
                <a href="{{ route('events.calendar') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-calendar-days"></i> Calendário
                </a>
            </li>
            <li>
                <a href="{{ route('previsibilidade.index') }}" class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-800 transition">
                    <i class="fa-solid fa-user-group"></i> Previsibilidade
                </a>
            </li>
        </ul>
    </nav>
</aside>
<!-- Botão mobile -->
<button id="sidebarToggle" class="fixed top-4 left-4 z-50 p-2 rounded bg-gray-900 text-white shadow-lg md:hidden" onclick="toggleSidebar()">
    <i class="fa-solid fa-bars text-2xl"></i>
</button>
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('-translate-x-full');
    }
</script> 