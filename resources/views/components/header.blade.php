<header class="main-header">
    <div class="header-content">
        <div class="header-left">
            <div class="logo">
                <i class="fas fa-chart-line"></i>
                <span>ADM System</span>
            </div>
        </div>
        
        <div class="header-center">
            <h1 class="page-title">{{ $title ?? 'Dashboard' }}</h1>
        </div>
        
        <div class="header-right">
            <div class="user-menu">
                <button class="user-button" onclick="toggleUserMenu()">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="user-name">{{ Auth::user()->name ?? 'Usuário' }}</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                
                <div class="user-dropdown" id="userDropdown">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="fas fa-user-edit"></i>
                        <span>Perfil</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="fas fa-cog"></i>
                        <span>Configurações</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}" class="dropdown-item">
                        @csrf
                        <button type="submit" class="logout-button">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Sair</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
/* FontAwesome CDN */
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');

/* Main Header */
.main-header {
    background: #ffffff;
    border-bottom: 1px solid #e5e7eb;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    position: relative;
    z-index: 40;
    height: 70px;
    width: 100%;
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 100%;
    padding: 0 24px;
    max-width: 1400px;
    margin: 0 auto;
}

/* Header Left - Logo */
.header-left {
    display: flex;
    align-items: center;
}

.logo {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 20px;
    font-weight: bold;
    color: #1f2937;
}

.logo i {
    color: #3b82f6;
    font-size: 24px;
}

.logo span {
    font-weight: 700;
}

/* Header Center - Page Title */
.header-center {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.page-title {
    font-size: 18px;
    font-weight: 600;
    color: #374151;
    margin: 0;
    text-align: center;
}

/* Header Right - User Menu */
.header-right {
    display: flex;
    align-items: center;
}

.user-menu {
    position: relative;
}

.user-button {
    display: flex;
    align-items: center;
    gap: 12px;
    background: none;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    color: #374151;
}

.user-button:hover {
    background: #f3f4f6;
}

.user-avatar {
    width: 36px;
    height: 36px;
    background: #3b82f6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
}

.user-name {
    font-weight: 500;
    font-size: 14px;
}

.user-button i:last-child {
    font-size: 12px;
    transition: transform 0.2s ease;
}

.user-button.active i:last-child {
    transform: rotate(180deg);
}

/* User Dropdown */
.user-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    min-width: 200px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.2s ease;
    z-index: 50;
    margin-top: 8px;
}

.user-dropdown.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    color: #374151;
    text-decoration: none;
    transition: background 0.2s ease;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
    font-size: 14px;
}

.dropdown-item:hover {
    background: #f9fafb;
}

.dropdown-item i {
    width: 16px;
    color: #6b7280;
}

.dropdown-divider {
    height: 1px;
    background: #e5e7eb;
    margin: 8px 0;
}

.logout-button {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0;
    border: none;
    background: none;
    color: #dc2626;
    cursor: pointer;
    font-size: 14px;
    width: 100%;
    text-align: left;
}

.logout-button:hover {
    color: #b91c1c;
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-content {
        padding: 0 16px;
    }
    
    .logo span {
        display: none;
    }
    
    .page-title {
        font-size: 16px;
    }
    
    .user-name {
        display: none;
    }
    
    .user-button {
        padding: 8px;
    }
}

@media (max-width: 480px) {
    .main-header {
        height: 60px;
    }
    
    .header-content {
        padding: 0 12px;
    }
    
    .page-title {
        font-size: 14px;
    }
    
    .user-avatar {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }
}

/* Hide on mobile (when bottom nav is shown) */
@media (max-width: 767px) {
    .main-header {
        display: none;
    }
}

/* Ensure content doesn't overlap */
body {
    padding-top: 70px;
}

@media (max-width: 767px) {
    body {
        padding-top: 0;
    }
}
</style>

<script>
// User menu toggle
function toggleUserMenu() {
    const button = document.querySelector('.user-button');
    const dropdown = document.getElementById('userDropdown');
    
    if (dropdown.classList.contains('show')) {
        dropdown.classList.remove('show');
        button.classList.remove('active');
    } else {
        // Close any other open dropdowns
        document.querySelectorAll('.user-dropdown.show').forEach(d => {
            d.classList.remove('show');
        });
        document.querySelectorAll('.user-button.active').forEach(b => {
            b.classList.remove('active');
        });
        
        dropdown.classList.add('show');
        button.classList.add('active');
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const userMenu = document.querySelector('.user-menu');
    const dropdown = document.getElementById('userDropdown');
    
    if (!userMenu.contains(event.target)) {
        dropdown.classList.remove('show');
        document.querySelector('.user-button').classList.remove('active');
    }
});

// Close dropdown with ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const dropdown = document.getElementById('userDropdown');
        if (dropdown.classList.contains('show')) {
            dropdown.classList.remove('show');
            document.querySelector('.user-button').classList.remove('active');
        }
    }
});

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if FontAwesome is loaded
    if (!document.querySelector('.fas')) {
        console.warn('FontAwesome não detectado, carregando...');
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css';
        document.head.appendChild(link);
    }
    
    // Set page title if not already set
    const pageTitle = document.querySelector('.page-title');
    if (pageTitle && pageTitle.textContent === 'Dashboard') {
        // Try to get title from document title or current page
        const docTitle = document.title;
        if (docTitle && docTitle !== 'Dashboard') {
            pageTitle.textContent = docTitle;
        }
    }
});
</script> 