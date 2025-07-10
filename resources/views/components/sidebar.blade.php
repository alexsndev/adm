<aside class="site-sidebar" id="siteSidebar">
    <button id="sidebar-toggle" class="sidebar-toggle" title="Comprimir/Expandir">
        <i class="fa-solid fa-angles-left"></i>
    </button>
    <nav class="sidebar-nav">
        <ul>
            <li class="sidebar-group">
                <a href="#" class="group-toggle">
                    <i class="fa-solid fa-house"></i>
                    <span>Tarefas de Casa</span>
                    <i class="fa-solid fa-chevron-down sub-arrow"></i>
                </a>
                <ul class="sidebar-sub">
                    <li><a href="{{ route('household-tasks.index') }}"><i class="fa-solid fa-list-check"></i> <span>Todas</span></a></li>
                    <li><a href="{{ route('household-tasks.create') }}"><i class="fa-solid fa-plus"></i> <span>Nova Tarefa</span></a></li>
                </ul>
            </li>
            <li class="sidebar-group">
                <a href="#" class="group-toggle">
                    <i class="fa-solid fa-diagram-project"></i>
                    <span>Projetos</span>
                    <i class="fa-solid fa-chevron-down sub-arrow"></i>
                </a>
                <ul class="sidebar-sub">
                    <li><a href="{{ route('projetos.index') }}"><i class="fa-solid fa-list"></i> <span>Todos</span></a></li>
                    <li><a href="{{ route('projetos.create') }}"><i class="fa-solid fa-plus"></i> <span>Novo Projeto</span></a></li>
                </ul>
            </li>
            <li class="sidebar-group">
                <a href="#" class="group-toggle">
                    <i class="fa-solid fa-coins"></i>
                    <span>Finanças</span>
                    <i class="fa-solid fa-chevron-down sub-arrow"></i>
                </a>
                <ul class="sidebar-sub">
                    <li><a href="{{ route('accounts.index') }}"><i class="fa-solid fa-building-columns"></i> <span>Contas</span></a></li>
                    <li><a href="{{ route('transactions.index') }}"><i class="fa-solid fa-arrow-right-arrow-left"></i> <span>Transações</span></a></li>
                    <li><a href="{{ route('debts.index') }}"><i class="fa-solid fa-money-bill-wave"></i> <span>Dívidas</span></a></li>
                    <li><a href="{{ route('financial-goals.index') }}"><i class="fa-solid fa-bullseye"></i> <span>Metas</span></a></li>
                    <li><a href="{{ route('faturas.index') }}"><i class="fa-solid fa-file-invoice"></i> <span>Faturas</span></a></li>
                </ul>
            </li>
            <li class="sidebar-group">
                <a href="#" class="group-toggle">
                    <i class="fa-solid fa-users"></i>
                    <span>Clientes</span>
                    <i class="fa-solid fa-chevron-down sub-arrow"></i>
                </a>
                <ul class="sidebar-sub">
                    <li><a href="{{ route('clientes.index') }}"><i class="fa-solid fa-list"></i> <span>Todos</span></a></li>
                </ul>
            </li>
            <li class="sidebar-group">
                <a href="#" class="group-toggle">
                    <i class="fa-solid fa-calendar-days"></i>
                    <span>Eventos</span>
                    <i class="fa-solid fa-chevron-down sub-arrow"></i>
                </a>
                <ul class="sidebar-sub">
                    <li><a href="{{ route('events.index') }}"><i class="fa-solid fa-list"></i> <span>Todos</span></a></li>
                    <li><a href="{{ route('events.create') }}"><i class="fa-solid fa-plus"></i> <span>Novo Evento</span></a></li>
                    <li><a href="{{ route('events.calendar') }}"><i class="fa-solid fa-calendar"></i> <span>Calendário</span></a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Acordeão dos grupos
        document.querySelectorAll('.site-sidebar .group-toggle').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const sub = this.nextElementSibling;
                if (sub) {
                    sub.classList.toggle('open');
                }
                this.querySelector('.sub-arrow').classList.toggle('rotated');
            });
        });

        // Sidebar toggle (comprimir/expandir) com persistência
        const sidebar = document.getElementById('siteSidebar');
        const toggleBtn = document.getElementById('sidebar-toggle');

        // Ao clicar, alterna e salva no localStorage
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('sidebar-collapsed');
            this.querySelector('i').classList.toggle('fa-angles-right');
            this.querySelector('i').classList.toggle('fa-angles-left');
            // Salva o estado
            if (sidebar.classList.contains('sidebar-collapsed')) {
                localStorage.setItem('sidebar-collapsed', '1');
            } else {
                localStorage.removeItem('sidebar-collapsed');
            }
        });

        // Ao carregar, aplica o estado salvo
        if (localStorage.getItem('sidebar-collapsed') === '1') {
            sidebar.classList.add('sidebar-collapsed');
            toggleBtn.querySelector('i').classList.remove('fa-angles-left');
            toggleBtn.querySelector('i').classList.add('fa-angles-right');
        }

        // Ao clicar em qualquer subitem final, comprime a sidebar e salva o estado
        document.querySelectorAll('.site-sidebar .sidebar-sub a, .site-sidebar > nav > ul > li > a:not(.group-toggle)').forEach(function(link) {
            link.addEventListener('click', function() {
                sidebar.classList.add('sidebar-collapsed');
                toggleBtn.querySelector('i').classList.remove('fa-angles-left');
                toggleBtn.querySelector('i').classList.add('fa-angles-right');
                localStorage.setItem('sidebar-collapsed', '1');
            });
        });
    });
</script> 