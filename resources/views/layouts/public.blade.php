@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col">
    <header class="w-full py-4 px-6 bg-white dark:bg-gray-800 shadow">
        <div class="flex items-center justify-between max-w-7xl mx-auto">
            <a href="/" class="flex items-center space-x-3">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600">
                    <i class="fa-solid fa-chart-line text-white text-sm"></i>
                </div>
                <span class="text-xl font-bold text-gray-900 dark:text-gray-100">
                    {{ config('app.name', 'Laravel') }}
                </span>
            </a>
            <nav class="flex items-center space-x-6">
                <a href="/login" class="text-blue-600 dark:text-blue-400 hover:underline">Entrar</a>
                <a href="/register" class="text-gray-700 dark:text-gray-300 hover:underline">Registrar</a>
            </nav>
        </div>
    </header>
    <main id="main-content" class="flex-1 flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
        @yield('main_content')
    </main>
    <footer class="w-full py-4 px-6 bg-gray-100 dark:bg-gray-900 text-center text-sm text-gray-500 dark:text-gray-400">
        &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Todos os direitos reservados.
    </footer>
</div>
@endsection 