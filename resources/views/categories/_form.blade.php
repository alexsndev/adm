@php
    $types = [
        'income' => 'Receita',
        'expense' => 'Despesa',
    ];
@endphp

<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Nome</label>
        <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Tipo</label>
        <select name="type" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            @foreach($types as $key => $label)
                <option value="{{ $key }}" @if(old('type', $category->type ?? '') == $key) selected @endif>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Cor</label>
        <input type="color" name="color" value="{{ old('color', $category->color ?? '#3B82F6') }}" required class="mt-1 block w-20 h-10 rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Ícone (FontAwesome)</label>
        <input type="text" name="icon" value="{{ old('icon', $category->icon ?? '') }}" placeholder="fa-home" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Descrição</label>
        <textarea name="description" rows="2" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $category->description ?? '') }}</textarea>
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