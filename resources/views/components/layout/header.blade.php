<header class="sticky top-0 z-40 flex h-16 items-center justify-between border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-4 shadow-sm sm:px-6 lg:px-8">
    <!-- Logo/Brand -->
    <div class="flex items-center gap-3">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600">
                <i class="fa-solid fa-chart-line text-white text-lg"></i>
            </span>
            <span class="text-xl font-bold text-gray-900 dark:text-gray-100">
                {{ config('app.name', 'Laravel') }}
            </span>
        </a>
    </div>

    <!-- Right side actions -->
    <div class="flex items-center gap-4">
        <!-- Notifications -->
        <a href="{{ route('notifications.index') }}" class="relative text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
            <i class="fa-solid fa-bell text-xl"></i>
            @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs text-white">
                    {{ auth()->user()->unreadNotifications->count() > 9 ? '9+' : auth()->user()->unreadNotifications->count() }}
                </span>
            @endif
        </a>

        <!-- User Menu -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-blue-500 text-white font-bold">
                    {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'U' }}
                </span>
                <span class="hidden sm:block text-gray-900 dark:text-gray-100 font-semibold">
                    {{ auth()->check() ? auth()->user()->name : 'Usuário' }}
                </span>
                <i class="fa-solid fa-chevron-down text-xs ml-1"></i>
            </button>
            <!-- Dropdown -->
            <div x-show="open" @click.away="open = false"
                class="absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-50 py-2"
                x-transition>
                <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700">
                    <div class="font-bold text-gray-900 dark:text-gray-100">
                        {{ auth()->check() ? auth()->user()->name : 'Usuário' }}
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        {{ auth()->check() ? auth()->user()->email : 'email@exemplo.com' }}
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Meu Perfil</a>
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Painel Admin</a>
                <div class="border-t border-gray-100 dark:border-gray-700 my-2"></div>
                <!-- Tema -->
                <button type="button" class="block w-full text-left px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700"
                    @click="window.dispatchEvent(new CustomEvent('toggle-theme'))">
                    Tema
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">Sair</button>
                </form>
            </div>
        </div>
    </div>
</header> 