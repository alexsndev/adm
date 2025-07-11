@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="w-full px-0">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Informações da Categoria -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            @if($taskCategory->icon)
                                <i class="{{ $taskCategory->icon }} text-2xl mr-3" style="color: {{ $taskCategory->color }}"></i>
                            @else
                                <div class="w-8 h-8 rounded-full mr-3 flex items-center justify-center" style="background-color: {{ $taskCategory->color }}">
                                    <i class="fas fa-tag text-white text-sm"></i>
                                </div>
                            @endif
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ $taskCategory->name }}
                            </h2>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('task-categories.edit', $taskCategory) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-edit mr-2"></i>Editar
                            </a>
                            <a href="{{ route('task-categories.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-arrow-left mr-2"></i>Voltar
                            </a>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Informações</h3>
                            @if($taskCategory->description)
                                <p class="text-gray-600">{{ $taskCategory->description }}</p>
                            @else
                                <p class="text-gray-500 italic">Sem descrição</p>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Estatísticas</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-600">{{ $taskCategory->total_tasks_count }}</div>
                                    <div class="text-xs text-gray-500">Total</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-green-600">{{ $taskCategory->completed_tasks_count }}</div>
                                    <div class="text-xs text-gray-500">Concluídas</div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Status</h3>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $taskCategory->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $taskCategory->is_active ? 'Ativa' : 'Inativa' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarefas da Categoria -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Tarefas desta Categoria</h3>
                        <a href="{{ route('household-tasks.create') }}?category_id={{ $taskCategory->id }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-plus mr-2"></i>Nova Tarefa
                        </a>
                    </div>

                    @if($tasks->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarefa</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioridade</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsável</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Limite</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($tasks as $task)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $task->title }}</div>
                                                    @if($task->description)
                                                        <div class="text-sm text-gray-500">{{ Str::limit($task->description, 50) }}</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $task->status_color }}-100 text-{{ $task->status_color }}-800">
                                                    {{ ucfirst($task->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $task->priority_color }}-100 text-{{ $task->priority_color }}-800">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $task->assigned_to_text }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if($task->due_date)
                                                    <div class="{{ $task->is_overdue ? 'text-red-600 font-semibold' : '' }}">
                                                        {{ $task->due_date->format('d/m/Y') }}
                                                        @if($task->due_time)
                                                            <br><span class="text-xs text-gray-500">{{ $task->due_time->format('H:i') }}</span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-gray-500">Não definida</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('household-tasks.show', $task) }}" class="text-blue-600 hover:text-blue-900">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('household-tasks.edit', $task) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if($task->status !== 'completed')
                                                        <form action="{{ route('household-tasks.complete', $task) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit" class="text-green-600 hover:text-green-900">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <i class="fas fa-tasks text-6xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhuma tarefa encontrada</h3>
                            <p class="text-gray-500 mb-6">Esta categoria ainda não possui tarefas. Crie a primeira tarefa para começar.</p>
                            <a href="{{ route('household-tasks.create') }}?category_id={{ $taskCategory->id }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-plus mr-2"></i>Criar Primeira Tarefa
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection 