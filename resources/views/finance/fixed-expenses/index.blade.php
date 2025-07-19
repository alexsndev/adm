@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 to-slate-100 dark:from-gray-900 dark:to-gray-800 py-8">
    <div class="container mx-auto max-w-4xl px-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-red-700 dark:text-red-300 flex items-center gap-3">
                    <i class="fa-solid fa-money-bill-trend-up text-2xl"></i>
                    Despesas Fixas
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Gerencie suas despesas recorrentes e pague antecipado se quiser!</p>
            </div>
            <a href="{{ route('finance.fixed-expenses.create') }}" class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <i class="fa-solid fa-plus mr-2"></i>
                Nova Despesa Fixa
            </a>
        </div>
        <form method="GET" class="mb-6 flex gap-2 items-center bg-white dark:bg-gray-900 rounded-xl shadow px-4 py-3">
            <label for="mes" class="text-gray-700 dark:text-gray-200 font-semibold">Mês:</label>
            <select name="mes" id="mes" class="rounded px-3 py-2 border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-red-500 focus:ring-red-500">
                @for($i = 0; $i < 12; $i++)
                    @php $data = now()->addMonths($i); @endphp
                    <option value="{{ $data->format('Y-m') }}" {{ request('mes', now()->format('Y-m')) == $data->format('Y-m') ? 'selected' : '' }}>
                        {{ $data->format('m/Y') }}
                    </option>
                @endfor
            </select>
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold shadow transition">Filtrar</button>
        </form>
        @if(session('success'))
            <div class="bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-6 py-4 rounded-xl mb-6 flex items-center animate-fade-in">
                <i class="fa-solid fa-check-circle mr-3 text-green-600 dark:text-green-400"></i>
                {{ session('success') }}
            </div>
        @endif
        @php
            $pagamentos = \App\Models\Transaction::where('is_recurring', false)
                ->where('type', 'expense')
                ->where('user_id', auth()->id())
                ->whereMonth('date', $mesSelecionado = request('mes', now()->format('Y-m')) ? explode('-', request('mes', now()->format('Y-m')))[1] : now()->month)
                ->whereYear('date', $anoSelecionado = request('mes', now()->format('Y-m')) ? explode('-', request('mes', now()->format('Y-m')))[0] : now()->year)
                ->pluck('description');
        @endphp
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl overflow-x-auto">
            <table class="min-w-full text-left divide-y divide-gray-200 dark:divide-gray-800">
                <thead class="bg-red-100 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Descrição</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Valor</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Categoria</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Conta</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Frequência</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Dia</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($despesasFixas as $despesa)
                        @php
                            $jaPago = $pagamentos->contains(fn($desc) => str_contains($desc, $despesa->description));
                        @endphp
                        <tr class="hover:bg-red-50 dark:hover:bg-gray-800/50 transition-colors duration-200">
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">{{ $despesa->description }}</td>
                            <td class="px-6 py-4 text-red-700 dark:text-red-300 font-bold">R$ {{ number_format($despesa->amount, 2, ',', '.') }}</td>
                            <td class="px-6 py-4">{{ $despesa->category->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $despesa->account->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ ucfirst($despesa->recurring_frequency) }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($despesa->date)->format('d') }}</td>
                            <td class="px-6 py-4 flex gap-2 items-center">
                                @if($jaPago)
                                    <span title="Pago" class="tooltip"><i class="fa-solid fa-check-circle text-green-500 text-xl"></i></span>
                                    <form action="{{ route('finance.fixed-expenses.unpay', $despesa->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="mes" value="{{ request('mes', now()->format('Y-m')) }}">
                                        <button type="submit" class="text-yellow-500 hover:underline font-semibold" title="Desfazer pagamento"><i class="fa-solid fa-rotate-left"></i> Desfazer</button>
                                    </form>
                                @else
                                    <form action="{{ route('finance.fixed-expenses.pay', $despesa->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="mes" value="{{ request('mes', now()->format('Y-m')) }}">
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold shadow transition flex items-center gap-2" title="Pagar">
                                            <i class="fa-solid fa-money-bill-wave"></i> Pagar
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('finance.fixed-expenses.edit', $despesa->id) }}" class="text-blue-600 hover:underline font-semibold flex items-center gap-1" title="Editar"><i class="fa-solid fa-pen"></i> Editar</a>
                                <form action="{{ route('finance.fixed-expenses.destroy', $despesa->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline font-semibold flex items-center gap-1" title="Excluir"><i class="fa-solid fa-trash"></i> Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-gray-400 py-8">Nenhuma despesa fixa cadastrada.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .tooltip:hover::after {
        content: attr(title);
        position: absolute;
        background: #222;
        color: #fff;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.85rem;
        top: 120%;
        left: 50%;
        transform: translateX(-50%);
        white-space: nowrap;
        z-index: 10;
    }
</style>
@endsection 