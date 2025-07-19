@php
    $types = [
        'checking' => 'Conta Corrente',
        'savings' => 'Poupança',
        'credit' => 'Cartão de Crédito',
        'cash' => 'Dinheiro',
        'investment' => 'Investimento',
    ];
    $contas = \App\Models\Account::where('user_id', auth()->id())->orderBy('name')->get();
@endphp

<div class="space-y-6">
    <div>
        <x-input-label for="name" :value="__('Nome')" class="text-slate-700 dark:text-slate-300" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-900 text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200" :value="old('name', $account->name ?? '')" required autofocus placeholder="Digite o nome da conta" />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="type" :value="__('Tipo')" class="text-slate-700 dark:text-slate-300" />
        <select id="type" name="type" class="mt-1 block w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-900 text-white transition-all duration-200" required>
            <option value="">Selecione o tipo de conta</option>
            @foreach($types as $key => $label)
                <option value="{{ $key }}" @if(old('type', $account->type ?? '') == $key) selected @endif>{{ $label }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('type')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="initial_balance" :value="__('Saldo Inicial')" class="text-slate-700 dark:text-slate-300" />
        <x-text-input id="initial_balance" name="initial_balance" type="number" step="0.01" class="mt-1 block w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-900 text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200" :value="old('initial_balance', $account->initial_balance ?? 0)" required placeholder="0.00" />
        <x-input-error :messages="$errors->get('initial_balance')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="currency" :value="__('Moeda')" class="text-slate-700 dark:text-slate-300" />
        <x-text-input id="currency" name="currency" type="text" class="mt-1 block w-24 px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-900 text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200" :value="old('currency', $account->currency ?? 'BRL')" maxlength="3" required placeholder="BRL" />
        <x-input-error :messages="$errors->get('currency')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="description" :value="__('Descrição')" class="text-slate-700 dark:text-slate-300" />
        <textarea id="description" name="description" rows="3" class="mt-1 block w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-900 text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200 resize-none" placeholder="Descrição da conta">{{ old('description', $account->description ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="related_account_id" :value="__('Conta Relacionada')" class="text-slate-700 dark:text-slate-300" />
        <select id="related_account_id" name="related_account_id" class="mt-1 block w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-900 text-white transition-all duration-200">
            <option value="">Selecione uma conta</option>
            @foreach($contas as $conta)
                @if(!isset($account) || $account->id !== $conta->id)
                    <option value="{{ $conta->id }}" @if(old('related_account_id', $account->related_account_id ?? '') == $conta->id) selected @endif>{{ $conta->name }}</option>
                @endif
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('related_account_id')" class="mt-2" />
    </div>

    <div class="flex items-center">
        <input id="is_active" name="is_active" type="checkbox" value="1" @if(old('is_active', $account->is_active ?? true)) checked @endif class="rounded border-slate-300 dark:border-slate-600 text-blue-600 dark:text-blue-400 shadow-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 focus:ring-2 bg-gray-900">
        <x-input-label for="is_active" :value="__('Ativa')" class="ml-2 text-slate-700 dark:text-slate-300" />
        <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Logo do Banco</label>
        @if(isset($account) && $account->logo)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $account->logo) }}" alt="Logo do Banco" class="w-16 h-16 rounded-full object-cover shadow border border-slate-300 dark:border-slate-700">
            </div>
        @endif
        <input type="file" name="logo" accept="image/*" class="mt-1 block w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-900 text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400 transition-all duration-200">
        @error('logo')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
</div> 