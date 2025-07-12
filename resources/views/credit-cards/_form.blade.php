@php
    $types = [
        'credit' => 'Cartão de Crédito',
        'debit' => 'Cartão de Débito',
        'prepaid' => 'Cartão Pré-pago',
    ];
@endphp

<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nome do Cartão</label>
        <input type="text" name="name" value="{{ old('name', $creditCard->name ?? '') }}" required 
               class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200"
               placeholder="Ex: Nubank, Itaú, etc.">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Tipo</label>
        <select name="type" required 
                class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white transition-all duration-200">
            <option value="">Selecione o tipo</option>
            @foreach($types as $key => $label)
                <option value="{{ $key }}" @if(old('type', $creditCard->type ?? '') == $key) selected @endif>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Limite de Crédito</label>
        <input type="number" step="0.01" name="credit_limit" value="{{ old('credit_limit', $creditCard->credit_limit ?? '') }}" 
               class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200"
               placeholder="0.00">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Dia de Vencimento da Fatura</label>
        <input type="number" name="due_day" id="due_day" min="1" max="31" value="{{ old('due_day', $creditCard->due_day ?? '') }}" 
               class="w-32 px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200" 
               placeholder="Ex: 10">
        <span class="text-xs text-slate-500 dark:text-slate-400">Informe apenas o dia do mês (1 a 31)</span>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Cor do Cartão</label>
        <input type="text" name="color" value="{{ old('color', $creditCard->color ?? '') }}" 
               class="w-32 px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200" 
               placeholder="Ex: bg-blue-600">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Logo (opcional)</label>
        <input type="file" name="logo" accept="image/*" 
               class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400 transition-all duration-200">
        @if(!empty($creditCard->logo))
            <img src="{{ asset('storage/' . $creditCard->logo) }}" alt="Logo atual" class="h-10 mt-2 rounded shadow">
        @endif
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Notas</label>
        <textarea name="notes" rows="2" 
                  class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200 resize-none"
                  placeholder="Observações sobre o cartão...">{{ old('notes', $creditCard->notes ?? '') }}</textarea>
    </div>
    <div class="flex items-center">
        <input type="checkbox" name="is_active" id="is_active" 
               class="rounded border-slate-300 dark:border-slate-600 text-blue-600 dark:text-blue-400 shadow-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700" 
               @if(old('is_active', $creditCard->is_active ?? true)) checked @endif>
        <label for="is_active" class="ml-2 block text-sm text-slate-700 dark:text-slate-300">Ativo</label>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validação do dia de vencimento
    const dueDayInput = document.getElementById('due_day');
    dueDayInput.addEventListener('input', function() {
        const value = parseInt(this.value);
        if (value < 1 || value > 31) {
            this.setCustomValidity('O dia deve estar entre 1 e 31');
        } else {
            this.setCustomValidity('');
        }
    });
});
</script>
@endpush 