@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/20 shadow-2xl">
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-white mb-2">Editar Categoria</h3>
                    <p class="text-gray-300">Atualize as informações da categoria "{{ $category->name }}".</p>
                </div>

                <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-white mb-2">Nome da Categoria</label>
                            <input type="text" name="name" value="{{ old('name', $category->name) }}" required 
                                class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 @error('name') border-red-400 @enderror">
                            @error('name')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-white mb-2">Tipo</label>
                            <select name="type" required 
                                class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 @error('type') border-red-400 @enderror">
                                <option value="">Selecione o tipo</option>
                                <option value="income" @if(old('type', $category->type) == 'income') selected @endif>Receita</option>
                                <option value="expense" @if(old('type', $category->type) == 'expense') selected @endif>Despesa</option>
                            </select>
                            @error('type')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-white mb-2">Cor</label>
                            <div class="flex items-center space-x-4">
                                <input type="color" name="color" value="{{ old('color', $category->color) }}" required 
                                    class="w-16 h-12 rounded-xl border-2 border-white/20 bg-white/10 backdrop-blur-sm cursor-pointer">
                                <span class="text-gray-300 text-sm">Escolha uma cor para identificar a categoria</span>
                            </div>
                            @error('color')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-white mb-2">Ícone (FontAwesome)</label>
                            <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" placeholder="fa-home" 
                                class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 @error('icon') border-red-400 @enderror">
                            @error('icon')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-white mb-2">Descrição</label>
                        <textarea name="description" rows="3" placeholder="Descreva brevemente esta categoria..."
                            class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 resize-none @error('description') border-red-400 @enderror">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-white mb-2">Categoria Pai (Opcional)</label>
                        <select name="parent_id" 
                            class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 @error('parent_id') border-red-400 @enderror">
                            <option value="">Nenhuma (Categoria Principal)</option>
                            @foreach($allCategories as $parentCategory)
                                <option value="{{ $parentCategory->id }}" @if(old('parent_id', $category->parent_id) == $parentCategory->id) selected @endif>
                                    {{ $parentCategory->name }} ({{ $parentCategory->type === 'income' ? 'Receita' : 'Despesa' }})
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-400">Selecione uma categoria pai para criar uma subcategoria</p>
                        @error('parent_id')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('categories.index') }}" 
                            class="px-8 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl font-bold text-white hover:bg-white/20 transition-all duration-300">
                            Cancelar
                        </a>
                        <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 border border-transparent rounded-xl font-bold text-white uppercase tracking-wider hover:from-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection 