<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{ $title ?? 'Dashboard' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50">
        <!-- Header - Always visible on desktop, hidden on mobile -->
        @include('components.header')
        
        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Page Content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
        </main>
        
        <!-- Bottom Navigation - Only on mobile -->
        @include('components.bottom-nav')
    </div>

    <style>
    /* Layout Styles */
    body {
        margin: 0;
        padding: 0;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: #f9fafb;
        color: #1f2937;
    }
    
    .min-h-screen {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }
    
    /* Main Content Area */
    .main-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        /* Reserve space for header on desktop */
        margin-top: 70px;
    }
    
    .content-wrapper {
        flex: 1;
        padding: 24px;
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
        box-sizing: border-box;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .main-content {
            margin-top: 0; /* No header on mobile */
            padding-bottom: 80px; /* Reserve space for bottom nav */
        }
        
        .content-wrapper {
            padding: 16px;
        }
    }
    
    @media (max-width: 480px) {
        .content-wrapper {
            padding: 12px;
        }
    }
    
    /* Ensure content is never hidden */
    .content-wrapper > * {
        position: relative;
        z-index: 1;
    }
    
    /* Page transitions */
    .content-wrapper {
        animation: fadeIn 0.3s ease-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Scrollbar styling */
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    /* Print styles */
    @media print {
        .main-header,
        .bottom-nav {
            display: none !important;
        }
        
        .main-content {
            margin-top: 0 !important;
            padding-bottom: 0 !important;
        }
        
        .content-wrapper {
            padding: 0 !important;
        }
    }
    </style>

    <script>
    // Layout initialization
    document.addEventListener('DOMContentLoaded', function() {
        // Ensure proper spacing
        const header = document.querySelector('.main-header');
        const mainContent = document.querySelector('.main-content');
        
        if (header && mainContent) {
            // Adjust content margin based on header visibility
            function adjustLayout() {
                if (window.innerWidth > 768) {
                    // Desktop: header is visible
                    mainContent.style.marginTop = '70px';
                    mainContent.style.paddingBottom = '0';
                } else {
                    // Mobile: header is hidden, bottom nav is visible
                    mainContent.style.marginTop = '0';
                    mainContent.style.paddingBottom = '80px';
                }
            }
            
            // Initial adjustment
            adjustLayout();
            
            // Adjust on window resize
            window.addEventListener('resize', adjustLayout);
        }
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Add loading state
        document.body.classList.add('loaded');
    });
    
    // Handle page transitions
    window.addEventListener('beforeunload', function() {
        document.body.classList.add('unloading');
    });
    </script>
</body>
</html>
