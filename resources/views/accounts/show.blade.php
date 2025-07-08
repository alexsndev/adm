@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                            {{ __('Detalhes da Conta') }}
                        </h2>
                        <div class="flex space-x-3">
                            <a href="{{ route('accounts.edit', $account) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Editar
                            </a>
                            <a href="{{ route('accounts.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Voltar
                            </a>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Informações da Conta</h3>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nome</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $account->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipo</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 capitalize">{{ $account->type }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Saldo Atual</dt>
                                    <dd class="mt-1 text-lg font-semibold text-green-600 dark:text-green-400">R$ {{ number_format($account->current_balance, 2, ',', '.') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Moeda</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $account->currency ?? 'BRL' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                    <dd class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $account->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                            {{ $account->is_active ? 'Ativa' : 'Inativa' }}
                                        </span>
                                    </dd>
                                </div>
                                @if($account->description)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Descrição</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $account->description }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Transações Recentes</h3>
                            @if(isset($transactions) && $transactions->count() > 0)
                                <div class="space-y-3">
                                    @foreach($transactions->take(5) as $transaction)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $transaction->description }}</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $transaction->date->format('d/m/Y') }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-medium text-{{ $transaction->type === 'income' ? 'green' : 'red' }}-600 dark:text-{{ $transaction->type === 'income' ? 'green' : 'red' }}-400">
                                                    {{ $transaction->type === 'income' ? '+' : '-' }}R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if($transactions->count() > 5)
                                    <div class="mt-4 text-center">
                                        <a href="{{ route('transactions.index', ['account' => $account->id]) }}" class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-medium">
                                            Ver todas as transações
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Nenhuma transação</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Esta conta ainda não possui transações.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dívidas vinculadas à conta --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-red-700 dark:text-red-300 mb-4 flex items-center">
                        <i class="fa-solid fa-money-bill-wave mr-2"></i> Dívidas vinculadas a esta conta
                    </h3>
                    @if($debts->count())
                        <div class="space-y-3">
                            @foreach($debts as $debt)
                                <div class="flex items-center justify-between p-3 bg-red-50 dark:bg-red-900/30 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $debt->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Vencimento: {{ $debt->due_date ? $debt->due_date->format('d/m/Y') : '-' }}</p>
                                        @if($debt->creditCard)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200">
                                                <i class="fa-solid fa-credit-card mr-1"></i> Cartão: {{ $debt->creditCard->display_name }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <span class="font-bold text-red-700 dark:text-red-300">R$ {{ number_format($debt->current_balance, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">Nenhuma dívida vinculada a esta conta.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Cartões de crédito vinculados à conta --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-blue-700 dark:text-blue-300 mb-4 flex items-center">
                        <i class="fa-solid fa-credit-card mr-2"></i> Cartões de Crédito desta conta
                    </h3>
                    @if($creditCards->count())
                        <div class="space-y-6">
                            @foreach($creditCards as $card)
                                <div class="p-4 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex flex-col md:flex-row md:items-center md:justify-between">
                                    <div class="flex items-center space-x-4">
                                        <img src="{{ $card->logo_url }}" alt="Logo" class="h-10 w-16 rounded shadow bg-white">
                                        <div>
                                            <div class="font-bold text-blue-900 dark:text-blue-100">{{ $card->display_name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">Limite: R$ {{ number_format($card->credit_limit, 2, ',', '.') }}</div>
                                        </div>
                                    </div>
                                    <div class="mt-4 md:mt-0">
                                        <span class="text-sm text-gray-700 dark:text-gray-200">Saldo atual: </span>
                                        <span class="font-bold text-blue-700 dark:text-blue-300">R$ {{ number_format($card->current_balance, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                                @if($card->debts->count())
                                    <div class="ml-8 mt-2 mb-4">
                                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Dívidas deste cartão:</h4>
                                        <ul class="space-y-1">
                                            @foreach($card->debts as $debt)
                                                <li class="flex items-center justify-between bg-red-100 dark:bg-red-900/30 rounded px-3 py-1">
                                                    <span>{{ $debt->name }}</span>
                                                    <span class="font-bold text-red-700 dark:text-red-300">R$ {{ number_format($debt->current_balance, 2, ',', '.') }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">Nenhum cartão de crédito cadastrado para esta conta.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection 