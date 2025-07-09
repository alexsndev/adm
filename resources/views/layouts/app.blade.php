<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-x-hidden">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Scriptss -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Custom CSS -->
        <!-- FontAwesome CDN -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link rel="stylesheet" href="/css/bottom-navigation.css">
        <link rel="stylesheet" href="/css/header.css">
        <link rel="stylesheet" href="/css/notifications.css">
        @stack('styles')
        <script>
            // Detecta o tema salvo e aplica a classe 'dark' no <html>
            (function() {
                const saved = localStorage.getItem('theme') || 'dark';
                if(saved === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="#2563eb">
        <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        
        <style>
            /* Transições da sidebar */
            aside {
                transition: width 0.3s ease;
            }
            .md\\:ml-64 {
                transition: margin-left 0.3s ease;
            }
            aside.collapsed {
                width: 4rem !important;
            }
            aside.collapsed .sidebar-content {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            aside.collapsed .sidebar-text,
            aside.collapsed .sidebar-arrow,
            aside.collapsed .sidebar-logo {
                display: none !important;
            }
            aside.collapsed .sidebar-avatar {
                margin: 0 auto !important;
                display: flex !important;
                justify-content: center !important;
            }
            aside.collapsed nav.sidebar-content a,
            aside.collapsed nav.sidebar-content button {
                justify-content: center !important;
            }
            aside.collapsed nav.sidebar-content a i,
            aside.collapsed nav.sidebar-content button i {
                margin: 0 !important;
            }
            aside.group\/sidebar {
                transition: width 0.3s cubic-bezier(.4,0,.2,1);
            }
            aside.w-16 .sidebar-label,
            aside.w-16 .h-16,
            aside.w-16 .logo {
                display: none !important;
            }
            aside.w-16 nav a, aside.w-16 nav button {
                justify-content: center !important;
            }
            aside.w-16 nav a i, aside.w-16 nav button i {
                margin: 0 !important;
            }
            aside.w-16 .inline-flex.w-10.h-10 {
                margin: 0 auto !important;
            }
            aside.w-16 .absolute.left-full {
                display: block !important;
            }
            .ml-64 {
                margin-left: 16rem !important;
                transition: margin-left 0.3s cubic-bezier(.4,0,.2,1);
            }
            .ml-16 {
                margin-left: 4rem !important;
                transition: margin-left 0.3s cubic-bezier(.4,0,.2,1);
            }
            
            /* Regra específica para garantir que a navegação bottom funcione corretamente em produção */
            nav.fixed.bottom-0 {
                position: fixed !important;
                bottom: 0 !important;
                left: 0 !important;
                right: 0 !important;
                z-index: 9999 !important;
                top: auto !important;
            }
            
            /* Garantir que a navegação bottom não seja afetada por outras regras */
            @media (max-width: 768px) {
                nav.fixed.bottom-0 {
                    position: fixed !important;
                    bottom: 0 !important;
                    left: 0 !important;
                    right: 0 !important;
                    z-index: 9999 !important;
                    top: auto !important;
                }
            }
            /* Regra para sobrescrever qualquer CSS que possa estar interferindo */
            body nav.fixed.bottom-0,
            html body nav.fixed.bottom-0,
            body nav[class*="fixed"][class*="bottom-0"],
            html body nav[class*="fixed"][class*="bottom-0"] {
                position: fixed !important;
                bottom: 0 !important;
                left: 0 !important;
                right: 0 !important;
                z-index: 9999 !important;
                top: auto !important;
            }
            
            /* Regra específica para garantir que a logo do header fique centralizada em produção */
            header .absolute.left-1\/2.top-1\/2 {
                position: absolute !important;
                left: 50% !important;
                top: 50% !important;
                transform: translate(-50%, -50%) !important;
                z-index: 5 !important;
            }
            
            /* Regra mais específica para a logo */
            header div[class*="absolute"][class*="left-1/2"][class*="top-1/2"] {
                position: absolute !important;
                left: 50% !important;
                top: 50% !important;
                transform: translate(-50%, -50%) !important;
                z-index: 5 !important;
            }
            
            /* Garantir que a logo não seja afetada por outras regras */
            @media (max-width: 768px) {
                header .absolute.left-1\/2.top-1\/2,
                header div[class*="absolute"][class*="left-1/2"][class*="top-1/2"] {
                    position: absolute !important;
                    left: 50% !important;
                    top: 50% !important;
                    transform: translate(-50%, -50%) !important;
                    z-index: 5 !important;
                }
            }
            
            /* Regras específicas para o dropdown de notificações */
            #notification-dropdown {
                position: fixed !important;
                top: 4rem !important;
                left: 0.5rem !important;
                width: 20rem !important;
                max-height: 24rem !important;
                z-index: 9998 !important;
                margin-top: 0.5rem !important;
            }
            
            /* Garantir que o sino fique acima do dropdown */
            #notification-bell {
                z-index: 9999 !important;
                position: relative !important;
            }
            
            /* Regra para sobrescrever qualquer CSS que possa estar interferindo com o dropdown */
            body #notification-dropdown,
            html body #notification-dropdown {
                position: fixed !important;
                top: 4rem !important;
                left: 0.5rem !important;
                width: 20rem !important;
                max-height: 24rem !important;
                z-index: 9998 !important;
                margin-top: 0.5rem !important;
            }
            
            /* Garantir que o sino não seja afetado por outras regras */
            body #notification-bell,
            html body #notification-bell {
                z-index: 9999 !important;
                position: relative !important;
            }
        </style>
        <script>
        document.addEventListener('alpine:init', () => {
            Alpine.effect(() => {
                const sidebar = document.querySelector('aside.group\/sidebar');
                const main = document.querySelector('div.ml-64, div.ml-16');
                if (!sidebar || !main) return;
                if (sidebar.classList.contains('w-16')) {
                    main.classList.remove('ml-64');
                    main.classList.add('ml-16');
                } else {
                    main.classList.remove('ml-16');
                    main.classList.add('ml-64');
                }
            });
        });
        </script>
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 overflow-x-hidden">
        @component('components.header')
        @endcomponent
        <!-- Barra de frase motivacional fixa com slider e efeito de digitação -->
        @php
            $frases = [
                'O sucesso é a soma de pequenos esforços repetidos todos os dias.',
                'A disciplina é a ponte entre metas e realizações.',
                'Grandes conquistas começam com pequenos passos.',
                'A persistência realiza o impossível.',
                'Você é o único responsável pelo seu próprio sucesso.',
                'A simplicidade é o último grau de sofisticação.',
                'A mente que se abre a uma nova ideia jamais volta ao seu tamanho original.',
                'A melhor maneira de prever o futuro é criá-lo.',
                'A excelência é um hábito, não um ato.',
                'O conhecimento é poder, mas a ação transforma.',
                'Organização é o primeiro passo para a liberdade.',
                'Planejar é trazer o futuro para o presente.',
                'O tempo é o recurso mais democrático: todos têm 24 horas.',
                'A produtividade nasce do foco, não do esforço desenfreado.',
                'Metas claras transformam sonhos em conquistas.',
                'A constância supera o talento quando o talento não é constante.',
                'Cada tarefa concluída é um degrau rumo ao seu objetivo.',
                'A melhor gestão é aquela que simplifica a vida.',
                'O autoconhecimento é o melhor investimento.',
                'A coragem de começar é mais valiosa que o medo de errar.',
                'O progresso é feito de pequenas vitórias diárias.',
                'A criatividade floresce na rotina bem organizada.',
                'O planejamento de hoje é o sucesso de amanhã.',
                'A mente organizada cria oportunidades onde outros veem obstáculos.',
                'A verdadeira riqueza está em saber administrar o que se tem.',
                'A colaboração multiplica resultados.',
                'A clareza de propósito ilumina o caminho.',
                'A disciplina é o segredo dos grandes realizadores.',
                'O tempo bem usado é o maior aliado do sucesso.',
                'A gratidão transforma o que temos em suficiente.',
                'A inovação nasce da curiosidade e da coragem.',
                'A vida é feita de escolhas: escolha evoluir.',
                'A persistência é o caminho do êxito.',
                'O fracasso é apenas uma oportunidade para recomeçar com mais inteligência.',
                'A organização elimina o caos e abre espaço para o novo.',
                'A mente focada realiza o impossível.',
                'A melhor forma de prever o futuro é construí-lo.',
                'A ação é o antídoto do medo.',
                'O aprendizado contínuo é a chave da evolução.',
                'A gestão eficiente transforma desafios em oportunidades.',
                'A confiança nasce da preparação.',
                'A simplicidade é o caminho da eficiência.',
                'O equilíbrio é a base da produtividade sustentável.',
                'A motivação é o combustível da realização.',
                'A humildade abre portas para o crescimento.',
                'A organização é a arte de dar lugar ao essencial.',
                'O sucesso é consequência de boas escolhas repetidas.',
                'A mente aberta aprende com cada experiência.',
                'A excelência é construída nos detalhes.',
                'A vida recompensa quem age com propósito.',
                'O segredo do progresso é começar.',
                'A gestão do tempo é a gestão da vida.',
                'A colaboração transforma metas em conquistas coletivas.',
                'A clareza de objetivos simplifica decisões.',
                'A disciplina diária constrói resultados extraordinários.',
                'A organização é o alicerce da liberdade criativa.',
                'A cada dia, uma nova chance de evoluir.',
                'O autoconhecimento potencializa a produtividade.',
                'A ação consistente supera a inspiração passageira.',
                'A mente tranquila produz melhores resultados.',
                'A gratidão multiplica conquistas.',
                'A coragem de mudar é o início de toda transformação.',
                'A vida é feita de ciclos: aprenda, evolua, recomece.',
                'A melhor versão de você está em construção.',
                'A organização é o segredo dos que realizam mais com menos.',
                'A persistência transforma obstáculos em degraus.',
                'A gestão inteligente é aquela que valoriza o tempo.',
                'A criatividade é filha da ordem.',
                'A excelência é fruto do hábito.',
                'A motivação se renova a cada conquista.',
                'A disciplina é liberdade.',
                'O planejamento é o mapa do sucesso.',
                'A ação transforma intenção em realização.',
                'A vida é curta demais para não ser organizada.',
                'A produtividade é amiga da simplicidade.',
                'A mente positiva encontra soluções.',
                'A organização é o caminho para a paz interior.',
                'A cada desafio, uma oportunidade de crescer.',
                'A gestão do tempo é a arte de priorizar o que importa.',
                'A realização começa com um passo.',
                'A clareza mental é o melhor presente que você pode se dar.',
                'A disciplina constrói o impossível.',
                'A organização é o segredo da leveza.',
                'A vida organizada é uma vida mais feliz.'
            ];
            shuffle($frases);
        @endphp
        <script>
            window.frasesMotivacionais = @json($frases);
        </script>
        <div class="w-full fixed left-0 top-14 z-40 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 py-1 sm:py-2 flex justify-center items-center shadow-sm min-w-0" style="z-index: 40;">
            <span id="frase-motivacional" class="w-full text-xs sm:text-sm text-gray-700 dark:text-gray-200 italic text-center max-w-full select-none block overflow-hidden whitespace-nowrap min-w-0"> </span>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const frases = window.frasesMotivacionais;
                const el = document.getElementById('frase-motivacional');
                let fraseIndex = 0;
                let charIndex = 0;
                let typing = true;

                function typeWriter(frase, i = 0) {
                    if (i <= frase.length) {
                        el.textContent = frase.slice(0, i);
                        setTimeout(() => typeWriter(frase, i + 1), 30);
                    } else {
                        typing = false;
                        setTimeout(() => eraseWriter(frase), 2500);
                    }
                }

                function eraseWriter(frase, i = null) {
                    if (i === null) i = frase.length;
                    if (i >= 0) {
                        el.textContent = frase.slice(0, i);
                        setTimeout(() => eraseWriter(frase, i - 1), 10);
                    } else {
                        fraseIndex = (fraseIndex + 1) % frases.length;
                        typing = true;
                        setTimeout(() => typeWriter(frases[fraseIndex]), 300);
                    }
                }

                // Iniciar animação
                typeWriter(frases[fraseIndex]);
            });
        </script>

        <!-- Fim do novo header -->
        <div class="pt-24">
        <div class="flex min-h-screen w-full">
            <!-- Incluir bottom navigation -->
            @component('components.bottom-navigation')
            @endcomponent
            
            <!-- Conteúdo principal -->
            <div class="flex-1 flex flex-col bg-white dark:bg-[#0d1117] min-h-screen p-0 m-0 relative z-10">
                <main class="flex-1 w-full max-w-full overflow-x-auto pb-16 md:pb-0">
                    @yield('content')
                </main>
            </div>
        </div>
        </div>
        <script>
        function setTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
        }
        window.onload = function() {
            const saved = localStorage.getItem('theme') || 'dark';
            setTheme(saved);
        };
        // Registrar o service worker para PWA
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js');
        }
        
        // Garantir que a navegação bottom funcione corretamente em produção
        document.addEventListener('DOMContentLoaded', function() {
            const bottomNav = document.querySelector('nav.fixed.bottom-0');
            if (bottomNav) {
                // Forçar o posicionamento correto
                bottomNav.style.position = 'fixed';
                bottomNav.style.bottom = '0';
                bottomNav.style.left = '0';
                bottomNav.style.right = '0';
                bottomNav.style.zIndex = '9999';
                bottomNav.style.top = 'auto';
                
                // Verificar periodicamente se o posicionamento está correto
                setInterval(function() {
                    if (bottomNav.style.position !== 'fixed' || bottomNav.style.bottom !== '0px') {
                        bottomNav.style.position = 'fixed';
                        bottomNav.style.bottom = '0';
                        bottomNav.style.left = '0';
                        bottomNav.style.right = '0';
                        bottomNav.style.zIndex = '9999';
                        bottomNav.style.top = 'auto';
                    }
                }, 1000);
            }
            
            // Garantir que a logo do header fique centralizada em produção
            const headerLogo = document.querySelector('header .absolute.left-1\\/2.top-1\\/2');
            if (headerLogo) {
                // Forçar o posicionamento correto da logo
                headerLogo.style.position = 'absolute';
                headerLogo.style.left = '50%';
                headerLogo.style.top = '50%';
                headerLogo.style.transform = 'translate(-50%, -50%)';
                headerLogo.style.zIndex = '5';
                
                // Verificar periodicamente se o posicionamento está correto
                setInterval(function() {
                    if (headerLogo.style.position !== 'absolute' || headerLogo.style.left !== '50%') {
                        headerLogo.style.position = 'absolute';
                        headerLogo.style.left = '50%';
                        headerLogo.style.top = '50%';
                        headerLogo.style.transform = 'translate(-50%, -50%)';
                        headerLogo.style.zIndex = '5';
                    }
                }, 1000);
            }
            
            // Garantir que o dropdown de notificações seja posicionado corretamente em produção
            const notificationDropdown = document.getElementById('notification-dropdown');
            const notificationBell = document.getElementById('notification-bell');
            
            if (notificationDropdown) {
                // Forçar o posicionamento correto do dropdown
                notificationDropdown.style.position = 'fixed';
                notificationDropdown.style.top = '4rem';
                notificationDropdown.style.left = '0.5rem';
                notificationDropdown.style.width = '20rem';
                notificationDropdown.style.maxHeight = '24rem';
                notificationDropdown.style.zIndex = '9998';
                notificationDropdown.style.marginTop = '0.5rem';
                
                // Verificar periodicamente se o posicionamento está correto
                setInterval(function() {
                    if (notificationDropdown.style.position !== 'fixed' || notificationDropdown.style.top !== '4rem') {
                        notificationDropdown.style.position = 'fixed';
                        notificationDropdown.style.top = '4rem';
                        notificationDropdown.style.left = '0.5rem';
                        notificationDropdown.style.width = '20rem';
                        notificationDropdown.style.maxHeight = '24rem';
                        notificationDropdown.style.zIndex = '9998';
                        notificationDropdown.style.marginTop = '0.5rem';
                    }
                }, 1000);
            }
            
            if (notificationBell) {
                // Forçar o z-index correto do sino
                notificationBell.style.zIndex = '9999';
                notificationBell.style.position = 'relative';
                
                // Verificar periodicamente se o z-index está correto
                setInterval(function() {
                    if (notificationBell.style.zIndex !== '9999') {
                        notificationBell.style.zIndex = '9999';
                        notificationBell.style.position = 'relative';
                    }
                }, 1000);
            }
        });
        
        // Toggle da sidebar lateral
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.querySelector('aside');
            const mainContent = document.querySelector('.md\\:ml-64');
            
            if (sidebarToggle && sidebar && mainContent) {
                sidebarToggle.addEventListener('click', function() {
                    const isCollapsed = sidebar.classList.contains('collapsed');
                    
                    if (isCollapsed) {
                        // Expandir sidebar
                        sidebar.classList.remove('collapsed');
                        sidebar.style.width = '16rem'; // w-64
                        mainContent.classList.add('md:ml-64');
                        mainContent.classList.remove('md:ml-16');
                        sidebarToggle.querySelector('i').className = 'fa-solid fa-bars text-lg';
                    } else {
                        // Comprimir sidebar
                        sidebar.classList.add('collapsed');
                        sidebar.style.width = '4rem'; // w-16
                        mainContent.classList.remove('md:ml-64');
                        mainContent.classList.add('md:ml-16');
                        sidebarToggle.querySelector('i').className = 'fa-solid fa-chevron-right text-lg';
                    }
                });
            }
        });
        </script>
        @stack('scripts')
        <script src="https://unpkg.com/alpinejs" defer></script>
        <!-- Notificações -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const bell = document.getElementById('notification-bell');
                const dropdown = document.getElementById('notification-dropdown');
                const countSpan = document.getElementById('notification-count');
                const list = document.getElementById('notification-list');
                const markAllBtn = document.getElementById('mark-all-read');
                let open = false;

                async function fetchNotifications() {
                    try {
                        const res = await fetch('/notifications');
                        if (!res.ok) return;
                        const data = await res.json();
                        // Atualiza contador
                        if (data.unread_count > 0) {
                            countSpan.textContent = data.unread_count;
                            countSpan.classList.remove('hidden');
                        } else {
                            countSpan.classList.add('hidden');
                        }
                        // Lista notificações
                        list.innerHTML = '';
                        if (data.notifications.length === 0) {
                            list.innerHTML = '<li class="p-3 text-gray-400 text-sm">Sem notificações.</li>';
                        } else {
                            data.notifications.forEach(n => {
                                const li = document.createElement('li');
                                li.className = 'flex items-start gap-2 p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition';
                                li.innerHTML = `
                                    <div class="mt-1"><i class="fa-solid fa-${n.data.icon || 'bell'} text-lg ${n.read_at ? 'text-gray-300 dark:text-gray-600' : 'text-blue-500'}"></i></div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-gray-800 dark:text-gray-100 text-sm">${n.data.title || 'Notificação'}</div>
                                        <div class="text-xs text-gray-600 dark:text-gray-300">${n.data.message || ''}</div>
                                        <div class="text-[10px] text-gray-400 mt-1">${new Date(n.created_at).toLocaleString('pt-BR')}</div>
                                    </div>
                                    <div class="flex flex-col gap-1 items-end">
                                        ${!n.read_at ? `<button class="text-xs text-blue-600 hover:underline mark-read-btn" data-id="${n.id}">Marcar como lida</button>` : ''}
                                        <button class="text-xs text-red-500 hover:underline delete-btn" data-id="${n.id}">Excluir</button>
                                    </div>
                                `;
                                list.appendChild(li);
                            });
                        }
                    } catch (e) {}
                }

                // Dropdown toggle
                bell.addEventListener('click', function(e) {
                    e.stopPropagation();
                    open = !open;
                    dropdown.classList.toggle('hidden', !open);
                    if (open) fetchNotifications();
                });
                document.addEventListener('click', function() {
                    dropdown.classList.add('hidden');
                    open = false;
                });
                dropdown.addEventListener('click', e => e.stopPropagation());

                // Marcar como lida
                list.addEventListener('click', async function(e) {
                    if (e.target.classList.contains('mark-read-btn')) {
                        const id = e.target.dataset.id;
                        await fetch(`/notifications/${id}/mark-as-read`, {method: 'POST', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}});
                        fetchNotifications();
                    }
                    if (e.target.classList.contains('delete-btn')) {
                        const id = e.target.dataset.id;
                        await fetch(`/notifications/${id}`, {method: 'DELETE', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}});
                        fetchNotifications();
                    }
                });
                // Marcar todas como lidas
                markAllBtn.addEventListener('click', async function() {
                    await fetch('/notifications/mark-all-as-read', {method: 'POST', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}});
                    fetchNotifications();
                });
                // Atualização periódica
                setInterval(fetchNotifications, 30000);
                fetchNotifications();
            });
        </script>
    </body>
</html>
