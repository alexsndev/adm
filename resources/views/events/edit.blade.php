@extends('layouts.app')

@section('content')
    <div class="py-12 min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-2xl rounded-3xl border border-gray-200 dark:border-gray-800">
                <div class="px-8 py-8">
                    <h2 class="text-3xl font-extrabold text-blue-700 dark:text-blue-300 mb-8 flex items-center gap-3">
                        <i class="fa-solid fa-calendar-days text-blue-500 text-2xl"></i>
                        Editar Evento
                    </h2>
                    <form method="POST" action="{{ route('events.update', $event) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Imagem do Evento -->
                            <div class="md:col-span-2 flex flex-col items-center mb-4">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-image text-blue-400"></i> Imagem do Evento
                                </label>
                                @if($event->image)
                                    <div class="mb-2 flex flex-col items-center">
                                        <img src="{{ asset('storage/' . $event->image) }}" alt="Imagem do Evento" class="w-40 h-40 object-cover rounded-2xl shadow-lg border-4 border-blue-200 dark:border-blue-700">
                                        <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pré-visualização da imagem atual</span>
                                    </div>
                                @endif
                                <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-200 dark:bg-gray-800 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>
                            <!-- Título -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-heading text-blue-400"></i> Título do Evento
                                </label>
                                <input id="title" class="block mt-1 w-full rounded-xl border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-lg px-4 py-3 shadow-sm" type="text" name="title" value="{{ old('title', $event->title) }}" required autofocus />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>
                            <!-- Descrição -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-align-left text-blue-400"></i> Descrição
                                </label>
                                <textarea id="description" name="description" rows="3" class="rounded-xl border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 block mt-1 w-full text-lg px-4 py-3 shadow-sm">{{ old('description', $event->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                            <!-- Tipo -->
                            <div>
                                <label for="type" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-tag text-blue-400"></i> Tipo
                                </label>
                                <select id="type" name="type" class="rounded-xl border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 block mt-1 w-full text-lg px-4 py-3 shadow-sm">
                                    <option value="birthday" {{ old('type', $event->type) == 'birthday' ? 'selected' : '' }}>Aniversário</option>
                                    <option value="anniversary" {{ old('type', $event->type) == 'anniversary' ? 'selected' : '' }}>Aniversário de Casamento</option>
                                    <option value="holiday" {{ old('type', $event->type) == 'holiday' ? 'selected' : '' }}>Feriado</option>
                                    <option value="custom" {{ old('type', $event->type) == 'custom' ? 'selected' : '' }}>Personalizado</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>
                            <!-- Recorrência -->
                            <div>
                                <label for="recurrence_type" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-repeat text-blue-400"></i> Recorrência
                                </label>
                                <select id="recurrence_type" name="recurrence_type" class="rounded-xl border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 block mt-1 w-full text-lg px-4 py-3 shadow-sm">
                                    <option value="yearly" {{ old('recurrence_type', $event->recurrence_type) == 'yearly' ? 'selected' : '' }}>Anual</option>
                                    <option value="monthly" {{ old('recurrence_type', $event->recurrence_type) == 'monthly' ? 'selected' : '' }}>Mensal</option>
                                    <option value="weekly" {{ old('recurrence_type', $event->recurrence_type) == 'weekly' ? 'selected' : '' }}>Semanal</option>
                                    <option value="daily" {{ old('recurrence_type', $event->recurrence_type) == 'daily' ? 'selected' : '' }}>Diário</option>
                                    <option value="once" {{ old('recurrence_type', $event->recurrence_type) == 'once' ? 'selected' : '' }}>Uma vez</option>
                                </select>
                                <x-input-error :messages="$errors->get('recurrence_type')" class="mt-2" />
                            </div>
                            <!-- Data de Início -->
                            <div>
                                <label for="start_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-calendar-day text-blue-400"></i> Data de Início
                                </label>
                                <input id="start_date" class="block mt-1 w-full rounded-xl border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-lg px-4 py-3 shadow-sm" type="date" name="start_date" value="{{ old('start_date', $event->start_date->format('Y-m-d')) }}" required />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>
                            <!-- Data de Fim (para eventos únicos) -->
                            <div id="end_date_container" style="display: {{ $event->recurrence_type === 'once' ? 'block' : 'none' }};">
                                <label for="end_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-calendar-check text-blue-400"></i> Data de Fim
                                </label>
                                <input id="end_date" class="block mt-1 w-full rounded-xl border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-lg px-4 py-3 shadow-sm" type="date" name="end_date" value="{{ old('end_date', $event->end_date ? $event->end_date->format('Y-m-d') : '') }}" />
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>
                            <!-- Hora -->
                            <div>
                                <label for="time" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-clock text-blue-400"></i> Hora (opcional)
                                </label>
                                <input id="time" class="block mt-1 w-full rounded-xl border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-lg px-4 py-3 shadow-sm" type="time" name="time" value="{{ old('time', $event->time ? $event->time->format('H:i') : '') }}" />
                                <x-input-error :messages="$errors->get('time')" class="mt-2" />
                            </div>
                            <!-- Local -->
                            <div>
                                <label for="location" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-location-dot text-blue-400"></i> Local (opcional)
                                </label>
                                <input id="location" class="block mt-1 w-full rounded-xl border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-lg px-4 py-3 shadow-sm" type="text" name="location" value="{{ old('location', $event->location) }}" />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>
                            <!-- Dias de Antecedência para Lembrete -->
                            <div>
                                <label for="reminder_days" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-bell text-blue-400"></i> Lembrete (dias antes)
                                </label>
                                <input id="reminder_days" class="block mt-1 w-full rounded-xl border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-lg px-4 py-3 shadow-sm" type="number" name="reminder_days" value="{{ old('reminder_days', $event->reminder_days) }}" min="0" max="365" />
                                <x-input-error :messages="$errors->get('reminder_days')" class="mt-2" />
                            </div>
                            <!-- Cor -->
                            <div>
                                <label for="color" class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1 flex items-center gap-2">
                                    <i class="fa-solid fa-palette text-blue-400"></i> Cor
                                </label>
                                <input id="color" class="block mt-1 w-16 h-10 rounded-xl border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 shadow-sm" type="color" name="color" value="{{ old('color', $event->color) }}" />
                                <x-input-error :messages="$errors->get('color')" class="mt-2" />
                            </div>
                            <!-- Status Ativo -->
                            <div class="md:col-span-2 flex items-center gap-3 mt-2">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $event->is_active) ? 'checked' : '' }} class="rounded border-gray-400 text-blue-600 shadow-sm focus:ring-blue-400">
                                <span class="text-sm text-gray-700 dark:text-gray-200">Evento ativo</span>
                            </div>
                            <!-- Regenerar Ocorrências -->
                            <div class="md:col-span-2 flex items-center gap-3 mt-2">
                                <input type="checkbox" name="regenerate_occurrences" value="1" class="rounded border-gray-400 text-blue-600 shadow-sm focus:ring-blue-400">
                                <span class="text-sm text-blue-500">Regenerar todas as ocorrências (isso apagará as existentes)</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-10 gap-4">
                            <button type="button" onclick="window.history.back()" class="inline-flex items-center px-5 py-3 rounded-xl bg-gradient-to-r from-gray-300 to-gray-400 dark:from-gray-700 dark:to-gray-800 text-gray-800 dark:text-gray-200 font-semibold shadow hover:from-gray-400 hover:to-gray-500 dark:hover:from-gray-600 dark:hover:to-gray-900 transition-all">
                                <i class="fa-solid fa-arrow-left mr-2"></i> Cancelar
                            </button>
                            <button type="submit" class="inline-flex items-center px-6 py-3 rounded-xl bg-gradient-to-r from-blue-500 to-blue-700 text-white font-bold shadow-lg hover:from-blue-600 hover:to-blue-800 transition-all focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <i class="fa-solid fa-floppy-disk mr-2"></i> Atualizar Evento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('recurrence_type').addEventListener('change', function() {
            const endDateContainer = document.getElementById('end_date_container');
            if (this.value === 'once') {
                endDateContainer.style.display = 'block';
            } else {
                endDateContainer.style.display = 'none';
            }
        });
    </script>
@endsection 