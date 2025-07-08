@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Editar Fatura</h1>
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('faturas.update', $fatura->id) }}" method="POST" class="max-w-4xl bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')
        
        <!-- Informações Básicas -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block mb-1 font-semibold">Cliente</label>
                <select name="client_id" class="w-full border px-3 py-2 rounded" required>
                    <option value="">Selecione um cliente</option>
                    @foreach(\App\Models\Client::all() as $client)
                        <option value="{{ $client->id }}" {{ old('client_id', $fatura->client_id) == $client->id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Número da Fatura</label>
                <input type="text" name="invoice_number" class="w-full border px-3 py-2 rounded" value="{{ old('invoice_number', $fatura->invoice_number) }}">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Data de Emissão</label>
                <input type="date" name="issue_date" class="w-full border px-3 py-2 rounded" value="{{ old('issue_date', $fatura->issue_date ? $fatura->issue_date->format('Y-m-d') : date('Y-m-d')) }}">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Data de Vencimento</label>
                <input type="date" name="due_date" class="w-full border px-3 py-2 rounded" value="{{ old('due_date', $fatura->due_date ? $fatura->due_date->format('Y-m-d') : date('Y-m-d', strtotime('+30 days'))) }}">
            </div>
        </div>

        <!-- Serviços -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-4">Serviços</h3>
            <div id="services-container">
                @if($fatura->items->count() > 0)
                    @foreach($fatura->items as $index => $item)
                        <div class="service-item border rounded p-4 mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="block mb-1 text-sm font-medium">Descrição</label>
                                    <input type="text" name="services[{{ $index }}][description]" class="w-full border px-3 py-2 rounded text-sm" value="{{ $item->description }}" required>
                                </div>
                                <div>
                                    <label class="block mb-1 text-sm font-medium">Quantidade</label>
                                    <input type="number" name="services[{{ $index }}][quantity]" class="w-full border px-3 py-2 rounded text-sm" value="{{ $item->quantity }}" min="1" step="1" required>
                                </div>
                                <div>
                                    <label class="block mb-1 text-sm font-medium">Valor Unitário</label>
                                    <input type="number" step="0.01" name="services[{{ $index }}][unit_price]" class="w-full border px-3 py-2 rounded text-sm" value="{{ $item->unit_price }}" required>
                                </div>
                                <div>
                                    <label class="block mb-1 text-sm font-medium">Total</label>
                                    <input type="number" step="0.01" name="services[{{ $index }}][total]" class="w-full border px-3 py-2 rounded text-sm bg-gray-50" value="{{ $item->total }}" readonly>
                                </div>
                            </div>
                            @if($index > 0)
                                <button type="button" class="remove-service mt-2 bg-red-500 text-white px-2 py-1 rounded text-sm hover:bg-red-600">Remover</button>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="service-item border rounded p-4 mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block mb-1 text-sm font-medium">Descrição</label>
                                <input type="text" name="services[0][description]" class="w-full border px-3 py-2 rounded text-sm" placeholder="Descrição do serviço" required>
                            </div>
                            <div>
                                <label class="block mb-1 text-sm font-medium">Quantidade</label>
                                <input type="number" name="services[0][quantity]" class="w-full border px-3 py-2 rounded text-sm" value="1" min="1" step="1" required>
                            </div>
                            <div>
                                <label class="block mb-1 text-sm font-medium">Valor Unitário</label>
                                <input type="number" step="0.01" name="services[0][unit_price]" class="w-full border px-3 py-2 rounded text-sm" placeholder="0.00" required>
                            </div>
                            <div>
                                <label class="block mb-1 text-sm font-medium">Total</label>
                                <input type="number" step="0.01" name="services[0][total]" class="w-full border px-3 py-2 rounded text-sm bg-gray-50" readonly>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <button type="button" id="add-service" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                <i class="fas fa-plus mr-2"></i>Adicionar Serviço
            </button>
        </div>

        <!-- Totais -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label class="block mb-1 font-semibold">Subtotal</label>
                <input type="number" step="0.01" name="subtotal" id="subtotal" class="w-full border px-3 py-2 rounded bg-gray-50" value="{{ old('subtotal', $fatura->subtotal) }}" readonly>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Taxa de Imposto (%)</label>
                <input type="number" step="0.01" name="tax_rate" id="tax_rate" class="w-full border px-3 py-2 rounded" value="{{ old('tax_rate', $fatura->tax_rate) }}">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Valor do Imposto</label>
                <input type="number" step="0.01" name="tax_amount" id="tax_amount" class="w-full border px-3 py-2 rounded bg-gray-50" value="{{ old('tax_amount', $fatura->tax_amount) }}" readonly>
            </div>
        </div>

        <div class="mb-6">
            <label class="block mb-1 font-semibold">Total</label>
            <input type="number" step="0.01" name="total" id="total" class="w-full border px-3 py-2 rounded text-xl font-bold bg-blue-50" value="{{ old('total', $fatura->total) }}" required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block mb-1 font-semibold">Status</label>
                <select name="status" class="w-full border px-3 py-2 rounded" required>
                    <option value="">Selecione o status</option>
                    <option value="draft" {{ old('status', $fatura->status) == 'draft' ? 'selected' : '' }}>Rascunho</option>
                    <option value="sent" {{ old('status', $fatura->status) == 'sent' ? 'selected' : '' }}>Enviada</option>
                    <option value="paid" {{ old('status', $fatura->status) == 'paid' ? 'selected' : '' }}>Paga</option>
                    <option value="overdue" {{ old('status', $fatura->status) == 'overdue' ? 'selected' : '' }}>Vencida</option>
                    <option value="cancelled" {{ old('status', $fatura->status) == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block mb-1 font-semibold">Observações</label>
                <textarea name="notes" class="w-full border px-3 py-2 rounded" rows="3">{{ old('notes', $fatura->notes) }}</textarea>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Termos</label>
                <textarea name="terms" class="w-full border px-3 py-2 rounded" rows="3">{{ old('terms', $fatura->terms) }}</textarea>
            </div>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Atualizar Fatura</button>
            <a href="{{ route('faturas.index') }}" class="bg-gray-300 px-6 py-2 rounded">Cancelar</a>
        </div>
    </form>
</div>

<script>
let serviceIndex = {{ $fatura->items->count() > 0 ? $fatura->items->count() : 1 }};

document.getElementById('add-service').addEventListener('click', function() {
    const container = document.getElementById('services-container');
    const newService = document.createElement('div');
    newService.className = 'service-item border rounded p-4 mb-4';
    newService.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block mb-1 text-sm font-medium">Descrição</label>
                <input type="text" name="services[${serviceIndex}][description]" class="w-full border px-3 py-2 rounded text-sm" placeholder="Descrição do serviço" required>
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium">Quantidade</label>
                <input type="number" name="services[${serviceIndex}][quantity]" class="w-full border px-3 py-2 rounded text-sm" value="1" min="1" step="1" required>
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium">Valor Unitário</label>
                <input type="number" step="0.01" name="services[${serviceIndex}][unit_price]" class="w-full border px-3 py-2 rounded text-sm" placeholder="0.00" required>
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium">Total</label>
                <input type="number" step="0.01" name="services[${serviceIndex}][total]" class="w-full border px-3 py-2 rounded text-sm bg-gray-50" readonly>
            </div>
        </div>
        <button type="button" class="remove-service mt-2 bg-red-500 text-white px-2 py-1 rounded text-sm hover:bg-red-600">Remover</button>
    `;
    
    container.appendChild(newService);
    serviceIndex++;
    
    // Adicionar event listeners para o novo serviço
    addServiceEventListeners(newService);
});

// Função para adicionar event listeners aos campos de serviço
function addServiceEventListeners(serviceElement) {
    const quantityInput = serviceElement.querySelector('input[name*="[quantity]"]');
    const unitPriceInput = serviceElement.querySelector('input[name*="[unit_price]"]');
    const totalInput = serviceElement.querySelector('input[name*="[total]"]');
    
    function calculateTotal() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const total = quantity * unitPrice;
        totalInput.value = total.toFixed(2);
        calculateSubtotal();
    }
    
    quantityInput.addEventListener('input', calculateTotal);
    unitPriceInput.addEventListener('input', calculateTotal);
    
    // Adicionar event listener para remover serviço
    const removeButton = serviceElement.querySelector('.remove-service');
    if (removeButton) {
        removeButton.addEventListener('click', function() {
            serviceElement.remove();
            calculateSubtotal();
        });
    }
}

// Calcular subtotal
function calculateSubtotal() {
    const totals = Array.from(document.querySelectorAll('input[name*="[total]"]')).map(input => parseFloat(input.value) || 0);
    const subtotal = totals.reduce((sum, total) => sum + total, 0);
    document.getElementById('subtotal').value = subtotal.toFixed(2);
    
    // Calcular imposto
    const taxRate = parseFloat(document.getElementById('tax_rate').value) || 0;
    const taxAmount = subtotal * (taxRate / 100);
    document.getElementById('tax_amount').value = taxAmount.toFixed(2);
    
    // Calcular total
    const total = subtotal + taxAmount;
    document.getElementById('total').value = total.toFixed(2);
}

// Adicionar event listeners aos serviços existentes
document.querySelectorAll('.service-item').forEach(addServiceEventListeners);

// Event listener para taxa de imposto
document.getElementById('tax_rate').addEventListener('input', calculateSubtotal);
</script>
@endsection 