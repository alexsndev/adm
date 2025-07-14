@php
    $theme = $theme ?? 'system';
@endphp

<div class="relative" x-data="{ open: false }">
    <button type="button" 
            class="-m-1.5 flex items-center p-1.5" 
            id="user-menu-button" 
            aria-expanded="false" 
            aria-haspopup="true"
            @click="open = !open">
        <span class="sr-only">Abrir menu do usuário</span>
        <div class="flex items-center space-x-3">
            <div class="flex items-center">
                @if(auth()->user()->profile_photo_url)
                    <img class="h-8 w-8 rounded-full object-cover" 
                         src="{{ auth()->user()->profile_photo_url }}" 
                         alt="{{ auth()->user()->name }}">
                @else
                    <div class="h-8 w-8 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                        <i class="fa-solid fa-user text-gray-600 dark:text-gray-400 text-sm"></i>
                    </div>
                @endif
            </div>
            <div class="hidden lg:flex lg:items-center lg:justify-between">
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ auth()->user()->email }}
                    </p>
                </div>
                <i class="fa-solid fa-chevron-down ml-2 text-gray-400 text-xs"></i>
            </div>
        </div>
    </button>
    
    <!-- Dropdown menu -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 z-10 mt-2.5 w-56 origin-top-right rounded-md bg-white dark:bg-gray-800 py-2 shadow-lg ring-1 ring-gray-900/5 dark:ring-gray-700/5 focus:outline-none"
         role="menu" 
         aria-orientation="vertical" 
         aria-labelledby="user-menu-button" 
         tabindex="-1"
         @click.away="open = false">
        
        <!-- User Info -->
        <div class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700">
            <p class="font-medium">{{ auth()->user()->name }}</p>
            <p class="text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
        </div>
        
        <!-- Menu Items -->
        <div class="py-1">
            <a href="{{ route('profile.edit') }}" 
               class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
               role="menuitem" 
               tabindex="-1">
                <i class="fa-solid fa-user mr-3 text-gray-400"></i>
                Meu Perfil
            </a>
            
            @if(auth()->user()->is_admin)
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                   role="menuitem" 
                   tabindex="-1">
                    <i class="fa-solid fa-shield-halved mr-3 text-gray-400"></i>
                    Painel Admin
                </a>
            @endif
            
            <!-- Separator -->
            <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
            
            <!-- Theme Toggle -->
            <div class="px-4 py-2">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Tema</span>
                    <div class="flex items-center space-x-2">
                        <button @click="setTheme('light')" 
                                class="p-1 rounded {{ $theme === 'light' ? 'bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400' : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-300' }}"
                                title="Tema Claro">
                            <i class="fa-solid fa-sun text-sm"></i>
                        </button>
                        <button @click="setTheme('dark')" 
                                class="p-1 rounded {{ $theme === 'dark' ? 'bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400' : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-300' }}"
                                title="Tema Escuro">
                            <i class="fa-solid fa-moon text-sm"></i>
                        </button>
                        <button @click="setTheme('system')" 
                                class="p-1 rounded {{ $theme === 'system' ? 'bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400' : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-300' }}"
                                title="Tema do Sistema">
                            <i class="fa-solid fa-desktop text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Separator -->
            <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
            
            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="flex w-full items-center px-4 py-2 text-sm text-red-700 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20"
                        role="menuitem" 
                        tabindex="-1">
                    <i class="fa-solid fa-right-from-bracket mr-3"></i>
                    Sair
                </button>
            </form>
        </div>
    </div>
</div> 