<nav class="bottom-nav">
  <ul>
    <!-- Dashboard -->
    <li>
      <button class="nav-btn" data-dropdown="dashboard-dropdown">
        <i class="fa-solid fa-house"></i>
        <span>Dashboard</span>
      </button>
      <ul id="dashboard-dropdown" class="dropdown">
        <li><a href="{{ route('dashboard') }}"><i class="fa-solid fa-gauge-high"></i> Visão Geral</a></li>
      </ul>
    </li>
    <!-- Finanças -->
    <li>
      <button class="nav-btn" data-dropdown="finance-dropdown">
        <i class="fa-solid fa-coins"></i>
        <span>Finanças</span>
      </button>
      <ul id="finance-dropdown" class="dropdown">
        <li><a href="{{ route('finance.dashboard') }}"><i class="fa-solid fa-chart-pie"></i> Resumo</a></li>
        <li><a href="{{ route('accounts.index') }}"><i class="fa-solid fa-wallet"></i> Contas</a></li>
        <li><a href="{{ route('transactions.index') }}"><i class="fa-solid fa-arrow-right-arrow-left"></i> Transações</a></li>
        <li><a href="{{ route('credit-cards.index') }}"><i class="fa-solid fa-credit-card"></i> Cartões</a></li>
        <li><a href="{{ route('debts.index') }}"><i class="fa-solid fa-money-bill-trend-up"></i> Dívidas</a></li>
      </ul>
    </li>
    <!-- Eventos -->
    <li>
      <button class="nav-btn" data-dropdown="events-dropdown">
        <i class="fa-solid fa-calendar-days"></i>
        <span>Eventos</span>
      </button>
      <ul id="events-dropdown" class="dropdown">
        <li><a href="{{ route('events.calendar') }}"><i class="fa-solid fa-calendar-days"></i> Calendário</a></li>
        <li><a href="{{ route('events.index') }}"><i class="fa-solid fa-list-ul"></i> Todos Eventos</a></li>
        <li><a href="{{ route('previsibilidade.index') }}"><i class="fa-solid fa-user-group"></i> Previsibilidade</a></li>
        <li><a href="{{ route('notifications.index') }}"><i class="fa-solid fa-bell"></i> Notificações</a></li>
      </ul>
    </li>
    <!-- Casa -->
    <li>
      <button class="nav-btn" data-dropdown="casa-dropdown">
        <i class="fa-solid fa-house-chimney"></i>
        <span>Casa</span>
      </button>
      <ul id="casa-dropdown" class="dropdown">
        <li><a href="{{ route('household-tasks.dashboard') }}"><i class="fa-solid fa-list-check"></i> Painel</a></li>
        <li><a href="{{ route('household-tasks.index') }}"><i class="fa-solid fa-broom"></i> Todas Tarefas</a></li>
        <li><a href="{{ route('household-tasks.create') }}"><i class="fa-solid fa-plus"></i> Nova Tarefa</a></li>
        <li><a href="{{ route('task-categories.index') }}"><i class="fa-solid fa-layer-group"></i> Categorias</a></li>
      </ul>
    </li>
    <!-- Profissional -->
    <li>
      <button class="nav-btn" data-dropdown="profissional-dropdown">
        <i class="fa-solid fa-briefcase"></i>
        <span>Profissional</span>
      </button>
      <ul id="profissional-dropdown" class="dropdown">
        <li><a href="{{ route('projetos.index') }}"><i class="fa-solid fa-briefcase"></i> Projetos</a></li>
        <li><a href="{{ route('tarefas.index') }}"><i class="fa-solid fa-tasks"></i> Tarefas</a></li>
        <li><a href="{{ route('clientes.index') }}"><i class="fa-solid fa-users"></i> Clientes</a></li>
        <li><a href="{{ route('faturas.index') }}"><i class="fa-solid fa-file-invoice-dollar"></i> Faturas</a></li>
        <li><a href="{{ route('registros-horas.index') }}"><i class="fa-solid fa-clock"></i> Registros de Horas</a></li>
      </ul>
    </li>
  </ul>
  <script>
    document.querySelectorAll('.nav-btn').forEach(btn => {
      btn.addEventListener('click', function(e) {
        e.stopPropagation();
        document.querySelectorAll('.dropdown').forEach(menu => menu.classList.remove('show'));
        const dropdown = document.getElementById(this.dataset.dropdown);
        if (dropdown) dropdown.classList.toggle('show');
      });
    });
    document.addEventListener('click', function() {
      document.querySelectorAll('.dropdown').forEach(menu => menu.classList.remove('show'));
    });
  </script>
</nav> 