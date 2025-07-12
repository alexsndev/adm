@php
    $types = [
        'income' => 'Receita',
        'expense' => 'Despesa',
    ];
@endphp

<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nome</label>
        <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" required 
               class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200"
               placeholder="Digite o nome da categoria">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Tipo</label>
        <select name="type" required 
                class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white transition-all duration-200">
            <option value="">Selecione o tipo</option>
            @foreach($types as $key => $label)
                <option value="{{ $key }}" @if(old('type', $category->type ?? '') == $key) selected @endif>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Cor</label>
        <input type="color" name="color" value="{{ old('color', $category->color ?? '#3B82F6') }}" required 
               class="w-20 h-10 rounded-xl border border-slate-300 dark:border-slate-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Ícone (FontAwesome)</label>
        <input type="text" name="icon" value="{{ old('icon', $category->icon ?? '') }}" placeholder="fa-home" 
               class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Descrição</label>
        <textarea name="description" rows="2" 
                  class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200 resize-none"
                  placeholder="Descrição da categoria...">{{ old('description', $category->description ?? '') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Categoria Pai</label>
        <select name="parent_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <option value="">Nenhuma (Categoria Principal)</option>
            @foreach($allCategories as $parentCategory)
                @if(!isset($category) || $parentCategory->id !== $category->id)
                    <option value="{{ $parentCategory->id }}" @if(old('parent_id', $category->parent_id ?? '') == $parentCategory->id) selected @endif>
                        {{ $parentCategory->name }}
                    </option>
                @endif
            @endforeach
        </select>
    </div>
</div> 