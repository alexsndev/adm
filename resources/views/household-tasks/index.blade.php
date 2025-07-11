@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800">
    <div class="w-full px-0 py-8" style="max-width:100%;">
        <!-- Header com estatísticas -->
        <div class="mb-8">
            <div class="text-center mb-8 fade-in-up">
                <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-4">
                    Tarefas Domésticas
                </h1>
                <p class="text-slate-600 dark:text-slate-300 text-lg max-w-2xl mx-auto">
                    Organize seu lar com carinho e eficiência. Cada tarefa concluída é um passo para uma casa mais feliz! 💙
                </p>
            </div>

            <!-- Cards de estatísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 fade-in-up" style="animation-delay: 0.1s;">
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total de Tarefas</p>
                            <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $tasks->total() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Pendentes</p>
                            <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $tasks->where('status', 'pending')->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Em Andamento</p>
                            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $tasks->where('status', 'in_progress')->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Concluídas</p>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $tasks->where('status', 'completed')->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros e busca -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 mb-8 fade-in-up" style="animation-delay: 0.2s;">
            <form method="GET" action="{{ route('household-tasks.index') }}" class="flex flex-col lg:flex-row justify-between items-center gap-4">
                <div class="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                    <!-- Busca -->
                    <div class="relative w-full sm:w-80">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar tarefas..." 
                               class="w-full pl-10 pr-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200">
                        <svg class="absolute left-3 top-3.5 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <!-- Filtro por status -->
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-slate-600 dark:text-slate-300">Status:</span>
                        <select name="status" class="border border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white transition-all duration-200">
                            <option value="">Todos</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendente</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Em Andamento</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Concluída</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                    </div>

                    <!-- Filtro por prioridade -->
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-slate-600 dark:text-slate-300">Prioridade:</span>
                        <select name="priority" class="border border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white transition-all duration-200">
                            <option value="">Todas</option>
                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Baixa</option>
                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Média</option>
                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Alta</option>
                            <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgente</option>
                        </select>
                    </div>

                    <!-- Filtro por responsável -->
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-slate-600 dark:text-slate-300">Responsável:</span>
                        <select name="assigned_to" class="border border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white transition-all duration-200">
                            <option value="">Todos</option>
                            <option value="alexandre" {{ request('assigned_to') == 'alexandre' ? 'selected' : '' }}>Alexandre</option>
                            <option value="liza" {{ request('assigned_to') == 'liza' ? 'selected' : '' }}>Liza</option>
                            <option value="both" {{ request('assigned_to') == 'both' ? 'selected' : '' }}>Ambos</option>
                        </select>
                    </div>

                    <!-- Filtro por categoria -->
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-slate-600 dark:text-slate-300">Categoria:</span>
                        <select name="category_id" class="border border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white transition-all duration-200">
                            <option value="">Todas</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Botões de ação -->
                <div class="flex items-center space-x-3">
                    <button type="submit" 
                            class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg flex items-center space-x-2 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Filtrar</span>
                    </button>
                    
                    <a href="{{ route('household-tasks.create') }}" 
                       class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg flex items-center space-x-2 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Nova Tarefa</span>
                    </a>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-300 px-6 py-4 rounded-xl relative fade-in-up" role="alert" style="animation-delay: 0.3s;">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-300 px-6 py-4 rounded-xl relative fade-in-up" role="alert" style="animation-delay: 0.3s;">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if($tasks->isEmpty())
            <!-- Estado vazio -->
            <div class="text-center py-16 fade-in-up" style="animation-delay: 0.3s;">
                <div class="w-24 h-24 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-2">Nenhuma tarefa encontrada</h3>
                <p class="text-slate-600 dark:text-slate-300 mb-6">Comece criando sua primeira tarefa doméstica para organizar seu lar.</p>
                <a href="{{ route('household-tasks.create') }}" 
                   class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg transition-all duration-200 transform hover:scale-105">
                    Criar Tarefa
                </a>
            </div>
        @else
            <!-- Layout Kanban -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8 fade-in-up" style="animation-delay: 0.3s;">
                @php
                    $statusList = [
                        'pending' => ['name' => 'Pendente', 'color' => 'yellow', 'icon' => 'clock'],
                        'in_progress' => ['name' => 'Em Andamento', 'color' => 'blue', 'icon' => 'play'],
                        'completed' => ['name' => 'Concluída', 'color' => 'green', 'icon' => 'check'],
                    ];
                @endphp

                @foreach($statusList as $statusKey => $statusInfo)
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                        <!-- Header da coluna -->
                        <div class="bg-gradient-to-r from-{{ $statusInfo['color'] }}-500 to-{{ $statusInfo['color'] }}-600 p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($statusInfo['icon'] == 'clock')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        @elseif($statusInfo['icon'] == 'play')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        @elseif($statusInfo['icon'] == 'check')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        @endif
                                    </svg>
                                    <h3 class="text-lg font-semibold text-white">{{ $statusInfo['name'] }}</h3>
                                </div>
                                <span class="bg-white/20 text-white text-sm font-medium px-2 py-1 rounded-full">
                                    {{ $tasks->where('status', $statusKey)->count() }}
                                </span>
                            </div>
                        </div>

                        <!-- Lista de tarefas -->
                        <div class="p-4 space-y-4 max-h-96 overflow-y-auto">
                            @php $filtered = $tasks->where('status', $statusKey); @endphp
                            @forelse($filtered as $task)
                                <div class="task-card bg-slate-50 dark:bg-slate-700 rounded-xl p-4 hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1 fade-in-up" 
                                     data-status="{{ $task->status }}"
                                     data-priority="{{ $task->priority }}"
                                     data-assigned="{{ $task->assigned_to }}"
                                     data-category="{{ $task->task_category_id }}"
                                     style="animation-delay: {{ 0.4 + ($loop->index * 0.1) }}s;">
                                    
                                    <!-- Cabeçalho da tarefa -->
                                    <div class="flex items-start justify-between mb-3">
                                        <h4 class="font-semibold text-slate-900 dark:text-white text-sm line-clamp-2">{{ $task->title }}</h4>
                                        <div class="flex space-x-1">
                                            @if($task->taskCategory)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                    @if($task->taskCategory->icon)
                                                        <i class="{{ $task->taskCategory->icon }} mr-1"></i>
                                                    @endif
                                                    {{ $task->taskCategory->name }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Descrição -->
                                    @if($task->description)
                                        <p class="text-xs text-slate-600 dark:text-slate-300 mb-3 line-clamp-2">{{ $task->description }}</p>
                                    @endif

                                    <!-- Informações da tarefa -->
                                    <div class="space-y-2 mb-3">
                                        <!-- Responsável -->
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <span class="text-xs text-slate-600 dark:text-slate-300">{{ $task->assigned_to_text }}</span>
                                        </div>

                                        <!-- Prioridade -->
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                                       {{ $task->priority === 'urgent' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : ($task->priority === 'high' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400' : ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400')) }}">
                                                {{ ucfirst($task->priority) }}
                                            </span>
                                        </div>

                                        <!-- Data de vencimento -->
                                        @if($task->due_date)
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <span class="text-xs {{ $task->is_overdue ? 'text-red-600 dark:text-red-400 font-semibold' : ($task->due_date->isToday() ? 'text-orange-600 dark:text-orange-400 font-semibold' : 'text-slate-600 dark:text-slate-300') }}">
                                                    {{ $task->due_date->format('d/m/Y') }}
                                                    @if($task->is_overdue)
                                                        (Atrasada)
                                                    @elseif($task->due_date->isToday())
                                                        (Vence hoje)
                                                    @endif
                                                </span>
                                            </div>
                                        @endif

                                        <!-- Tempo estimado -->
                                        @if($task->estimated_minutes)
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="text-xs text-slate-600 dark:text-slate-300">{{ $task->estimated_minutes }} min</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Botões de ação -->
                                    <div class="flex space-x-2">
                                        <a href="{{ route('household-tasks.show', $task) }}" 
                                           class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent text-xs font-medium rounded-lg text-blue-700 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 transition-all duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Ver
                                        </a>
                                        <a href="{{ route('household-tasks.edit', $task) }}" 
                                           class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent text-xs font-medium rounded-lg text-yellow-700 bg-yellow-100 hover:bg-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400 dark:hover:bg-yellow-900/50 transition-all duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Editar
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-slate-400 dark:text-slate-500">
                                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm">Nenhuma tarefa {{ strtolower($statusInfo['name']) }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Tarefas Canceladas -->
            @php $canceladas = $tasks->where('status', 'cancelled'); @endphp
            @if($canceladas->count() > 0)
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden fade-in-up" style="animation-delay: 0.4s;">
                    <div class="bg-gradient-to-r from-red-500 to-red-600 p-4">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-white">Canceladas</h3>
                            <span class="bg-white/20 text-white text-sm font-medium px-2 py-1 rounded-full">{{ $canceladas->count() }}</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($canceladas as $task)
                                <div class="bg-red-50 dark:bg-slate-700 border border-red-200 dark:border-slate-600 rounded-xl p-4">
                                    <h4 class="font-semibold text-slate-900 dark:text-white text-sm mb-2">{{ $task->title }}</h4>
                                    @if($task->description)
                                        <p class="text-xs text-slate-600 dark:text-slate-300 mb-3 line-clamp-2">{{ $task->description }}</p>
                                    @endif
                                    <div class="flex space-x-2">
                                        <a href="{{ route('household-tasks.show', $task) }}" 
                                           class="inline-flex items-center px-3 py-1 bg-blue-500 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition-all duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Ver
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Paginação -->
            @if($tasks->hasPages())
                <div class="mt-8 flex justify-center fade-in-up" style="animation-delay: 0.5s;">
                    {{ $tasks->appends(request()->query())->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

@endsection

@push('styles')
<style>
.fade-in-up {
    animation: fadeInUp 0.6s ease-out forwards;
    opacity: 0;
    transform: translateY(30px);
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
}

.pagination > * {
    padding: 0.5rem 1rem;
    border-radius: 0.75rem;
    text-decoration: none;
    transition: all 0.2s;
}

.pagination .page-link {
    background-color: white;
    color: #64748b;
    border: 1px solid #e2e8f0;
}

.pagination .page-link:hover {
    background-color: #f1f5f9;
    color: #475569;
}

.pagination .active {
    background: linear-gradient(to right, #2563eb, #7c3aed);
    color: white;
    border: none;
}

.dark .pagination .page-link {
    background-color: #1e293b;
    color: #cbd5e1;
    border: 1px solid #475569;
}

.dark .pagination .page-link:hover {
    background-color: #334155;
    color: #e2e8f0;
}
</style>
@endpush

@push('scripts')
<script>
// Filtros em tempo real
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    const statusFilter = document.querySelector('select[name="status"]');
    const priorityFilter = document.querySelector('select[name="priority"]');
    const assignedFilter = document.querySelector('select[name="assigned_to"]');
    const categoryFilter = document.querySelector('select[name="category_id"]');
    
    // Auto-submit quando os filtros mudarem
    [statusFilter, priorityFilter, assignedFilter, categoryFilter].forEach(filter => {
        if (filter) {
            filter.addEventListener('change', function() {
                this.closest('form').submit();
            });
        }
    });
    
    // Debounce para busca
    let searchTimeout;
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.closest('form').submit();
            }, 500);
        });
    }
});
</script>
@endpush 