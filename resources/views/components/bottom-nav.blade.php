<!-- Bottom Navigation com TailwindCSS -->
<nav class="fixed bottom-0 left-0 right-0 z-50 bg-black border-t border-gray-700 shadow-lg">
  <ul class="flex justify-around items-center h-16 px-4">
    <!-- Dashboard -->
    <li class="relative">
      <button type="button" class="flex flex-col items-center text-white hover:text-blue-400 w-full h-16 px-2 transition-colors" onclick="toggleDropdown('dashboard-dropdown', event)">
        <i class="fa-solid fa-house text-xl mb-1"></i>
        <span class="text-xs">Dashboard</span>
      </button>
      <ul id="dashboard-dropdown" class="absolute bottom-16 left-1/2 transform -translate-x-1/2 bg-gray-800 rounded-lg shadow-xl flex flex-row flex-wrap gap-1 py-2 px-2 min-w-[120px] max-w-[95vw] opacity-0 pointer-events-none transition-opacity duration-200">
        <li><a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded text-white hover:bg-gray-700 text-sm whitespace-nowrap"><i class="fa-solid fa-gauge-high"></i> Visão Geral</a></li>
      </ul>
    </li>
    <!-- Finanças -->
    <li class="relative">
      <button type="button" class="flex flex-col items-center text-white hover:text-blue-400 w-full h-16 px-2 transition-colors" onclick="toggleDropdown('finance-dropdown', event)">
        <i class="fa-solid fa-coins text-xl mb-1"></i>
        <span class="text-xs">Finanças</span>
      </button>
      <ul id="finance-dropdown" class="absolute bottom-16 left-1/2 transform -translate-x-1/2 bg-gray-800 rounded-lg shadow-xl flex flex-row flex-wrap gap-1 py-2 px-2 min-w-[180px] max-w-[95vw] opacity-0 pointer-events-none transition-opacity duration-200">
        <li><a href="{{ route('finance.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded text-white hover:bg-gray-700 text-sm whitespace-nowrap"><i class="fa-solid fa-chart-pie"></i> Resumo</a></li>
        <li><a href="{{ route('accounts.index') }}" class="flex items-center gap-2 px-3 py-2 rounded text-white hover:bg-gray-700 text-sm whitespace-nowrap"><i class="fa-solid fa-wallet"></i> Contas</a></li>
        <li><a href="{{ route('transactions.index') }}" class="flex items-center gap-2 px-3 py-2 rounded text-white hover:bg-gray-700 text-sm whitespace-nowrap"><i class="fa-solid fa-arrow-right-arrow-left"></i> Transações</a></li>
        <li><a href="{{ route('credit-cards.index') }}" class="flex items-center gap-2 px-3 py-2 rounded text-white hover:bg-gray-700 text-sm whitespace-nowrap"><i class="fa-solid fa-credit-card"></i> Cartões</a></li>
        <li><a href="{{ route('debts.index') }}" class="flex items-center gap-2 px-3 py-2 rounded text-white hover:bg-gray-700 text-sm whitespace-nowrap"><i class="fa-solid fa-money-bill-trend-up"></i> Dívidas</a></li>
      </ul>
    </li>
    <!-- Eventos -->
    <li class="relative">
      <button type="button" class="flex flex-col items-center text-white hover:text-blue-400 w-full h-16 px-2 transition-colors" onclick="toggleDropdown('events-dropdown', event)">
        <i class="fa-solid fa-calendar-days text-xl mb-1"></i>
        <span class="text-xs">Eventos</span>
      </button>
      <ul id="events-dropdown" class="absolute bottom-16 left-1/2 transform -translate-x-1/2 bg-gray-800 rounded-lg shadow-xl flex flex-row flex-wrap gap-1 py-2 px-2 min-w-[180px] max-w-[95vw] opacity-0 pointer-events-none transition-opacity duration-200">
        <li><a href="{{ route('events.calendar') }}" class="flex items-center gap-2 px-3 py-2 rounded text-white hover:bg-gray-700 text-sm whitespace-nowrap"><i class="fa-solid fa-calendar-days"></i> Calendário</a></li>
        <li><a href="{{ route('events.index') }}" class="flex items-center gap-2 px-3 py-2 rounded text-white hover:bg-gray-700 text-sm whitespace-nowrap"><i class="fa-solid fa-list-ul"></i> Todos Eventos</a></li>
        <li><a href="{{ route('previsibilidade.index') }}" class="flex items-center gap-2 px-3 py-2 rounded text-white hover:bg-gray-700 text-sm whitespace-nowrap"><i class="fa-solid fa-user-group"></i> Previsibilidade</a></li>
        <li><a href="{{ route('notifications.index') }}" class="flex items-center gap-2 px-3 py-2 rounded text-white hover:bg-gray-700 text-sm whitespace-nowrap"><i class="fa-solid fa-bell"></i> Notificações</a></li>
      </ul>
    </li>
    <!-- Casa -->
    <li class="relative">
      <button type="button" class="flex flex-col items-center text-white hover:text-blue-400 w-full h-16 px-2 transition-colors" onclick="toggleDropdown('casa-dropdown', event)">
        <i class="fa-solid fa-house-chimney text-xl mb-1"></i>
        <span class="text-xs">Casa</span>
      </button>
      <ul id="casa-dropdown" class="absolute bottom-16 left-1/2 transform -translate-x-1/2 bg-gray-800 rounded-lg shadow-xl flex flex-row flex-wrap gap-1 py-2 px-2 min-w-[180px] max-w-[95vw] opacity-0 pointer-events-none transition-opacity duration-200">
        <li><a href="{{ route('household-tasks.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded text-white hover:bg-gray-700 text-sm whitespace-nowrap"><i class="fa-solid fa-list-check"></i> Painel</a></li>
        <li><a href="{{ route('household-tasks.index') }}" class="flex items-center gap-2 px-3 py-2 rounded text-white hover:bg-gray-700 text-sm whitespace-nowrap"><i class="fa-solid fa-broom"></i> Todas Tarefas</a></li>
        <li><a href="{{ route('household-tasks.create') }}" class="flex items-center gap-2 px-3 py-2 rounded text-white hover:bg-gray-700 text-sm whitespace-nowrap"><i class="fa-solid fa-plus"></i> Nova Tarefa</a></li>
        <li><a href="{{ route('task-categories.index') }}" class="flex items-center gap-2 px-3 py-2 rounded text-white hover:bg-gray-700 text-sm whitespace-nowrap"><i class="fa-solid fa-layer-group"></i> Categorias</a></li>
      </ul>
    </li>
    <!-- Profissional -->
    <li class="relative">
      <button type="button" class="flex flex-col items-center text-white hover:text-blue-400 w-full h-16 px-2 transition-colors" onclick="toggleDropdown('profissional-dropdown', event)">
        <i class="fa-solid fa-briefcase text-xl mb-1"></i>
        <span class="text-xs">Profissional</span>
      </button>
      <ul id="profissional-dropdown" class="absolute bottom-16 right-0 bg-gray-800 rounded-lg shadow-xl flex flex-row flex-wrap gap-1 py-2 px-2 min-w-[180px] max-w-[95vw] opacity-0 pointer-events-none transition-opacity duration-200">
        <li><a href="{{ route('projetos.index') }}" class="flex items-center gap-2 px-3 py-2 rounded text-white hover:bg-gray-700 text-sm whitespace-nowrap"><i class="fa-solid fa-briefcase"></i> Projetos</a></li>
        <li><a href="{{ route('tarefas.index') }}" class="flex items-center gap-2 px-3 py-2 rounded text-white hover:bg-gray-700 text-sm whitespace-nowrap"><i class="fa-solid fa-tasks"></i> Tarefas</a></li>
        <li><a href="{{ route('clientes.index') }}" class="flex items-center gap-2 px-3 py-2 rounded text-white hover:bg-gray-700 text-sm whitespace-nowrap"><i class="fa-solid fa-users"></i> Clientes</a></li>
        <li><a href="{{ route('faturas.index') }}" class="flex items-center gap-2 px-3 py-2 rounded text-white hover:bg-gray-700 text-sm whitespace-nowrap"><i class="fa-solid fa-file-invoice-dollar"></i> Faturas</a></li>
        <li><a href="{{ route('registros-horas.index') }}" class="flex items-center gap-2 px-3 py-2 rounded text-white hover:bg-gray-700 text-sm whitespace-nowrap"><i class="fa-solid fa-clock"></i> Registros de Horas</a></li>
      </ul>
    </li>
  </ul>
  <script>
    function toggleDropdown(id, event) {
      event.stopPropagation();
      document.querySelectorAll('[id$="-dropdown"]').forEach(menu => {
        menu.classList.remove('opacity-100', 'pointer-events-auto');
        menu.classList.add('opacity-0', 'pointer-events-none');
      });
      const dropdown = document.getElementById(id);
      if (dropdown.classList.contains('opacity-0')) {
        dropdown.classList.remove('opacity-0', 'pointer-events-none');
        dropdown.classList.add('opacity-100', 'pointer-events-auto');
      } else {
        dropdown.classList.remove('opacity-100', 'pointer-events-auto');
        dropdown.classList.add('opacity-0', 'pointer-events-none');
      }
    }
    document.addEventListener('click', function() {
      document.querySelectorAll('[id$="-dropdown"]').forEach(menu => {
        menu.classList.remove('opacity-100', 'pointer-events-auto');
        menu.classList.add('opacity-0', 'pointer-events-none');
      });
    });
  </script>
</nav> 