@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-900 dark:from-gray-900 dark:to-blue-900 py-8">
    <div class="container mx-auto max-w-4xl px-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold text-blue-900 dark:text-blue-200 flex items-center gap-3">
                    <i class="fa-solid fa-wallet text-2xl"></i>
                    Transações da Conta: <span class="text-blue-700 dark:text-blue-300">{{ $account->name }}</span>
                </h2>
                <p class="text-blue-700 dark:text-blue-300 mt-2 text-lg font-semibold">Saldo atual: <span class="font-bold">R$ {{ number_format($account->current_balance, 2, ',', '.') }}</span></p>
            </div>
            <a href="{{ route('accounts.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Voltar
            </a>
        </div>
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl overflow-x-auto">
            @if($transactions->count() > 0)
                <table class="min-w-full text-left divide-y divide-blue-200 dark:divide-blue-800">
                    <thead class="bg-blue-900">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-white uppercase tracking-wider">Data</th>
                            <th class="px-6 py-4 text-xs font-bold text-white uppercase tracking-wider">Descrição</th>
                            <th class="px-6 py-4 text-xs font-bold text-white uppercase tracking-wider">Categoria</th>
                            <th class="px-6 py-4 text-xs font-bold text-white uppercase tracking-wider">Tipo</th>
                            <th class="px-6 py-4 text-xs font-bold text-white uppercase tracking-wider">Valor</th>
                            <th class="px-6 py-4 text-xs font-bold text-white uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-blue-200 dark:divide-blue-800">
                        @foreach($transactions as $transaction)
                            <tr class="hover:bg-blue-50 dark:hover:bg-blue-800/50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-900 dark:text-blue-100">
                                    {{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-900 dark:text-blue-100">
                                    {{ $transaction->description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-700 dark:text-blue-300">
                                    {{ $transaction->category->name ?? 'Sem categoria' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm capitalize">
                                    @if($transaction->type == 'income')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fa-solid fa-arrow-down mr-1"></i> Receita
                                        </span>
                                    @elseif($transaction->type == 'expense')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fa-solid fa-arrow-up mr-1"></i> Despesa
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <i class="fa-solid fa-right-left mr-1"></i> Transferência
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('transactions.edit', $transaction) }}" class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold transition shadow gap-1" title="Editar"><i class="fa-solid fa-pen"></i> Editar</a>
                                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta transação?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold transition shadow gap-1" title="Excluir"><i class="fa-solid fa-trash"></i> Excluir</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-xl font-extrabold text-blue-900 dark:text-blue-200">Nenhuma transação</h3>
                    <p class="mt-1 text-base text-blue-700 dark:text-blue-300">Esta conta não possui transações registradas.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 