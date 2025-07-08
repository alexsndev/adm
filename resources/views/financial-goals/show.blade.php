@extends('layouts.app')

@section('content')
    @section('header')
        <div class="flex justify-between items-center mb-2">
            <h2 class="font-extrabold text-3xl md:text-4xl text-gray-900 dark:text-white tracking-tight drop-shadow-lg animate-fade-in">
                <i class="fa-solid fa-target mr-2 text-green-400"></i> {{ $financialGoal->name }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('financial-goals.edit', $financialGoal) }}" class="inline-flex items-center px-5 py-2 border border-transparent text-base font-bold rounded-xl text-white bg-gradient-to-r from-yellow-500 to-orange-600 hover:from-yellow-600 hover:to-orange-700 shadow transition-all duration-200 animate-fade-in">
                    <i class="fa-solid fa-edit mr-2"></i> Editar
                </a>
                <a href="{{ route('financial-goals.index') }}" class="inline-flex items-center px-5 py-2 border border-transparent text-base font-bold rounded-xl text-white bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 shadow transition-all duration-200 animate-fade-in">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Voltar
                </a>
            </div>
        </div>
    @endsection

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Card Principal -->
            <div class="bg-white/60 dark:bg-gray-900/60 rounded-3xl shadow-xl p-8 border border-white/30 dark:border-gray-700/30 backdrop-blur-lg animate-fade-in mb-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Informações Principais -->
                    <div class="lg:col-span-2">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 shadow border border-green-200 dark:border-green-700 mr-4">
                                    <i class="fa-solid {{ $financialGoal->goal_type_icon }} fa-2x"></i>
                                </span>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $financialGoal->name }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $financialGoal->goal_type_label }}</p>
                                </div>
                            </div>
                            @if($financialGoal->is_eco_friendly)
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-sm font-bold">
                                    <i class="fa-solid fa-leaf mr-1"></i> Verde
                                </span>
                            @endif
                        </div>

                        <!-- Progresso -->
                        <div class="mb-6">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600 dark:text-gray-400">Progresso</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $financialGoal->progress_percentage }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                                <div class="bg-gradient-to-r from-green-400 to-blue-500 h-4 rounded-full transition-all duration-500" style="width: {{ $financialGoal->progress_percentage }}%"></div>
                            </div>
                        </div>

                        <!-- Valores -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="bg-white/50 dark:bg-gray-800/50 rounded-xl p-4 border border-white/20 dark:border-gray-700/20">
                                <div class="text-sm text-gray-500 dark:text-gray-400">Valor Atual</div>
                                <div class="text-xl font-bold text-gray-900 dark:text-white">R$ {{ number_format($financialGoal->current_amount, 2, ',', '.') }}</div>
                            </div>
                            <div class="bg-white/50 dark:bg-gray-800/50 rounded-xl p-4 border border-white/20 dark:border-gray-700/20">
                                <div class="text-sm text-gray-500 dark:text-gray-400">Meta</div>
                                <div class="text-xl font-bold text-gray-900 dark:text-white">R$ {{ number_format($financialGoal->target_amount, 2, ',', '.') }}</div>
                            </div>
                            <div class="bg-white/50 dark:bg-gray-800/50 rounded-xl p-4 border border-white/20 dark:border-gray-700/20">
                                <div class="text-sm text-gray-500 dark:text-gray-400">Restante</div>
                                <div class="text-xl font-bold text-gray-900 dark:text-white">R$ {{ number_format($financialGoal->remaining_amount, 2, ',', '.') }}</div>
                            </div>
                        </div>

                        <!-- Descrição -->
                        @if($financialGoal->description)
                            <div class="mb-6">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Descrição</h4>
                                <p class="text-gray-600 dark:text-gray-400">{{ $financialGoal->description }}</p>
                            </div>
                        @endif

                        <!-- Impacto Ecológico -->
                        @if($financialGoal->is_eco_friendly && $financialGoal->eco_impact_description)
                            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-200 dark:border-green-700">
                                <h4 class="text-lg font-bold text-green-700 dark:text-green-300 mb-2">
                                    <i class="fa-solid fa-leaf mr-1"></i> Impacto Ecológico
                                </h4>
                                <p class="text-green-600 dark:text-green-400">{{ $financialGoal->eco_impact_description }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Status e Prioridade -->
                        <div class="bg-white/50 dark:bg-gray-800/50 rounded-xl p-6 border border-white/20 dark:border-gray-700/20">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Informações</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Status:</span>
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $financialGoal->status_label }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Prioridade:</span>
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $financialGoal->priority_label }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Contribuição Mensal:</span>
                                    <span class="font-bold text-gray-900 dark:text-white">R$ {{ number_format($financialGoal->monthly_contribution, 2, ',', '.') }}</span>
                                </div>
                                @if($financialGoal->account)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Conta:</span>
                                        <span class="font-bold text-gray-900 dark:text-white">{{ $financialGoal->account->name }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Datas -->
                        <div class="bg-white/50 dark:bg-gray-800/50 rounded-xl p-6 border border-white/20 dark:border-gray-700/20">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Datas</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Início:</span>
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $financialGoal->start_date->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Meta:</span>
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $financialGoal->target_date->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Dias restantes:</span>
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $financialGoal->days_until_target }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Recomendações -->
                        <div class="bg-white/50 dark:bg-gray-800/50 rounded-xl p-6 border border-white/20 dark:border-gray-700/20">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Recomendações</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Contribuição recomendada:</span>
                                    <span class="font-bold text-gray-900 dark:text-white">R$ {{ number_format($financialGoal->recommended_monthly_contribution, 2, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-gray-600 dark:text-gray-400 mr-2">No caminho:</span>
                                    @if($financialGoal->is_on_track)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs font-bold">
                                            <i class="fa-solid fa-check mr-1"></i> Sim
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 text-xs font-bold">
                                            <i class="fa-solid fa-exclamation-triangle mr-1"></i> Não
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="flex justify-center space-x-4">
                <form method="POST" action="{{ route('financial-goals.destroy', $financialGoal) }}" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta meta?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-bold rounded-xl text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 shadow transition-all duration-200">
                        <i class="fa-solid fa-trash mr-2"></i> Excluir Meta
                    </button>
                </form>
            </div>
        </div>

        <!-- Seção de Contribuições -->
        <div class="mt-8">
            <div class="bg-white/60 dark:bg-gray-900/60 rounded-3xl shadow-xl p-8 border border-white/30 dark:border-gray-700/30 backdrop-blur-lg animate-fade-in">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                        <i class="fa-solid fa-coins mr-2 text-green-400"></i> Contribuições
                    </h3>
                    <a href="{{ route('financial-goals.contributions.create', $financialGoal) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-bold rounded-xl text-white bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 shadow transition-all duration-200">
                        <i class="fa-solid fa-plus mr-2"></i> Nova Contribuição
                    </a>
                </div>

                <!-- Contribuição Rápida -->
                <div class="bg-white/50 dark:bg-gray-800/50 rounded-xl p-6 border border-white/20 dark:border-gray-700/20 mb-6">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                        <i class="fa-solid fa-bolt mr-2 text-yellow-500"></i> Contribuição Rápida
                    </h4>
                    <form method="POST" action="{{ route('financial-goals.quick-contribution', $financialGoal) }}" class="flex gap-4">
                        @csrf
                        <div class="flex-1">
                            <input type="number" name="amount" step="0.01" min="0.01" placeholder="Valor da contribuição" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                        </div>
                        <div class="flex-1">
                            <input type="text" name="description" placeholder="Descrição (opcional)" maxlength="255"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200">
                        </div>
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-bold rounded-xl text-white bg-gradient-to-r from-yellow-500 to-orange-600 hover:from-yellow-600 hover:to-orange-700 shadow transition-all duration-200">
                            <i class="fa-solid fa-plus mr-2"></i> Adicionar
                        </button>
                    </form>
                </div>

                <!-- Lista de Contribuições -->
                <div class="space-y-4">
                    @if($financialGoal->contributions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-900 dark:text-white">
                                <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-white/50 dark:bg-gray-800/50">
                                    <tr>
                                        <th class="px-6 py-3 rounded-l-xl">Data</th>
                                        <th class="px-6 py-3">Valor</th>
                                        <th class="px-6 py-3">Tipo</th>
                                        <th class="px-6 py-3">Descrição</th>
                                        <th class="px-6 py-3">Conta</th>
                                        <th class="px-6 py-3 rounded-r-xl">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($financialGoal->contributions()->orderBy('contribution_date', 'desc')->get() as $contribution)
                                        <tr class="bg-white/30 dark:bg-gray-800/30 hover:bg-white/50 dark:hover:bg-gray-800/50 transition-colors">
                                            <td class="px-6 py-4 font-medium">
                                                {{ $contribution->formatted_date }}
                                            </td>
                                            <td class="px-6 py-4 font-bold text-green-600 dark:text-green-400">
                                                {{ $contribution->formatted_amount }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold
                                                    @if($contribution->type === 'manual') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                                                    @elseif($contribution->type === 'automatic') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                                    @else bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 @endif">
                                                    {{ $contribution->type_label }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                                {{ $contribution->description ?: '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                                {{ $contribution->account ? $contribution->account->name : '-' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('financial-goals.contributions.edit', [$financialGoal, $contribution]) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-bold text-sm transition">
                                                        <i class="fa-solid fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('financial-goals.contributions.destroy', [$financialGoal, $contribution]) }}" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta contribuição?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-bold text-sm transition">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Resumo das Contribuições -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                            <div class="bg-white/50 dark:bg-gray-800/50 rounded-xl p-4 border border-white/20 dark:border-gray-700/20">
                                <div class="text-sm text-gray-500 dark:text-gray-400">Total Contribuído</div>
                                <div class="text-xl font-bold text-green-600 dark:text-green-400">R$ {{ number_format($financialGoal->total_contributions, 2, ',', '.') }}</div>
                            </div>
                            <div class="bg-white/50 dark:bg-gray-800/50 rounded-xl p-4 border border-white/20 dark:border-gray-700/20">
                                <div class="text-sm text-gray-500 dark:text-gray-400">Última Contribuição</div>
                                <div class="text-lg font-bold text-gray-900 dark:text-white">
                                    @if($financialGoal->last_contribution)
                                        {{ $financialGoal->last_contribution->formatted_date }}
                                    @else
                                        Nenhuma
                                    @endif
                                </div>
                            </div>
                            <div class="bg-white/50 dark:bg-gray-800/50 rounded-xl p-4 border border-white/20 dark:border-gray-700/20">
                                <div class="text-sm text-gray-500 dark:text-gray-400">Total de Contribuições</div>
                                <div class="text-xl font-bold text-gray-900 dark:text-white">{{ $financialGoal->contributions->count() }}</div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fa-solid fa-coins fa-3x text-gray-300 mb-4"></i>
                            <h3 class="mt-2 text-xl font-extrabold text-gray-900 dark:text-white">Nenhuma contribuição registrada</h3>
                            <p class="mt-1 text-base text-gray-500 dark:text-gray-400">Comece registrando sua primeira contribuição para esta meta.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection 