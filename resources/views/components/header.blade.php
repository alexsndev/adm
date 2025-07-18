<header class="site-header">
    <div class="header-container" style="display: flex; align-items: center; justify-content: space-between; position: relative; height: 64px;">
        <div class="header-left" style="display: flex; align-items: center; gap: 16px; min-width: 80px;">
            <button id="sidebar-toggle-btn" class="header-notification" style="font-size: 1.6rem; color: #38bdf8; background: none; border: none; cursor: pointer; display: none;">
                <i class="fa-solid fa-bars"></i>
            </button>
            <button id="notification-btn" class="header-notification" style="font-size: 1.6rem; color: #38bdf8; background: none; border: none; cursor: pointer;">
                <i class="fa-solid fa-bell"></i>
            </button>
            @if(Auth::check() && Auth::user()->is_admin)
                <div style="position: relative; display: inline-block;">
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
        <div class="header-logo" style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);">
            @php $user = Auth::user(); @endphp
            {{-- DEBUG TEMPORÁRIO --}}
            {{-- @php dd($user, $logoHref); @endphp --}}
            @php
                $logoHref = route('dashboard');
                if ($user && (int)$user->is_admin === 1) {
                    $logoHref = route('dashboard'); // dashboard geral para admin
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
        <div class="header-user" style="position: relative; min-width: 80px; display: flex; justify-content: flex-end;">
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
            
            // Toggle da sidebar (expandir/comprimir)
            const sidebarToggleBtn = document.getElementById('sidebar-toggle-btn');
            if (sidebarToggleBtn) {
                sidebarToggleBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    // Usa a função toggleSidebar() que já existe na sidebar
                    if (typeof toggleSidebar === 'function') {
                        toggleSidebar();
                        // Atualiza o ícone do botão
                        updateHeaderToggleIcon();
                    }
                });
                
                // Função para atualizar o ícone do botão no header
                function updateHeaderToggleIcon() {
                    const sidebar = document.getElementById('side-nav');
                    const icon = sidebarToggleBtn.querySelector('i');
                    if (sidebar && icon) {
                        if (sidebar.classList.contains('collapsed')) {
                            icon.className = 'fa-solid fa-bars';
                        } else {
                            icon.className = 'fa-solid fa-xmark';
                        }
                    }
                }
                
                // Atualiza o ícone inicial
                updateHeaderToggleIcon();
            }
            

            
            // Integração do sino de notificação com o sistema de toast
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