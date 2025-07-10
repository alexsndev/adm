<header class="site-header">
    <div class="header-container" style="display: flex; align-items: center; justify-content: space-between; position: relative; height: 64px;">
        <div class="header-left" style="display: flex; align-items: center; gap: 16px; min-width: 80px;">
            <button id="notification-btn" class="header-notification" style="font-size: 1.6rem; color: #38bdf8; background: none; border: none; cursor: pointer;">
                <i class="fa-solid fa-bell"></i>
            </button>
        </div>
        <div class="header-logo" style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);">
            @php $user = Auth::user(); @endphp
            @if($user && $user->logo)
                <a href="/">
                    <img src="{{ Storage::url($user->logo) }}" alt="Logo" height="40" style="max-height:40px;max-width:120px;object-fit:contain;">
                </a>
            @else
                <a href="/">
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
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" style="width: 100%; background: none; border: none; color: #fff; padding: 12px 20px; text-align: left; cursor: pointer;">Sair</button>
                </form>
            </div>
        </div>
    </div>
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