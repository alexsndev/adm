<?php
// Sidebar em PHP puro, CSS puro e JS puro
?>
<style>
/* Sidebar fixa à esquerda */
#side-nav {
    position: fixed;
    top: 64px; /* altura do header */
    left: 0;
    height: calc(100vh - 64px);
    width: 220px;
    background: #23232a;
    color: #fff;
    box-shadow: 2px 0 8px rgba(0,0,0,0.08);
    z-index: 1000;
    display: flex;
    flex-direction: column;
    transition: width 0.2s;
}
#side-nav.collapsed {
    width: 56px;
}
#side-nav .sidebar-section {
    margin-bottom: 12px;
}
#side-nav .sidebar-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #b0b0c3;
    background: none;
    border: none;
    width: 100%;
    padding: 12px 16px;
    font-size: 1rem;
    cursor: pointer;
    border-radius: 8px;
    transition: background 0.2s, color 0.2s;
    text-align: left;
}
#side-nav .sidebar-btn:hover, #side-nav .sidebar-btn.active {
    background: #32323e;
    color: #fff;
}
#side-nav .sidebar-btn i {
    font-size: 1.2rem;
    min-width: 22px;
    text-align: center;
}
#side-nav .sidebar-label {
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: opacity 0.2s;
}
#side-nav.collapsed .sidebar-label {
    opacity: 0;
    width: 0;
    pointer-events: none;
}
#side-nav .sidebar-arrow {
    margin-left: auto;
    transition: transform 0.2s, opacity 0.2s;
    opacity: 1;
}
#side-nav.collapsed .sidebar-arrow {
    opacity: 0;
    pointer-events: none;
}
#side-nav .sidebar-submenu {
    display: none;
    flex-direction: column;
    padding-left: 32px;
    margin-top: 2px;
}
#side-nav .sidebar-submenu.open {
    display: flex;
}
#side-nav .sidebar-link {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #b0b0c3;
    text-decoration: none;
    font-size: 0.97rem;
    padding: 7px 0;
    border-radius: 6px;
    transition: background 0.2s, color 0.2s;
}
#side-nav .sidebar-link:hover {
    background: #32323e;
    color: #fff;
}
@media (max-width: 767px) {
    #side-nav {
        display: none;
    }
}
</style>
<nav id="side-nav">
    <div class="sidebar-section">
        <button class="sidebar-btn" data-menu="casa">
            <i class="fa-solid fa-house-chimney"></i>
            <span class="sidebar-label">Casa</span>
            <i class="fa-solid fa-angle-down sidebar-arrow"></i>
        </button>
        <div class="sidebar-submenu" data-submenu="casa">
            <a href="<?php echo route('household-tasks.dashboard'); ?>" class="sidebar-link"><i class="fa-solid fa-gauge"></i>Dashboard</a>
            <a href="<?php echo route('household-tasks.index'); ?>" class="sidebar-link"><i class="fa-solid fa-list-check"></i>Todas as Tarefas</a>
            <a href="<?php echo route('household-tasks.create'); ?>" class="sidebar-link"><i class="fa-solid fa-plus"></i>Nova Tarefa</a>
            <a href="<?php echo route('task-categories.index'); ?>" class="sidebar-link"><i class="fa-solid fa-tags"></i>Categorias</a>
        </div>
    </div>
    <div class="sidebar-section">
        <button class="sidebar-btn" data-menu="financeiro">
            <i class="fa-solid fa-coins"></i>
            <span class="sidebar-label">Financeiro</span>
            <i class="fa-solid fa-angle-down sidebar-arrow"></i>
        </button>
        <div class="sidebar-submenu" data-submenu="financeiro">
            <a href="<?php echo route('finance.dashboard'); ?>" class="sidebar-link"><i class="fa-solid fa-chart-pie"></i>Dashboard</a>
            <a href="<?php echo route('accounts.index'); ?>" class="sidebar-link"><i class="fa-solid fa-wallet"></i>Contas</a>
            <a href="<?php echo route('transactions.index'); ?>" class="sidebar-link"><i class="fa-solid fa-arrow-right-arrow-left"></i>Transações</a>
            <a href="<?php echo route('debts.index'); ?>" class="sidebar-link"><i class="fa-solid fa-money-bill-trend-up"></i>Dívidas</a>
            <a href="<?php echo route('financial-goals.index'); ?>" class="sidebar-link"><i class="fa-solid fa-bullseye"></i>Metas Financeiras</a>
            <a href="<?php echo route('faturas.index'); ?>" class="sidebar-link"><i class="fa-solid fa-file-invoice"></i>Faturas</a>
            <a href="<?php echo route('categories.index'); ?>" class="sidebar-link"><i class="fa-solid fa-layer-group"></i>Categorias</a>
            <a href="<?php echo route('credit-cards.index'); ?>" class="sidebar-link"><i class="fa-solid fa-credit-card"></i>Cartões de Crédito</a>
            <a href="<?php echo route('clientes.index'); ?>" class="sidebar-link"><i class="fa-solid fa-users"></i>Clientes</a>
        </div>
    </div>
    <div class="sidebar-section">
        <button class="sidebar-btn" data-menu="eventos">
            <i class="fa-solid fa-calendar-days"></i>
            <span class="sidebar-label">Eventos</span>
            <i class="fa-solid fa-angle-down sidebar-arrow"></i>
        </button>
        <div class="sidebar-submenu" data-submenu="eventos">
            <a href="<?php echo route('events.index'); ?>" class="sidebar-link"><i class="fa-solid fa-list-ul"></i>Todos Eventos</a>
            <a href="<?php echo route('events.create'); ?>" class="sidebar-link"><i class="fa-solid fa-plus"></i>Novo Evento</a>
            <a href="<?php echo route('events.calendar'); ?>" class="sidebar-link"><i class="fa-solid fa-calendar-days"></i>Calendário</a>
            <a href="<?php echo route('previsibilidade.index'); ?>" class="sidebar-link"><i class="fa-solid fa-user-group"></i>Previsibilidade</a>
        </div>
    </div>
    <div class="sidebar-section">
        <button class="sidebar-btn" data-menu="projetos">
            <i class="fa-solid fa-briefcase"></i>
            <span class="sidebar-label">Projetos</span>
            <i class="fa-solid fa-angle-down sidebar-arrow"></i>
        </button>
        <div class="sidebar-submenu" data-submenu="projetos">
            <a href="<?php echo route('projetos.index'); ?>" class="sidebar-link"><i class="fa-solid fa-list"></i>Todos Projetos</a>
            <a href="<?php echo route('projetos.create'); ?>" class="sidebar-link"><i class="fa-solid fa-plus"></i>Novo Projeto</a>
            <a href="<?php echo route('tarefas.index'); ?>" class="sidebar-link"><i class="fa-solid fa-tasks"></i>Tarefas Profissionais</a>
            <a href="<?php echo route('clientes.index'); ?>" class="sidebar-link"><i class="fa-solid fa-users"></i>Clientes</a>
            <a href="<?php echo route('faturas.index'); ?>" class="sidebar-link"><i class="fa-solid fa-file-invoice-dollar"></i>Faturas</a>
            <a href="<?php echo route('registros-horas.index'); ?>" class="sidebar-link"><i class="fa-solid fa-clock"></i>Registros de Horas</a>
            <a href="<?php echo route('categories.index'); ?>" class="sidebar-link"><i class="fa-solid fa-tags"></i>Categorias</a>
        </div>
    </div>
</nav>
<script>
(function() {
    var sidebar = document.getElementById('side-nav');
    var btns = sidebar.querySelectorAll('.sidebar-btn');
    var submenus = sidebar.querySelectorAll('.sidebar-submenu');
    var arrows = sidebar.querySelectorAll('.sidebar-arrow');
    var lastOpen = null;

    btns.forEach(function(btn, idx) {
        btn.addEventListener('click', function() {
            var menu = btn.getAttribute('data-menu');
            var submenu = sidebar.querySelector('.sidebar-submenu[data-submenu="' + menu + '"]');
            var arrow = btn.querySelector('.sidebar-arrow');
            // Expande sidebar ao clicar
            sidebar.classList.remove('collapsed');
            // Fecha outros submenus
            submenus.forEach(function(sm) {
                if (sm !== submenu) sm.classList.remove('open');
            });
            arrows.forEach(function(a) {
                if (a !== arrow) a.classList.remove('open');
            });
            // Toggle submenu
            var isOpen = submenu.classList.contains('open');
            if (isOpen) {
                submenu.classList.remove('open');
                arrow.classList.remove('open');
            } else {
                submenu.classList.add('open');
                arrow.classList.add('open');
            }
        });
    });

    // Colapso/expansão via botão do header
    window.toggleSidebar = function() {
        sidebar.classList.toggle('collapsed');
        // Fecha todos submenus se colapsar
        if (sidebar.classList.contains('collapsed')) {
            submenus.forEach(function(sm) { sm.classList.remove('open'); });
            arrows.forEach(function(a) { a.classList.remove('open'); });
        }
    };
})();
</script> 