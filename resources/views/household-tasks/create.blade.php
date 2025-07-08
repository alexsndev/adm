@extends('layouts.app')

@section('content')
@section('nav-classes', 'bg-white/30 dark:bg-gray-900/30 border-b border-white/20 dark:border-gray-700/20')
@section('background')
    <div class="fixed inset-0 z-0 bg-gradient-to-br from-indigo-500 via-blue-300 to-green-200 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 animate-fade-in"></div>
@endsection
@section('header-classes', 'bg-white/30 dark:bg-gray-900/30 shadow-none')
@section('main-classes', 'relative z-10')

<div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-white/30 dark:border-gray-700/30 p-8">
            <div class="p-0 text-gray-900 dark:text-gray-100">
                <form method="POST" action="{{ route('household-tasks.store') }}" class="space-y-6">
                    @csrf

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                            <strong>Erros encontrados:</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Categoria -->
                        <div>
                            <x-input-label for="task_category_id" :value="__('Categoria')" class="text-gray-800 dark:text-gray-200" />
                            <select id="task_category_id" name="task_category_id" class="mt-1 block w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="">Selecione uma categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('task_category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('task_category_id')" class="mt-2" />
                        </div>

                        <!-- Título -->
                        <div>
                            <x-input-label for="title" :value="__('Título')" class="text-gray-800 dark:text-gray-200" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Descrição -->
                    <div>
                        <x-input-label for="description" :value="__('Descrição')" class="text-gray-800 dark:text-gray-200" />
                        <textarea id="description" name="description" rows="3" class="mt-1 block w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Status -->
                        <div>
                            <x-input-label for="status" :value="__('Status')" class="text-gray-800 dark:text-gray-200" />
                            <select id="status" name="status" class="mt-1 block w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pendente</option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>Em Andamento</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Concluída</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <!-- Prioridade -->
                        <div>
                            <x-input-label for="priority" :value="__('Prioridade')" class="text-gray-800 dark:text-gray-200" />
                            <select id="priority" name="priority" class="mt-1 block w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Baixa</option>
                                <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Média</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Alta</option>
                                <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgente</option>
                            </select>
                            <x-input-error :messages="$errors->get('priority')" class="mt-2" />
                        </div>

                        <!-- Responsável -->
                        <div>
                            <x-input-label for="assigned_to" :value="__('Responsável')" class="text-gray-800 dark:text-gray-200" />
                            <select id="assigned_to" name="assigned_to" class="mt-1 block w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="alexandre" {{ old('assigned_to') == 'alexandre' ? 'selected' : '' }}>Alexandre</option>
                                <option value="liza" {{ old('assigned_to') == 'liza' ? 'selected' : '' }}>Liza</option>
                                <option value="both" {{ old('assigned_to') == 'both' ? 'selected' : '' }}>Ambos</option>
                            </select>
                            <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Frequência -->
                        <div>
                            <x-input-label for="frequency" :value="__('Frequência')" class="text-gray-800 dark:text-gray-200" />
                            <select id="frequency" name="frequency" class="mt-1 block w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="once" {{ old('frequency') == 'once' ? 'selected' : '' }}>Uma vez</option>
                                <option value="daily" {{ old('frequency') == 'daily' ? 'selected' : '' }}>Diário</option>
                                <option value="weekly" {{ old('frequency') == 'weekly' ? 'selected' : '' }}>Semanal</option>
                                <option value="monthly" {{ old('frequency') == 'monthly' ? 'selected' : '' }}>Mensal</option>
                            </select>
                            <x-input-error :messages="$errors->get('frequency')" class="mt-2" />
                        </div>

                        <!-- Data de Vencimento -->
                        <div>
                            <x-input-label for="due_date" :value="__('Data de Vencimento')" class="text-gray-800 dark:text-gray-200" />
                            <x-text-input id="due_date" name="due_date" type="date" class="mt-1 block w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700" :value="old('due_date')" />
                            <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                        </div>

                        <!-- Horário de Vencimento -->
                        <div>
                            <x-input-label for="due_time" :value="__('Horário de Vencimento')" class="text-gray-800 dark:text-gray-200" />
                            <x-text-input id="due_time" name="due_time" type="time" class="mt-1 block w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700" :value="old('due_time')" />
                            <x-input-error :messages="$errors->get('due_time')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tempo Estimado (minutos) -->
                        <div>
                            <x-input-label for="estimated_minutes" :value="__('Tempo Estimado (minutos)')" class="text-gray-800 dark:text-gray-200" />
                            <x-text-input id="estimated_minutes" name="estimated_minutes" type="number" min="1" class="mt-1 block w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700" :value="old('estimated_minutes')" placeholder="Ex: 30" />
                            <x-input-error :messages="$errors->get('estimated_minutes')" class="mt-2" />
                        </div>

                        <!-- Recorrente -->
                        <div class="flex items-center mt-6">
                            <input id="is_recurring" name="is_recurring" type="checkbox" class="rounded border-gray-300 dark:border-gray-700 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" {{ old('is_recurring') ? 'checked' : '' }}>
                            <label for="is_recurring" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                {{ __('Tarefa Recorrente') }}
                            </label>
                        </div>
                    </div>

                    <!-- Observações -->
                    <div>
                        <x-input-label for="notes" :value="__('Observações')" class="text-gray-800 dark:text-gray-200" />
                        <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes') }}</textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6 space-x-4">
                        <a href="{{ route('household-tasks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
                            <i class="fas fa-save mr-2"></i>{{ __('Criar Tarefa') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 