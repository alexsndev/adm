@php
    $brands = [
        'visa' => 'Visa',
        'mastercard' => 'Mastercard',
        'elo' => 'Elo',
        'amex' => 'American Express',
        'hipercard' => 'Hipercard',
        'discover' => 'Discover',
        'jcb' => 'JCB',
        'other' => 'Outro',
    ];
@endphp
@if ($errors->any())
    <div class="mb-4">
        <ul class="text-red-600 text-sm font-semibold">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Banco/Conta *</label>
        <select name="account_id" id="account_id" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            <option value="">Selecione o banco</option>
            @foreach($accounts as $account)
                <option value="{{ $account->id }}" data-balance="{{ $account->current_balance }}" @if(old('account_id', $creditCard->account_id ?? '') == $account->id) selected @endif>{{ $account->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nome do Cartão *</label>
        <input type="text" name="name" value="{{ old('name', $creditCard->name ?? '') }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Bandeira *</label>
        <select name="brand" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            @foreach($brands as $key => $label)
                <option value="{{ $key }}" @if(old('brand', $creditCard->brand ?? '') == $key) selected @endif>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Últimos 4 dígitos</label>
        <input type="text" name="last_four_digits" maxlength="4" value="{{ old('last_four_digits', $creditCard->last_four_digits ?? '') }}" class="mt-1 block w-24 rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Limite de Crédito</label>
        <input type="number" step="0.01" name="credit_limit" value="{{ old('credit_limit', $creditCard->credit_limit ?? '') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Saldo Atual</label>
        <input type="number" step="0.01" name="current_balance" id="current_balance" value="{{ old('current_balance', $creditCard->current_balance ?? '') }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Dia de Vencimento da Fatura</label>
        <input type="number" name="due_day" id="due_day" min="1" max="31" value="{{ old('due_day', $creditCard->due_day ?? '') }}" class="mt-1 block w-32 rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Ex: 10">
        <span class="text-xs text-gray-500 dark:text-gray-400">Informe apenas o dia do mês (1 a 31)</span>
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Cor do Cartão</label>
        <input type="text" name="color" value="{{ old('color', $creditCard->color ?? '') }}" class="mt-1 block w-32 rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Ex: bg-blue-600">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Logo (opcional)</label>
        <input type="file" name="logo" accept="image/*" class="mt-1 block w-full text-sm text-gray-500">
        @if(!empty($creditCard->logo))
            <img src="{{ asset('storage/' . $creditCard->logo) }}" alt="Logo atual" class="h-10 mt-2 rounded shadow">
        @endif
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Notas</label>
        <textarea name="notes" rows="2" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('notes', $creditCard->notes ?? '') }}</textarea>
    </div>
    <div class="flex items-center">
        <input type="checkbox" name="is_active" id="is_active" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" @if(old('is_active', $creditCard->is_active ?? true)) checked @endif>
        <label for="is_active" class="ml-2 block text-sm text-gray-700 dark:text-gray-200">Ativo</label>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const accountSelect = document.getElementById('account_id');
        const balanceInput = document.getElementById('current_balance');
        if(accountSelect && balanceInput) {
            accountSelect.addEventListener('change', function() {
                const selected = accountSelect.options[accountSelect.selectedIndex];
                const balance = selected.getAttribute('data-balance');
                if(balance !== null) {
                    balanceInput.value = balance;
                }
            });
            // Preencher saldo ao carregar se já houver conta selecionada
            const selected = accountSelect.options[accountSelect.selectedIndex];
            const balance = selected.getAttribute('data-balance');
            if(balance !== null && accountSelect.value) {
                balanceInput.value = balance;
            }
        }
    });
</script>
@endpush 