<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', config('app.description', 'Sistema de gerenciamento pessoal e financeiro'))">
    <meta name="keywords" content="@yield('meta_keywords', 'finanças, organização, metas, dívidas, eventos')">
    <meta name="author" content="@yield('meta_author', config('app.name', 'Laravel'))">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:title" content="@yield('meta_title', config('app.name', 'Laravel'))">
    <meta property="og:description" content="@yield('meta_description', config('app.description', 'Sistema de gerenciamento pessoal e financeiro'))">
    <meta property="og:image" content="@yield('meta_image', asset('images/og-image.jpg'))">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ request()->url() }}">
    <meta property="twitter:title" content="@yield('meta_title', config('app.name', 'Laravel'))">
    <meta property="twitter:description" content="@yield('meta_description', config('app.description', 'Sistema de gerenciamento pessoal e financeiro'))">
    <meta property="twitter:image" content="@yield('meta_image', asset('images/og-image.jpg'))">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    
    <!-- Preload Critical Resources -->
    <link rel="preload" href="{{ asset('fonts/inter-var.woff2') }}" as="font" type="font/woff2" crossorigin>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- External CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous">
    
    <!-- Custom Styles -->
    @stack('styles')
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Theme Script -->
    <script>
        // Check for saved theme preference or default to 'system'
        const theme = localStorage.getItem('theme') || 'system';
        const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        
        // Apply theme
        if (theme === 'dark' || (theme === 'system' && systemTheme === 'dark')) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 antialiased transition-colors duration-200">
    <!-- Skip to main content for accessibility -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-blue-600 text-white px-4 py-2 rounded-md z-50">
        Pular para o conteúdo principal
    </a>
    
    <!-- Loading Spinner -->
    <div id="loading-spinner" class="fixed inset-0 bg-white dark:bg-gray-900 z-50 flex items-center justify-center transition-opacity duration-300">
        <div class="animate-spin rounded-full h-32 w-32 border-b-2 border-blue-600"></div>
    </div>
    
    <!-- Main Layout -->
    <div id="app" class="h-full flex flex-col" x-data="appData()">
        @yield('content')
    </div>
    
    <!-- Scripts -->
    @stack('scripts')
    
    <!-- Loading Script -->
    <script>
        // Hide loading spinner when page is loaded
        window.addEventListener('load', function() {
            const spinner = document.getElementById('loading-spinner');
            if (spinner) {
                spinner.style.opacity = '0';
                setTimeout(() => spinner.style.display = 'none', 300);
            }
        });
        
        // Alpine.js data
        function appData() {
            return {
                sidebarOpen: false,
                theme: localStorage.getItem('theme') || 'system',
                
                toggleSidebar() {
                    this.sidebarOpen = !this.sidebarOpen;
                },
                
                setTheme(newTheme) {
                    this.theme = newTheme;
                    localStorage.setItem('theme', newTheme);
                    
                    if (newTheme === 'dark' || (newTheme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                },
                
                init() {
                    // Listen for system theme changes
                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                        if (this.theme === 'system') {
                            if (e.matches) {
                                document.documentElement.classList.add('dark');
                            } else {
                                document.documentElement.classList.remove('dark');
                            }
                        }
                    });
                }
            }
        }
    </script>
</body>
</html> 