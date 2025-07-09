@extends('layouts.app')

@section('content')
    <div class="py-6 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-200 px-6 py-3 rounded-lg flex items-center" role="alert">
                    <i class="fa-solid fa-circle-check w-5 h-5 mr-2"></i>
                    <span class="block sm:inline font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Botão para criar nova categoria pai -->
            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Categorias</h1>
                <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold uppercase tracking-wider transition-colors duration-150 shadow-lg">
                    <i class="fa-solid fa-plus mr-2"></i>
                    Nova Categoria
                </a>
            </div>

            @if($categories->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    @foreach($categories as $category)
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-5 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-150 group {{ $category->parent_id ? 'ml-6 border-l-4 border-l-blue-500' : '' }}">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 rounded-full mr-2 border border-gray-300 dark:border-gray-600" style="background-color: {{ $category->color }}"></div>
                                    <h3 class="text-base font-bold text-gray-800 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                        @if($category->parent_id)
                                            <i class="fa-solid fa-level-down-alt mr-1 text-blue-500"></i>
                                        @endif
                                        {{ $category->name }}
                                    </h3>
                                </div>
                                <div class="flex space-x-2 transition-opacity duration-150">
                                    <a href="{{ route('categories.create', ['parent_id' => $category->id]) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" title="Criar subcategoria">
                                        <i class="fa-solid fa-plus"></i>
                                    </a>
                                    <a href="{{ route('categories.edit', $category) }}" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300" title="Editar categoria">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" title="Excluir categoria">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <p class="text-xs text-gray-600 dark:text-gray-300 mb-3 line-clamp-2">{{ $category->description ?? 'Sem descrição' }}</p>
                            <div class="flex items-center justify-between text-xs">
                                <span class="px-2 py-1 rounded-full font-semibold flex items-center {{ $category->type === 'income' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }} border {{ $category->type === 'income' ? 'border-green-200 dark:border-green-700' : 'border-red-200 dark:border-red-700' }}">
                                    @if($category->type === 'income')
                                        <span class="mr-1">💰</span>
                                    @else
                                        <span class="mr-1">💸</span>
                                    @endif
                                    {{ $category->type === 'income' ? 'Receita' : 'Despesa' }}
                                </span>
                                <span class="font-bold text-gray-700 dark:text-gray-300 flex items-center">
                                    <i class="fa-solid fa-chart-column mr-1"></i>
                                    {{ $category->transactions_count ?? 0 }} transações
                                </span>
                            </div>
                            @if($category->parent)
                                <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    <i class="fa-solid fa-level-up-alt mr-1"></i>
                                    Pai: {{ $category->parent->name }}
                                </div>
                            @endif
                            @if($category->children_count > 0)
                                <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    <i class="fa-solid fa-sitemap mr-1"></i>
                                    {{ $category->children_count }} subcategoria(s)
                                </div>
                            @endif
                            @if($category->icon)
                                <div class="mt-3 flex items-center text-gray-500 dark:text-gray-400 text-xs">
                                    <i class="fa-solid {{ $category->icon }} mr-2"></i>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-10 border border-gray-200 dark:border-gray-700 shadow-sm">
                        <div class="w-20 h-20 mx-auto mb-4 flex items-center justify-center text-blue-500">
                            <i class="fa-solid fa-layer-group fa-2x"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Nenhuma categoria encontrada</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-6 max-w-md mx-auto">Comece organizando suas finanças criando categorias para receitas e despesas.</p>
                        <a href="{{ route('categories.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold uppercase tracking-wider transition-colors duration-150 shadow-lg">
                            <i class="fa-solid fa-plus mr-2"></i>
                            Criar Primeira Categoria
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection 