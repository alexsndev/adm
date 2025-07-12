@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 py-8">
    <div class="max-w-4xl mx-auto px-2 sm:px-4 w-full">
        <!-- Header -->
        <div class="text-center mb-8 fade-in-up w-full flex flex-col items-center justify-center">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-4 w-full">Novo Projeto Profissional</h1>
            <p class="text-slate-600 dark:text-slate-300 text-base sm:text-lg max-w-2xl mx-auto w-full">Crie um novo projeto para gerenciar tarefas e acompanhar o progresso.</p>
        </div>

        <!-- Formulário -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden fade-in-up w-full" style="animation-delay: 0.1s;">
            <form action="{{ route('projetos.store') }}" method="POST" class="p-4 sm:p-8 w-full space-y-6">
                @csrf

                <!-- Informações Básicas -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Informações Básicas
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Cliente -->
                        <div>
                            <label for="client_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Cliente *
                            </label>
                            <select name="client_id" id="client_id" required
                                    class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white transition-all duration-200">
                                <option value="">Selecione o cliente</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nome do Projeto -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Nome do Projeto *
                            </label>
                            <input type="text" id="name" name="name" required
                                   class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200"
                                   placeholder="Digite o nome do projeto">
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
                            Descrição do Projeto
                        </label>
                        <textarea id="description" name="description" rows="4"
                                  class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200 resize-none"
                                  placeholder="Descreva o projeto em detalhes..."></textarea>
                    </div>
                </div>

                <!-- Datas -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Datas e Prazos
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Data de Início -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Data de Início
                            </label>
                            <input type="date" id="start_date" name="start_date"
                                   class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white transition-all duration-200">
                        </div>

                        <!-- Data de Término -->
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Data de Término
                            </label>
                            <input type="date" id="end_date" name="end_date"
                                   class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white transition-all duration-200">
                        </div>
                    </div>
                </div>

                <!-- Valores -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        Valores e Estimativas
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Taxa por Hora -->
                        <div>
                            <label for="hourly_rate" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Taxa por Hora (R$)
                            </label>
                            <input type="number" id="hourly_rate" name="hourly_rate" step="0.01" min="0"
                                   class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200"
                                   placeholder="0.00">
                        </div>

                        <!-- Horas Estimadas -->
                        <div>
                            <label for="estimated_hours" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Horas Estimadas
                            </label>
                            <input type="number" id="estimated_hours" name="estimated_hours" min="0"
                                   class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200"
                                   placeholder="0">
                        </div>
                    </div>
                </div>

                <!-- Notas -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Notas Adicionais
                    </h3>
                    
                    <div>
                        <label for="notes" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Notas
                        </label>
                        <textarea id="notes" name="notes" rows="3"
                                  class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200 resize-none"
                                  placeholder="Observações adicionais sobre o projeto..."></textarea>
                    </div>
                </div>

                <!-- Botões -->
                <div class="flex flex-col sm:flex-row justify-end items-center gap-4 pt-6 border-t border-slate-200 dark:border-slate-700">
                    <a href="{{ route('projetos.index') }}" 
                       class="w-full sm:w-auto px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-all duration-200 text-center">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-xl font-semibold shadow-lg transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Salvar Projeto
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