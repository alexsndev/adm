@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700 dark:from-gray-900 dark:via-gray-800 dark:to-gray-700 p-4">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-8 max-w-lg w-full flex flex-col items-center border border-blue-200 dark:border-gray-800">
        <h1 class="text-3xl font-bold text-blue-700 dark:text-blue-300 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-shield-halved text-blue-500"></i> Painel Administrativo
        </h1>
        <p class="text-gray-700 dark:text-gray-300 text-center mb-6">Bem-vindo! Apenas administradores podem ver esta página.</p>
        <div class="flex flex-col gap-4 w-full">
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow transition text-center justify-center">
                <i class="fa-solid fa-users-cog"></i> Gerenciar Usuários
            </a>
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-gray-200 hover:bg-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-200 font-semibold shadow transition text-center justify-center">
                <i class="fa-solid fa-chart-line"></i> Voltar ao Dashboard
            </a>
        </div>
    </div>
</div>
@endsection 