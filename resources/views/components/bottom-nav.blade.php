<nav class="fixed bottom-0 left-0 right-0 w-full z-50 bg-white dark:bg-gray-900 shadow-lg border-t border-gray-200 dark:border-gray-800 h-16 md:hidden">
    <!-- Ícones -->
    <div class="flex justify-around items-center w-full h-full">
        <!-- Casa -->
        <button type="button" class="flex flex-col items-center justify-center text-gray-400 hover:text-blue-600 transition-colors h-full w-full" onclick="openBottomModal('casa')">
            <i class="fa-solid fa-house-chimney text-xl"></i>
            <span class="text-xs">Casa</span>
        </button>
        <!-- Financeiro -->
        <button type="button" class="flex flex-col items-center justify-center text-gray-400 hover:text-blue-600 transition-colors h-full w-full" onclick="openBottomModal('financeiro')">
            <i class="fa-solid fa-coins text-xl"></i>
            <span class="text-xs">Financeiro</span>
        </button>
        <!-- Eventos -->
        <button type="button" class="flex flex-col items-center justify-center text-gray-400 hover:text-blue-600 transition-colors h-full w-full" onclick="openBottomModal('eventos')">
            <i class="fa-solid fa-calendar-days text-xl"></i>
            <span class="text-xs">Eventos</span>
        </button>
        <!-- Projetos -->
        <button type="button" class="flex flex-col items-center justify-center text-gray-400 hover:text-blue-600 transition-colors h-full w-full" onclick="openBottomModal('projetos')">
            <i class="fa-solid fa-briefcase text-xl"></i>
            <span class="text-xs">Projetos</span>
        </button>
    </div>
</nav>

<!-- Modal para navegação mobile -->
<div id="bottom-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden md:hidden flex items-center justify-center">
    <div class="bg-gray-900 rounded-2xl shadow-2xl max-w-sm w-full mx-4 max-h-96 overflow-y-auto">
        <div class="p-4">
            <div class="flex items-center justify-between mb-3">
                <h3 id="modal-title" class="text-xl font-semibold text-white"></h3>
                <button onclick="closeBottomModal()" class="text-gray-400 hover:text-white text-2xl">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div id="modal-content" class="space-y-1">
                <!-- Conteúdo será inserido dinamicamente -->
            </div>
        </div>
    </div>
</div>

<script>
// Dados dos menus
const menuData = {
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
            { label: 'Clientes', route: '{{ route("clientes.index") }}', icon: 'fa-users' },
            { label: 'Receitas Fixas', route: '{{ route("finance.fixed-incomes.index") }}', icon: 'fa-money-bill-wave' },
            { label: 'Despesas Fixas', route: '{{ route("finance.fixed-expenses.index") }}', icon: 'fa-money-bill-trend-up' }
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

function openBottomModal(groupName) {
    const modal = document.getElementById('bottom-modal');
    const title = document.getElementById('modal-title');
    const content = document.getElementById('modal-content');
    
    if (menuData[groupName]) {
        title.textContent = menuData[groupName].title;
        
        content.innerHTML = menuData[groupName].items.map(item => `
            <a href="${item.route}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-800 transition-colors text-white">
                <i class="fa-solid ${item.icon} text-lg"></i>
                <span class="font-medium">${item.label}</span>
            </a>
        `).join('');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
}

function closeBottomModal() {
    const modal = document.getElementById('bottom-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Fechar modal ao clicar fora
document.getElementById('bottom-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeBottomModal();
    }
});

// Fechar modal com ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeBottomModal();
    }
});
</script> 