<!-- Bottom Navigation com TailwindCSS -->
<style>
.bottom-nav {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 50;
  background-color: #000000;
  border-top: 1px solid #374151;
  box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1);
}
.bottom-nav ul {
  display: flex;
  justify-content: space-around;
  align-items: center;
  height: 4rem;
  padding: 0 1rem;
  margin: 0;
  list-style: none;
}
.bottom-nav li {
  position: relative;
  flex: 1 1 0%;
  text-align: center;
}
.bottom-nav button {
  display: flex;
  flex-direction: column;
  align-items: center;
  color: #ffffff;
  width: 100%;
  height: 4rem;
  padding: 0 0.5rem;
  transition: color 0.2s;
  background: none;
  border: none;
  cursor: pointer;
}
.bottom-nav button:hover {
  color: #60a5fa;
}
.bottom-nav i {
  font-size: 1.25rem;
  margin-bottom: 0.25rem;
}
.bottom-nav span {
  font-size: 0.75rem;
}
.bottom-nav .dropdown {
  position: absolute;
  bottom: 4rem;
  left: 50%;
  transform: translateX(-50%);
  background-color: #1f2937;
  border-radius: 0.5rem;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  gap: 0.25rem;
  padding: 0.5rem;
  min-width: 7.5rem;
  max-width: 95vw;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.2s;
}
.bottom-nav .dropdown.show {
  opacity: 1;
  pointer-events: auto;
}
.bottom-nav .dropdown li {
  list-style: none;
  margin: 0;
  padding: 0;
}
.bottom-nav .dropdown a {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 0.75rem;
  border-radius: 0.25rem;
  color: #ffffff;
  text-decoration: none;
  font-size: 0.875rem;
  white-space: nowrap;
}
.bottom-nav .dropdown a:hover {
  background-color: #374151;
}
.bottom-nav li:last-child .dropdown {
  left: auto;
  right: 0;
  transform: none;
}
@media (max-width: 768px) {
  .bottom-nav .dropdown {
    min-width: 7rem;
    max-width: 95vw;
    padding: 0.375rem;
    gap: 0.125rem;
  }
  .bottom-nav .dropdown a {
    padding: 0.375rem 0.5rem;
    font-size: 0.75rem;
  }
}
</style>

<nav class="bottom-nav">
  <ul>
    <!-- Dashboard -->
    <li>
      <button type="button" onclick="toggleDropdown('dashboard-dropdown', event)">
        <i class="fa-solid fa-house"></i>
        <span>Dashboard</span>
      </button>
      <ul id="dashboard-dropdown" class="dropdown">
        <li><a href="{{ route('dashboard') }}"><i class="fa-solid fa-gauge-high"></i> Visão Geral</a></li>
      </ul>
    </li>
    <!-- Finanças -->
    <li>
      <button type="button" onclick="toggleDropdown('finance-dropdown', event)">
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
      <button type="button" onclick="toggleDropdown('events-dropdown', event)">
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
      <button type="button" onclick="toggleDropdown('casa-dropdown', event)">
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
      <button type="button" onclick="toggleDropdown('profissional-dropdown', event)">
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
    function toggleDropdown(id, event) {
      event.stopPropagation();
      document.querySelectorAll('[id$="-dropdown"]').forEach(menu => {
        menu.classList.remove('show');
      });
      const dropdown = document.getElementById(id);
      if (dropdown.classList.contains('show')) {
        dropdown.classList.remove('show');
      } else {
        dropdown.classList.add('show');
      }
    }
    document.addEventListener('click', function() {
      document.querySelectorAll('[id$="-dropdown"]').forEach(menu => {
        menu.classList.remove('show');
      });
    });
  </script>
</nav> 