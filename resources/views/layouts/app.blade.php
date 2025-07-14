<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-x-hidden" x-data="{ sidebarOpen: true }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="theme-color" content="#18181b">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    <!-- FontAwesome 6.5.0 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Fallback para produção sem Vite -->
        <script type="module" src="https://unpkg.com/vite@5/dist/vite.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2/dist/tailwind.min.css">
    @endif
    <link rel="stylesheet" href="/css/frases-motivacionais.css">
    <link rel="stylesheet" href="/css/notifications.css">
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css">
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.bubble.css">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    @stack('styles')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="manifest" href="/manifest.json">
</head>
<body class="font-sans antialiased bg-gray-900 text-gray-100 overflow-x-hidden min-h-screen w-full">
    <header class="px-4 md:px-8 py-2 bg-gray-950">
        @include('components.layout.header')
    </header>
    <div class="flex w-full min-h-screen px-2 md:px-8">
        @include('components.side-nav')
        <main id="main-content" class="flex-1 w-full max-w-7xl min-h-screen flex flex-col bg-[#0d1117] p-4 md:p-8 m-0 relative z-10 transition-all duration-200" style="margin-left:220px;">
            <main class="flex-1 w-full max-w-full overflow-x-auto pb-16 md:pb-0">
                @yield('content')
            </main>
        </main>
    </div>
    <div class="md:hidden">
        @include('components.bottom-nav')
    </div>
    <button id="pwa-install-btn" style="display:none; position:fixed; bottom:24px; right:24px; z-index:9999; background:#2563eb; color:#fff; border:none; border-radius:8px; padding:12px 20px; font-size:1rem; box-shadow:0 2px 8px rgba(0,0,0,0.15);">
        Instalar App
    </button>
    <script>
    let deferredPrompt;
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        const installBtn = document.getElementById('pwa-install-btn');
        if (installBtn) {
            installBtn.style.display = 'block';
            installBtn.onclick = function() {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        installBtn.style.display = 'none';
                    }
                    deferredPrompt = null;
                });
            };
        }
    });
    </script>
    <script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/service-worker.js');
    }
    </script>
    <script>
    // Ajusta o margin-left do main-content conforme a sidebar
    (function() {
        var sidebar = document.getElementById('side-nav');
        var main = document.getElementById('main-content');
        function updateMainMargin() {
            if (window.innerWidth < 768) {
                main.style.marginLeft = '0';
                return;
            }
            if (sidebar.classList.contains('collapsed')) {
                main.style.marginLeft = '56px';
            } else {
                main.style.marginLeft = '220px';
            }
        }
        // Integrar com toggleSidebar global
        var oldToggleSidebar = window.toggleSidebar;
        window.toggleSidebar = function() {
            if (typeof oldToggleSidebar === 'function') oldToggleSidebar();
            updateMainMargin();
        };

        // Atualiza ao redimensionar
        window.addEventListener('resize', updateMainMargin);
        // Inicial
        updateMainMargin();
    })();
    </script>
    @stack('scripts')
    @yield('after_content')
</body>
</html>
