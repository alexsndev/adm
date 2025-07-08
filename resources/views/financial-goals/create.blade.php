@extends('layouts.app')

@section('content')
@section('nav-classes', 'bg-white/30 dark:bg-gray-900/30 border-b border-white/20 dark:border-gray-700/20 backdrop-blur-lg')
@section('background')
    <div class="fixed inset-0 z-0 bg-gradient-to-br from-green-500 via-blue-300 to-blue-900 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 animate-fade-in"></div>
@endsection
@section('header-classes', 'bg-white/30 dark:bg-gray-900/30 shadow-none backdrop-blur-lg')
@section('main-classes', 'relative z-10')

<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white/60 dark:bg-gray-900/60 rounded-3xl shadow-xl p-8 border border-white/30 dark:border-gray-700/30 backdrop-blur-lg animate-fade-in">
            <form method="POST" action="{{ route('financial-goals.store') }}" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nome da Meta -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-target mr-1 text-green-400"></i> Nome da Meta *
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipo de Meta -->
                    <div>
                        <label for="goal_type" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-seedling mr-1 text-green-400"></i> Tipo de Meta *
                        </label>
                        <select name="goal_type" id="goal_type" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                            <option value="">Selecione o tipo</option>
                            <option value="emergency_fund" {{ old('goal_type') == 'emergency_fund' ? 'selected' : '' }}>Fundo de Emergência</option>
                            <option value="debt_free" {{ old('goal_type') == 'debt_free' ? 'selected' : '' }}>Livre de Dívidas</option>
                            <option value="savings" {{ old('goal_type') == 'savings' ? 'selected' : '' }}>Poupança</option>
                            <option value="investment" {{ old('goal_type') == 'investment' ? 'selected' : '' }}>Investimentos</option>
                            <option value="eco_friendly_home" {{ old('goal_type') == 'eco_friendly_home' ? 'selected' : '' }}>Casa Sustentável</option>
                            <option value="solar_panels" {{ old('goal_type') == 'solar_panels' ? 'selected' : '' }}>Painéis Solares</option>
                            <option value="electric_vehicle" {{ old('goal_type') == 'electric_vehicle' ? 'selected' : '' }}>Veículo Elétrico</option>
                            <option value="sustainable_business" {{ old('goal_type') == 'sustainable_business' ? 'selected' : '' }}>Negócio Sustentável</option>
                            <option value="green_investment" {{ old('goal_type') == 'green_investment' ? 'selected' : '' }}>Investimento Verde</option>
                            <option value="education" {{ old('goal_type') == 'education' ? 'selected' : '' }}>Educação</option>
                            <option value="travel" {{ old('goal_type') == 'travel' ? 'selected' : '' }}>Viagem</option>
                            <option value="retirement" {{ old('goal_type') == 'retirement' ? 'selected' : '' }}>Aposentadoria</option>
                            <option value="other" {{ old('goal_type') == 'other' ? 'selected' : '' }}>Outro</option>
                        </select>
                        @error('goal_type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Valor da Meta -->
                    <div>
                        <label for="target_amount" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-dollar-sign mr-1 text-green-400"></i> Valor da Meta *
                        </label>
                        <input type="number" name="target_amount" id="target_amount" value="{{ old('target_amount') }}" step="0.01" min="0" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                        @error('target_amount')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Valor Atual -->
                    <div>
                        <label for="current_amount" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-piggy-bank mr-1 text-green-400"></i> Valor Atual
                        </label>
                        <input type="number" name="current_amount" id="current_amount" value="{{ old('current_amount', 0) }}" step="0.01" min="0"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                        @error('current_amount')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prioridade -->
                    <div>
                        <label for="priority" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-exclamation-triangle mr-1 text-green-400"></i> Prioridade *
                        </label>
                        <select name="priority" id="priority" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Baixa</option>
                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Média</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Alta</option>
                            <option value="critical" {{ old('priority') == 'critical' ? 'selected' : '' }}>Crítica</option>
                        </select>
                        @error('priority')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data de Início -->
                    <div>
                        <label for="start_date" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-calendar mr-1 text-green-400"></i> Data de Início *
                        </label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data da Meta -->
                    <div>
                        <label for="target_date" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-calendar-day mr-1 text-green-400"></i> Data da Meta *
                        </label>
                        <input type="date" name="target_date" id="target_date" value="{{ old('target_date') }}" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                        @error('target_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contribuição Mensal -->
                    <div>
                        <label for="monthly_contribution" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-coins mr-1 text-green-400"></i> Contribuição Mensal
                        </label>
                        <input type="number" name="monthly_contribution" id="monthly_contribution" value="{{ old('monthly_contribution', 0) }}" step="0.01" min="0"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                        @error('monthly_contribution')
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
                                <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                    {{ $account->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('account_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Meta Eco-Friendly -->
                <div class="flex items-center space-x-3 p-4 bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-200 dark:border-green-700">
                    <input type="checkbox" name="is_eco_friendly" id="is_eco_friendly" value="1" {{ old('is_eco_friendly') ? 'checked' : '' }}
                        class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="is_eco_friendly" class="text-sm font-bold text-green-700 dark:text-green-300">
                        <i class="fa-solid fa-leaf mr-1"></i> Esta é uma meta com impacto ambiental positivo
                    </label>
                </div>

                <!-- Descrição do Impacto Ecológico -->
                <div id="eco_impact_section" class="{{ old('is_eco_friendly') ? '' : 'hidden' }}">
                    <label for="eco_impact_description" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fa-solid fa-leaf mr-1 text-green-400"></i> Descrição do Impacto Ecológico
                    </label>
                    <textarea name="eco_impact_description" id="eco_impact_description" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">{{ old('eco_impact_description') }}</textarea>
                    @error('eco_impact_description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descrição -->
                <div>
                    <label for="description" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fa-solid fa-align-left mr-1 text-green-400"></i> Descrição
                    </label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botões -->
                <div class="flex justify-end space-x-4 pt-6">
                    <a href="{{ route('financial-goals.index') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-base font-bold rounded-xl text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">
                        <i class="fa-solid fa-times mr-2"></i> Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-bold rounded-xl text-white bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 shadow transition-all duration-200">
                        <i class="fa-solid fa-save mr-2"></i> Criar Meta Verde
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('is_eco_friendly').addEventListener('change', function() {
        const ecoSection = document.getElementById('eco_impact_section');
        if (this.checked) {
            ecoSection.classList.remove('hidden');
        } else {
            ecoSection.classList.add('hidden');
        }
    });
</script>
@endsection 