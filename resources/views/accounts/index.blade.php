@extends('layouts.app')

@section('content')
@section('nav-classes', 'bg-card border-b border-main backdrop-blur-lg')
@section('background')
    <div class="fixed inset-0 z-0 bg-main animate-fade-in"></div>
@endsection
@section('header-classes', 'bg-card shadow-none backdrop-blur-lg')
@section('main-classes', 'relative z-10')

<div class="py-6 bg-main w-full max-w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full max-w-full">
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

        <div class="bg-card glass-card rounded-3xl-custom shadow-xl-custom p-8 border border-main backdrop-blur-lg animate-fade-in overflow-x-auto w-full max-w-full">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold !text-white" style="color: #fff !important;">Minhas Contas</h2>
                <a href="{{ route('accounts.create') }}" class="inline-flex items-center px-4 py-2 border border-main shadow-sm text-sm font-bold rounded-lg text-main bg-accent hover:bg-main hover:text-accent transition-all duration-200">
                    <i class="fa-solid fa-plus mr-2"></i>
                    Nova Conta
                </a>
            </div>
            
            @if($accounts->count() > 0)
                <div class="overflow-x-auto rounded-xl border border-main w-full max-w-full">
                    <table class="min-w-full divide-y divide-main text-sm">
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
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    <h3 class="mt-2 text-xl font-extrabold text-main">Nenhuma conta</h3>
                    <p class="mt-1 text-base text-accent">Comece criando sua primeira conta.</p>
                    <div class="mt-6">
                        <a href="{{ route('accounts.create') }}" class="inline-flex items-center px-5 py-2 border border-main shadow-sm text-base font-bold rounded-xl text-main bg-accent hover:bg-main hover:text-accent transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Criar Conta
                        </a>
                    </div>
                </div>
            @endif
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