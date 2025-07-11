<nav class="fixed bottom-0 left-0 right-0 z-50 bg-gray-900 shadow-2xl border-t border-gray-800 flex justify-around items-center h-16 px-1 md:hidden">
    @php
        $items = [
            [
                'label' => 'Dashboard',
                'icon' => 'fa-house',
                'route' => 'dashboard',
            ],
            [
                'label' => 'Finanças',
                'icon' => 'fa-coins',
                'options' => [
                    ['label' => 'Resumo', 'icon' => 'fa-chart-pie', 'route' => 'finance.dashboard'],
                    ['label' => 'Contas', 'icon' => 'fa-wallet', 'route' => 'accounts.index'],
                    ['label' => 'Transações', 'icon' => 'fa-arrow-right-arrow-left', 'route' => 'transactions.index'],
                    ['label' => 'Cartões', 'icon' => 'fa-credit-card', 'route' => 'credit-cards.index'],
                    ['label' => 'Dívidas', 'icon' => 'fa-money-bill-trend-up', 'route' => 'debts.index'],
                ],
            ],
            [
                'label' => 'Eventos',
                'icon' => 'fa-calendar-days',
                'options' => [
                    ['label' => 'Todos Eventos', 'icon' => 'fa-list-ul', 'route' => 'events.index'],
                    ['label' => 'Novo Evento', 'icon' => 'fa-plus', 'route' => 'events.create'],
                    ['label' => 'Calendário', 'icon' => 'fa-calendar-days', 'route' => 'events.calendar'],
                    ['label' => 'Previsibilidade', 'icon' => 'fa-user-group', 'route' => 'previsibilidade.index'],
                ],
            ],
            [
                'label' => 'Casa',
                'icon' => 'fa-house-chimney',
                'options' => [
                    ['label' => 'Dashboard', 'icon' => 'fa-gauge', 'route' => 'household-tasks.dashboard'],
                    ['label' => 'Todas as Tarefas', 'icon' => 'fa-list-check', 'route' => 'household-tasks.index'],
                    ['label' => 'Nova Tarefa', 'icon' => 'fa-plus', 'route' => 'household-tasks.create'],
                    ['label' => 'Categorias', 'icon' => 'fa-tags', 'route' => 'task-categories.index'],
                ],
            ],
            [
                'label' => 'Profissional',
                'icon' => 'fa-briefcase',
                'options' => [
                    ['label' => 'Projetos', 'icon' => 'fa-briefcase', 'route' => 'projetos.index'],
                    ['label' => 'Tarefas', 'icon' => 'fa-tasks', 'route' => 'tarefas.index'],
                    ['label' => 'Clientes', 'icon' => 'fa-users', 'route' => 'clientes.index'],
                    ['label' => 'Faturas', 'icon' => 'fa-file-invoice-dollar', 'route' => 'faturas.index'],
                    ['label' => 'Registros de Horas', 'icon' => 'fa-clock', 'route' => 'registros-horas.index'],
                ],
            ],
        ];
        $current = Route::currentRouteName();
    @endphp
    
    @foreach($items as $i => $item)
        @if(isset($item['options']))
            <button type="button"
                class="group flex flex-col items-center justify-center flex-1 h-full transition relative text-gray-300 hover:text-blue-300 focus:outline-none"
                aria-label="{{ $item['label'] }}"
                data-menu-title="{{ $item['label'] }}"
                data-menu-options="{{ json_encode($item['options']) }}"
                onclick="openFullScreenMenu(this, event)">
                <span class="flex items-center justify-center w-10 h-10 rounded-full transition-all duration-200 group-hover:bg-gray-800/80">
                    <i class="fa-solid {{ $item['icon'] }} text-xl"></i>
                </span>
                <span class="text-xs mt-1 font-medium tracking-tight">{{ $item['label'] }}</span>
            </button>
        @else
            <a href="{{ route($item['route']) }}"
               class="group flex flex-col items-center justify-center flex-1 h-full transition relative {{ $current === $item['route'] ? 'text-blue-400' : 'text-gray-300 hover:text-blue-300' }}"
               aria-label="{{ $item['label'] }}">
                <span class="flex items-center justify-center w-10 h-10 rounded-full transition-all duration-200 {{ $current === $item['route'] ? 'bg-blue-900/60 shadow-lg scale-110' : 'group-hover:bg-gray-800/80' }}">
                    <i class="fa-solid {{ $item['icon'] }} text-xl"></i>
                </span>
                <span class="text-xs mt-1 font-medium tracking-tight transition-all duration-200 {{ $current === $item['route'] ? 'text-blue-400' : 'text-gray-400 group-hover:text-blue-300' }}">
                    {{ $item['label'] }}
                </span>
            </a>
        @endif
    @endforeach
</nav>

<!-- Overlay de tela completa -->
<div id="fullscreen-overlay" class="fixed inset-0 bg-black/90 backdrop-blur-sm z-[60] hidden flex items-center justify-center">
    <div class="bg-gray-900 rounded-2xl shadow-2xl border border-gray-700 max-w-md w-full mx-4 max-h-[80vh] overflow-hidden">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-700">
            <h2 id="menu-title" class="text-xl font-bold text-white"></h2>
            <button onclick="closeFullScreenMenu()" class="text-gray-400 hover:text-white transition-colors">
                <i class="fa-solid fa-xmark text-2xl"></i>
            </button>
        </div>
        
        <!-- Menu items -->
        <div id="menu-items" class="p-4 space-y-2 max-h-[60vh] overflow-y-auto">
            <!-- Items serão inseridos aqui via JavaScript -->
        </div>
    </div>
</div>

<style>
nav.fixed.bottom-0 {
    backdrop-filter: blur(6px);
}

#fullscreen-overlay {
    animation: fadeIn 0.2s ease-out;
}

#fullscreen-overlay > div {
    animation: slideUp 0.3s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from { 
        opacity: 0; 
        transform: translateY(20px) scale(0.95); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0) scale(1); 
    }
}

@media (max-width: 400px) {
    nav.fixed.bottom-0 span.text-xs { font-size: 0.7rem; }
    nav.fixed.bottom-0 .w-10 { width: 2.2rem; height: 2.2rem; }
}
</style>

<script>
function openFullScreenMenu(button, event) {
    event.preventDefault();
    event.stopPropagation();
    
    // Previne múltiplos cliques
    if (document.getElementById('fullscreen-overlay').classList.contains('flex')) {
        return;
    }
    
    try {
        // Pega os dados do botão
        const title = button.getAttribute('data-menu-title');
        const optionsJson = button.getAttribute('data-menu-options');
        const options = JSON.parse(optionsJson);
        
        // Define o título
        document.getElementById('menu-title').textContent = title;
        
        // Limpa e adiciona os itens
        const menuItems = document.getElementById('menu-items');
        menuItems.innerHTML = '';
        
        options.forEach(option => {
            const item = document.createElement('a');
            // Gera a URL baseada na rota
            let href = '#';
            if (option.route) {
                // Mapeia as rotas para URLs
                const routeMap = {
                    'finance.dashboard': '{{ route("finance.dashboard") }}',
                    'accounts.index': '{{ route("accounts.index") }}',
                    'transactions.index': '{{ route("transactions.index") }}',
                    'credit-cards.index': '{{ route("credit-cards.index") }}',
                    'debts.index': '{{ route("debts.index") }}',
                    'events.index': '{{ route("events.index") }}',
                    'events.create': '{{ route("events.create") }}',
                    'events.calendar': '{{ route("events.calendar") }}',
                    'previsibilidade.index': '{{ route("previsibilidade.index") }}',
                    'household-tasks.dashboard': '{{ route("household-tasks.dashboard") }}',
                    'household-tasks.index': '{{ route("household-tasks.index") }}',
                    'household-tasks.create': '{{ route("household-tasks.create") }}',
                    'task-categories.index': '{{ route("task-categories.index") }}',
                    'projetos.index': '{{ route("projetos.index") }}',
                    'tarefas.index': '{{ route("tarefas.index") }}',
                    'clientes.index': '{{ route("clientes.index") }}',
                    'faturas.index': '{{ route("faturas.index") }}',
                    'registros-horas.index': '{{ route("registros-horas.index") }}'
                };
                href = routeMap[option.route] || '#';
            }
            item.href = href;
            item.className = 'flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-800/80 transition-all duration-200 text-gray-200 hover:text-white group';
            
            item.innerHTML = `
                <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-600/20 group-hover:bg-blue-600/30 transition-colors">
                    <i class="fa-solid ${option.icon} text-xl text-blue-400"></i>
                </div>
                <div class="flex-1">
                    <span class="font-medium">${option.label}</span>
                </div>
                <i class="fa-solid fa-chevron-right text-gray-500 group-hover:text-blue-400 transition-colors"></i>
            `;
            
            menuItems.appendChild(item);
        });
        
        // Mostra o overlay
        const overlay = document.getElementById('fullscreen-overlay');
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        
        // Foca no overlay para acessibilidade
        overlay.focus();
        
    } catch (error) {
        console.error('Erro ao abrir menu:', error);
        // Fallback: mostra mensagem de erro
        alert('Erro ao abrir menu. Tente novamente.');
    }
}

// Função para fechar o menu e restaurar scroll
function closeFullScreenMenu() {
    try {
        const overlay = document.getElementById('fullscreen-overlay');
        if (overlay) {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
            // Restaura o scroll do body
            document.body.style.overflow = '';
        }
    } catch (error) {
        console.error('Erro ao fechar menu:', error);
    }
}



// Fecha ao clicar fora do menu
document.addEventListener('click', function(event) {
    const overlay = document.getElementById('fullscreen-overlay');
    if (overlay && event.target === overlay) {
        closeFullScreenMenu();
    }
});

// Fecha com ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeFullScreenMenu();
    }
});

// Previne scroll do body quando menu está aberto
function preventBodyScroll() {
    const overlay = document.getElementById('fullscreen-overlay');
    if (overlay && overlay.classList.contains('flex')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
}

// Observa mudanças no overlay
document.addEventListener('DOMContentLoaded', function() {
    const overlay = document.getElementById('fullscreen-overlay');
    if (overlay) {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    preventBodyScroll();
                }
            });
        });

        observer.observe(overlay, {
            attributes: true,
            attributeFilter: ['class']
        });
    }
});

// Inicialização e verificações
document.addEventListener('DOMContentLoaded', function() {
    // Verifica se o FontAwesome está carregado
    if (typeof FontAwesome === 'undefined') {
        console.warn('FontAwesome não detectado, carregando...');
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css';
        document.head.appendChild(link);
    }
    
    // Verifica se todos os elementos necessários existem
    const requiredElements = ['fullscreen-overlay', 'menu-title', 'menu-items'];
    requiredElements.forEach(id => {
        if (!document.getElementById(id)) {
            console.error(`Elemento necessário não encontrado: ${id}`);
        }
    });
    
    // Adiciona listeners para os botões do menu
    const menuButtons = document.querySelectorAll('[data-menu-title]');
    menuButtons.forEach(button => {
        if (!button.hasAttribute('onclick')) {
            button.addEventListener('click', function(event) {
                openFullScreenMenu(this, event);
            });
        }
    });
});
</script> 