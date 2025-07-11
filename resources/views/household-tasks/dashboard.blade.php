@extends('layouts.app')

@section('content')
<div class="w-full h-full min-h-screen bg-white dark:bg-[#0d1117]" style="box-sizing:border-box;">
    <div class="content-wrapper" style="max-width: 1200px; margin: 0 auto; padding: 0 24px;">
        <div class="w-full px-0 py-4 md:py-8" style="max-width:100%;">
            <!-- Header com estatísticas -->
            <div class="mb-8">
                <div class="text-center mb-8 fade-in-up">
                    <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-4">
                        Dashboard de Tarefas Domésticas
                    </h1>
                    <p class="text-slate-600 dark:text-slate-300 text-lg w-full">
                        Organize, acompanhe e otimize as tarefas do seu lar com visual moderno e profissional.
                    </p>
                </div>
                <!-- Cards de estatísticas -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 fade-in-up" style="animation-delay: 0.1s;">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total de Tarefas</p>
                                <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $stats['total'] }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Pendentes</p>
                                <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['pending'] }}</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Em Andamento</p>
                                <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['in_progress'] }}</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12l4-4 4 4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Concluídas</p>
                                <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $stats['completed'] }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Filtros e busca -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 mb-8 fade-in-up" style="animation-delay: 0.2s;">
                <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
                    <div class="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                        <!-- Busca -->
                        <div class="relative w-full sm:w-80">
                            <input type="text" id="search" placeholder="Buscar tarefas..." 
                                   class="w-full pl-10 pr-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200">
                            <svg class="absolute left-3 top-3.5 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <!-- Filtro por status -->
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-slate-600 dark:text-slate-300">Status:</span>
                            <select id="status-filter" class="border border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white transition-all duration-200">
                                <option value="">Todos</option>
                                <option value="pending">Pendente</option>
                                <option value="in_progress">Em Andamento</option>
                                <option value="completed">Concluída</option>
                            </select>
                        </div>
                        <!-- Filtro por prioridade -->
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-slate-600 dark:text-slate-300">Prioridade:</span>
                            <select id="priority-filter" class="border border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white transition-all duration-200">
                                <option value="">Todas</option>
                                <option value="low">Baixa</option>
                                <option value="medium">Média</option>
                                <option value="high">Alta</option>
                                <option value="urgent">Urgente</option>
                            </select>
                        </div>
                    </div>
                    <!-- Botão adicionar -->
                    <a href="{{ route('household-tasks.create') }}" 
                       class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg flex items-center space-x-2 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Nova Tarefa</span>
                    </a>
                </div>
            </div>
            @include('household-tasks._dashboard_sections', [
                'todayTasks' => $todayTasks,
                'overdueTasks' => $overdueTasks,
                'weekTasks' => $weekTasks,
                'stats' => $stats,
                'timeStats' => $timeStats
            ])
        </div>
    </div>
</div>
@endsection 