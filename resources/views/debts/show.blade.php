@extends('layouts.app')

@section('content')
@section('nav-classes', 'bg-white/30 dark:bg-gray-900/30 border-b border-white/20 dark:border-gray-700/20 backdrop-blur-lg')
@section('background')
    <div class="fixed inset-0 z-0 bg-gradient-to-br from-red-500 via-orange-300 to-yellow-200 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 animate-fade-in"></div>
@endsection
@section('header-classes', 'bg-white/30 dark:bg-gray-900/30 shadow-none backdrop-blur-lg')
@section('main-classes', 'relative z-10')

<div class="py-6">
    <!-- Conteúdo da página de detalhes da dívida -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Informações Principais -->
        <div class="bg-white/60 dark:bg-gray-900/60 rounded-3xl shadow-xl p-8 border border-white/30 dark:border-gray-700/30 backdrop-blur-lg animate-fade-in mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Saldo Atual -->
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-3 flex items-center justify-center rounded-full bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300 shadow border border-red-200 dark:border-red-700">
                        <i class="fa-solid fa-dollar-sign fa-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Saldo Atual</h3>
                    <p class="text-2xl font-extrabold text-red-600 dark:text-red-400">R$ {{ number_format($debt->current_balance, 2, ',', '.') }}</p>
                </div>

                <!-- Valor Original -->
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-3 flex items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 shadow border border-blue-200 dark:border-blue-700">
                        <i class="fa-solid fa-chart-line fa-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Valor Original</h3>
                    <p class="text-2xl font-extrabold text-blue-600 dark:text-blue-400">R$ {{ number_format($debt->original_amount, 2, ',', '.') }}</p>
                </div>

                <!-- Progresso -->
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-3 flex items-center justify-center rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 shadow border border-green-200 dark:border-green-700">
                        <i class="fa-solid fa-percentage fa-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Progresso</h3>
                    <p class="text-2xl font-extrabold text-green-600 dark:text-green-400">{{ $debt->progress_percentage }}%</p>
                </div>

                <!-- Juros Mensais -->
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-3 flex items-center justify-center rounded-full bg-orange-100 dark:bg-orange-900 text-orange-600 dark:text-orange-300 shadow border border-orange-200 dark:border-orange-700">
                        <i class="fa-solid fa-percent fa-lg"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Juros Mensais</h3>
                    <p class="text-2xl font-extrabold text-orange-600 dark:text-orange-400">R$ {{ number_format($debt->monthly_interest, 2, ',', '.') }}</p>
                </div>
            </div>

            <!-- Barra de Progresso -->
            <div class="mt-8">
                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                    <span>Progresso do pagamento</span>
                    <span>{{ $debt->progress_percentage }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                    <div class="bg-gradient-to-r from-red-500 to-orange-400 h-4 rounded-full transition-all duration-500" style="width: {{ $debt->progress_percentage }}%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-2">
                    <span>Pago: R$ {{ number_format($debt->total_paid, 2, ',', '.') }}</span>
                    <span>Restante: R$ {{ number_format($debt->current_balance, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Detalhes da Dívida -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Informações Básicas -->
            <div class="bg-white/60 dark:bg-gray-900/60 rounded-3xl shadow-xl p-8 border border-white/30 dark:border-gray-700/30 backdrop-blur-lg animate-fade-in">
                <h3 class="text-xl font-extrabold text-gray-900 dark:text-white mb-6 flex items-center">
                    <i class="fa-solid fa-info-circle mr-2 text-red-400"></i> Informações Básicas
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                        <span class="font-bold text-gray-700 dark:text-gray-300">Tipo:</span>
                        <span class="text-gray-900 dark:text-white">{{ $debt->debt_type_label }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                        <span class="font-bold text-gray-700 dark:text-gray-300">Prioridade:</span>
                        <span class="inline-block px-2 py-1 rounded-full bg-{{ $debt->priority_color }}-100 text-{{ $debt->priority_color }}-800 dark:bg-{{ $debt->priority_color }}-900 dark:text-{{ $debt->priority_color }}-200 font-bold">
                            {{ $debt->priority_label }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                        <span class="font-bold text-gray-700 dark:text-gray-300">Status:</span>
                        <span class="inline-block px-2 py-1 rounded-full bg-{{ $debt->status == 'active' ? 'green' : ($debt->status == 'paid' ? 'blue' : 'red') }}-100 text-{{ $debt->status == 'active' ? 'green' : ($debt->status == 'paid' ? 'blue' : 'red') }}-800 dark:bg-{{ $debt->status == 'active' ? 'green' : ($debt->status == 'paid' ? 'blue' : 'red') }}-900 dark:text-{{ $debt->status == 'active' ? 'green' : ($debt->status == 'paid' ? 'blue' : 'red') }}-200 font-bold">
                            {{ ucfirst($debt->status) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                        <span class="font-bold text-gray-700 dark:text-gray-300">Taxa de Juros:</span>
                        <span class="text-gray-900 dark:text-white">{{ $debt->interest_rate }}% ao mês</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                        <span class="font-bold text-gray-700 dark:text-gray-300">Data de Início:</span>
                        <span class="text-gray-900 dark:text-white">{{ $debt->start_date->format('d/m/Y') }}</span>
                    </div>
                    @if($debt->due_date)
                        <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                            <span class="font-bold text-gray-700 dark:text-gray-300">Vencimento:</span>
                            <span class="text-gray-900 dark:text-white">{{ $debt->due_date->format('d/m/Y') }}</span>
                        </div>
                    @endif
                    @if($debt->account)
                        <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                            <span class="font-bold text-gray-700 dark:text-gray-300">Conta:</span>
                            <span class="text-gray-900 dark:text-white">{{ $debt->account->name }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Informações do Credor -->
            <div class="bg-white/60 dark:bg-gray-900/60 rounded-3xl shadow-xl p-8 border border-white/30 dark:border-gray-700/30 backdrop-blur-lg animate-fade-in">
                <h3 class="text-xl font-extrabold text-gray-900 dark:text-white mb-6 flex items-center">
                    <i class="fa-solid fa-building mr-2 text-red-400"></i> Informações do Credor
                </h3>
                <div class="space-y-4">
                    @if($debt->creditor_name)
                        <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                            <span class="font-bold text-gray-700 dark:text-gray-300">Nome:</span>
                            <span class="text-gray-900 dark:text-white">{{ $debt->creditor_name }}</span>
                        </div>
                    @endif
                    @if($debt->creditor_contact)
                        <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                            <span class="font-bold text-gray-700 dark:text-gray-300">Contato:</span>
                            <span class="text-gray-900 dark:text-white">{{ $debt->creditor_contact }}</span>
                        </div>
                    @endif
                    @if($debt->contract_number)
                        <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                            <span class="font-bold text-gray-700 dark:text-gray-300">Contrato:</span>
                            <span class="text-gray-900 dark:text-white">{{ $debt->contract_number }}</span>
                        </div>
                    @endif
                    @if($debt->description)
                        <div class="py-3">
                            <span class="font-bold text-gray-700 dark:text-gray-300 block mb-2">Descrição:</span>
                            <p class="text-gray-900 dark:text-white">{{ $debt->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Histórico de Pagamentos -->
        @if($debt->payments->count() > 0)
            <div class="bg-white/60 dark:bg-gray-900/60 rounded-3xl shadow-xl p-8 border border-white/30 dark:border-gray-700/30 backdrop-blur-lg animate-fade-in mt-8">
                <h3 class="text-xl font-extrabold text-gray-900 dark:text-white mb-6 flex items-center">
                    <i class="fa-solid fa-history mr-2 text-red-400"></i> Histórico de Pagamentos
                </h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-white/80 dark:bg-gray-900/80">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Data</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Valor</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Saldo Após</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white/60 dark:bg-gray-900/60 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($debt->payments as $payment)
                                <tr class="hover:bg-red-50 dark:hover:bg-gray-800 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $payment->payment_date->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600 dark:text-green-400">
                                        R$ {{ number_format($payment->amount, 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="inline-block px-2 py-1 rounded-full bg-{{ $payment->payment_type_color }}-100 text-{{ $payment->payment_type_color }}-800 dark:bg-{{ $payment->payment_type_color }}-900 dark:text-{{ $payment->payment_type_color }}-200 font-bold text-xs">
                                            {{ $payment->payment_type_label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        R$ {{ number_format($payment->balance_after, 2, ',', '.') }}
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