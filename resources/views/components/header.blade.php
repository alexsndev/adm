<!-- Header com tecnologia pura (HTML, CSS, JS inline) -->
<style>
/* Reset e configurações básicas do header */
.site-header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 64px;
    background: #1a1a1a;
    border-bottom: 1px solid #333;
    z-index: 1000;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.header-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 100%;
    padding: 0 16px;
    position: relative;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 16px;
    min-width: 80px;
}

.header-notification {
    font-size: 1.6rem;
    color: #38bdf8;
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px;
    border-radius: 50%;
    transition: background-color 0.3s ease;
}

.header-notification:hover {
    background-color: rgba(56, 189, 248, 0.1);
}

.header-logo {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
}

.header-logo a {
    text-decoration: none;
}

.header-logo img {
    max-height: 40px;
    max-width: 120px;
    object-fit: contain;
}

.header-logo span {
    font-size: 2rem;
    color: #38bdf8;
}

.header-user {
    position: relative;
    min-width: 80px;
    display: flex;
    justify-content: flex-end;
}

#user-menu-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
}

.user-avatar {
    display: inline-block;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    background: #23232a;
    border: 2px solid #38bdf8;
}

.user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-avatar-icon {
    display: inline-block;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #23232a;
    color: #38bdf8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    border: 2px solid #38bdf8;
}

#user-dropdown {
    display: none;
    position: absolute;
    right: 0;
    top: 48px;
    background: #23232a;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    min-width: 160px;
    z-index: 2000;
    border: 1px solid #333;
}

#user-dropdown a,
#user-dropdown button {
    display: block;
    width: 100%;
    padding: 12px 20px;
    color: #fff;
    text-decoration: none;
    background: none;
    border: none;
    text-align: left;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

#user-dropdown a:hover,
#user-dropdown button:hover {
    background-color: #333;
}

#user-dropdown a:not(:last-child) {
    border-bottom: 1px solid #333;
}

/* Espaçamento para o conteúdo não ser sobreposto */
body {
    padding-top: 64px;
}

/* Responsividade */
@media (max-width: 768px) {
    .header-container {
        padding: 0 12px;
    }
    
    .header-left {
        min-width: 60px;
    }
    
    .header-user {
        min-width: 60px;
    }
}
</style>

<header class="site-header">
    <div class="header-container">
        <div class="header-left">
            <button id="notification-btn" class="header-notification">
                <i class="fa-solid fa-bell"></i>
            </button>
        </div>
        
        <div class="header-logo">
            @php $user = Auth::user(); @endphp
            @if($user && $user->logo)
                <a href="/">
                    <img src="{{ Storage::url($user->logo) }}" alt="Logo">
                </a>
            @else
                <a href="/">
                    <span>🏷️</span>
                </a>
            @endif
        </div>
        
        <div class="header-user">
            <button id="user-menu-btn">
                @if($user && $user->photo)
                    <span class="user-avatar">
                        <img src="{{ Storage::url($user->photo) }}" alt="Usuário">
                    </span>
                @else
                    <span class="user-avatar-icon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                @endif
            </button>
            
            <div id="user-dropdown">
                <a href="{{ route('profile.edit') }}">Perfil</a>
                @if($user && $user->is_admin)
                <a href="{{ route('admin.home') }}">Administração</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit">Sair</button>
                </form>
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Controle do dropdown do usuário
    const userBtn = document.getElementById('user-menu-btn');
    const userDropdown = document.getElementById('user-dropdown');
    
    if (userBtn && userDropdown) {
        userBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.style.display = userDropdown.style.display === 'block' ? 'none' : 'block';
        });
        
        // Fechar dropdown ao clicar fora
        document.addEventListener('click', function() {
            userDropdown.style.display = 'none';
        });
        
        // Prevenir fechamento ao clicar dentro do dropdown
        userDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
    
    // Controle das notificações
    const notificationBtn = document.getElementById('notification-btn');
    if (notificationBtn) {
        notificationBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            
            // Sistema de notificação simples
            if (typeof showNotification === 'function') {
                showNotification('Você tem novas notificações!', 'success');
            } else {
                // Fallback se a função não existir
                alert('Você tem novas notificações!');
            }
        });
    }
    
    // Garantir que o body tenha padding-top
    if (!document.body.style.paddingTop) {
        document.body.style.paddingTop = '64px';
    }
});
</script> 