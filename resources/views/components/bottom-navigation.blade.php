<!-- Bottom Navigation - Mobile Friendly -->
<nav class="fixed bottom-0 left-0 right-0 z-50 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 shadow-lg md:hidden" style="position: fixed !important; bottom: 0 !important; left: 0 !important; right: 0 !important; z-index: 9999 !important;">
    <div class="flex justify-around items-center h-16">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('dashboard') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
            <i class="fa-solid fa-house-chimney text-lg mb-1"></i>
            <span class="text-xs">Dashboard</span>
        </a>
        
        <!-- Finanças -->
        <a href="{{ route('finance.dashboard') }}" class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('finance.*') ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-green-600 dark:hover:text-green-400 transition-colors">
            <i class="fa-solid fa-coins text-lg mb-1"></i>
            <span class="text-xs">Finanças</span>
        </a>
        
        <!-- Tarefas Domésticas -->
        <a href="{{ route('household-tasks.dashboard') }}" class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('household-tasks.*') ? 'text-orange-600 dark:text-orange-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-orange-600 dark:hover:text-orange-400 transition-colors">
            <i class="fa-solid fa-soap text-lg mb-1"></i>
            <span class="text-xs">Tarefas</span>
        </a>
        
        <!-- Projetos -->
        <a href="{{ route('projetos.index') }}" class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('projetos.*') || request()->routeIs('tarefas.*') || request()->routeIs('clientes.*') || request()->routeIs('faturas.*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-purple-600 dark:hover:text-purple-400 transition-colors">
            <i class="fa-solid fa-briefcase text-lg mb-1"></i>
            <span class="text-xs">Projetos</span>
        </a>
        
        <!-- Previsibilidade -->
        <a href="{{ route('events.index') }}" class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('events.*') || request()->routeIs('previsibilidade.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
            <i class="fa-solid fa-calendar-days text-lg mb-1"></i>
            <span class="text-xs">Eventos</span>
        </a>
    </div>
</nav> 