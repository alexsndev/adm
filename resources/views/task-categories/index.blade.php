@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Categorias de Tarefas</h1>
                <a href="{{ route('task-categories.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold shadow transition-all duration-200">
                    <i class="fas fa-plus mr-2"></i> Criar Categoria
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($categories->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($categories as $category)
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                    <div class="p-6">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center">
                                                @if($category->icon)
                                                    <i class="{{ $category->icon }} text-2xl mr-3" style="color: {{ $category->color }}"></i>
                                                @else
                                                    <div class="w-8 h-8 rounded-full mr-3 flex items-center justify-center" style="background-color: {{ $category->color }}">
                                                        <i class="fas fa-tag text-white text-sm"></i>
                                                    </div>
                                                @endif
                                                <h3 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                                            </div>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('task-categories.edit', $category) }}" class="text-blue-600 hover:text-blue-800">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('task-categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        @if($category->description)
                                            <p class="text-gray-600 text-sm mb-4">{{ $category->description }}</p>
                                        @endif

                                        <div class="grid grid-cols-3 gap-4 text-center mb-4">
                                            <div>
                                                <div class="text-2xl font-bold text-blue-600">{{ $category->household_tasks_count }}</div>
                                                <div class="text-xs text-gray-500">Total</div>
                                            </div>
                                            <div>
                                                <div class="text-2xl font-bold text-orange-600">{{ $category->active_tasks_count }}</div>
                                                <div class="text-xs text-gray-500">Pendentes</div>
                                            </div>
                                            <div>
                                                <div class="text-2xl font-bold text-green-600">{{ $category->completed_tasks_count }}</div>
                                                <div class="text-xs text-gray-500">Concluídas</div>
                                            </div>
                                        </div>

                                        <div class="flex justify-between items-center">
                                            <a href="{{ route('task-categories.show', $category) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                Ver Tarefas <i class="fas fa-arrow-right ml-1"></i>
                                            </a>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $category->is_active ? 'Ativa' : 'Inativa' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <i class="fas fa-tags text-6xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhuma categoria encontrada</h3>
                            <p class="text-gray-500 mb-6">Crie sua primeira categoria de tarefas para começar a organizar suas atividades domésticas.</p>
                            <a href="{{ route('task-categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-plus mr-2"></i>Criar Primeira Categoria
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection 