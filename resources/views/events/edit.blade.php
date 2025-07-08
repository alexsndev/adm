@extends('layouts.app')

@section('content')
    <div class="py-12 bg-main">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-card overflow-hidden shadow-xl-custom rounded-3xl-custom">
                <div class="p-6 text-main">
                    <form method="POST" action="{{ route('events.update', $event) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Título -->
                            <div class="md:col-span-2">
                                <x-input-label for="title" :value="__('Título do Evento')" />
                                <x-text-input id="title" class="block mt-1 w-full bg-main text-main border-main" type="text" name="title" :value="old('title', $event->title)" required autofocus />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <!-- Descrição -->
                            <div class="md:col-span-2">
                                <x-input-label for="description" :value="__('Descrição')" />
                                <textarea id="description" name="description" rows="3" class="border-main focus:border-accent focus:ring-accent rounded-md shadow-sm block mt-1 w-full bg-main text-main">{{ old('description', $event->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- Tipo -->
                            <div>
                                <x-input-label for="type" :value="__('Tipo')" />
                                <select id="type" name="type" class="border-main focus:border-accent focus:ring-accent rounded-md shadow-sm block mt-1 w-full bg-main text-main">
                                    <option value="birthday" {{ old('type', $event->type) == 'birthday' ? 'selected' : '' }}>Aniversário</option>
                                    <option value="anniversary" {{ old('type', $event->type) == 'anniversary' ? 'selected' : '' }}>Aniversário de Casamento</option>
                                    <option value="holiday" {{ old('type', $event->type) == 'holiday' ? 'selected' : '' }}>Feriado</option>
                                    <option value="custom" {{ old('type', $event->type) == 'custom' ? 'selected' : '' }}>Personalizado</option>
                                </select>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                            <!-- Recorrência -->
                            <div>
                                <x-input-label for="recurrence_type" :value="__('Recorrência')" />
                                <select id="recurrence_type" name="recurrence_type" class="border-main focus:border-accent focus:ring-accent rounded-md shadow-sm block mt-1 w-full bg-main text-main">
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
                                <x-input-label for="start_date" :value="__('Data de Início')" />
                                <x-text-input id="start_date" class="block mt-1 w-full bg-main text-main border-main" type="date" name="start_date" :value="old('start_date', $event->start_date->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>

                            <!-- Data de Fim (para eventos únicos) -->
                            <div id="end_date_container" style="display: {{ $event->recurrence_type === 'once' ? 'block' : 'none' }};">
                                <x-input-label for="end_date" :value="__('Data de Fim')" />
                                <x-text-input id="end_date" class="block mt-1 w-full bg-main text-main border-main" type="date" name="end_date" :value="old('end_date', $event->end_date ? $event->end_date->format('Y-m-d') : '')" />
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>

                            <!-- Hora -->
                            <div>
                                <x-input-label for="time" :value="__('Hora (opcional)')" />
                                <x-text-input id="time" class="block mt-1 w-full bg-main text-main border-main" type="time" name="time" :value="old('time', $event->time ? $event->time->format('H:i') : '')" />
                                <x-input-error :messages="$errors->get('time')" class="mt-2" />
                            </div>

                            <!-- Local -->
                            <div>
                                <x-input-label for="location" :value="__('Local (opcional)')" />
                                <x-text-input id="location" class="block mt-1 w-full bg-main text-main border-main" type="text" name="location" :value="old('location', $event->location)" />
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>

                            <!-- Dias de Antecedência para Lembrete -->
                            <div>
                                <x-input-label for="reminder_days" :value="__('Lembrete (dias antes)')" />
                                <x-text-input id="reminder_days" class="block mt-1 w-full bg-main text-main border-main" type="number" name="reminder_days" :value="old('reminder_days', $event->reminder_days)" min="0" max="365" />
                                <x-input-error :messages="$errors->get('reminder_days')" class="mt-2" />
                            </div>

                            <!-- Cor -->
                            <div>
                                <x-input-label for="color" :value="__('Cor')" />
                                <x-text-input id="color" class="block mt-1 w-full" type="color" name="color" :value="old('color', $event->color)" />
                                <x-input-error :messages="$errors->get('color')" class="mt-2" />
                            </div>

                            <!-- Status Ativo -->
                            <div class="md:col-span-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $event->is_active) ? 'checked' : '' }} class="rounded border-main text-accent shadow-sm focus:ring-accent">
                                    <span class="ml-2 text-sm text-main">Evento ativo</span>
                                </label>
                            </div>

                            <!-- Regenerar Ocorrências -->
                            <div class="md:col-span-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="regenerate_occurrences" value="1" class="rounded border-main text-accent shadow-sm focus:ring-accent">
                                    <span class="ml-2 text-sm text-accent">Regenerar todas as ocorrências (isso apagará as existentes)</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-secondary-button type="button" onclick="window.history.back()" class="mr-3">
                                {{ __('Cancelar') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Atualizar Evento') }}
                            </x-primary-button>
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