<aside id="sidebar" class="hidden md:flex flex-col fixed top-0 left-0 h-full bg-gray-900 text-white shadow-2xl z-40 transition-all duration-300 sidebar-collapsed">
    <div class="flex items-center justify-center h-16 border-b border-gray-800">
        <button id="sidebarToggle" class="text-gray-400 hover:text-white focus:outline-none transition">
            <i class="fa-solid fa-xmark text-2xl"></i>
            <i class="fa-solid fa-bars text-2xl"></i>
        </button>
    </div>
    <nav class="flex-1 overflow-y-auto py-4 px-1">
        <ul class="space-y-2">
            @foreach([
                ['label'=>'Casa','icon'=>'fa-house-chimney','sub'=>[
                    ['label'=>'Dashboard','route'=>'household-tasks.dashboard','icon'=>'fa-gauge'],
                    ['label'=>'Todas as Tarefas','route'=>'household-tasks.index','icon'=>'fa-list-check'],
                    ['label'=>'Nova Tarefa','route'=>'household-tasks.create','icon'=>'fa-plus'],
                    ['label'=>'Categorias','route'=>'task-categories.index','icon'=>'fa-tags'],
                ]],
                ['label'=>'Financeiro','icon'=>'fa-coins','sub'=>[
                    ['label'=>'Dashboard','route'=>'finance.dashboard','icon'=>'fa-chart-pie'],
                    ['label'=>'Contas','route'=>'accounts.index','icon'=>'fa-wallet'],
                    ['label'=>'Transações','route'=>'transactions.index','icon'=>'fa-arrow-right-arrow-left'],
                    ['label'=>'Dívidas','route'=>'debts.index','icon'=>'fa-money-bill-trend-up'],
                    ['label'=>'Metas Financeiras','route'=>'financial-goals.index','icon'=>'fa-bullseye'],
                    ['label'=>'Faturas','route'=>'faturas.index','icon'=>'fa-file-invoice'],
                    ['label'=>'Categorias de Transação','route'=>'categories.index','icon'=>'fa-layer-group'],
                    ['label'=>'Cartões de Crédito','route'=>'credit-cards.index','icon'=>'fa-credit-card'],
                    ['label'=>'Clientes','route'=>'clientes.index','icon'=>'fa-users'],
                ]],
                ['label'=>'Eventos','icon'=>'fa-calendar-days','sub'=>[
                    ['label'=>'Todos Eventos','route'=>'events.index','icon'=>'fa-list-ul'],
                    ['label'=>'Novo Evento','route'=>'events.create','icon'=>'fa-plus'],
                    ['label'=>'Calendário','route'=>'events.calendar','icon'=>'fa-calendar-days'],
                    ['label'=>'Previsibilidade','route'=>'previsibilidade.index','icon'=>'fa-user-group'],
                ]],
                ['label'=>'Projetos','icon'=>'fa-briefcase','sub'=>[
                    ['label'=>'Todos Projetos','route'=>'projetos.index','icon'=>'fa-list'],
                    ['label'=>'Novo Projeto','route'=>'projetos.create','icon'=>'fa-plus'],
                    ['label'=>'Tarefas Profissionais','route'=>'tarefas.index','icon'=>'fa-tasks'],
                    ['label'=>'Clientes','route'=>'clientes.index','icon'=>'fa-users'],
                    ['label'=>'Faturas','route'=>'faturas.index','icon'=>'fa-file-invoice-dollar'],
                    ['label'=>'Registros de Horas','route'=>'registros-horas.index','icon'=>'fa-clock'],
                    ['label'=>'Categorias','route'=>'categories.index','icon'=>'fa-tags'],
                ]],
            ] as $i => $menu)
                <li>
                    <button type="button"
                        class="w-full flex items-center gap-3 px-3 py-3 rounded-lg hover:bg-gray-800 transition sidebar-main-btn font-semibold text-base"
                        onclick="toggleGroup({{ $i }})">
                        <i class="fa-solid {{ $menu['icon'] }} text-xl"></i>
                        <span class="sidebar-label">{{ $menu['label'] }}</span>
                        <i class="fa-solid fa-chevron-down text-xs ml-auto transition-transform" id="arrow-{{ $i }}"></i>
                    </button>
                    <ul class="sidebar-submenu space-y-1 mt-1 ml-6 border-l-2 border-blue-700/40 pl-2 hidden" id="submenu-{{ $i }}">
                        @foreach($menu['sub'] as $sub)
                            <li>
                                <a href="{{ route($sub['route']) }}"
                                   class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-700/80 transition sidebar-final-item text-sm font-medium"
                                   onclick="sidebarAutoCollapse()">
                                    <i class="fa-solid {{ $sub['icon'] }} text-base"></i>
                                    <span class="sidebar-label">{{ $sub['label'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </nav>
</aside>

<style>
.sidebar-collapsed { width: 4.5rem !important; }
.sidebar-expanded { width: 16rem !important; }
.sidebar-collapsed .sidebar-label { display: none !important; }
.sidebar-collapsed .sidebar-submenu { display: none !important; }
.sidebar-expanded .sidebar-label { display: inline !important; }
.sidebar-main-btn.active, .sidebar-main-btn:focus { background: #1e293b !important; }
.sidebar-main-btn { position: relative; }
.sidebar-submenu { background: #111827; border-radius: 0.5rem; }
.rotate-180 { transform: rotate(180deg); }
</style>

<script>
if (!localStorage.getItem('sidebarState')) {
    localStorage.setItem('sidebarState', 'collapsed');
}
let openGroup = null;

function applySidebarState() {
    const sidebar = document.getElementById('sidebar');
    const icon = document.getElementById('sidebarToggleIcon');
    if (localStorage.getItem('sidebarState') === 'expanded') {
        sidebar.classList.remove('sidebar-collapsed');
        sidebar.classList.add('sidebar-expanded');
        if(icon) { icon.classList.remove('fa-bars'); icon.classList.add('fa-xmark'); }
        document.querySelectorAll('.sidebar-submenu').forEach(ul => ul.classList.add('hidden'));
        document.querySelectorAll('.sidebar-main-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.fa-chevron-down').forEach(arrow => arrow.classList.remove('rotate-180'));
        openGroup = null;
    } else {
        sidebar.classList.add('sidebar-collapsed');
        sidebar.classList.remove('sidebar-expanded');
        if(icon) { icon.classList.remove('fa-xmark'); icon.classList.add('fa-bars'); }
        document.querySelectorAll('.sidebar-submenu').forEach(ul => ul.classList.add('hidden'));
        document.querySelectorAll('.sidebar-main-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.fa-chevron-down').forEach(arrow => arrow.classList.remove('rotate-180'));
        openGroup = null;
    }
}

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const icon = document.getElementById('sidebarToggleIcon');
    if (sidebar.classList.contains('sidebar-collapsed')) {
        localStorage.setItem('sidebarState', 'expanded');
        if(icon) { icon.classList.remove('fa-bars'); icon.classList.add('fa-xmark'); }
    } else {
        localStorage.setItem('sidebarState', 'collapsed');
        if(icon) { icon.classList.remove('fa-xmark'); icon.classList.add('fa-bars'); }
    }
    applySidebarState();
}

function toggleGroup(idx) {
    const sidebar = document.getElementById('sidebar');
    if (!sidebar.classList.contains('sidebar-expanded')) {
        localStorage.setItem('sidebarState', 'expanded');
        applySidebarState();
    }
    document.querySelectorAll('.sidebar-submenu').forEach((ul, i) => {
        if (i === idx) {
            ul.classList.toggle('hidden');
            document.getElementById('arrow-' + i).classList.toggle('rotate-180');
            if (!ul.classList.contains('hidden')) {
                openGroup = idx;
            } else {
                openGroup = null;
            }
        } else {
            ul.classList.add('hidden');
            document.getElementById('arrow-' + i).classList.remove('rotate-180');
        }
    });
    document.querySelectorAll('.sidebar-main-btn').forEach((btn, i) => {
        if (i === idx && openGroup === idx) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });
}

function sidebarAutoCollapse() {
    localStorage.setItem('sidebarState', 'collapsed');
    setTimeout(applySidebarState, 200);
}
document.addEventListener('DOMContentLoaded', applySidebarState);
</script> 