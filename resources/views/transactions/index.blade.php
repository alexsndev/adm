@extends('layouts.app')

@section('content')
    <div class="py-6 bg-gray-50 dark:bg-gray-900 w-full max-w-full">
        <div class="w-full px-0 min-w-0">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-4 sm:p-6">
                @if(session('success'))
                    <div class="mb-6 bg-green-100 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-200 px-4 py-3 rounded relative animate-fade-in" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-lg sm:text-2xl font-bold mb-4">Transações</h1>
                    <div class="flex gap-2">
                        <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold shadow transition-all duration-200">
                            <i class="fa-solid fa-plus mr-2"></i> Criar Transação
                        </a>
                        <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold shadow transition-all duration-200">
                            <i class="fa-solid fa-tags mr-2"></i> Categorias
                        </a>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-2xl mb-6 w-full max-w-full">
                    <div class="p-6">
                        <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <x-input-label for="type" :value="__('Tipo')" class="text-gray-800 dark:text-gray-200" />
                                <select id="type" name="type" class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                    <option value="">Todos</option>
                                    <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Receita</option>
                                    <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Despesa</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="category" :value="__('Categoria')" class="text-gray-800 dark:text-gray-200" />
                                <select id="category" name="category_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                    <option value="">Todas</option>
                                    @foreach($categories ?? [] as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="account" :value="__('Conta')" class="text-gray-800 dark:text-gray-200" />
                                <select id="account" name="account_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                    <option value="">Todas</option>
                                    @foreach($accounts ?? [] as $account)
                                        <option value="{{ $account->id }}" {{ request('account_id') == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold uppercase tracking-widest shadow transition">Filtrar</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-2xl w-full max-w-full">
                    <div class="p-6 w-full max-w-full">
                        @if($transactions->count() > 0)
                            <div class="overflow-x-auto w-full max-w-full">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-100 dark:bg-gray-900">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Data</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Descrição</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Categoria</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Conta</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Valor</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($transactions as $transaction)
                                            <tr class="hover:bg-blue-50 dark:hover:bg-gray-700 transition">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $transaction->date->format('d/m/Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $transaction->description }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <div class="flex items-center">
                                                        <div class="w-3 h-3 rounded-full mr-2" style="background: {{ $transaction->category->color ?? '#3B82F6' }}"></div>
                                                        <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $transaction->category->name ?? 'Sem categoria' }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $transaction->account->name ?? 'Sem conta' }}</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold">
                                                    <span class="{{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                        {{ $transaction->type === 'income' ? '+' : '-' }}R$ {{ number_format($transaction->amount, 2, ',', '.') }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <div class="flex space-x-3">
                                                        <a href="{{ route('transactions.show', $transaction) }}" class="px-2 py-1 rounded bg-blue-600 hover:bg-blue-700 text-white font-bold transition shadow">Ver</a>
                                                        <a href="{{ route('transactions.edit', $transaction) }}" class="px-2 py-1 rounded bg-green-600 hover:bg-green-700 text-white font-bold transition shadow">Editar</a>
                                                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta transação?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="px-2 py-1 rounded bg-red-600 hover:bg-red-700 text-white font-bold transition shadow">Excluir</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($transactions->hasPages())
                                <div class="mt-6">
                                    {{ $transactions->links() }}
                                </div>
                            @endif
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <h3 class="mt-2 text-lg font-bold text-gray-800 dark:text-white">Nenhuma transação</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Comece registrando suas primeiras transações.</p>
                                <div class="mt-6">
                                    <a href="{{ route('transactions.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold shadow transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Criar Transação
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 