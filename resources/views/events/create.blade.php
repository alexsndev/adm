@extends('layouts.app')

@section('content')
    <div class="py-8 bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                            <i class="fa-solid fa-plus-circle text-green-600 mr-3"></i>
                            Criar Novo Evento
                        </h1>
                        <p class="text-gray-600 dark:text-gray-300">Preencha as informações abaixo para criar seu evento</p>
                    </div>
                    <a href="{{ route('events.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-all duration-200">
                        <i class="fa-solid fa-arrow-left mr-2"></i>
                        Voltar
                    </a>
                </div>
            </div>

            <!-- Formulário -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <form method="POST" action="{{ route('events.store') }}" id="event-form">
                    @csrf
                    
                    <div class="p-8">
                        <!-- Informações Básicas -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fa-solid fa-info-circle text-blue-500 mr-2"></i>
                                Informações Básicas
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Título -->
                                <div class="md:col-span-2">
                                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fa-solid fa-heading mr-1"></i>
                                        Título do Evento *
                                    </label>
                                    <input type="text" id="title" name="title" 
                                           class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                           value="{{ old('title') }}" required autofocus
                                           placeholder="Ex: Aniversário da Maria">
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Descrição -->
                                <div class="md:col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fa-solid fa-align-left mr-1"></i>
                                        Descrição
                                    </label>
                                    <textarea id="description" name="description" rows="4" 
                                              class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                              placeholder="Descreva detalhes sobre o evento...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tipo -->
                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fa-solid fa-tag mr-1"></i>
                                        Tipo de Evento *
                                    </label>
                                    <select id="type" name="type" 
                                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                        <option value="birthday" {{ old('type') == 'birthday' ? 'selected' : '' }}>
                                            🎂 Aniversário
                                        </option>
                                        <option value="anniversary" {{ old('type') == 'anniversary' ? 'selected' : '' }}>
                                            💕 Aniversário de Casamento
                                        </option>
                                        <option value="holiday" {{ old('type') == 'holiday' ? 'selected' : '' }}>
                                            🏖️ Feriado
                                        </option>
                                        <option value="custom" {{ old('type') == 'custom' ? 'selected' : '' }}>
                                            📅 Personalizado
                                        </option>
                                    </select>
                                    @error('type')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Cor -->
                                <div>
                                    <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fa-solid fa-palette mr-1"></i>
                                        Cor do Evento
                                    </label>
                                    <div class="flex items-center space-x-3">
                                        <input type="color" id="color" name="color" 
                                               class="w-16 h-12 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer"
                                               value="{{ old('color', '#3B82F6') }}">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Escolha uma cor para identificar o evento</span>
                                    </div>
                                    @error('color')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Configurações de Data e Hora -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fa-solid fa-calendar-alt text-green-500 mr-2"></i>
                                Data e Hora
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Data de Início -->
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fa-solid fa-calendar-day mr-1"></i>
                                        Data de Início *
                                    </label>
                                    <input type="date" id="start_date" name="start_date" 
                                           class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                           value="{{ old('start_date') }}" required>
                                    @error('start_date')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Data de Fim (para eventos únicos) -->
                                <div id="end_date_container" style="display: none;">
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fa-solid fa-calendar-check mr-1"></i>
                                        Data de Fim
                                    </label>
                                    <input type="date" id="end_date" name="end_date" 
                                           class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                           value="{{ old('end_date') }}">
                                    @error('end_date')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Hora -->
                                <div>
                                    <label for="time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fa-solid fa-clock mr-1"></i>
                                        Hora (opcional)
                                    </label>
                                    <input type="time" id="time" name="time" 
                                           class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                           value="{{ old('time') }}">
                                    @error('time')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Recorrência -->
                                <div>
                                    <label for="recurrence_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fa-solid fa-repeat mr-1"></i>
                                        Recorrência *
                                    </label>
                                    <select id="recurrence_type" name="recurrence_type" 
                                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                        <option value="yearly" {{ old('recurrence_type') == 'yearly' ? 'selected' : '' }}>
                                            📅 Anual
                                        </option>
                                        <option value="monthly" {{ old('recurrence_type') == 'monthly' ? 'selected' : '' }}>
                                            📆 Mensal
                                        </option>
                                        <option value="weekly" {{ old('recurrence_type') == 'weekly' ? 'selected' : '' }}>
                                            📊 Semanal
                                        </option>
                                        <option value="daily" {{ old('recurrence_type') == 'daily' ? 'selected' : '' }}>
                                            📈 Diário
                                        </option>
                                        <option value="once" {{ old('recurrence_type') == 'once' ? 'selected' : '' }}>
                                            ⭐ Uma vez
                                        </option>
                                    </select>
                                    @error('recurrence_type')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Localização e Lembretes -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fa-solid fa-map-marker-alt text-red-500 mr-2"></i>
                                Localização e Lembretes
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Local -->
                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fa-solid fa-map-marker-alt mr-1"></i>
                                        Local (opcional)
                                    </label>
                                    <input type="text" id="location" name="location" 
                                           class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                           value="{{ old('location') }}" 
                                           placeholder="Ex: Casa da Maria, Restaurante ABC">
                                    @error('location')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Dias de Antecedência para Lembrete -->
                                <div>
                                    <label for="reminder_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fa-solid fa-bell mr-1"></i>
                                        Lembrete (dias antes)
                                    </label>
                                    <input type="number" id="reminder_days" name="reminder_days" 
                                           class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                           value="{{ old('reminder_days', 7) }}" min="0" max="365"
                                           placeholder="7">
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Quantos dias antes do evento você quer ser lembrado?</p>
                                    @error('reminder_days')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Pessoas Vinculadas -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fa-solid fa-users text-purple-500 mr-2"></i>
                                Pessoas Vinculadas
                            </h3>
                            
                            <div>
                                <label for="predictability_people" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fa-solid fa-user-plus mr-1"></i>
                                    Selecione as pessoas (amigos/familiares)
                                </label>
                                <select id="predictability_people" name="predictability_people[]" multiple 
                                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 min-h-32">
                                    @foreach($pessoas as $pessoa)
                                        <option value="{{ $pessoa->id }}" {{ in_array($pessoa->id, old('predictability_people', [])) ? 'selected' : '' }}>
                                            {{ $pessoa->name }} ({{ ucfirst($pessoa->category) }})
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                    <i class="fa-solid fa-info-circle mr-1"></i>
                                    Segure Ctrl (Windows) ou Command (Mac) para selecionar múltiplas pessoas
                                </p>
                                @error('predictability_people')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Preview do Evento -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                                <i class="fa-solid fa-eye text-blue-500 mr-2"></i>
                                Preview do Evento
                            </h3>
                            
                            <div id="event-preview" class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 border border-gray-200 dark:border-gray-600">
                                <div class="text-center text-gray-500 dark:text-gray-400">
                                    <i class="fa-solid fa-calendar-plus text-4xl mb-2"></i>
                                    <p>Preencha os campos acima para ver o preview do evento</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ações -->
                    <div class="bg-gray-50 dark:bg-gray-700 px-8 py-6 border-t border-gray-200 dark:border-gray-600">
                        <div class="flex flex-col sm:flex-row justify-end gap-4">
                            <button type="button" onclick="window.history.back()" 
                                    class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-all duration-200">
                                <i class="fa-solid fa-times mr-2"></i>
                                Cancelar
                            </button>
                            <button type="submit" 
                                    class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl">
                                <i class="fa-solid fa-check mr-2"></i>
                                Criar Evento
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Controle da data de fim para eventos únicos
        document.getElementById('recurrence_type').addEventListener('change', function() {
            const endDateContainer = document.getElementById('end_date_container');
            if (this.value === 'once') {
                endDateContainer.style.display = 'block';
            } else {
                endDateContainer.style.display = 'none';
            }
            updatePreview();
        });

        // Preview em tempo real
        function updatePreview() {
            const title = document.getElementById('title').value;
            const description = document.getElementById('description').value;
            const type = document.getElementById('type').value;
            const color = document.getElementById('color').value;
            const startDate = document.getElementById('start_date').value;
            const time = document.getElementById('time').value;
            const location = document.getElementById('location').value;
            const recurrenceType = document.getElementById('recurrence_type').value;

            const preview = document.getElementById('event-preview');
            
            if (!title) {
                preview.innerHTML = `
                    <div class="text-center text-gray-500 dark:text-gray-400">
                        <i class="fa-solid fa-calendar-plus text-4xl mb-2"></i>
                        <p>Preencha os campos acima para ver o preview do evento</p>
                    </div>
                `;
                return;
            }

            const typeLabels = {
                'birthday': '🎂 Aniversário',
                'anniversary': '💕 Aniversário de Casamento',
                'holiday': '🏖️ Feriado',
                'custom': '📅 Personalizado'
            };

            const recurrenceLabels = {
                'yearly': 'Anual',
                'monthly': 'Mensal',
                'weekly': 'Semanal',
                'daily': 'Diário',
                'once': 'Uma vez'
            };

            let dateText = '';
            if (startDate) {
                const date = new Date(startDate);
                dateText = date.toLocaleDateString('pt-BR');
                if (time) {
                    dateText += ` às ${time}`;
                }
            }

            preview.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg border" style="border-color: ${color}20;">
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium" 
                              style="background-color: ${color}20; color: ${color};">
                            ${typeLabels[type] || type}
                        </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            ${recurrenceLabels[recurrenceType] || recurrenceType}
                        </span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">${title}</h3>
                    
                    ${description ? `<p class="text-gray-600 dark:text-gray-300 mb-3">${description}</p>` : ''}
                    
                    <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                        ${dateText ? `<div class="flex items-center"><i class="fa-solid fa-calendar-day mr-2 text-blue-500"></i>${dateText}</div>` : ''}
                        ${location ? `<div class="flex items-center"><i class="fa-solid fa-map-marker-alt mr-2 text-green-500"></i>${location}</div>` : ''}
                    </div>
                </div>
            `;
        }

        // Event listeners para preview em tempo real
        ['title', 'description', 'type', 'color', 'start_date', 'time', 'location', 'recurrence_type'].forEach(id => {
            document.getElementById(id).addEventListener('input', updatePreview);
            document.getElementById(id).addEventListener('change', updatePreview);
        });

        // Trigger inicial
        document.addEventListener('DOMContentLoaded', function() {
            const recurrenceType = document.getElementById('recurrence_type');
            const endDateContainer = document.getElementById('end_date_container');
            if (recurrenceType.value === 'once') {
                endDateContainer.style.display = 'block';
            }
            updatePreview();
        });

        // Validação do formulário
        document.getElementById('event-form').addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            const startDate = document.getElementById('start_date').value;
            
            if (!title) {
                e.preventDefault();
                alert('Por favor, preencha o título do evento.');
                document.getElementById('title').focus();
                return;
            }
            
            if (!startDate) {
                e.preventDefault();
                alert('Por favor, selecione a data de início.');
                document.getElementById('start_date').focus();
                return;
            }
        });
    </script>

    <style>
        .animate-fade-in-up {
            animation: fadeInUp 0.3s ease-out;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection 