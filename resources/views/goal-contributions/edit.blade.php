@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Informações da Meta -->
            <div class="bg-white/60 dark:bg-gray-900/60 rounded-3xl shadow-xl p-6 border border-white/30 dark:border-gray-700/30 backdrop-blur-lg animate-fade-in mb-8">
                <div class="flex items-center">
                    <span class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 shadow border border-green-200 dark:border-green-700 mr-4">
                        <i class="fa-solid {{ $financialGoal->goal_type_icon }} fa-lg"></i>
                    </span>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $financialGoal->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Progresso: {{ $financialGoal->progress_percentage }}% (R$ {{ number_format($financialGoal->current_amount, 2, ',', '.') }} / R$ {{ number_format($financialGoal->target_amount, 2, ',', '.') }})</p>
                    </div>
                </div>
            </div>

            <!-- Formulário de Edição de Contribuição -->
            <div class="bg-white/60 dark:bg-gray-900/60 rounded-3xl shadow-xl p-8 border border-white/30 dark:border-gray-700/30 backdrop-blur-lg animate-fade-in">
                <form method="POST" action="{{ route('financial-goals.contributions.update', [$financialGoal, $contribution]) }}" class="space-y-6">
                    @csrf
                    @method('PATCH')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Valor da Contribuição -->
                        <div>
                            <label for="amount" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-dollar-sign mr-1 text-green-400"></i> Valor da Contribuição *
                            </label>
                            <input type="number" name="amount" id="amount" value="{{ old('amount', $contribution->amount) }}" step="0.01" min="0.01" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Data da Contribuição -->
                        <div>
                            <label for="contribution_date" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-calendar mr-1 text-green-400"></i> Data da Contribuição *
                            </label>
                            <input type="date" name="contribution_date" id="contribution_date" value="{{ old('contribution_date', $contribution->contribution_date->format('Y-m-d')) }}" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                            @error('contribution_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Tipo de Contribuição -->
                        <div>
                            <label for="type" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-tag mr-1 text-green-400"></i> Tipo de Contribuição *
                            </label>
                            <select name="type" id="type" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                <option value="manual" {{ old('type', $contribution->type) == 'manual' ? 'selected' : '' }}>Manual</option>
                                <option value="automatic" {{ old('type', $contribution->type) == 'automatic' ? 'selected' : '' }}>Automático</option>
                                <option value="bonus" {{ old('type', $contribution->type) == 'bonus' ? 'selected' : '' }}>Bônus</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Conta (Opcional) -->
                        <div>
                            <label for="account_id" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fa-solid fa-wallet mr-1 text-green-400"></i> Conta (Opcional)
                            </label>
                            <select name="account_id" id="account_id"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                                <option value="">Selecione uma conta</option>
                                @foreach($accounts as $account)
                                    <option value="{{ $account->id }}" {{ old('account_id', $contribution->account_id) == $account->id ? 'selected' : '' }}>
                                        {{ $account->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('account_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <!-- Descrição -->
                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-align-left mr-1 text-green-400"></i> Descrição
                        </label>
                        <input type="text" name="description" id="description" value="{{ old('description', $contribution->description) }}" maxlength="255" placeholder="Ex: Depósito mensal, Bônus salarial, etc."
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Referência -->
                    <div>
                        <label for="reference" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-hashtag mr-1 text-green-400"></i> Referência (Opcional)
                        </label>
                        <input type="text" name="reference" id="reference" value="{{ old('reference', $contribution->reference) }}" maxlength="255" placeholder="Ex: Número do depósito, comprovante, etc."
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                        @error('reference')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Botões -->
                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('financial-goals.show', $financialGoal) }}" class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-base font-bold rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">
                            <i class="fa-solid fa-times mr-2"></i> Cancelar
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-bold rounded-xl text-white bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 shadow transition-all duration-200">
                            <i class="fa-solid fa-save mr-2"></i> Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection 