<nav class="fixed bottom-0 left-0 right-0 z-50 bg-gray-900 shadow-2xl border-t border-gray-800 flex justify-around items-center h-16 px-1 md:hidden">
    @php
        $items = [
            [
                'label' => 'Dashboard',
                'icon' => 'fa-house',
                'route' => 'dashboard',
            ],
            [
                'label' => 'Finanças',
                'icon' => 'fa-coins',
                'modal_id' => 'financas-modal',
                'options' => [
                    ['label' => 'Resumo', 'icon' => 'fa-chart-pie', 'route' => 'finance.dashboard'],
                    ['label' => 'Contas', 'icon' => 'fa-wallet', 'route' => 'accounts.index'],
                    ['label' => 'Transações', 'icon' => 'fa-arrow-right-arrow-left', 'route' => 'transactions.index'],
                    ['label' => 'Cartões', 'icon' => 'fa-credit-card', 'route' => 'credit-cards.index'],
                    ['label' => 'Dívidas', 'icon' => 'fa-money-bill-trend-up', 'route' => 'debts.index'],
                ],
            ],
            [
                'label' => 'Eventos',
                'icon' => 'fa-calendar-days',
                'modal_id' => 'eventos-modal',
                'options' => [
                    ['label' => 'Todos Eventos', 'icon' => 'fa-list-ul', 'route' => 'events.index'],
                    ['label' => 'Novo Evento', 'icon' => 'fa-plus', 'route' => 'events.create'],
                    ['label' => 'Calendário', 'icon' => 'fa-calendar-days', 'route' => 'events.calendar'],
                    ['label' => 'Previsibilidade', 'icon' => 'fa-user-group', 'route' => 'previsibilidade.index'],
                ],
            ],
            [
                'label' => 'Casa',
                'icon' => 'fa-house-chimney',
                'modal_id' => 'casa-modal',
                'options' => [
                    ['label' => 'Dashboard', 'icon' => 'fa-gauge', 'route' => 'household-tasks.dashboard'],
                    ['label' => 'Todas as Tarefas', 'icon' => 'fa-list-check', 'route' => 'household-tasks.index'],
                    ['label' => 'Nova Tarefa', 'icon' => 'fa-plus', 'route' => 'household-tasks.create'],
                    ['label' => 'Categorias', 'icon' => 'fa-tags', 'route' => 'task-categories.index'],
                ],
            ],
            [
                'label' => 'Profissional',
                'icon' => 'fa-briefcase',
                'modal_id' => 'profissional-modal',
                'options' => [
                    ['label' => 'Projetos', 'icon' => 'fa-briefcase', 'route' => 'projetos.index'],
                    ['label' => 'Tarefas', 'icon' => 'fa-tasks', 'route' => 'tarefas.index'],
                    ['label' => 'Clientes', 'icon' => 'fa-users', 'route' => 'clientes.index'],
                    ['label' => 'Faturas', 'icon' => 'fa-file-invoice-dollar', 'route' => 'faturas.index'],
                    ['label' => 'Registros de Horas', 'icon' => 'fa-clock', 'route' => 'registros-horas.index'],
                ],
            ],
        ];
        $current = Route::currentRouteName();
    @endphp
    
    @foreach($items as $item)
        @if(isset($item['modal_id']))
            <button type="button"
                class="group flex flex-col items-center justify-center flex-1 h-full transition relative text-gray-300 hover:text-blue-300 focus:outline-none"
                aria-label="{{ $item['label'] }}"
                onclick="openModal('{{ $item['modal_id'] }}')">
                <span class="flex items-center justify-center w-10 h-10 rounded-full transition-all duration-200 group-hover:bg-gray-800/80">
                    <i class="fa-solid {{ $item['icon'] }} text-xl"></i>
                </span>
                <span class="text-xs mt-1 font-medium tracking-tight">{{ $item['label'] }}</span>
            </button>
        @else
            <a href="{{ route($item['route']) }}"
               class="group flex flex-col items-center justify-center flex-1 h-full transition relative {{ $current === $item['route'] ? 'text-blue-400' : 'text-gray-300 hover:text-blue-300' }}"
               aria-label="{{ $item['label'] }}">
                <span class="flex items-center justify-center w-10 h-10 rounded-full transition-all duration-200 {{ $current === $item['route'] ? 'bg-blue-900/60 shadow-lg scale-110' : 'group-hover:bg-gray-800/80' }}">
                    <i class="fa-solid {{ $item['icon'] }} text-xl"></i>
                </span>
                <span class="text-xs mt-1 font-medium tracking-tight transition-all duration-200 {{ $current === $item['route'] ? 'text-blue-400' : 'text-gray-400 group-hover:text-blue-300' }}">
                    {{ $item['label'] }}
                </span>
            </a>
        @endif
    @endforeach
</nav>

<!-- Modal Finanças -->
<div id="financas-modal" class="modal hidden fixed inset-0 z-[60] overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-75" onclick="closeModal('financas-modal')"></div>
        <div class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-gray-900 shadow-xl rounded-2xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-white">Finanças</h3>
                <button onclick="closeModal('financas-modal')" class="text-gray-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>
            <div class="space-y-3">
                <a href="{{ route('finance.dashboard') }}" class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-800 transition-colors text-gray-200 hover:text-white">
                    <i class="fa-solid fa-chart-pie text-xl text-blue-400"></i>
                    <span class="font-medium">Resumo</span>
                </a>
                <a href="{{ route('accounts.index') }}" class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-800 transition-colors text-gray-200 hover:text-white">
                    <i class="fa-solid fa-wallet text-xl text-blue-400"></i>
                    <span class="font-medium">Contas</span>
                </a>
                <a href="{{ route('transactions.index') }}" class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-800 transition-colors text-gray-200 hover:text-white">
                    <i class="fa-solid fa-arrow-right-arrow-left text-xl text-blue-400"></i>
                    <span class="font-medium">Transações</span>
                </a>
                <a href="{{ route('credit-cards.index') }}" class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-800 transition-colors text-gray-200 hover:text-white">
                    <i class="fa-solid fa-credit-card text-xl text-blue-400"></i>
                    <span class="font-medium">Cartões</span>
                </a>
                <a href="{{ route('debts.index') }}" class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-800 transition-colors text-gray-200 hover:text-white">
                    <i class="fa-solid fa-money-bill-trend-up text-xl text-blue-400"></i>
                    <span class="font-medium">Dívidas</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Eventos -->
<div id="eventos-modal" class="modal hidden fixed inset-0 z-[60] overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-75" onclick="closeModal('eventos-modal')"></div>
        <div class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-gray-900 shadow-xl rounded-2xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-white">Eventos</h3>
                <button onclick="closeModal('eventos-modal')" class="text-gray-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>
            <div class="space-y-3">
                <a href="{{ route('events.index') }}" class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-800 transition-colors text-gray-200 hover:text-white">
                    <i class="fa-solid fa-list-ul text-xl text-blue-400"></i>
                    <span class="font-medium">Todos Eventos</span>
                </a>
                <a href="{{ route('events.create') }}" class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-800 transition-colors text-gray-200 hover:text-white">
                    <i class="fa-solid fa-plus text-xl text-blue-400"></i>
                    <span class="font-medium">Novo Evento</span>
                </a>
                <a href="{{ route('events.calendar') }}" class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-800 transition-colors text-gray-200 hover:text-white">
                    <i class="fa-solid fa-calendar-days text-xl text-blue-400"></i>
                    <span class="font-medium">Calendário</span>
                </a>
                <a href="{{ route('previsibilidade.index') }}" class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-800 transition-colors text-gray-200 hover:text-white">
                    <i class="fa-solid fa-user-group text-xl text-blue-400"></i>
                    <span class="font-medium">Previsibilidade</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Casa -->
<div id="casa-modal" class="modal hidden fixed inset-0 z-[60] overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-75" onclick="closeModal('casa-modal')"></div>
        <div class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-gray-900 shadow-xl rounded-2xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-white">Casa</h3>
                <button onclick="closeModal('casa-modal')" class="text-gray-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>
            <div class="space-y-3">
                <a href="{{ route('household-tasks.dashboard') }}" class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-800 transition-colors text-gray-200 hover:text-white">
                    <i class="fa-solid fa-gauge text-xl text-blue-400"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('household-tasks.index') }}" class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-800 transition-colors text-gray-200 hover:text-white">
                    <i class="fa-solid fa-list-check text-xl text-blue-400"></i>
                    <span class="font-medium">Todas as Tarefas</span>
                </a>
                <a href="{{ route('household-tasks.create') }}" class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-800 transition-colors text-gray-200 hover:text-white">
                    <i class="fa-solid fa-plus text-xl text-blue-400"></i>
                    <span class="font-medium">Nova Tarefa</span>
                </a>
                <a href="{{ route('task-categories.index') }}" class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-800 transition-colors text-gray-200 hover:text-white">
                    <i class="fa-solid fa-tags text-xl text-blue-400"></i>
                    <span class="font-medium">Categorias</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Profissional -->
<div id="profissional-modal" class="modal hidden fixed inset-0 z-[60] overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-75" onclick="closeModal('profissional-modal')"></div>
        <div class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-gray-900 shadow-xl rounded-2xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-white">Profissional</h3>
                <button onclick="closeModal('profissional-modal')" class="text-gray-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>
            <div class="space-y-3">
                <a href="{{ route('projetos.index') }}" class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-800 transition-colors text-gray-200 hover:text-white">
                    <i class="fa-solid fa-briefcase text-xl text-blue-400"></i>
                    <span class="font-medium">Projetos</span>
                </a>
                <a href="{{ route('tarefas.index') }}" class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-800 transition-colors text-gray-200 hover:text-white">
                    <i class="fa-solid fa-tasks text-xl text-blue-400"></i>
                    <span class="font-medium">Tarefas</span>
                </a>
                <a href="{{ route('clientes.index') }}" class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-800 transition-colors text-gray-200 hover:text-white">
                    <i class="fa-solid fa-users text-xl text-blue-400"></i>
                    <span class="font-medium">Clientes</span>
                </a>
                <a href="{{ route('faturas.index') }}" class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-800 transition-colors text-gray-200 hover:text-white">
                    <i class="fa-solid fa-file-invoice-dollar text-xl text-blue-400"></i>
                    <span class="font-medium">Faturas</span>
                </a>
                <a href="{{ route('registros-horas.index') }}" class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-800 transition-colors text-gray-200 hover:text-white">
                    <i class="fa-solid fa-clock text-xl text-blue-400"></i>
                    <span class="font-medium">Registros de Horas</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
nav.fixed.bottom-0 {
    backdrop-filter: blur(6px);
}

.modal {
    transition: opacity 0.3s ease-in-out;
}

.modal.hidden {
    opacity: 0;
    pointer-events: none;
}

.modal:not(.hidden) {
    opacity: 1;
    pointer-events: auto;
}

@media (max-width: 400px) {
    nav.fixed.bottom-0 span.text-xs { font-size: 0.7rem; }
    nav.fixed.bottom-0 .w-10 { width: 2.2rem; height: 2.2rem; }
}
</style>

<script>
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

// Fecha modal com ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (!modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    }
});

// Fecha modal ao clicar fora
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.add('hidden');
        document.body.style.overflow = '';
    }
});
</script> 