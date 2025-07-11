<nav class="fixed top-0 left-0 h-full w-20 bg-gray-900 text-white shadow-lg z-40 hidden md:flex flex-col items-center py-6 space-y-6">
    <!-- Casa -->
    <button type="button" class="flex flex-col items-center justify-center text-gray-400 hover:text-white transition-colors" onclick="openSideModal('casa')">
        <i class="fa-solid fa-house-chimney text-2xl mb-1"></i>
        <span class="text-xs">Casa</span>
    </button>
    <!-- Financeiro -->
    <button type="button" class="flex flex-col items-center justify-center text-gray-400 hover:text-white transition-colors" onclick="openSideModal('financeiro')">
        <i class="fa-solid fa-coins text-2xl mb-1"></i>
        <span class="text-xs">Financeiro</span>
    </button>
    <!-- Eventos -->
    <button type="button" class="flex flex-col items-center justify-center text-gray-400 hover:text-white transition-colors" onclick="openSideModal('eventos')">
        <i class="fa-solid fa-calendar-days text-2xl mb-1"></i>
        <span class="text-xs">Eventos</span>
    </button>
    <!-- Projetos -->
    <button type="button" class="flex flex-col items-center justify-center text-gray-400 hover:text-white transition-colors" onclick="openSideModal('projetos')">
        <i class="fa-solid fa-briefcase text-2xl mb-1"></i>
        <span class="text-xs">Projetos</span>
    </button>
</nav>

<!-- Modal para navegação lateral desktop -->
<div id="side-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden md:flex items-center justify-center">
    <div class="bg-gray-900 rounded-2xl shadow-2xl max-w-sm w-full mx-4 max-h-96 overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 id="side-modal-title" class="text-xl font-semibold text-white"></h3>
                <button onclick="closeSideModal()" class="text-gray-400 hover:text-white text-2xl">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div id="side-modal-content" class="space-y-2">
                <!-- Conteúdo será inserido dinamicamente -->
            </div>
        </div>
    </div>
</div>

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