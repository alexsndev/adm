<nav id="side-nav" x-data="{ submenu: '' }" :class="$root.sidebarOpen ? 'w-56' : 'w-16'" class="fixed top-16 left-0 h-[calc(100vh-4rem)] bg-gray-900 text-white shadow-lg z-40 hidden md:flex flex-col py-8 px-2 transition-all duration-200">
    <!-- Casa -->
    <div>
        <button @click="$root.sidebarOpen = true; submenu = submenu === 'casa' ? '' : 'casa'" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg px-3 py-3 transition-colors w-full text-left">
            <i class="fa-solid fa-house-chimney text-xl"></i>
            <span x-show="$root.sidebarOpen" class="text-base font-medium">Casa</span>
            <i x-show="$root.sidebarOpen" :class="submenu === 'casa' ? 'fa-angle-up' : 'fa-angle-down'" class="fa-solid ml-auto"></i>
        </button>
        <div x-show="submenu === 'casa' && $root.sidebarOpen" class="pl-10 flex flex-col gap-1 mt-1">
            <a href="{{ route('household-tasks.dashboard') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-gauge"></i> Dashboard</a>
            <a href="{{ route('household-tasks.index') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-list-check"></i> Todas as Tarefas</a>
            <a href="{{ route('household-tasks.create') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-plus"></i> Nova Tarefa</a>
            <a href="{{ route('task-categories.index') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-tags"></i> Categorias</a>
        </div>
    </div>
    <!-- Financeiro -->
    <div>
        <button @click="$root.sidebarOpen = true; submenu = submenu === 'financeiro' ? '' : 'financeiro'" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg px-3 py-3 transition-colors w-full text-left">
            <i class="fa-solid fa-coins text-xl"></i>
            <span x-show="$root.sidebarOpen" class="text-base font-medium">Financeiro</span>
            <i x-show="$root.sidebarOpen" :class="submenu === 'financeiro' ? 'fa-angle-up' : 'fa-angle-down'" class="fa-solid ml-auto"></i>
        </button>
        <div x-show="submenu === 'financeiro' && $root.sidebarOpen" class="pl-10 flex flex-col gap-1 mt-1">
            <a href="{{ route('finance.dashboard') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-chart-pie"></i> Dashboard</a>
            <a href="{{ route('accounts.index') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-wallet"></i> Contas</a>
            <a href="{{ route('transactions.index') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-arrow-right-arrow-left"></i> Transações</a>
            <a href="{{ route('debts.index') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-money-bill-trend-up"></i> Dívidas</a>
            <a href="{{ route('financial-goals.index') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-bullseye"></i> Metas Financeiras</a>
            <a href="{{ route('faturas.index') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-file-invoice"></i> Faturas</a>
            <a href="{{ route('categories.index') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-layer-group"></i> Categorias</a>
            <a href="{{ route('credit-cards.index') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-credit-card"></i> Cartões de Crédito</a>
            <a href="{{ route('clientes.index') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-users"></i> Clientes</a>
        </div>
    </div>
    <!-- Eventos -->
    <div>
        <button @click="$root.sidebarOpen = true; submenu = submenu === 'eventos' ? '' : 'eventos'" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg px-3 py-3 transition-colors w-full text-left">
            <i class="fa-solid fa-calendar-days text-xl"></i>
            <span x-show="$root.sidebarOpen" class="text-base font-medium">Eventos</span>
            <i x-show="$root.sidebarOpen" :class="submenu === 'eventos' ? 'fa-angle-up' : 'fa-angle-down'" class="fa-solid ml-auto"></i>
        </button>
        <div x-show="submenu === 'eventos' && $root.sidebarOpen" class="pl-10 flex flex-col gap-1 mt-1">
            <a href="{{ route('events.index') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-list-ul"></i> Todos Eventos</a>
            <a href="{{ route('events.create') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-plus"></i> Novo Evento</a>
            <a href="{{ route('events.calendar') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-calendar-days"></i> Calendário</a>
            <a href="{{ route('previsibilidade.index') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-user-group"></i> Previsibilidade</a>
        </div>
    </div>
    <!-- Projetos -->
    <div>
        <button @click="$root.sidebarOpen = true; submenu = submenu === 'projetos' ? '' : 'projetos'" class="flex items-center gap-3 text-gray-400 hover:text-white hover:bg-gray-800 rounded-lg px-3 py-3 transition-colors w-full text-left">
            <i class="fa-solid fa-briefcase text-xl"></i>
            <span x-show="$root.sidebarOpen" class="text-base font-medium">Projetos</span>
            <i x-show="$root.sidebarOpen" :class="submenu === 'projetos' ? 'fa-angle-up' : 'fa-angle-down'" class="fa-solid ml-auto"></i>
        </button>
        <div x-show="submenu === 'projetos' && $root.sidebarOpen" class="pl-10 flex flex-col gap-1 mt-1">
            <a href="{{ route('projetos.index') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-list"></i> Todos Projetos</a>
            <a href="{{ route('projetos.create') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-plus"></i> Novo Projeto</a>
            <a href="{{ route('tarefas.index') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-tasks"></i> Tarefas Profissionais</a>
            <a href="{{ route('clientes.index') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-users"></i> Clientes</a>
            <a href="{{ route('faturas.index') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-file-invoice-dollar"></i> Faturas</a>
            <a href="{{ route('registros-horas.index') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-clock"></i> Registros de Horas</a>
            <a href="{{ route('categories.index') }}" class="flex items-center gap-2 text-gray-300 hover:text-white text-sm py-1"> <i class="fa-solid fa-tags"></i> Categorias</a>
        </div>
    </div>
</nav>

<script>
// Dados dos menus (mesmo do bottom nav)
const sideMenuData = {
    casa: {
        title: 'Casa',
        items: [
            { label: 'Dashboard', route: '{{ route("household-tasks.dashboard") }}', icon: 'fa-gauge' },
            { label: 'Todas as Tarefas', route: '{{ route("household-tasks.index") }}', icon: 'fa-list-check' },
            { label: 'Nova Tarefa', route: '{{ route("household-tasks.create") }}', icon: 'fa-plus' },
            { label: 'Categorias', route: '{{ route("task-categories.index") }}', icon: 'fa-tags' }
        ]
    },
    financeiro: {
        title: 'Financeiro',
        items: [
            { label: 'Dashboard', route: '{{ route("finance.dashboard") }}', icon: 'fa-chart-pie' },
            { label: 'Contas', route: '{{ route("accounts.index") }}', icon: 'fa-wallet' },
            { label: 'Transações', route: '{{ route("transactions.index") }}', icon: 'fa-arrow-right-arrow-left' },
            { label: 'Dívidas', route: '{{ route("debts.index") }}', icon: 'fa-money-bill-trend-up' },
            { label: 'Metas Financeiras', route: '{{ route("financial-goals.index") }}', icon: 'fa-bullseye' },
            { label: 'Faturas', route: '{{ route("faturas.index") }}', icon: 'fa-file-invoice' },
            { label: 'Categorias', route: '{{ route("categories.index") }}', icon: 'fa-layer-group' },
            { label: 'Cartões de Crédito', route: '{{ route("credit-cards.index") }}', icon: 'fa-credit-card' },
            { label: 'Clientes', route: '{{ route("clientes.index") }}', icon: 'fa-users' }
        ]
    },
    eventos: {
        title: 'Eventos',
        items: [
            { label: 'Todos Eventos', route: '{{ route("events.index") }}', icon: 'fa-list-ul' },
            { label: 'Novo Evento', route: '{{ route("events.create") }}', icon: 'fa-plus' },
            { label: 'Calendário', route: '{{ route("events.calendar") }}', icon: 'fa-calendar-days' },
            { label: 'Previsibilidade', route: '{{ route("previsibilidade.index") }}', icon: 'fa-user-group' }
        ]
    },
    projetos: {
        title: 'Projetos',
        items: [
            { label: 'Todos Projetos', route: '{{ route("projetos.index") }}', icon: 'fa-list' },
            { label: 'Novo Projeto', route: '{{ route("projetos.create") }}', icon: 'fa-plus' },
            { label: 'Tarefas Profissionais', route: '{{ route("tarefas.index") }}', icon: 'fa-tasks' },
            { label: 'Clientes', route: '{{ route("clientes.index") }}', icon: 'fa-users' },
            { label: 'Faturas', route: '{{ route("faturas.index") }}', icon: 'fa-file-invoice-dollar' },
            { label: 'Registros de Horas', route: '{{ route("registros-horas.index") }}', icon: 'fa-clock' },
            { label: 'Categorias', route: '{{ route("categories.index") }}', icon: 'fa-tags' }
        ]
    }
};

function openSideModal(groupName) {
    const modal = document.getElementById('side-modal');
    const title = document.getElementById('side-modal-title');
    const content = document.getElementById('side-modal-content');
    
    if (sideMenuData[groupName]) {
        title.textContent = sideMenuData[groupName].title;
        
        content.innerHTML = sideMenuData[groupName].items.map(item => `
            <a href="${item.route}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-800 transition-colors text-white">
                <i class="fa-solid ${item.icon} text-lg"></i>
                <span class="font-medium">${item.label}</span>
            </a>
        `).join('');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
}

function closeSideModal() {
    const modal = document.getElementById('side-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Fechar modal ao clicar fora
document.getElementById('side-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeSideModal();
    }
});

// Fechar modal com ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeSideModal();
    }
});
</script> 