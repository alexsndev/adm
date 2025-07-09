@extends('layouts.app')

@section('nav-classes', 'bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800')
@section('background')
    <div class="fixed inset-0 z-0 bg-gray-100 dark:bg-gray-900 transition-colors duration-300"></div>
@endsection
@section('header-classes', 'bg-white dark:bg-gray-900 shadow-none')
@section('main-classes', 'relative z-10')

@section('content')
    <div class="py-6 sm:py-12 w-full max-w-full">
        <div class="w-full max-w-7xl mx-auto px-1.5 sm:px-6 lg:px-8 min-w-0">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-4 sm:p-6">
                <h1 class="text-lg sm:text-2xl font-bold mb-4">Dívidas</h1>
                <div class="overflow-x-auto w-full">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-3 lg:px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Dívida</th>
                                <th class="px-3 lg:px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Saldo</th>
                                <th class="hidden lg:table-cell px-3 lg:px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Juros</th>
                                <th class="hidden lg:table-cell px-3 lg:px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Vencimento</th>
                                <th class="hidden lg:table-cell px-3 lg:px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Prioridade</th>
                                <th class="hidden lg:table-cell px-3 lg:px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Negociação</th>
                                <th class="px-3 lg:px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Progresso</th>
                                <th class="px-3 lg:px-6 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-[#161b22] divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($debts as $debt)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200">
                                    <td class="px-3 lg:px-6 py-3 lg:py-4">
                                        <div class="flex items-center">
                                            @if($debt->creditCard && $debt->creditCard->logo_url)
                                                <img src="{{ $debt->creditCard->logo_url }}" alt="Logo Cartão" class="h-8 w-12 rounded shadow bg-white mr-2">
                                            @else
                                                <div class="flex-shrink-0 h-8 w-8 lg:h-10 lg:w-10">
                                                    <div class="h-8 w-8 lg:h-10 lg:w-10 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center">
                                                        <i class="fa-solid fa-file-invoice-dollar text-red-600 dark:text-red-300 text-xs lg:text-sm"></i>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="ml-3 lg:ml-4 min-w-0 flex-1">
                                                <div class="text-sm font-bold text-gray-900 dark:text-gray-100 truncate">
                                                    <a href="{{ route('debts.show', $debt) }}" class="hover:text-red-600 dark:hover:text-red-400 transition-colors">
                                                        {{ $debt->name }}
                                                    </a>
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $debt->debt_type_label }}</div>
                                                @if((!$debt->is_negotiated && $debt->is_overdue) || ($debt->is_negotiated && $debt->days_until_due < 0))
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 mt-1">
                                                        <i class="fa-solid fa-exclamation-triangle mr-1"></i> Atrasada
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 lg:px-6 py-3 lg:py-4 align-top">
                                        @if($debt->is_negotiated)
                                            <div class="flex items-center gap-2">
                                                <span class="text-sm font-bold text-green-600 dark:text-green-400">
                                                    R$ {{ number_format($debt->total_negotiated_amount, 2, ',', '.') }}
                                                </span>
                                                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Negociado</span>
                                                <button @click="modalDebt = {{ $debt->id }}" class="ml-1 text-gray-400 hover:text-green-600 focus:outline-none" title="Ver detalhes">
                                                    <i class="fa-solid fa-circle-info"></i>
                                                </button>
                                            </div>
                                            <!-- Modal de detalhes -->
                                            <div x-data="{ show: false }" x-show="modalDebt === {{ $debt->id }}" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                                                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-xl p-6 w-full max-w-md relative">
                                                    <button @click="modalDebt = null" class="absolute top-2 right-2 text-gray-400 hover:text-red-600"><i class="fa-solid fa-times"></i></button>
                                                    <h3 class="text-lg font-bold mb-2 text-green-700 dark:text-green-300">Detalhes da Negociação</h3>
                                                    <div class="text-sm text-gray-700 dark:text-gray-200 mb-2">
                                                        <div><b>Valor negociado:</b> R$ {{ number_format($debt->total_negotiated_amount, 2, ',', '.') }}</div>
                                                        <div><b>Valor original:</b> R$ {{ number_format($debt->original_amount, 2, ',', '.') }}</div>
                                                        <div><b>Parcelas:</b> {{ $debt->installments ?? '-' }}</div>
                                                        <div><b>Parcelas pagas:</b> {{ $debt->payments->count() }}</div>
                                                        <div><b>Parcelas a pagar:</b> {{ ($debt->installments ?? 0) - $debt->payments->count() }}</div>
                                                        <div><b>Valor da parcela:</b> R$ {{ number_format($debt->installment_amount, 2, ',', '.') }}</div>
                                                        <div><b>Data do acordo:</b> {{ $debt->agreement_date ? $debt->agreement_date->format('d/m/Y') : '-' }}</div>
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">Clique fora ou no X para fechar</div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-sm font-bold text-red-600 dark:text-red-400">
                                                R$ {{ number_format($debt->current_balance, 2, ',', '.') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="hidden lg:table-cell px-3 lg:px-6 py-3 lg:py-4">
                                        @if($debt->is_negotiated && $debt->installment_amount)
                                            <div class="text-lg font-extrabold text-orange-600 dark:text-orange-300">
                                                R$ {{ number_format($debt->corrected_installment_amount, 2, ',', '.') }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                Parcela corrigida @if($debt->days_until_due < 0) (atraso: {{ abs($debt->days_until_due) }} dias) @endif
                                            </div>
                                            <div class="text-xs text-gray-400 mt-1">
                                                <span class="line-through">R$ {{ number_format($debt->installment_amount, 2, ',', '.') }}</span> valor original
                                            </div>
                                        @else
                                            <div class="text-sm text-gray-900 dark:text-gray-100 font-semibold">
                                                {{ $debt->interest_rate }}%/mês
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                R$ {{ number_format($debt->monthly_interest, 2, ',', '.') }}/mês
                                            </div>
                                        @endif
                                    </td>
                                    <td class="hidden lg:table-cell px-3 lg:px-6 py-3 lg:py-4">
                                        @php
                                            $vencimento = null;
                                            if ($debt->is_negotiated && $debt->first_payment_date) {
                                                $vencimento = $debt->first_payment_date;
                                            } elseif ($debt->is_negotiated && $debt->agreement_date) {
                                                $vencimento = $debt->agreement_date;
                                            } else {
                                                $vencimento = $debt->due_date;
                                            }
                                        @endphp
                                        @if($vencimento)
                                            <div class="text-sm text-gray-900 dark:text-gray-100">
                                                {{ \Carbon\Carbon::parse($vencimento)->format('d/m/Y') }}
                                            </div>
                                            @if($debt->days_until_due !== null)
                                                <div class="text-xs {{ $debt->days_until_due < 0 ? 'text-red-600 dark:text-red-400' : ($debt->days_until_due <= 7 ? 'text-orange-600 dark:text-orange-400' : 'text-gray-500 dark:text-gray-400') }}">
                                                    {{ $debt->days_until_due < 0 ? 'Atrasada há ' . diasAtrasados($debt->days_until_due) . ' dias' : ($debt->days_until_due == 0 ? 'Vence hoje' : 'Vence em ' . diasAtrasados($debt->days_until_due) . ' dias') }}
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-sm text-gray-500 dark:text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="hidden lg:table-cell px-3 lg:px-6 py-3 lg:py-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold
                                            {{ $debt->priority === 'low' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                            {{ $debt->priority === 'medium' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                                            {{ $debt->priority === 'high' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200' : '' }}
                                            {{ $debt->priority === 'critical' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}">
                                            {{ $debt->priority_label }}
                                        </span>
                                    </td>
                                    <td class="hidden lg:table-cell px-3 lg:px-6 py-3 lg:py-4">
                                        @if($debt->is_negotiated)
                                            <div class="flex flex-col">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    <i class="fa-solid fa-handshake mr-1"></i> Negociada
                                                </span>
                                                <span class="text-xs text-green-600 dark:text-green-400 mt-1 font-semibold">
                                                    -{{ number_format($debt->negotiation_discount_percentage, 1) }}%
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-500 dark:text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-3 lg:px-6 py-3 lg:py-4">
                                        <div class="flex items-center">
                                            <div class="w-16 lg:w-20 bg-gray-200 dark:bg-gray-700 rounded-full h-2 mr-2">
                                                <div class="bg-gradient-to-r from-red-500 to-orange-500 h-2 rounded-full transition-all duration-300" style="width: {{ $debt->progress_percentage }}%"></div>
                                            </div>
                                            <span class="text-xs font-bold text-gray-900 dark:text-gray-100">{{ $debt->progress_percentage }}%</span>
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            R$ {{ number_format($debt->total_paid, 2, ',', '.') }} pagos
                                        </div>
                                    </td>
                                    <td class="px-3 lg:px-6 py-3 lg:py-4 text-sm font-medium">
                                        <div class="flex flex-col lg:flex-row gap-1 lg:gap-2">
                                            <a href="{{ route('debts.show', $debt) }}" class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-bold rounded-lg text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900 hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors">
                                                <i class="fa-solid fa-eye"></i>
                                                <span class="hidden sm:inline ml-1">Ver</span>
                                            </a>
                                            <a href="{{ route('debts.edit', $debt) }}" class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-bold rounded-lg text-yellow-600 dark:text-yellow-400 bg-yellow-100 dark:bg-yellow-900 hover:bg-yellow-200 dark:hover:bg-yellow-800 transition-colors">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                <span class="hidden sm:inline ml-1">Editar</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@php
    function diasAtrasados($dias) {
        return intval(round($dias));
    }
@endphp

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('modalDebt', null);
    });
</script>
<div x-data="{ modalDebt: null }"> 