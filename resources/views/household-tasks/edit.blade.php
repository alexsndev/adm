@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-white/30 dark:border-gray-700/30 p-8">
                <div class="p-0 text-gray-900">
                    <form method="POST" action="{{ route('household-tasks.update', $householdTask) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Categoria -->
                            <div>
                                <x-input-label for="task_category_id" :value="__('Categoria')" />
                                <select id="task_category_id" name="task_category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="">Selecione uma categoria</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('task_category_id', $householdTask->task_category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('task_category_id')" class="mt-2" />
                            </div>

                            <!-- Título -->
                            <div>
                                <x-input-label for="title" :value="__('Título')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $householdTask->title)" required autofocus />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Descrição -->
                        <div>
                            <x-input-label for="description" :value="__('Descrição')" />
                            <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $householdTask->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="pending" {{ old('status', $householdTask->status) == 'pending' ? 'selected' : '' }}>Pendente</option>
                                    <option value="in_progress" {{ old('status', $householdTask->status) == 'in_progress' ? 'selected' : '' }}>Em Andamento</option>
                                    <option value="completed" {{ old('status', $householdTask->status) == 'completed' ? 'selected' : '' }}>Concluída</option>
                                    <option value="cancelled" {{ old('status', $householdTask->status) == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Prioridade -->
                            <div>
                                <x-input-label for="priority" :value="__('Prioridade')" />
                                <select id="priority" name="priority" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="low" {{ old('priority', $householdTask->priority) == 'low' ? 'selected' : '' }}>Baixa</option>
                                    <option value="medium" {{ old('priority', $householdTask->priority) == 'medium' ? 'selected' : '' }}>Média</option>
                                    <option value="high" {{ old('priority', $householdTask->priority) == 'high' ? 'selected' : '' }}>Alta</option>
                                    <option value="urgent" {{ old('priority', $householdTask->priority) == 'urgent' ? 'selected' : '' }}>Urgente</option>
                                </select>
                                <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                            </div>

                            <!-- Responsável -->
                            <div>
                                <x-input-label for="assigned_to" :value="__('Responsável')" />
                                <select id="assigned_to" name="assigned_to" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="alexandre" {{ old('assigned_to', $householdTask->assigned_to) == 'alexandre' ? 'selected' : '' }}>Alexandre</option>
                                    <option value="liza" {{ old('assigned_to', $householdTask->assigned_to) == 'liza' ? 'selected' : '' }}>Liza</option>
                                    <option value="both" {{ old('assigned_to', $householdTask->assigned_to) == 'both' ? 'selected' : '' }}>Ambos</option>
                                </select>
                                <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Frequência -->
                            <div>
                                <x-input-label for="frequency" :value="__('Frequência')" />
                                <select id="frequency" name="frequency" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="once" {{ old('frequency', $householdTask->frequency) == 'once' ? 'selected' : '' }}>Uma vez</option>
                                    <option value="daily" {{ old('frequency', $householdTask->frequency) == 'daily' ? 'selected' : '' }}>Diário</option>
                                    <option value="weekly" {{ old('frequency', $householdTask->frequency) == 'weekly' ? 'selected' : '' }}>Semanal</option>
                                    <option value="monthly" {{ old('frequency', $householdTask->frequency) == 'monthly' ? 'selected' : '' }}>Mensal</option>
                                </select>
                                <x-input-error :messages="$errors->get('frequency')" class="mt-2" />
                            </div>

                            <!-- Data de Vencimento -->
                            <div>
                                <x-input-label for="due_date" :value="__('Data de Vencimento')" />
                                <x-text-input id="due_date" name="due_date" type="date" class="mt-1 block w-full" :value="old('due_date', $householdTask->due_date?->format('Y-m-d'))" />
                                <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                            </div>

                            <!-- Horário de Vencimento -->
                            <div>
                                <x-input-label for="due_time" :value="__('Horário de Vencimento')" />
                                <x-text-input id="due_time" name="due_time" type="time" class="mt-1 block w-full" :value="old('due_time', $householdTask->due_time?->format('H:i'))" />
                                <x-input-error :messages="$errors->get('due_time')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Tempo Estimado (minutos) -->
                            <div>
                                <x-input-label for="estimated_minutes" :value="__('Tempo Estimado (minutos)')" />
                                <x-text-input id="estimated_minutes" name="estimated_minutes" type="number" min="1" class="mt-1 block w-full" :value="old('estimated_minutes', $householdTask->estimated_minutes)" placeholder="Ex: 30" />
                                <x-input-error :messages="$errors->get('estimated_minutes')" class="mt-2" />
                            </div>

                            <!-- Tempo Real (minutos) -->
                            <div>
                                <x-input-label for="actual_minutes" :value="__('Tempo Real (minutos)')" />
                                <x-text-input id="actual_minutes" name="actual_minutes" type="number" min="0" class="mt-1 block w-full" :value="old('actual_minutes', $householdTask->actual_minutes)" placeholder="Ex: 25" />
                                <x-input-error :messages="$errors->get('actual_minutes')" class="mt-2" />
                            </div>

                            <!-- Recorrente -->
                            <div class="flex items-center mt-6">
                                <input id="is_recurring" name="is_recurring" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" {{ old('is_recurring', $householdTask->is_recurring) ? 'checked' : '' }}>
                                <label for="is_recurring" class="ml-2 block text-sm text-gray-900">
                                    {{ __('Tarefa Recorrente') }}
                                </label>
                            </div>
                        </div>

                        <!-- Observações -->
                        <div>
                            <x-input-label for="notes" :value="__('Observações')" />
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes', $householdTask->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <!-- Informações de Conclusão -->
                        @if($householdTask->completed_date)
                            <div class="bg-green-50 border border-green-200 rounded-md p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle text-green-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-green-800">
                                            Tarefa Concluída
                                        </h3>
                                        <div class="mt-2 text-sm text-green-700">
                                            <p>Concluída em: {{ $householdTask->completed_date->format('d/m/Y') }}</p>
                                            @if($householdTask->actual_minutes)
                                                <p>Tempo real: {{ $householdTask->actual_hours }} horas</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center justify-end mt-6 space-x-4">
                            <a href="{{ route('household-tasks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <x-primary-button>
                                <i class="fas fa-save mr-2"></i>{{ __('Atualizar Tarefa') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection 