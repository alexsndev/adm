@extends('layouts.app')

@section('content')
@section('nav-classes', 'bg-white/30 dark:bg-gray-900/30 border-b border-white/20 dark:border-gray-700/20 backdrop-blur-lg')
@section('background')
    <div class="fixed inset-0 z-0 bg-gradient-to-br from-red-500 via-orange-300 to-yellow-200 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 animate-fade-in"></div>
@endsection
@section('header-classes', 'bg-white/30 dark:bg-gray-900/30 shadow-none backdrop-blur-lg')
@section('main-classes', 'relative z-10')

<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/60 dark:bg-gray-900/60 rounded-3xl shadow-xl p-8 border border-white/30 dark:border-gray-700/30 backdrop-blur-lg animate-fade-in">
            <form method="POST" action="{{ route('debts.update', $debt) }}" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nome da Dívida -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-file-invoice-dollar mr-1 text-red-400"></i> Nome da Dívida *
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $debt->name) }}" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipo de Dívida -->
                    <div>
                        <label for="debt_type" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-tag mr-1 text-red-400"></i> Tipo de Dívida *
                        </label>
                        <select name="debt_type" id="debt_type" required onchange="toggleCreditCardField()"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                            <option value="credit_card" {{ old('debt_type', $debt->debt_type) == 'credit_card' ? 'selected' : '' }}>Cartão de Crédito</option>
                            <option value="personal_loan" {{ old('debt_type', $debt->debt_type) == 'personal_loan' ? 'selected' : '' }}>Empréstimo Pessoal</option>
                            <option value="mortgage" {{ old('debt_type', $debt->debt_type) == 'mortgage' ? 'selected' : '' }}>Financiamento Imobiliário</option>
                            <option value="car_loan" {{ old('debt_type', $debt->debt_type) == 'car_loan' ? 'selected' : '' }}>Financiamento de Veículo</option>
                            <option value="student_loan" {{ old('debt_type', $debt->debt_type) == 'student_loan' ? 'selected' : '' }}>Empréstimo Estudantil</option>
                            <option value="business_loan" {{ old('debt_type', $debt->debt_type) == 'business_loan' ? 'selected' : '' }}>Empréstimo Empresarial</option>
                            <option value="other" {{ old('debt_type', $debt->debt_type) == 'other' ? 'selected' : '' }}>Outro</option>
                        </select>
                        @error('debt_type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Campo de Cartão de Crédito (dinâmico) -->
                    <div id="credit_card_field" style="display: none;">
                        <label for="credit_card_id" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-credit-card mr-1 text-blue-400"></i> Cartão de Crédito
                        </label>
                        <select name="credit_card_id" id="credit_card_id"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            <option value="">Selecione o cartão</option>
                            @foreach($creditCards as $card)
                                <option value="{{ $card->id }}" data-logo="{{ $card->logo_url }}" {{ old('credit_card_id', $debt->credit_card_id) == $card->id ? 'selected' : '' }}>
                                    {{ $card->display_name }}
                                </option>
                            @endforeach
                        </select>
                        <div id="credit_card_logo" class="mt-2"></div>
                        @error('credit_card_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Valor Original -->
                    <div>
                        <label for="original_amount" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-dollar-sign mr-1 text-red-400"></i> Valor Original *
                        </label>
                        <input type="number" name="original_amount" id="original_amount" value="{{ old('original_amount', $debt->original_amount) }}" step="0.01" min="0" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                        @error('original_amount')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Saldo Atual -->
                    <div>
                        <label for="current_balance" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-balance-scale mr-1 text-red-400"></i> Saldo Atual *
                        </label>
                        <input type="number" name="current_balance" id="current_balance" value="{{ old('current_balance', $debt->current_balance) }}" step="0.01" min="0" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                        @error('current_balance')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Taxa de Juros -->
                    <div>
                        <label for="interest_rate" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-percent mr-1 text-red-400"></i> Taxa de Juros Mensal (%) *
                        </label>
                        <input type="number" name="interest_rate" id="interest_rate" value="{{ old('interest_rate', $debt->interest_rate) }}" step="0.01" min="0" max="100" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                        @error('interest_rate')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Taxa de IOF -->
                    <div>
                        <label for="iof_rate" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-percentage mr-1 text-red-400"></i> Taxa de IOF Diária
                        </label>
                        <input type="number" name="iof_rate" id="iof_rate" value="{{ old('iof_rate', $debt->iof_rate ?? 0.000082) }}" step="0.000001" min="0" max="1"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Ex: 0.000082 = 0.0082% ao dia (padrão IOF 2024)</p>
                        @error('iof_rate')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-info-circle mr-1 text-red-400"></i> Status *
                        </label>
                        <select name="status" id="status" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                            <option value="active" {{ old('status', $debt->status) == 'active' ? 'selected' : '' }}>Ativa</option>
                            <option value="paid" {{ old('status', $debt->status) == 'paid' ? 'selected' : '' }}>Paga</option>
                            <option value="defaulted" {{ old('status', $debt->status) == 'defaulted' ? 'selected' : '' }}>Inadimplente</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prioridade -->
                    <div>
                        <label for="priority" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-exclamation-triangle mr-1 text-red-400"></i> Prioridade *
                        </label>
                        <select name="priority" id="priority" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                            <option value="low" {{ old('priority', $debt->priority) == 'low' ? 'selected' : '' }}>Baixa</option>
                            <option value="medium" {{ old('priority', $debt->priority) == 'medium' ? 'selected' : '' }}>Média</option>
                            <option value="high" {{ old('priority', $debt->priority) == 'high' ? 'selected' : '' }}>Alta</option>
                            <option value="critical" {{ old('priority', $debt->priority) == 'critical' ? 'selected' : '' }}>Crítica</option>
                        </select>
                        @error('priority')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data de Início -->
                    <div>
                        <label for="start_date" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-calendar mr-1 text-red-400"></i> Data de Início *
                        </label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $debt->start_date->format('Y-m-d')) }}" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data de Vencimento -->
                    <div>
                        <label for="due_date" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-calendar-day mr-1 text-red-400"></i> Data de Vencimento
                        </label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date', (is_object($debt->due_date) ? $debt->due_date->format('Y-m-d') : $debt->due_date)) }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                        @error('due_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nome do Credor -->
                    <div>
                        <label for="creditor_name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-building mr-1 text-red-400"></i> Nome do Credor
                        </label>
                        <input type="text" name="creditor_name" id="creditor_name" value="{{ old('creditor_name', $debt->creditor_name) }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                        @error('creditor_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contato do Credor -->
                    <div>
                        <label for="creditor_contact" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-phone mr-1 text-red-400"></i> Contato do Credor
                        </label>
                        <input type="text" name="creditor_contact" id="creditor_contact" value="{{ old('creditor_contact', $debt->creditor_contact) }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                        @error('creditor_contact')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Número do Contrato -->
                    <div>
                        <label for="contract_number" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-hashtag mr-1 text-red-400"></i> Número do Contrato
                        </label>
                        <input type="text" name="contract_number" id="contract_number" value="{{ old('contract_number', $debt->contract_number) }}"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                        @error('contract_number')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Conta (Opcional) -->
                    <div>
                        <label for="account_id" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-wallet mr-1 text-red-400"></i> Conta (Opcional)
                        </label>
                        <select name="account_id" id="account_id"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                            <option value="">Selecione uma conta</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}" {{ old('account_id', $debt->account_id) == $account->id ? 'selected' : '' }}>
                                    {{ $account->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('account_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                @if($debt->is_negotiated)
                    <!-- Seção de Negociação / Parcelamento -->
                    <div class="mt-8 p-6 rounded-2xl bg-orange-50 dark:bg-gray-800/60 border border-orange-200 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-orange-700 dark:text-orange-300 mb-4 flex items-center">
                            <i class="fa-solid fa-handshake mr-2"></i> Negociação / Parcelamento
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <!-- Valor Negociado -->
                            <div>
                                <label for="negotiated_amount" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    Valor Negociado
                                </label>
                                <input type="number" name="negotiated_amount" id="negotiated_amount" value="{{ old('negotiated_amount', $debt->negotiated_amount) }}" step="0.01" min="0"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
                                @error('negotiated_amount')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- Número de Parcelas -->
                            <div>
                                <label for="installments" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    Nº de Parcelas
                                </label>
                                <input type="number" name="installments" id="installments" value="{{ old('installments', $debt->installments) }}" min="1" max="120"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
                                @error('installments')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- Valor da Parcela -->
                            <div>
                                <label for="installment_amount" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    Valor da Parcela
                                </label>
                                <input type="number" name="installment_amount" id="installment_amount" value="{{ old('installment_amount', $debt->installment_amount) }}" step="0.01" min="0"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
                                @error('installment_amount')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- Data do Acordo -->
                            <div>
                                <label for="agreement_date" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                    Data do Acordo
                                </label>
                                <input type="date" name="agreement_date" id="agreement_date" value="{{ old('agreement_date', (is_object($debt->agreement_date) ? $debt->agreement_date->format('Y-m-d') : $debt->agreement_date)) }}"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
                                @error('agreement_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <!-- Data do Primeiro Pagamento -->
                        <div class="mt-8">
                            <label for="first_payment_date" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-calendar-day mr-1 text-orange-400"></i> Data do Primeiro Pagamento
                            </label>
                            <input type="date" name="first_payment_date" id="first_payment_date" value="{{ old('first_payment_date', (is_object($debt->first_payment_date) ? $debt->first_payment_date->format('Y-m-d') : $debt->first_payment_date)) }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Data em que será realizado o primeiro pagamento ou vencimento da dívida.</p>
                            @error('first_payment_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Taxa de Juros -->
                        <div class="mt-8">
                            <label for="interest_rate" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-percent mr-1 text-red-400"></i> Taxa de Juros Mensal (%)
                            </label>
                            <input type="number" name="interest_rate" id="interest_rate" value="{{ old('interest_rate', $debt->interest_rate) }}" step="0.01" min="0" max="100"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                            @error('interest_rate')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Taxa de IOF -->
                        <div class="mt-8">
                            <label for="iof_rate" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-percentage mr-1 text-red-400"></i> IOF: 0,38% + 0,01118% ao dia
                            </label>
                            <input type="text" name="iof_rate" id="iof_rate" value="0,38% + 0,01118% ao dia" readonly
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">IOF padrão bancário: 0,38% fixo + 0,01118% ao dia. Para outros tipos de dívida, ajuste conforme necessário.</p>
                        </div>
                        <!-- Descrição -->
                        <div class="mt-8">
                            <label for="description" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-align-left mr-1 text-red-400"></i> Descrição
                            </label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">{{ old('description', $debt->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @else
                    <!-- Campos normais de dívida -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                        <!-- Valor Original -->
                        <div>
                            <label for="original_amount" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-dollar-sign mr-1 text-red-400"></i> Valor Original *
                            </label>
                            <input type="number" name="original_amount" id="original_amount" value="{{ old('original_amount', $debt->original_amount) }}" step="0.01" min="0" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                            @error('original_amount')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Saldo Atual -->
                        <div>
                            <label for="current_balance" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-balance-scale mr-1 text-red-400"></i> Saldo Atual *
                            </label>
                            <input type="number" name="current_balance" id="current_balance" value="{{ old('current_balance', $debt->current_balance) }}" step="0.01" min="0" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                            @error('current_balance')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Taxa de Juros -->
                        <div>
                            <label for="interest_rate" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-percent mr-1 text-red-400"></i> Taxa de Juros Mensal (%) *
                            </label>
                            <input type="number" name="interest_rate" id="interest_rate" value="{{ old('interest_rate', $debt->interest_rate) }}" step="0.01" min="0" max="100" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                            @error('interest_rate')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Taxa de IOF -->
                        <div>
                            <label for="iof_rate" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-percentage mr-1 text-red-400"></i> IOF: 0,38% + 0,01118% ao dia
                            </label>
                            <input type="text" name="iof_rate" id="iof_rate" value="0,38% + 0,01118% ao dia" readonly
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">IOF padrão bancário: 0,38% fixo + 0,01118% ao dia. Para outros tipos de dívida, ajuste conforme necessário.</p>
                        </div>
                        <!-- Nome do Credor -->
                        <div>
                            <label for="creditor_name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-building mr-1 text-red-400"></i> Nome do Credor
                            </label>
                            <input type="text" name="creditor_name" id="creditor_name" value="{{ old('creditor_name', $debt->creditor_name) }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                            @error('creditor_name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Contato do Credor -->
                        <div>
                            <label for="creditor_contact" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-phone mr-1 text-red-400"></i> Contato do Credor
                            </label>
                            <input type="text" name="creditor_contact" id="creditor_contact" value="{{ old('creditor_contact', $debt->creditor_contact) }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                            @error('creditor_contact')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Número do Contrato -->
                        <div>
                            <label for="contract_number" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-hashtag mr-1 text-red-400"></i> Número do Contrato
                            </label>
                            <input type="text" name="contract_number" id="contract_number" value="{{ old('contract_number', $debt->contract_number) }}"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                            @error('contract_number')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Conta (Opcional) -->
                        <div>
                            <label for="account_id" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-wallet mr-1 text-red-400"></i> Conta (Opcional)
                            </label>
                            <select name="account_id" id="account_id"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-200">
                                <option value="">Selecione uma conta</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" {{ old('account_id', $debt->account_id) == $account->id ? 'selected' : '' }}>
                                        {{ $account->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('account_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endif

                <!-- Botões -->
                <div class="flex justify-end space-x-4 pt-6">
                    <a href="{{ route('debts.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-base font-bold rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">
                        <i class="fa-solid fa-times mr-2"></i> Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-bold rounded-xl text-white bg-gradient-to-r from-red-500 to-orange-600 hover:from-red-600 hover:to-orange-700 shadow transition-all duration-200">
                        <i class="fa-solid fa-save mr-2"></i> Atualizar Dívida
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleCreditCardField() {
        const debtType = document.getElementById('debt_type').value;
        const ccField = document.getElementById('credit_card_field');
        if (debtType === 'credit_card') {
            ccField.style.display = '';
        } else {
            ccField.style.display = 'none';
            document.getElementById('credit_card_logo').innerHTML = '';
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        toggleCreditCardField();
        document.getElementById('credit_card_id')?.addEventListener('change', function(e) {
            const selected = e.target.options[e.target.selectedIndex];
            const logo = selected.getAttribute('data-logo');
            if (logo) {
                document.getElementById('credit_card_logo').innerHTML = `<img src="${logo}" alt="Logo do Cartão" class="h-8 inline-block rounded shadow">`;
            } else {
                document.getElementById('credit_card_logo').innerHTML = '';
            }
        });
        // Exibir logo se já houver cartão selecionado
        const ccSelect = document.getElementById('credit_card_id');
        if (ccSelect && ccSelect.value) {
            const selected = ccSelect.options[ccSelect.selectedIndex];
            const logo = selected.getAttribute('data-logo');
            if (logo) {
                document.getElementById('credit_card_logo').innerHTML = `<img src="${logo}" alt="Logo do Cartão" class="h-8 inline-block rounded shadow">`;
            }
        }
    });
</script>
@endpush
@endsection 