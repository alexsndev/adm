@extends('layouts.app')

@section('content')
<div class="container mx-auto py-4 md:py-8 px-2 md:px-4 max-w-3xl">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
        <div class="bg-green-100 dark:bg-green-900/30 rounded-xl p-4 md:p-6 shadow border border-green-200 dark:border-green-800 flex flex-col items-center">
            <div class="text-xl md:text-2xl font-bold text-green-700 dark:text-green-300 mb-1">R$ {{ number_format($totalRecebido, 2, ',', '.') }}</div>
            <div class="text-xs md:text-sm text-green-900 dark:text-green-200 font-semibold">Total Recebido</div>
        </div>
        <div class="bg-yellow-100 dark:bg-yellow-900/30 rounded-xl p-4 md:p-6 shadow border border-yellow-200 dark:border-yellow-800 flex flex-col items-center">
            <div class="text-xl md:text-2xl font-bold text-yellow-700 dark:text-yellow-300 mb-1">R$ {{ number_format($totalPendente, 2, ',', '.') }}</div>
            <div class="text-xs md:text-sm text-yellow-900 dark:text-yellow-200 font-semibold">Total Pendente</div>
        </div>
        <div class="bg-blue-100 dark:bg-blue-900/30 rounded-xl p-4 md:p-6 shadow border border-blue-200 dark:border-blue-800 flex flex-col items-center">
            <div class="text-xl md:text-2xl font-bold text-blue-700 dark:text-blue-300 mb-1">R$ {{ number_format($totalGeral, 2, ',', '.') }}</div>
            <div class="text-xs md:text-sm text-blue-900 dark:text-blue-200 font-semibold">Total Geral</div>
        </div>
    </div>
    <div class="mb-6 md:mb-8">
        <h2 class="text-base md:text-lg font-bold mb-3 text-gray-900 dark:text-white flex items-center gap-2">
            <i class="fa-solid fa-ranking-star text-yellow-500"></i>
            Ranking de Clientes (Total Recebido)
        </h2>
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow border border-gray-200 dark:border-gray-800 p-3 md:p-4">
            @forelse($rankingClientes as $item)
                <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-800 last:border-0">
                    <div class="flex items-center gap-3">
                        @if($item['cliente'] && $item['cliente']->photo)
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 font-bold text-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $item['cliente']->photo) }}" alt="Foto" class="w-8 h-8 object-cover rounded-full">
                            </span>
                        @else
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 font-bold text-lg">
                                <i class="fa-solid fa-user"></i>
                            </span>
                        @endif
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $item['nome'] }}</span>
                    </div>
                    <div class="font-bold text-green-700 dark:text-green-300">R$ {{ number_format($item['valor'], 2, ',', '.') }}</div>
                </div>
            @empty
                <div class="text-gray-400 text-center py-4">Nenhum cliente com diárias recebidas.</div>
            @endforelse
        </div>
    </div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h1 class="text-xl md:text-2xl font-bold flex items-center gap-2">
            <i class="fa-solid fa-list text-blue-600"></i>
            Gerenciar Diárias Previstas
        </h1>
        <button type="button" onclick="document.getElementById('modalDiariaRapida').classList.remove('hidden')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold shadow transition flex items-center gap-2 text-sm md:text-base">
            <i class="fa-solid fa-bolt"></i> <span class="hidden sm:inline">Lançar</span> Diária Rápida
        </button>
    </div>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-4 md:p-6 overflow-hidden">
        <!-- Desktop Table -->
        <div class="hidden md:block">
            <table class="w-full text-sm divide-y divide-gray-200 dark:divide-gray-800">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left">Data</th>
                        <th class="px-4 py-2 text-left">Cliente</th>
                        <th class="px-4 py-2 text-left">Valor</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Observação</th>
                        <th class="px-4 py-2 text-center">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($diarias as $diaria)
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($diaria->date)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ $diaria->client->name ?? '-' }}</td>
                            <td class="px-4 py-2 font-bold text-green-700 dark:text-green-400">R$ {{ number_format($diaria->amount, 2, ',', '.') }}</td>
                            <td class="px-4 py-2">
                                @if($diaria->status === 'pendente')
                                    <span class="inline-block px-2 py-1 rounded bg-yellow-100 text-yellow-800 text-xs font-semibold">Pendente</span>
                                @else
                                    <span class="inline-block px-2 py-1 rounded bg-green-100 text-green-800 text-xs font-semibold">Recebido</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $diaria->notes }}</td>
                                                    <td class="px-4 py-2 text-center">
                            <div class="flex gap-2 justify-center">
                                @if($diaria->status === 'pendente')
                                    <button type="button" onclick="abrirModalReceber({{ $diaria->id }}, '{{ $diaria->amount }}')" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-semibold">Receber</button>
                                @else
                                    <span class="text-green-600 font-bold">✓</span>
                                @endif
                                <button type="button" onclick="excluirDiaria({{ $diaria->id }})" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold">Excluir</button>
                            </div>
                        </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-400 py-8">Nenhuma diária prevista cadastrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Mobile Cards -->
        <div class="md:hidden space-y-4">
            @forelse($diarias as $diaria)
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                    <div class="mb-3">
                        <div class="font-semibold text-gray-900 dark:text-white mb-1">{{ $diaria->client->name ?? '-' }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ \Carbon\Carbon::parse($diaria->date)->format('d/m/Y') }}</div>
                        <div class="font-bold text-green-700 dark:text-green-400 text-lg mb-2">R$ {{ number_format($diaria->amount, 2, ',', '.') }}</div>
                    </div>
                    @if($diaria->notes)
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                            <span class="font-medium">Observação:</span> {{ $diaria->notes }}
                        </div>
                    @endif
                    <div class="flex justify-between items-center">
                        @if($diaria->status === 'pendente')
                            <span class="inline-block px-2 py-1 rounded bg-yellow-100 text-yellow-800 text-xs font-semibold">Pendente</span>
                        @else
                            <span class="inline-block px-2 py-1 rounded bg-green-100 text-green-800 text-xs font-semibold">Recebido</span>
                        @endif
                        <div class="flex gap-2">
                            @if($diaria->status === 'pendente')
                                <button type="button" onclick="abrirModalReceber({{ $diaria->id }}, '{{ $diaria->amount }}')" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-semibold">Receber</button>
                            @else
                                <span class="text-green-600 font-bold text-sm">✓ Recebido</span>
                            @endif
                            <button type="button" onclick="excluirDiaria({{ $diaria->id }})" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold">Excluir</button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-400 py-8">Nenhuma diária prevista cadastrada.</div>
            @endforelse
        </div>
    </div>
</div>
<!-- Modal Lançamento Rápido de Diária -->
<div id="modalDiariaRapida" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden p-4">
    <div class="bg-white rounded-xl shadow-lg p-4 md:p-8 w-full max-w-md relative max-h-[90vh] overflow-y-auto">
        <button type="button" onclick="document.getElementById('modalDiariaRapida').classList.add('hidden')" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-gray-900">Lançamento Rápido de Diária</h2>
        <form method="POST" action="{{ route('daily-forecasts.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-gray-700">Valor da diária</label>
                <input type="number" step="0.01" name="amount" class="w-full rounded px-3 py-2 border border-gray-300 text-gray-900" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-gray-700">Cliente pagante</label>
                <div class="flex gap-2">
                    <select name="client_id" id="clientSelect" class="flex-1 rounded px-3 py-2 border border-gray-300 text-gray-900">
                        <option value="">Selecione</option>
                        @foreach(\App\Models\Client::where('user_id', auth()->id())->orderBy('name')->get() as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                        @endforeach
                    </select>
                    <button type="button" onclick="abrirModalNovoCliente()" class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-gray-700">Data</label>
                <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full rounded px-3 py-2 border border-gray-300 text-gray-900" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-gray-700">Observação</label>
                <textarea name="notes" class="w-full rounded px-3 py-2 border border-gray-300 text-gray-900"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modalDiariaRapida').classList.add('hidden')" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Cancelar</button>
                <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700 font-semibold">Salvar</button>
            </div>
        </form>
    </div>
</div>
<!-- Modal Receber Diária -->
<div id="modalReceberDiaria" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden p-4">
    <div class="bg-white rounded-xl shadow-lg p-4 md:p-8 w-full max-w-md relative max-h-[90vh] overflow-y-auto">
        <button type="button" onclick="document.getElementById('modalReceberDiaria').classList.add('hidden')" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-gray-900">Receber Diária</h2>
        <form id="formReceberDiaria" method="POST" action="">
            @csrf
            <input type="hidden" name="diaria_id" id="inputDiariaId">
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-gray-700">Valor</label>
                <input type="text" id="inputDiariaValor" class="w-full rounded px-3 py-2 border border-gray-300 text-gray-900 bg-gray-100" readonly>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-gray-700">Conta para receber</label>
                <select name="account_id" class="w-full rounded px-3 py-2 border border-gray-300 text-gray-900" required>
                    <option value="">Selecione</option>
                    @foreach(\App\Models\Account::where('user_id', auth()->id())->orderBy('name')->get() as $conta)
                        <option value="{{ $conta->id }}">{{ $conta->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modalReceberDiaria').classList.add('hidden')" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Cancelar</button>
                <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700 font-semibold">Confirmar Recebimento</button>
            </div>
        </form>
    </div>
</div>
<!-- Modal Criar Novo Cliente -->
<div id="modalNovoCliente" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md relative max-h-[90vh] overflow-y-auto">
        <button type="button" onclick="fecharModalNovoCliente()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
        <h2 class="text-xl font-bold mb-4 text-gray-900">Criar Novo Cliente</h2>
        <form id="formNovoCliente" method="POST" action="{{ route('clientes.store-ajax') }}">
            @csrf
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-gray-700">Nome *</label>
                <input type="text" name="name" id="clienteName" class="w-full rounded px-3 py-2 border border-gray-300 text-gray-900" required>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-gray-700">Email</label>
                <input type="email" name="email" id="clienteEmail" class="w-full rounded px-3 py-2 border border-gray-300 text-gray-900">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-gray-700">Telefone</label>
                <input type="tel" name="phone" id="clientePhone" class="w-full rounded px-3 py-2 border border-gray-300 text-gray-900">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-gray-700">Empresa</label>
                <input type="text" name="company" id="clienteCompany" class="w-full rounded px-3 py-2 border border-gray-300 text-gray-900">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-gray-700">Endereço</label>
                <textarea name="address" id="clienteAddress" rows="2" class="w-full rounded px-3 py-2 border border-gray-300 text-gray-900"></textarea>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold text-gray-700">Observações</label>
                <textarea name="notes" id="clienteNotes" rows="2" class="w-full rounded px-3 py-2 border border-gray-300 text-gray-900"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="fecharModalNovoCliente()" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Cancelar</button>
                <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 font-semibold">Criar Cliente</button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirModalReceber(diariaId, valor) {
    document.getElementById('modalReceberDiaria').classList.remove('hidden');
    document.getElementById('inputDiariaId').value = diariaId;
    document.getElementById('inputDiariaValor').value = valor;
    document.getElementById('formReceberDiaria').action = '/diarias-previstas/' + diariaId + '/receive';
}

function abrirModalNovoCliente() {
    document.getElementById('modalNovoCliente').classList.remove('hidden');
}

function fecharModalNovoCliente() {
    document.getElementById('modalNovoCliente').classList.add('hidden');
    // Limpar formulário
    document.getElementById('formNovoCliente').reset();
}

function excluirDiaria(diariaId) {
    if (confirm('Tem certeza que deseja excluir esta diária?')) {
        fetch(`/diarias-previstas/${diariaId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                // Recarregar a página para atualizar a lista
                window.location.reload();
            } else {
                alert('Erro ao excluir diária. Tente novamente.');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao excluir diária. Tente novamente.');
        });
    }
}

// Submissão do formulário de novo cliente via AJAX
document.getElementById('formNovoCliente').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('{{ route("clientes.store-ajax") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Adicionar novo cliente ao select
            const clientSelect = document.getElementById('clientSelect');
            const option = document.createElement('option');
            option.value = data.client.id;
            option.textContent = data.client.name;
            clientSelect.appendChild(option);
            
            // Selecionar o novo cliente
            clientSelect.value = data.client.id;
            
            // Fechar modal
            fecharModalNovoCliente();
            
            // Mostrar mensagem de sucesso
            alert('Cliente criado com sucesso!');
        } else {
            alert('Erro ao criar cliente: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao criar cliente. Tente novamente.');
    });
});
</script>
@endsection 