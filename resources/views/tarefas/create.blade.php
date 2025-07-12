@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 py-8">
    <div class="max-w-4xl mx-auto px-2 sm:px-4 w-full">
        <!-- Header -->
        <div class="text-center mb-8 fade-in-up w-full flex flex-col items-center justify-center">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-4 w-full">Nova Tarefa Profissional</h1>
            <p class="text-slate-600 dark:text-slate-300 text-base sm:text-lg max-w-2xl mx-auto w-full">Crie uma nova tarefa para organizar seu trabalho e acompanhar o progresso.</p>
        </div>

        <!-- Formulário -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden fade-in-up w-full" style="animation-delay: 0.1s;">
            <form action="{{ route('tarefas.store') }}" method="POST" class="p-4 sm:p-8 w-full space-y-6">
                @csrf

                @if(session('success'))
                    <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-400 px-4 py-3 rounded-xl mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Informações Básicas -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Informações Básicas
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Projeto -->
                        <div>
                            <label for="project_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Projeto *
                            </label>
                            <select name="project_id" id="project_id" required {{ isset($projectId) && $projectId ? 'readonly disabled' : '' }}
                                    class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white transition-all duration-200">
                                <option value="">Selecione o projeto</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ (old('project_id', $projectId ?? '') == $project->id) ? 'selected' : '' }}>{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Título da Tarefa -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Título da Tarefa *
                            </label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                   class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200"
                                   placeholder="Digite o título da tarefa">
                        </div>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Descrição
                    </h3>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Descrição da Tarefa
                        </label>
                        <textarea id="description" name="description" rows="4" value="{{ old('description') }}"
                                  class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200 resize-none"
                                  placeholder="Descreva a tarefa em detalhes...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <!-- Botões -->
                <div class="flex flex-col sm:flex-row justify-end items-center gap-4 pt-6 border-t border-slate-200 dark:border-slate-700">
                    <a href="{{ route('tarefas.index') }}" 
                       class="w-full sm:w-auto px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-all duration-200 text-center">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-xl font-semibold shadow-lg transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Criar Tarefa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.fade-in-up {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.6s ease-out forwards;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Dark mode transitions */
* {
    transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
}
</style>
@endsection 