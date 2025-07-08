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
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Descrição</label>
        <input type="text" name="description" value="{{ old('description', $transaction->description ?? '') }}" required class="mt-1 block w-full rounded bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-400 @error('description') border-red-500 @enderror">
        @error('description')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
    
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Valor</label>
        <input type="number" step="0.01" name="amount" value="{{ old('amount', $transaction->amount ?? '') }}" required class="mt-1 block w-full rounded bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-400 @error('amount') border-red-500 @enderror">
        @error('amount')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
    
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tipo</label>
        <select name="type" id="transaction-type" required class="mt-1 block w-full rounded bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-gray-100 @error('type') border-red-500 @enderror">
            @foreach($types as $key => $label)
                <option value="{{ $key }}" @if(old('type', $transaction->type ?? '') == $key) selected @endif>{{ $label }}</option>
            @endforeach
        </select>
        @error('type')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
    
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Data</label>
        <input type="date" name="date" value="{{ old('date', $transaction->date ?? date('Y-m-d')) }}" required class="mt-1 block w-full rounded bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-gray-100 @error('date') border-red-500 @enderror">
        @error('date')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
    
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Categoria</label>
        <select name="category_id" required class="mt-1 block w-full rounded bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-gray-100 @error('category_id') border-red-500 @enderror">
            <option value="">Selecione uma categoria</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @if(old('category_id', $transaction->category_id ?? '') == $category->id) selected @endif>
                    {{ $category->name }} ({{ $category->type === 'income' ? 'Receita' : 'Despesa' }})
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
    
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Conta</label>
        <select name="account_id" required class="mt-1 block w-full rounded bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-gray-100 @error('account_id') border-red-500 @enderror">
            <option value="">Selecione uma conta</option>
            @foreach($accounts as $account)
                <option value="{{ $account->id }}" @if(old('account_id', $transaction->account_id ?? '') == $account->id) selected @endif>
                    {{ $account->name }} - R$ {{ number_format($account->current_balance, 2, ',', '.') }}
                </option>
            @endforeach
        </select>
        @error('account_id')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
    
    <div id="transfer-account-field" style="display: none;">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Conta de Destino</label>
        <select name="transfer_account_id" class="mt-1 block w-full rounded bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-gray-100 @error('transfer_account_id') border-red-500 @enderror">
            <option value="">Selecione uma conta de destino</option>
            @foreach($accounts as $account)
                <option value="{{ $account->id }}" @if(old('transfer_account_id', $transaction->transfer_account_id ?? '') == $account->id) selected @endif>
                    {{ $account->name }} - R$ {{ number_format($account->current_balance, 2, ',', '.') }}
                </option>
            @endforeach
        </select>
        @error('transfer_account_id')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
    
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Observações</label>
        <textarea name="notes" rows="2" class="mt-1 block w-full rounded bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-400 @error('notes') border-red-500 @enderror">{{ old('notes', $transaction->notes ?? '') }}</textarea>
        @error('notes')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
    
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Referência</label>
        <input type="text" name="reference" value="{{ old('reference', $transaction->reference ?? '') }}" placeholder="Número do cheque, etc." class="mt-1 block w-full rounded bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-400 @error('reference') border-red-500 @enderror">
        @error('reference')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
    
    <div class="flex items-center">
        <input type="checkbox" name="is_recurring" value="1" @if(old('is_recurring', $transaction->is_recurring ?? false)) checked @endif class="rounded border-gray-300 dark:border-gray-700 text-blue-600 shadow-sm focus:ring-blue-500 dark:focus:ring-blue-400">
        <label class="ml-2 text-sm text-gray-700 dark:text-gray-200">Transação Recorrente</label>
    </div>
    
    <div id="recurring-fields" style="display: none;">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Frequência</label>
            <select name="recurring_frequency" class="mt-1 block w-full rounded bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-gray-100 @error('recurring_frequency') border-red-500 @enderror">
                <option value="weekly" @if(old('recurring_frequency', $transaction->recurring_frequency ?? '') == 'weekly') selected @endif>Semanal</option>
                <option value="monthly" @if(old('recurring_frequency', $transaction->recurring_frequency ?? '') == 'monthly') selected @endif>Mensal</option>
                <option value="yearly" @if(old('recurring_frequency', $transaction->recurring_frequency ?? '') == 'yearly') selected @endif>Anual</option>
            </select>
            @error('recurring_frequency')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Data de Fim</label>
            <input type="date" name="recurring_end_date" value="{{ old('recurring_end_date', $transaction->recurring_end_date ?? '') }}" class="mt-1 block w-full rounded bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 text-gray-900 dark:text-gray-100 @error('recurring_end_date') border-red-500 @enderror">
            @error('recurring_end_date')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>
    
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Pagamento de Dívida Negociada</label>
        <select name="debt_id" class="mt-1 block w-full rounded bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 shadow-sm focus:ring-green-500 focus:border-green-500 dark:focus:ring-green-400 dark:focus:border-green-400 text-gray-900 dark:text-gray-100">
            <option value="">Não vincular a dívida</option>
            @foreach($negotiatedDebts as $debt)
                <option value="{{ $debt->id }}" @if(old('debt_id', $transaction->debt_id ?? '') == $debt->id) selected @endif>
                    {{ $debt->name }} ({{ $debt->installments }}x de R$ {{ number_format($debt->installment_amount, 2, ',', '.') }})
                </option>
            @endforeach
        </select>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Selecione para registrar o pagamento de uma parcela de dívida negociada.</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('transaction-type');
    const transferField = document.getElementById('transfer-account-field');
    const recurringCheckbox = document.querySelector('input[name="is_recurring"]');
    const recurringFields = document.getElementById('recurring-fields');
    
    function toggleTransferField() {
        if (typeSelect.value === 'transfer') {
            transferField.style.display = 'block';
        } else {
            transferField.style.display = 'none';
        }
    }
    
    function toggleRecurringFields() {
        if (recurringCheckbox.checked) {
            recurringFields.style.display = 'block';
        } else {
            recurringFields.style.display = 'none';
        }
    }
    
    typeSelect.addEventListener('change', toggleTransferField);
    recurringCheckbox.addEventListener('change', toggleRecurringFields);
    
    // Initialize on page load
    toggleTransferField();
    toggleRecurringFields();
});
</script> 