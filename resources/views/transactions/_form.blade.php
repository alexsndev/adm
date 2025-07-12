@php
    $types = [
        'income' => 'Receita',
        'expense' => 'Despesa',
        'transfer' => 'Transferência',
    ];
    
    $user = auth()->user();
    $categories = \App\Models\Category::where('user_id', $user->id)->orderBy('name')->get();
    $accounts = \App\Models\Account::where('user_id', $user->id)->where('is_active', true)->orderBy('name')->get();
    $negotiatedDebts = \App\Models\Debt::where('user_id', $user->id)
        ->where('is_negotiated', true)
        ->where('status', 'active')
        ->orderBy('name')->get();
@endphp

<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Descrição</label>
        <input type="text" name="description" value="{{ old('description', $transaction->description ?? '') }}" required 
               class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200 @error('description') border-red-500 @enderror"
               placeholder="Digite a descrição da transação">
        @error('description')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
    
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Valor</label>
        <input type="number" step="0.01" name="amount" value="{{ old('amount', $transaction->amount ?? '') }}" required 
               class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200 @error('amount') border-red-500 @enderror"
               placeholder="0.00">
        @error('amount')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
    
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Tipo</label>
        <select name="type" required 
                class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white transition-all duration-200">
            <option value="">Selecione o tipo</option>
            @foreach($types as $key => $label)
                <option value="{{ $key }}" @if(old('type', $transaction->type ?? '') == $key) selected @endif>{{ $label }}</option>
            @endforeach
        </select>
        @error('type')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
    
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Categoria</label>
        <select name="category_id" 
                class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white transition-all duration-200">
            <option value="">Selecione uma categoria</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @if(old('category_id', $transaction->category_id ?? '') == $category->id) selected @endif>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
    
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Conta</label>
        <select name="account_id" required 
                class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white transition-all duration-200">
            <option value="">Selecione uma conta</option>
            @foreach($accounts as $account)
                <option value="{{ $account->id }}" @if(old('account_id', $transaction->account_id ?? '') == $account->id) selected @endif>{{ $account->name }}</option>
            @endforeach
        </select>
        @error('account_id')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
    
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Data</label>
        <input type="date" name="date" value="{{ old('date', $transaction->date ?? date('Y-m-d')) }}" required 
               class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white transition-all duration-200">
        @error('date')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
    
    @if($negotiatedDebts->count() > 0)
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Dívida Negociada (opcional)</label>
        <select name="debt_id" 
                class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white transition-all duration-200">
            <option value="">Nenhuma</option>
            @foreach($negotiatedDebts as $debt)
                <option value="{{ $debt->id }}" @if(old('debt_id', $transaction->debt_id ?? '') == $debt->id) selected @endif>{{ $debt->name }}</option>
            @endforeach
        </select>
        @error('debt_id')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
    @endif
    
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Notas</label>
        <textarea name="notes" rows="3" 
                  class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200 resize-none"
                  placeholder="Observações sobre a transação...">{{ old('notes', $transaction->notes ?? '') }}</textarea>
        @error('notes')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
</div> 