@php
    $types = [
        'checking' => 'Conta Corrente',
        'savings' => 'Poupança',
        'credit' => 'Cartão de Crédito',
        'cash' => 'Dinheiro',
        'investment' => 'Investimento',
    ];
@endphp

<div class="space-y-6">
    <div>
        <x-input-label for="name" :value="__('Nome')" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $account->name ?? '')" required autofocus />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="type" :value="__('Tipo')" />
        <select id="type" name="type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
            @foreach($types as $key => $label)
                <option value="{{ $key }}" @if(old('type', $account->type ?? '') == $key) selected @endif>{{ $label }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('type')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="initial_balance" :value="__('Saldo Inicial')" />
        <x-text-input id="initial_balance" name="initial_balance" type="number" step="0.01" class="mt-1 block w-full" :value="old('initial_balance', $account->initial_balance ?? 0)" required />
        <x-input-error :messages="$errors->get('initial_balance')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="currency" :value="__('Moeda')" />
        <x-text-input id="currency" name="currency" type="text" class="mt-1 block w-24" :value="old('currency', $account->currency ?? 'BRL')" maxlength="3" required />
        <x-input-error :messages="$errors->get('currency')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="description" :value="__('Descrição')" />
        <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $account->description ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div class="flex items-center">
        <input id="is_active" name="is_active" type="checkbox" value="1" @if(old('is_active', $account->is_active ?? true)) checked @endif class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
        <x-input-label for="is_active" :value="__('Ativa')" class="ml-2" />
        <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Logo do Banco</label>
        @if(isset($account) && $account->logo)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $account->logo) }}" alt="Logo do Banco" class="w-16 h-16 rounded-full object-cover shadow border border-gray-300 dark:border-gray-700">
            </div>
        @endif
        <input type="file" name="logo" accept="image/*" class="mt-1 block w-full text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400">
        @error('logo')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
</div> 