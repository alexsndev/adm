<header class="w-full flex items-center justify-center px-4 py-2 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 shadow-sm fixed top-0 left-0 z-[9999] h-14">
    <!-- Sininho de notificações à esquerda -->
    <div class="absolute left-4 flex items-center space-x-3">
        <a href="#" class="flex items-center" title="Notificações">
            <i class="fa-solid fa-bell text-2xl text-gray-400 dark:text-gray-500 hover:text-blue-500 transition-colors"></i>
        </a>
    </div>
    <!-- Logo centralizada -->
    <div class="flex items-center justify-center flex-1">
        @if(Auth::user()->logo)
            <img src="{{ Storage::url(Auth::user()->logo) }}" alt="Logo" class="h-10 w-auto rounded shadow max-w-[120px] object-contain mx-auto">
        @else
            <span class="text-xl font-extrabold tracking-tight text-gray-900 dark:text-white select-none">Alexandre <span class="text-blue-500">e</span> Liza <span class="text-blue-500">Gestão</span></span>
        @endif
    </div>
    <!-- Foto de perfil à direita -->
    <div class="absolute right-4 flex items-center space-x-3">
        <a href="{{ route('profile.edit') }}" class="flex items-center">
            @if(Auth::user()->photo)
                <img src="{{ Storage::url(Auth::user()->photo) }}" alt="Foto de perfil" class="w-10 h-10 rounded-full object-cover border-2 border-blue-200 dark:border-blue-700 shadow">
            @else
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 font-bold text-lg">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
            @endif
        </a>
    </div>
</header> 