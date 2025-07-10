<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-x-hidden">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/frases-motivacionais.css">
    <link rel="stylesheet" href="/css/bottom-navigation.css">
    <link rel="stylesheet" href="/css/notifications.css">
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 overflow-x-hidden">
    @component('components.header') @endcomponent

    @php
        $frases = [
            'O sucesso é a soma de pequenos esforços repetidos todos os dias.',
            'A disciplina é a ponte entre metas e realizações.',
            'A persistência realiza o impossível.',
            'A melhor maneira de prever o futuro é criá-lo.',
            'A excelência é um hábito, não um ato.',
        ];
        shuffle($frases);
    @endphp
    <script>
        window.frasesMotivacionais = @json($frases);
    </script>
    <div class="w-full fixed left-0 top-14 z-40 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 py-1 sm:py-2 flex justify-center items-center shadow-sm min-w-0 barra-motivacional" style="z-index: 40;">
        <span id="frase-motivacional" class="w-full text-xs sm:text-sm text-gray-700 dark:text-gray-200 italic text-center max-w-full select-none block overflow-hidden whitespace-nowrap min-w-0">
            {{ $frases[0] ?? 'Tenha um ótimo dia!' }}
        </span>
    </div>

    <div class="main-content-padding">
        <div class="flex min-h-screen w-full">
            @component('components.bottom-navigation') @endcomponent
            <div class="flex-1 flex flex-col bg-white dark:bg-[#0d1117] min-h-screen p-0 m-0 relative z-10">
                <main class="flex-1 w-full max-w-full overflow-x-auto pb-16 md:pb-0">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    <script src="/js/frase-motivacional.js"></script>
</body>
</html>
