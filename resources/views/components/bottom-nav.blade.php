<nav class="bottom-nav">
    <div class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link">
            <i class="fas fa-house"></i>
            <span>Dashboard</span>
        </a>
    </div>
    
    <div class="nav-item">
        <button class="nav-button" onclick="openModal('financas')">
            <i class="fas fa-coins"></i>
            <span>Finanças</span>
        </button>
    </div>
    
    <div class="nav-item">
        <button class="nav-button" onclick="openModal('eventos')">
            <i class="fas fa-calendar-days"></i>
            <span>Eventos</span>
        </button>
    </div>
    
    <div class="nav-item">
        <button class="nav-button" onclick="openModal('casa')">
            <i class="fas fa-house-chimney"></i>
            <span>Casa</span>
        </button>
    </div>
    
    <div class="nav-item">
        <button class="nav-button" onclick="openModal('profissional')">
            <i class="fas fa-briefcase"></i>
            <span>Profissional</span>
        </button>
    </div>
</nav>

<!-- Modal Finanças -->
<div id="financas" class="modal">
    <div class="modal-backdrop" onclick="closeModal('financas')"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3>Finanças</h3>
            <button class="close-btn" onclick="closeModal('financas')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <a href="{{ route('finance.dashboard') }}" class="modal-item">
                <i class="fas fa-chart-pie"></i>
                <span>Resumo</span>
            </a>
            <a href="{{ route('accounts.index') }}" class="modal-item">
                <i class="fas fa-wallet"></i>
                <span>Contas</span>
            </a>
            <a href="{{ route('transactions.index') }}" class="modal-item">
                <i class="fas fa-arrow-right-arrow-left"></i>
                <span>Transações</span>
            </a>
            <a href="{{ route('credit-cards.index') }}" class="modal-item">
                <i class="fas fa-credit-card"></i>
                <span>Cartões</span>
            </a>
            <a href="{{ route('debts.index') }}" class="modal-item">
                <i class="fas fa-money-bill-trend-up"></i>
                <span>Dívidas</span>
            </a>
        </div>
    </div>
</div>

<!-- Modal Eventos -->
<div id="eventos" class="modal">
    <div class="modal-backdrop" onclick="closeModal('eventos')"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3>Eventos</h3>
            <button class="close-btn" onclick="closeModal('eventos')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <a href="{{ route('events.index') }}" class="modal-item">
                <i class="fas fa-list-ul"></i>
                <span>Todos Eventos</span>
            </a>
            <a href="{{ route('events.create') }}" class="modal-item">
                <i class="fas fa-plus"></i>
                <span>Novo Evento</span>
            </a>
            <a href="{{ route('events.calendar') }}" class="modal-item">
                <i class="fas fa-calendar-days"></i>
                <span>Calendário</span>
            </a>
            <a href="{{ route('previsibilidade.index') }}" class="modal-item">
                <i class="fas fa-user-group"></i>
                <span>Previsibilidade</span>
            </a>
        </div>
    </div>
</div>

<!-- Modal Casa -->
<div id="casa" class="modal">
    <div class="modal-backdrop" onclick="closeModal('casa')"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3>Casa</h3>
            <button class="close-btn" onclick="closeModal('casa')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <a href="{{ route('household-tasks.dashboard') }}" class="modal-item">
                <i class="fas fa-gauge"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('household-tasks.index') }}" class="modal-item">
                <i class="fas fa-list-check"></i>
                <span>Todas as Tarefas</span>
            </a>
            <a href="{{ route('household-tasks.create') }}" class="modal-item">
                <i class="fas fa-plus"></i>
                <span>Nova Tarefa</span>
            </a>
            <a href="{{ route('task-categories.index') }}" class="modal-item">
                <i class="fas fa-tags"></i>
                <span>Categorias</span>
            </a>
        </div>
    </div>
</div>

<!-- Modal Profissional -->
<div id="profissional" class="modal">
    <div class="modal-backdrop" onclick="closeModal('profissional')"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3>Profissional</h3>
            <button class="close-btn" onclick="closeModal('profissional')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <a href="{{ route('projetos.index') }}" class="modal-item">
                <i class="fas fa-briefcase"></i>
                <span>Projetos</span>
            </a>
            <a href="{{ route('tarefas.index') }}" class="modal-item">
                <i class="fas fa-tasks"></i>
                <span>Tarefas</span>
            </a>
            <a href="{{ route('clientes.index') }}" class="modal-item">
                <i class="fas fa-users"></i>
                <span>Clientes</span>
            </a>
            <a href="{{ route('faturas.index') }}" class="modal-item">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Faturas</span>
            </a>
            <a href="{{ route('registros-horas.index') }}" class="modal-item">
                <i class="fas fa-clock"></i>
                <span>Registros de Horas</span>
            </a>
        </div>
    </div>
</div>

<style>
/* FontAwesome CDN */
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');

/* Bottom Navigation */
.bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #111827;
    border-top: 1px solid #374151;
    display: flex;
    justify-content: space-around;
    align-items: center;
    height: 64px;
    padding: 0 4px;
    z-index: 50;
    box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(8px);
}

.nav-item {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.nav-link, .nav-button {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    color: #9CA3AF;
    text-decoration: none;
    border: none;
    background: none;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 12px;
    font-weight: 500;
}

.nav-link:hover, .nav-button:hover {
    color: #93C5FD;
}

.nav-link i, .nav-button i {
    font-size: 20px;
    margin-bottom: 4px;
    transition: all 0.2s ease;
}

.nav-link:hover i, .nav-button:hover i {
    transform: scale(1.1);
}

/* Modal Styles */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 60;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 16px;
}

.modal.show {
    display: flex;
}

.modal-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.75);
    backdrop-filter: blur(4px);
}

.modal-content {
    position: relative;
    background: #111827;
    border-radius: 16px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 100%;
    max-height: 80vh;
    overflow: hidden;
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 24px;
    border-bottom: 1px solid #374151;
}

.modal-header h3 {
    color: white;
    font-size: 20px;
    font-weight: bold;
    margin: 0;
}

.close-btn {
    background: none;
    border: none;
    color: #9CA3AF;
    font-size: 24px;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.close-btn:hover {
    color: white;
    background: rgba(255, 255, 255, 0.1);
}

.modal-body {
    padding: 16px;
    max-height: 60vh;
    overflow-y: auto;
}

.modal-item {
    display: flex;
    align-items: center;
    padding: 16px;
    color: #E5E7EB;
    text-decoration: none;
    border-radius: 12px;
    transition: all 0.2s ease;
    margin-bottom: 8px;
}

.modal-item:hover {
    background: #374151;
    color: white;
    transform: translateX(4px);
}

.modal-item i {
    font-size: 20px;
    color: #60A5FA;
    margin-right: 16px;
    width: 24px;
    text-align: center;
}

.modal-item span {
    font-weight: 500;
    font-size: 14px;
}

/* Responsive */
@media (max-width: 400px) {
    .bottom-nav {
        height: 60px;
    }
    
    .nav-link, .nav-button {
        font-size: 11px;
    }
    
    .nav-link i, .nav-button i {
        font-size: 18px;
    }
    
    .modal {
        padding: 8px;
    }
    
    .modal-content {
        max-width: 100%;
    }
}

/* Hide on desktop */
@media (min-width: 768px) {
    .bottom-nav {
        display: none;
    }
}

/* Scrollbar styling */
.modal-body::-webkit-scrollbar {
    width: 6px;
}

.modal-body::-webkit-scrollbar-track {
    background: #1F2937;
    border-radius: 3px;
}

.modal-body::-webkit-scrollbar-thumb {
    background: #4B5563;
    border-radius: 3px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: #6B7280;
}
</style>

<script>
// Modal functions
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }
}

// Close modal with ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (modal.classList.contains('show')) {
                modal.classList.remove('show');
                document.body.style.overflow = '';
            }
        });
    }
});

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('show');
        document.body.style.overflow = '';
    }
});

// Prevent modal close when clicking inside modal content
document.addEventListener('click', function(event) {
    if (event.target.closest('.modal-content')) {
        event.stopPropagation();
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
    
    // Add active state to current page
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.style.color = '#60A5FA';
            link.querySelector('i').style.color = '#60A5FA';
        }
    });
});
</script> 