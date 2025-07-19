@extends('layouts.app')

@section('content')
@section('nav-classes', 'bg-card border-b border-main backdrop-blur-lg')
@section('background')
    <div class="fixed inset-0 z-0 bg-main animate-fade-in"></div>
@endsection
@section('header-classes', 'bg-card shadow-none backdrop-blur-lg')
@section('main-classes', 'relative z-10')

<div class="py-6 bg-main w-full max-w-full">
    <div class="w-full max-w-7xl mx-auto px-1.5 sm:px-6 lg:px-8 min-w-0">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-4 sm:p-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-lg sm:text-2xl font-bold">Contas</h1>
                <a href="{{ route('accounts.create') }}" class="inline-flex items-center px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold shadow transition gap-2">
                    <i class="fa-solid fa-plus"></i> Nova Conta
                </a>
            </div>
            @if(session('success'))
                <div class="mb-6 bg-success/10 border border-success text-success px-4 py-3 rounded relative animate-fade-in" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative animate-fade-in" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="overflow-x-auto w-full">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                    <thead class="bg-[#181c20] sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-3 text-left font-bold text-white uppercase tracking-wider">Nome</th>
                            <th class="px-6 py-3 text-left font-bold text-white uppercase tracking-wider">Tipo</th>
                            <th class="px-6 py-3 text-left font-bold text-white uppercase tracking-wider">Saldo Atual</th>
                            <th class="px-6 py-3 text-left font-bold text-white uppercase tracking-wider">Moeda</th>
                            <th class="px-6 py-3 text-left font-bold text-white uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-card divide-y divide-main">
                        @foreach($accounts as $account)
                            <tr class="hover:bg-[#23272e] transition duration-150 {{ $loop->even ? 'bg-[#181c20]' : 'bg-card' }}">
                                <td class="px-6 py-4 whitespace-nowrap flex items-center gap-3">
                                    @if($account->logo)
                                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-card border border-main shadow">
                                            <img src="{{ asset('storage/' . $account->logo) }}" alt="Logo do Banco" class="w-8 h-8 object-cover rounded-full" loading="lazy">
                                        </div>
                                    @else
                                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-main text-main shadow border border-main">
                                            <i class="fa-solid fa-building-columns fa-lg"></i>
                                        </span>
                                    @endif
                                    <span class="font-bold text-white text-base">{{ $account->name }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $account->type == 'checking' ? 'bg-blue-900 text-blue-200' : ($account->type == 'savings' ? 'bg-green-900 text-green-200' : 'bg-gray-700 text-gray-200') }} capitalize">
                                        {{ $account->type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold {{ $account->current_balance < 0 ? 'text-red-400' : 'text-green-400' }} text-lg">
                                    R$ {{ number_format($account->current_balance, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-white">
                                    {{ $account->currency ?? 'BRL' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('accounts.show', $account) }}" class="inline-flex items-center px-2 py-1 rounded bg-[#23272e] hover:bg-blue-900 text-blue-100 font-bold transition" title="Ver">
                                            <i class="fa-solid fa-eye mr-1"></i> Ver
                                        </a>
                                        <a href="{{ route('accounts.edit', $account) }}" class="inline-flex items-center px-2 py-1 rounded bg-[#23272e] hover:bg-yellow-900 text-yellow-100 font-bold transition" title="Editar">
                                            <i class="fa-solid fa-pen-to-square mr-1"></i> Editar
                                        </a>
                                        <a href="{{ route('accounts.transactions', $account) }}" class="inline-flex items-center px-2 py-1 rounded bg-[#23272e] hover:bg-purple-900 text-purple-100 font-bold transition" title="Transações">
                                            <i class="fa-solid fa-list mr-1"></i> Transações
                                        </a>
                                        <form action="{{ route('accounts.destroy', $account) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta conta?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-2 py-1 rounded bg-[#23272e] hover:bg-red-900 text-red-100 font-bold transition" title="Excluir">
                                                <i class="fa-solid fa-trash mr-1"></i> Excluir
                                            </button>
                                        </form>
                                        <form action="{{ route('accounts.recalculate-balance', $account) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-2 py-1 rounded bg-[#23272e] hover:bg-green-900 text-green-100 font-bold transition" title="Recalcular Saldo">
                                                <i class="fa-solid fa-calculator mr-1"></i> Recalcular Saldo
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        
        <!-- Seção de Dívidas Negociadas -->
        @if($negotiatedDebts->count() > 0)
            <div class="mt-8 bg-card glass-card rounded-3xl-custom shadow-xl-custom p-8 border border-main backdrop-blur-lg animate-fade-in">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold !text-white" style="color: #fff !important;">
                        <i class="fa-solid fa-handshake mr-2 text-orange-400"></i>
                        Dívidas Negociadas
                    </h2>
                    <a href="{{ route('debts.create') }}" class="inline-flex items-center px-4 py-2 border border-main shadow-sm text-sm font-bold rounded-lg text-main bg-accent hover:bg-main hover:text-accent transition-all duration-200">
                        <i class="fa-solid fa-plus mr-2"></i>
                        Nova Dívida
                    </a>
                </div>
                
                <div class="overflow-x-auto rounded-xl border border-main w-full max-w-full">
                    <table class="min-w-full divide-y divide-main text-sm">
                        <thead class="bg-[#181c20] sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-3 text-left font-bold text-white uppercase tracking-wider">Dívida</th>
                                <th class="px-6 py-3 text-left font-bold text-white uppercase tracking-wider">Valor Original</th>
                                <th class="px-6 py-3 text-left font-bold text-white uppercase tracking-wider">Valor Negociado</th>
                                <th class="px-6 py-3 text-left font-bold text-white uppercase tracking-wider">Parcelas</th>
                                <th class="px-6 py-3 text-left font-bold text-white uppercase tracking-wider">Valor Parcela</th>
                                <th class="px-6 py-3 text-left font-bold text-white uppercase tracking-wider">Data Acordo</th>
                                <th class="px-6 py-3 text-left font-bold text-white uppercase tracking-wider">Desconto</th>
                                <th class="px-6 py-3 text-left font-bold text-white uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-card divide-y divide-main">
                            @foreach($negotiatedDebts as $debt)
                                <tr class="hover:bg-[#23272e] transition duration-150 {{ $loop->even ? 'bg-[#181c20]' : 'bg-card' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-orange-900 text-orange-200 shadow border border-orange-700">
                                                <i class="fa-solid fa-handshake fa-lg"></i>
                                            </span>
                                            <div>
                                                <span class="font-bold text-white text-base">{{ $debt->name }}</span>
                                                @if($debt->account)
                                                    <div class="text-xs text-accent">{{ $debt->account->name }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-red-400 text-lg">
                                        R$ {{ number_format($debt->original_amount, 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-green-400 text-lg">
                                        R$ {{ number_format($debt->negotiated_amount, 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-white">
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-900 text-blue-200">
                                            {{ $debt->installments }}x
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-blue-400 text-lg">
                                        R$ {{ number_format($debt->installment_amount, 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-white">
                                        {{ $debt->agreement_date ? $debt->agreement_date->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-success font-bold text-sm">
                                                R$ {{ number_format($debt->negotiation_discount, 2, ',', '.') }}
                                            </span>
                                            <span class="text-xs text-accent">
                                                -{{ number_format($debt->negotiation_discount_percentage, 1) }}%
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('debts.show', $debt) }}" class="inline-flex items-center px-2 py-1 rounded bg-[#23272e] hover:bg-blue-900 text-blue-100 font-bold transition" title="Ver">
                                                <i class="fa-solid fa-eye mr-1"></i> Ver
                                            </a>
                                            <a href="{{ route('debts.edit', $debt) }}" class="inline-flex items-center px-2 py-1 rounded bg-[#23272e] hover:bg-yellow-900 text-yellow-100 font-bold transition" title="Editar">
                                                <i class="fa-solid fa-pen-to-square mr-1"></i> Editar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 

@if(session('relatorio'))
    @php $relatorio = session('relatorio'); @endphp
    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
        <h3 class="text-lg font-bold text-yellow-800 mb-2">Diferença de Saldo Detectada</h3>
        <p class="text-yellow-800 mb-1">Saldo anterior: <b>R$ {{ number_format($relatorio['saldo_antigo'], 2, ',', '.') }}</b></p>
        <p class="text-yellow-800 mb-1">Saldo recalculado: <b>R$ {{ number_format($relatorio['saldo_calculado'], 2, ',', '.') }}</b></p>
        <p class="text-yellow-800 mb-2">Diferença: <b>R$ {{ number_format($relatorio['diferenca'], 2, ',', '.') }}</b></p>
        <div class="overflow-x-auto">
            <table class="min-w-full text-xs mt-2 divide-y divide-yellow-200">
                <thead class="bg-yellow-100">
                    <tr>
                        <th class="px-2 py-1 text-yellow-900">Data</th>
                        <th class="px-2 py-1 text-yellow-900">Descrição</th>
                        <th class="px-2 py-1 text-yellow-900">Tipo</th>
                        <th class="px-2 py-1 text-yellow-900">Valor</th>
                    </tr>
                </thead>
                <tbody class="bg-yellow-50">
                    @foreach($relatorio['transacoes'] as $t)
                        <tr>
                            <td class="px-2 py-1">{{ \Carbon\Carbon::parse($t->date)->format('d/m/Y') }}</td>
                            <td class="px-2 py-1">{{ $t->description }}</td>
                            <td class="px-2 py-1">{{ $t->type }}</td>
                            <td class="px-2 py-1">R$ {{ number_format($t->amount, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif 