@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="w-full px-0">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-700 dark:text-gray-300">Descrição:</span>
                            <span class="text-gray-900 dark:text-gray-100">{{ $transaction->description }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-700 dark:text-gray-300">Valor:</span>
                            <span class="text-lg font-semibold {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $transaction->type === 'income' ? '+' : '-' }}R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-700 dark:text-gray-300">Tipo:</span>
                            <span class="px-2 py-1 text-xs rounded-full {{ $transaction->type === 'income' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : ($transaction->type === 'expense' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300') }}">
                                {{ $transaction->type === 'income' ? 'Receita' : ($transaction->type === 'expense' ? 'Despesa' : 'Transferência') }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-700 dark:text-gray-300">Data:</span>
                            <span class="text-gray-900 dark:text-gray-100">{{ $transaction->date->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-700 dark:text-gray-300">Categoria:</span>
                            <span class="px-2 py-1 text-xs rounded-full" style="background-color: {{ $transaction->category->color ?? '#3B82F6' }}20; color: {{ $transaction->category->color ?? '#3B82F6' }};">
                                {{ $transaction->category->name ?? 'Sem categoria' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-700 dark:text-gray-300">Conta:</span>
                            <span class="text-gray-900 dark:text-gray-100">{{ $transaction->account->name ?? 'Sem conta' }}</span>
                        </div>
                        @if($transaction->transfer_account_id)
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Conta de Destino:</span>
                                <span class="text-gray-900 dark:text-gray-100">{{ $transaction->transferAccount->name ?? 'N/A' }}</span>
                            </div>
                        @endif
                        @if($transaction->notes)
                            <div class="flex justify-between items-start">
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Observações:</span>
                                <span class="text-gray-900 dark:text-gray-100 text-right max-w-xs">{{ $transaction->notes }}</span>
                            </div>
                        @endif
                        @if($transaction->reference)
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Referência:</span>
                                <span class="text-gray-900 dark:text-gray-100">{{ $transaction->reference }}</span>
                            </div>
                        @endif
                        @if($transaction->is_recurring)
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Recorrente:</span>
                                <span class="text-gray-900 dark:text-gray-100">Sim ({{ $transaction->recurring_frequency }})</span>
                            </div>
                            @if($transaction->recurring_end_date)
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold text-gray-700 dark:text-gray-300">Data de Fim:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ $transaction->recurring_end_date->format('d/m/Y') }}</span>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 