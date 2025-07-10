@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 overflow-x-hidden w-full max-w-full">
    <div class="container mx-auto px-2 md:px-4 py-4 md:py-8 w-full max-w-full">
        <div class="mb-8 text-center fade-in-up w-full max-w-full">
            <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent mb-4 w-full max-w-full">
                Dashboard Geral
            </h1>
            <p class="text-slate-600 dark:text-slate-300 text-lg max-w-2xl mx-auto w-full max-w-full">
                Visão geral de eventos, finanças, tarefas, aniversários, metas e muito mais.
            </p>
        </div>
        <!-- Cards de resumo -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8 fade-in-up w-full max-w-full min-w-0">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 shadow-lg border border-slate-200 dark:border-slate-700 flex flex-col items-center w-full max-w-full min-w-0">
                <span class="text-xs text-slate-500 dark:text-slate-400 mb-1 break-words">Saldo Total</span>
                <span class="text-2xl font-bold text-green-600 dark:text-green-400 break-words">R$ {{ number_format($totalBalance ?? 0, 2, ',', '.') }}</span>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 shadow-lg border border-slate-200 dark:border-slate-700 flex flex-col items-center w-full max-w-full min-w-0">
                <span class="text-xs text-slate-500 dark:text-slate-400 mb-1 break-words">Receitas do Mês</span>
                <span class="text-2xl font-bold text-blue-600 dark:text-blue-400 break-words">R$ {{ number_format($monthlyIncome ?? 0, 2, ',', '.') }}</span>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 shadow-lg border border-slate-200 dark:border-slate-700 flex flex-col items-center w-full max-w-full min-w-0">
                <span class="text-xs text-slate-500 dark:text-slate-400 mb-1 break-words">Despesas do Mês</span>
                <span class="text-2xl font-bold text-red-600 dark:text-red-400 break-words">R$ {{ number_format($monthlyExpenses ?? 0, 2, ',', '.') }}</span>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 shadow-lg border border-slate-200 dark:border-slate-700 flex flex-col items-center w-full max-w-full min-w-0">
                <span class="text-xs text-slate-500 dark:text-slate-400 mb-1 break-words">Transações</span>
                <span class="text-2xl font-bold text-purple-600 dark:text-purple-400 break-words">{{ $totalTransactions ?? 0 }}</span>
            </div>
        </div>
        <!-- Tabela de Transações Recentes -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 mb-8 fade-in-up flex flex-col items-center w-full max-w-full overflow-x-auto">
            <h2 class="text-lg font-semibold mb-4 text-slate-700 dark:text-slate-200 w-full max-w-full">Transações Recentes</h2>
            <div class="w-full flex justify-center">
                <div class="overflow-x-auto w-full min-w-0 max-w-full">
                    <table class="min-w-full text-xs sm:text-sm divide-y divide-gray-200 dark:divide-gray-800 max-w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase break-words">Data</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase break-words">Conta</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase break-words">Categoria</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase break-words">Tipo</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase break-words">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions ?? [] as $transaction)
                                <tr>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200 break-words">{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200 break-words">{{ $transaction->account->name ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200 break-words">{{ $transaction->category->name ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200 break-words">
                                        <span class="px-2 py-1 rounded-full text-xs font-bold break-words {{ $transaction->type === 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $transaction->type === 'income' ? 'Receita' : 'Despesa' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap text-sm text-right font-bold break-words {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-gray-500 dark:text-gray-400 py-8 break-words">Nenhuma transação recente.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Outras seções podem ser adicionadas aqui, seguindo o mesmo padrão responsivo -->
    </div>
</div>
@endsection 