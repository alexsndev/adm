<header class="w-full fixed top-0 left-0 z-50 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 shadow-sm h-14 flex items-center justify-between px-2 sm:px-6">
    <!-- Botão toggle sidebar + Sino à esquerda -->
    <div class="flex items-center min-w-[40px] justify-start z-10 gap-3">
        <!-- Botão toggle sidebar (apenas desktop) -->
        <button id="sidebar-toggle" class="hidden md:flex items-center justify-center w-8 h-8 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" title="Alternar sidebar">
            <i class="fa-solid fa-bars text-lg"></i>
        </button>
        
        <div id="notification-bell" class="relative cursor-pointer min-w-0">
            <i class="fa-solid fa-bell text-base sm:text-2xl text-gray-400 dark:text-gray-500 hover:text-blue-500 transition-colors"></i>
            <span id="notification-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-0.5 py-0.5 hidden"></span>
        </div>
    </div>
    
    <!-- Logo centralizada -->
    <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2" style="position: absolute !important; left: 50% !important; top: 50% !important; transform: translate(-50%, -50%) !important; z-index: 5 !important;">
        @if(Auth::user() && Auth::user()->logo)
            <img src="{{ Storage::url(Auth::user()->logo) }}" alt="Logo" class="h-8 w-auto max-w-[120px] sm:max-w-[150px]">
        @else
            <span class="font-bold text-lg sm:text-xl text-gray-800 dark:text-gray-200">Life Organizer</span>
        @endif
    </div>
    
    <!-- Avatar à direita -->
    <div class="flex items-center min-w-[40px] justify-end z-10">
        <div class="relative">
            @if(Auth::user() && Auth::user()->photo)
                <img src="{{ Storage::url(Auth::user()->photo) }}" alt="Avatar" class="h-8 w-8 rounded-full object-cover">
            @else
                <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center">
                    <span class="text-white text-sm font-medium">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                </div>
            @endif
        </div>
    </div>
</header>

<!-- Dropdown de notificações -->
<div id="notification-dropdown" class="hidden fixed top-16 left-2 w-80 max-h-96 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-50 overflow-hidden">
    <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <h3 class="font-semibold text-gray-800 dark:text-gray-200">Notificações</h3>
        <button id="mark-all-read" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Marcar todas como lidas</button>
    </div>
    <div id="notification-list" class="max-h-80 overflow-y-auto">
        <!-- Notificações serão carregadas aqui via JavaScript -->
    </div>
    <div id="no-notifications" class="hidden p-4 text-center text-gray-500 dark:text-gray-400">
        Nenhuma notificação
    </div>
</div> 