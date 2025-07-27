<header class="site-header text-white">
    <div class="header-container px-2 md:px-8 lg:px-16" style="max-width: 1200px; margin: 0 auto; height: 64px; display: flex; align-items: center; justify-content: space-between; position: relative;">
        <!-- Esquerda -->
        <div class="header-left" style="display: flex; align-items: center; gap: 8px; min-width: 80px; flex: 1;">
            <button id="sidebar-toggle-btn" class="header-notification hidden md:flex" style="position: fixed; left: 0; z-index: 1100; font-size: 1.8rem; color: #38bdf8; background: none; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 48px; height: 48px; border-radius: 0 12px 12px 0; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <i class="fa-solid fa-bars"></i>
            </button>
            <button id="notification-btn" class="header-notification" style="font-size: 1.6rem; color: #38bdf8; background: none; border: none; cursor: pointer; margin-left: 8px;">
                <i class="fa-solid fa-bell"></i>
            </button>
            @if(Auth::check() && Auth::user()->is_admin)
                <div style="position: relative; display: inline-block; margin-left: 16px;">
                    <button id="admin-chat-btn" style="font-size: 1.6rem; color: #38bdf8; background: none; border: none; cursor: pointer; margin-left: 8px;">
                        <i class="fa-solid fa-comments"></i>
                    </button>
                    <div id="admin-chat-dropdown" style="display: none; position: absolute; left: 0; top: 36px; background: #23232a; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.12); min-width: 260px; z-index: 2000; max-height: 340px; overflow-y: auto;">
                        @php
                            $clientesChat = \App\Models\Client::whereHas('chats')->with(['chats' => function($q){ $q->latest(); }])->get();
                        @endphp
                        @forelse($clientesChat as $cliente)
                            @php $lastMsg = $cliente->chats->sortByDesc('created_at')->first(); @endphp
                            <a href="{{ route('admin.chats.show', $cliente->id) }}" style="display: flex; align-items: center; gap: 10px; padding: 12px 16px; color: #fff; text-decoration: none; border-bottom: 1px solid #333;">
                                @if($cliente->logo)
                                    <img src="{{ Storage::url($cliente->logo) }}" class="h-8 w-8 rounded bg-white/10 object-contain" alt="Logo">
                                @else
                                    <span class="inline-flex items-center justify-center h-8 w-8 rounded bg-purple-700 text-white font-bold text-base">
                                        <i class="fa-solid fa-user"></i>
                                    </span>
                                @endif
                                <span style="flex:1;">
                                    <span class="font-semibold">{{ $cliente->name }}</span><br>
                                    <span class="text-xs text-gray-400">{{ $lastMsg ? Str::limit($lastMsg->message, 32) : 'Sem mensagens' }}</span>
                                </span>
                            </a>
                        @empty
                            <span style="display:block; padding: 16px; color: #aaa;">Nenhuma conversa</span>
                        @endforelse
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const chatBtn = document.getElementById('admin-chat-btn');
                        const chatDropdown = document.getElementById('admin-chat-dropdown');
                        if(chatBtn && chatDropdown) {
                            chatBtn.addEventListener('click', function(e) {
                                e.stopPropagation();
                                chatDropdown.style.display = chatDropdown.style.display === 'block' ? 'none' : 'block';
                            });
                            document.addEventListener('click', function() {
                                chatDropdown.style.display = 'none';
                            });
                        }
                    });
                </script>
            @endif
        </div>
        <!-- Centro: Logo -->
        <div class="header-logo" style="display: flex; align-items: center; justify-content: center; flex: 1; min-width: 0;">
            @php $user = Auth::user(); @endphp
            @php
                $logoHref = route('dashboard');
                if ($user && (int)$user->is_admin === 1) {
                    $logoHref = route('dashboard');
                } elseif ($user && (int)$user->is_client === 1) {
                    $logoHref = route('cliente.dashboard');
                }
            @endphp
            @if($user && $user->logo)
                <a href="{{ $logoHref }}">
                    <img src="{{ Storage::url($user->logo) }}" alt="Logo" height="40" style="max-height:40px;max-width:120px;object-fit:contain;">
                </a>
            @else
                <a href="{{ $logoHref }}">
                    <span style="font-size:2rem;color:#38bdf8;">🏷️</span>
                </a>
            @endif
        </div>
        <!-- Direita: User -->
        <div class="header-user" style="position: relative; min-width: 80px; display: flex; justify-content: flex-end; flex: 1;">
            <button id="user-menu-btn" style="background: none; border: none; cursor: pointer; padding: 0;">
                @if($user && $user->photo)
                    <span style="display: inline-block; width: 40px; height: 40px; border-radius: 50%; overflow: hidden; background: #23232a; border: 2px solid #38bdf8;">
                        <img src="{{ Storage::url($user->photo) }}" alt="Usuário" style="width: 100%; height: 100%; object-fit: cover;">
                    </span>
                @else
                    <span style="display: inline-block; width: 40px; height: 40px; border-radius: 50%; background: #23232a; color: #38bdf8; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; border: 2px solid #38bdf8;">
                        <i class="fa-solid fa-user"></i>
                    </span>
                @endif
            </button>
            <div id="user-dropdown" style="display: none; position: absolute; right: 0; top: 48px; background: #23232a; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.12); min-width: 160px; z-index: 2000;">
                <a href="{{ route('profile.edit') }}" style="display: block; padding: 12px 20px; color: #fff; text-decoration: none; border-bottom: 1px solid #333;">Perfil</a>
                @if($user && $user->is_admin)
                <a href="{{ route('admin.home') }}" style="display: block; padding: 12px 20px; color: #fff; text-decoration: none; border-bottom: 1px solid #333;">Administração</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" style="width: 100%; background: none; border: none; color: #fff; padding: 12px 20px; text-align: left; cursor: pointer;">Sair</button>
                </form>
            </div>
        </div>
    </div>
    <style>
        @media (min-width: 768px) {
            #sidebar-toggle-btn {
                display: flex !important;
                position: fixed !important;
                left: 0 !important;
                z-index: 1100 !important;
                font-size: 1.8rem !important;
                color: #38bdf8 !important;
                background: none !important;
                border: none !important;
                cursor: pointer !important;
                align-items: center !important;
                justify-content: center !important;
                width: 48px !important;
                height: 48px !important;
                border-radius: 0 12px 12px 0 !important;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08) !important;
            }
        }
        
        @media (max-width: 767px) {
            #sidebar-toggle-btn {
                display: none !important;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('user-menu-btn');
            const dropdown = document.getElementById('user-dropdown');
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            });
            document.addEventListener('click', function() {
                dropdown.style.display = 'none';
            });
            const sidebarToggleBtn = document.getElementById('sidebar-toggle-btn');
            if (sidebarToggleBtn) {
                sidebarToggleBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (typeof toggleSidebar === 'function') {
                        toggleSidebar();
                        updateHeaderToggleIcon();
                    }
                });
                function updateHeaderToggleIcon() {
                    const sidebar = document.getElementById('side-nav');
                    const icon = sidebarToggleBtn.querySelector('i');
                    if (sidebar && icon) {
                        if (sidebar.classList.contains('collapsed')) {
                            icon.className = 'fa-solid fa-bars';
                            icon.style.color = '#cbd5e1';
                        } else {
                            icon.className = 'fa-solid fa-xmark';
                            icon.style.color = '#cbd5e1';
                        }
                    }
                }
                updateHeaderToggleIcon();
            }
            const notificationBtn = document.getElementById('notification-btn');
            if (notificationBtn && typeof showNotification === 'function') {
                notificationBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    showNotification('Você tem novas notificações!', 'success');
                });
            }
        });
    </script>
</header> 