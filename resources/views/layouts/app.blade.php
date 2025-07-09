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
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 overflow-x-hidden">
        <!-- Header ultra responsivo -->
        <header class="w-full fixed top-0 left-0 z-50 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 shadow-sm h-14 flex items-center justify-between px-2 sm:px-6">
            <!-- Sino à esquerda -->
            <div class="flex items-center min-w-[40px] justify-start z-10">
                <div id="notification-bell" class="relative cursor-pointer min-w-0">
                    <i class="fa-solid fa-bell text-base sm:text-2xl text-gray-400 dark:text-gray-500 hover:text-blue-500 transition-colors"></i>
                    <span id="notification-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-0.5 py-0.5 hidden"></span>
                    <div id="notification-dropdown" class="hidden absolute left-0 mt-2 max-w-[95vw] sm:max-w-[400px] w-full sm:w-auto bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-50">
                        <div class="p-2 sm:p-3 border-b border-gray-100 dark:border-gray-700 font-semibold text-gray-700 dark:text-gray-200">Notificações</div>
                        <ul id="notification-list" class="max-h-80 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-700"></ul>
                        <div class="flex justify-between items-center p-1 sm:p-2">
                            <button id="mark-all-read" class="text-xs text-blue-600 hover:underline">Marcar todas como lidas</button>
                            <a href="/notifications" class="text-xs text-gray-500 hover:underline">Ver todas</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Logo centralizada absoluta, largura máxima e truncamento -->
            <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 flex items-center justify-center pointer-events-none w-[calc(100vw-96px)] max-w-[160px] sm:max-w-[220px]">
                @if(Auth::user()->logo)
                    <img src="{{ Storage::url(Auth::user()->logo) }}" alt="Logo" class="h-7 w-auto rounded shadow max-w-full object-contain mx-auto">
                @else
                    <span class="text-base font-extrabold tracking-tight text-gray-900 dark:text-white select-none truncate max-w-full block text-center">Alexandre <span class="text-blue-500">e</span> Liza <span class="text-blue-500">Gestão</span></span>
                @endif
            </div>
            <!-- Avatar à direita -->
            <div class="flex items-center min-w-[40px] justify-end z-10">
                <a href="{{ route('profile.edit') }}" class="flex items-center min-w-0">
                    @if(Auth::user()->photo)
                        <img src="{{ Storage::url(Auth::user()->photo) }}" alt="Foto de perfil" class="w-7 h-7 sm:w-10 sm:h-10 rounded-full object-cover border-2 border-blue-200 dark:border-blue-700 shadow">
                    @else
                        <span class="inline-flex items-center justify-center w-7 h-7 sm:w-10 sm:h-10 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 font-bold text-xs sm:text-lg">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    @endif
                </a>
            </div>
        </header>
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
        <div class="w-full fixed left-0 top-16 z-40 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 py-1 sm:py-2 flex justify-center items-center shadow-sm min-w-0">
            <span id="frase-motivacional" class="w-full text-xs sm:text-sm text-gray-700 dark:text-gray-200 italic text-center max-w-full select-none block overflow-hidden whitespace-nowrap min-w-0"> </span>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const frases = @json($frases);
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
        <!-- Menu mobile dropdown (simples exemplo) -->
        <div id="mobile-menu" class="hidden fixed top-16 left-0 w-full bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 shadow-md z-40 md:hidden">
            <nav class="flex flex-col space-y-2 p-4">
                <a href="/" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition">Dashboard</a>
                <a href="/accounts" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition">Contas</a>
                <a href="/transactions" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition">Transações</a>
                <a href="/projects" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition">Projetos</a>
            </nav>
        </div>
        <script>
            // Script simples para abrir/fechar menu mobile
            document.addEventListener('DOMContentLoaded', function() {
                const btn = document.getElementById('mobile-menu-button');
                const menu = document.getElementById('mobile-menu');
                btn.addEventListener('click', function() {
                    menu.classList.toggle('hidden');
                });
            });
        </script>
        <!-- Fim do novo header -->
        <div class="pt-32">
        <div x-data="{ sidebarOpen: false, open: '' }" class="flex min-h-screen w-full">
            <!-- Sidebar sempre visível, nunca fixed -->
            <aside :class="sidebarOpen ? 'w-64' : 'w-10'" class="relative border-r border-gray-200 dark:border-[#21262d] flex flex-col transition-all duration-200 ease-in-out animated-gradient-sidebar">
                <!-- Botão de expandir/comprimir -->
                <button @click="sidebarOpen = !sidebarOpen"
                    :class="!sidebarOpen ? 'animate-pulse-arrow' : ''"
                    class="absolute top-2 right-2 z-20 bg-gray-100 dark:bg-[#161b22] rounded-full p-1 shadow-md focus:outline-none mb-4 transition-all">
                    <i :class="sidebarOpen ? 'fa-solid fa-chevron-left' : 'fa-solid fa-chevron-right'" class="text-gray-700 dark:text-gray-200"></i>
                </button>
                <!-- Espaço extra antes do menu -->
                <nav class="flex-1 py-6 space-y-1 mt-6">
                    <div>
                        @include('layouts.navigation-items')
                    </div>
                </nav>
                <div class="mt-auto px-2 md:px-4 py-4 border-t border-gray-200 dark:border-[#21262d]" x-show="sidebarOpen">
                    <div class="flex items-center space-x-3">
                        @if(Auth::user()->photo)
                            <img src="{{ Storage::url(Auth::user()->photo) }}" alt="Foto de perfil" class="w-10 h-10 rounded-full object-cover border-2 border-blue-200 dark:border-blue-700">
                        @else
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        @endif
                        <div class="flex-1 min-w-0">
                            <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-400 hover:text-red-600 dark:hover:text-red-400" title="Sair">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>
            <!-- Conteúdo principal -->
            <div class="flex-1 flex flex-col bg-white dark:bg-[#0d1117] min-h-screen p-0 m-0 relative z-10">
                <main class="flex-1 w-full max-w-full overflow-x-auto">
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
