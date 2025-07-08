@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800">
    <div class="container mx-auto px-4 py-8">
        <!-- Header com estatísticas -->
        <div class="mb-8">
            <div class="text-center mb-8 fade-in-up">
                <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-4">
                    Projetos Profissionais
                </h1>
                <p class="text-slate-600 dark:text-slate-300 text-lg max-w-2xl mx-auto">
                    Gerencie seus projetos profissionais com eficiência e organização.
                </p>
            </div>

            <!-- Cards de estatísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 fade-in-up" style="animation-delay: 0.1s;">
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total de Projetos</p>
                            <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $projects->total() }}</p>
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
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Em Andamento</p>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $projects->where('status', 'in_progress')->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Concluídos</p>
                            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $projects->where('status', 'completed')->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Urgentes</p>
                            <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $projects->where('priority', 'urgent')->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros e busca -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 mb-8 fade-in-up" style="animation-delay: 0.2s;">
            <form method="GET" action="{{ route('projetos.index') }}" class="flex flex-col lg:flex-row justify-between items-center gap-4">
                <div class="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                    <!-- Busca -->
                    <div class="relative w-full sm:w-80">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar projetos..." 
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
                            <option value="planning" {{ request('status') == 'planning' ? 'selected' : '' }}>Planejamento</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Em Andamento</option>
                            <option value="on_hold" {{ request('status') == 'on_hold' ? 'selected' : '' }}>Em Pausa</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Concluído</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
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

                    <!-- Filtro por cliente -->
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-slate-600 dark:text-slate-300">Cliente:</span>
                        <select name="client_id" class="border border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white transition-all duration-200">
                            <option value="">Todos</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
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
                    
                    <a href="{{ route('projetos.create') }}" 
                       class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg flex items-center space-x-2 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Novo Projeto</span>
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

        @if($projects->isEmpty())
            <!-- Estado vazio -->
            <div class="text-center py-16 fade-in-up" style="animation-delay: 0.3s;">
                <div class="w-24 h-24 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-2">Nenhum projeto encontrado</h3>
                <p class="text-slate-600 dark:text-slate-300 mb-6">Comece criando seu primeiro projeto profissional.</p>
                <a href="{{ route('projetos.create') }}" 
                   class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg transition-all duration-200 transform hover:scale-105">
                    Criar Projeto
                </a>
            </div>
        @else
            <!-- Grid de projetos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="projects-grid">
                @foreach($projects as $index => $project)
                    <div class="project-card bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden group hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 fade-in-up" 
                         data-status="{{ $project->status }}"
                         data-priority="{{ $project->priority }}"
                         data-client="{{ strtolower($project->client->name ?? '') }}"
                         style="animation-delay: {{ 0.3 + ($index * 0.1) }}s;">
                        
                        <!-- Header do card com gradiente baseado no status -->
                        <div class="relative h-32 bg-gradient-to-r {{ $project->status === 'completed' ? 'from-green-500 to-emerald-600' : ($project->status === 'in_progress' ? 'from-blue-500 to-purple-600' : ($project->status === 'on_hold' ? 'from-yellow-500 to-orange-600' : ($project->status === 'cancelled' ? 'from-red-500 to-pink-600' : 'from-slate-500 to-gray-600'))) }} flex items-center justify-center">
                            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center border-4 border-white/30">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            
                            <!-- Badges -->
                            <div class="absolute top-3 right-3 flex flex-col items-end space-y-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                           {{ $project->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : ($project->status === 'in_progress' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : ($project->status === 'on_hold' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : ($project->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300'))) }}">
                                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                           {{ $project->priority === 'urgent' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : ($project->priority === 'high' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400' : ($project->priority === 'medium' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400')) }}">
                                    {{ ucfirst($project->priority) }}
                                </span>
                            </div>
                        </div>

                        <!-- Conteúdo do card -->
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2">
                                {{ $project->name }}
                            </h3>
                            
                            <div class="space-y-2 text-sm text-slate-600 dark:text-slate-300 mb-4">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span class="truncate">{{ $project->client->name ?? 'Sem cliente' }}</span>
                                </div>
                                
                                @if($project->due_date)
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($project->due_date)->format('d/m/Y') }}</span>
                                    </div>
                                @endif
                                
                                @if($project->budget)
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        <span>R$ {{ number_format($project->budget, 2, ',', '.') }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Progresso do projeto -->
                            @if($project->tasks && $project->tasks->count() > 0)
                                @php
                                    $completedTasks = $project->tasks->where('status', 'completed')->count();
                                    $totalTasks = $project->tasks->count();
                                    $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
                                @endphp
                                <div class="mb-4">
                                    <div class="flex justify-between text-xs text-slate-500 dark:text-slate-400 mb-1">
                                        <span>Progresso</span>
                                        <span>{{ $completedTasks }}/{{ $totalTasks }}</span>
                                    </div>
                                    <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>
                            @endif

                            <!-- Botões de ação -->
                            <div class="flex space-x-2">
                                <a href="{{ route('projetos.show', $project) }}" 
                                   class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent text-sm font-medium rounded-xl text-blue-700 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:hover:bg-blue-900/50 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Ver
                                </a>
                                <a href="{{ route('projetos.edit', $project) }}" 
                                   class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent text-sm font-medium rounded-xl text-yellow-700 bg-yellow-100 hover:bg-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400 dark:hover:bg-yellow-900/50 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Editar
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginação -->
            @if($projects->hasPages())
                <div class="mt-8 flex justify-center fade-in-up" style="animation-delay: 0.4s;">
                    {{ $projects->appends(request()->query())->links() }}
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
// Filtros em tempo real (opcional - para melhorar a experiência)
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    const statusFilter = document.querySelector('select[name="status"]');
    const priorityFilter = document.querySelector('select[name="priority"]');
    const clientFilter = document.querySelector('select[name="client_id"]');
    
    // Auto-submit quando os filtros mudarem
    [statusFilter, priorityFilter, clientFilter].forEach(filter => {
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