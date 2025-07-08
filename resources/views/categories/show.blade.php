@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/20 shadow-2xl">
                <!-- Header da Categoria -->
                <div class="flex items-center mb-8">
                    <div class="w-16 h-16 rounded-2xl mr-6 shadow-xl" style="background-color: {{ $category->color }}"></div>
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-2">{{ $category->name }}</h3>
                        <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $category->type === 'income' ? 'bg-green-500/20 text-green-300 border border-green-400/30' : 'bg-red-500/20 text-red-300 border border-red-400/30' }}">
                            {{ $category->type === 'income' ? 'Receita' : 'Despesa' }}
                        </span>
                    </div>
                </div>

                <!-- Informações da Categoria -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div class="space-y-6">
                        <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                            <h4 class="text-lg font-bold text-white mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Informações Básicas
                            </h4>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-300 font-medium">Nome:</span>
                                    <span class="text-white font-bold">{{ $category->name }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-300 font-medium">Tipo:</span>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $category->type === 'income' ? 'bg-green-500/20 text-green-300 border border-green-400/30' : 'bg-red-500/20 text-red-300 border border-red-400/30' }}">
                                        {{ $category->type === 'income' ? 'Receita' : 'Despesa' }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-300 font-medium">Cor:</span>
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 rounded-full mr-2 shadow-lg" style="background-color: {{ $category->color }}"></div>
                                        <span class="text-white font-mono text-sm">{{ $category->color }}</span>
                                    </div>
                                </div>
                                @if($category->icon)
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-300 font-medium">Ícone:</span>
                                    <div class="flex items-center">
                                        <i class="{{ $category->icon }} mr-2 text-purple-300"></i>
                                        <span class="text-white font-mono text-sm">{{ $category->icon }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                            <h4 class="text-lg font-bold text-white mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Estatísticas
                            </h4>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-300 font-medium">Total de Transações:</span>
                                    <span class="text-white font-bold text-xl">{{ $category->transactions_count ?? 0 }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-300 font-medium">Criada em:</span>
                                    <span class="text-white">{{ $category->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-300 font-medium">Última atualização:</span>
                                    <span class="text-white">{{ $category->updated_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Descrição -->
                @if($category->description)
                <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10 mb-8">
                    <h4 class="text-lg font-bold text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        Descrição
                    </h4>
                    <p class="text-gray-300 leading-relaxed">{{ $category->description }}</p>
                </div>
                @endif

                <!-- Ações -->
                <div class="flex justify-center space-x-4 pt-6 border-t border-white/10">
                    <a href="{{ route('categories.edit', $category) }}" 
                        class="px-8 py-3 bg-gradient-to-r from-yellow-600 to-orange-600 border border-transparent rounded-xl font-bold text-white uppercase tracking-wider hover:from-yellow-700 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Editar Categoria
                    </a>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta categoria? Esta ação não pode ser desfeita.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-red-600 to-pink-600 border border-transparent rounded-xl font-bold text-white uppercase tracking-wider hover:from-red-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Excluir Categoria
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection 