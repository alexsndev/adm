@extends("layouts.app")

@section("content")
@section("nav-classes", "bg-card border-b border-main backdrop-blur-lg")
@section("background")
    <div class="fixed inset-0 z-0 bg-main animate-fade-in"></div>
@endsection
@section("header-classes", "bg-card shadow-none backdrop-blur-lg")
@section("main-classes", "relative z-10")

<div class="py-6 bg-main">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-card glass-card rounded-3xl-custom shadow-xl-custom p-8 border border-main backdrop-blur-lg animate-fade-in">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-main">Transações da Conta: {{ $account->name }}</h2>
                    <p class="text-accent mt-1">Saldo atual: R$ {{ number_format($account->current_balance, 2, ",", ".") }}</p>
                </div>
                <a href="{{ route("accounts.index") }}" class="inline-flex items-center px-4 py-2 border border-main shadow-sm text-sm font-bold rounded-lg text-main bg-accent hover:bg-main hover:text-accent transition-all duration-200">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    Voltar
                </a>
            </div>

            @if($transactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-main">
                        <thead class="bg-main">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-main uppercase tracking-wider">Data</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-main uppercase tracking-wider">Descrição</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-main uppercase tracking-wider">Categoria</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-main uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-main uppercase tracking-wider">Valor</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-main uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-card divide-y divide-main">
                            @foreach($transactions as $transaction)
                                <tr class="hover:bg-main/60 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-main">
                                        {{ \Carbon\Carbon::parse($transaction->date)->format("d/m/Y") }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-main">
                                        {{ $transaction->description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-accent">
                                        {{ $transaction->category->name ?? "Sem categoria" }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-accent capitalize">
                                        @if($transaction->type == "income")
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Receita
                                            </span>
                                        @elseif($transaction->type == "expense")
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Despesa
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Transferência
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold {{ $transaction->type == "income" ? "text-green-600" : "text-red-600" }}">
                                        R$ {{ number_format($transaction->amount, 2, ",", ".") }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-3">
                                            <a href="{{ route("transactions.edit", $transaction) }}" class="text-accent hover:text-main font-bold transition">Editar</a>
                                            <form action="{{ route("transactions.destroy", $transaction) }}" method="POST" class="inline" onsubmit="return confirm("Tem certeza que deseja excluir esta transação?");">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="text-accent hover:text-main font-bold transition">Excluir</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fa-solid fa-exclamation-triangle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">
                                Para excluir esta conta
                            </h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>Você precisa primeiro excluir ou transferir todas as {{ $transactions->count() }} transação(ões) listadas acima.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-xl font-extrabold text-main">Nenhuma transação</h3>
                    <p class="mt-1 text-base text-accent">Esta conta não possui transações registradas.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
