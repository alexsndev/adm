@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800">
    <div class="container mx-auto px-4 py-8">
        <!-- Header da página -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                        <i class="fa-solid fa-arrow-up text-green-500 mr-3"></i>
                        Receitas Fixas
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Gerencie suas receitas recorrentes mensais</p>
                </div>
                <a href="{{ route('finance.fixed-incomes.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                    <i class="fa-solid fa-plus mr-2"></i>
                    Nova Receita Fixa
                </a>
            </div>
            
            @if(session('success'))
                <div class="bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-6 py-4 rounded-xl mb-6 flex items-center">
                    <i class="fa-solid fa-check-circle mr-3 text-green-600 dark:text-green-400"></i>
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <!-- Estatísticas rápidas -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-800">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                        <i class="fa-solid fa-list text-green-600 dark:text-green-400 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Receitas</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $receitasFixas->count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-800">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                        <i class="fa-solid fa-calendar-day text-blue-600 dark:text-blue-400 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Valor Mensal</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            R$ {{ number_format($receitasFixas->sum('amount'), 2, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-800">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                        <i class="fa-solid fa-clock text-yellow-600 dark:text-yellow-400 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Próximas (7 dias)</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $receitasFixas->filter(function($receita) { 
                                return \Carbon\Carbon::parse($receita->date)->diffInDays(now()) <= 7; 
                            })->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de receitas fixas -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Receitas Cadastradas</h2>
            </div>
            
            @if($receitasFixas->count() > 0)
                <div class="divide-y divide-gray-200 dark:divide-gray-800">
                    @foreach($receitasFixas as $receita)
                        <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors duration-200">
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                                <!-- Informações principais -->
                                <div class="flex-1">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                                                {{ $receita->description }}
                                            </h3>
                                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                                                <span class="flex items-center">
                                                    <i class="fa-solid fa-tag mr-2 text-green-500"></i>
                                                    {{ $receita->category->name ?? 'Sem categoria' }}
                                                </span>
                                                <span class="flex items-center">
                                                    <i class="fa-solid fa-wallet mr-2 text-blue-500"></i>
                                                    {{ $receita->account->name ?? 'Sem conta' }}
                                                </span>
                                                <span class="flex items-center">
                                                    <i class="fa-solid fa-calendar-day mr-2 text-purple-500"></i>
                                                    Dia {{ \Carbon\Carbon::parse($receita->date)->format('d') }} do mês
                                                </span>
                                                <span class="flex items-center">
                                                    <i class="fa-solid fa-repeat mr-2 text-orange-500"></i>
                                                    {{ ucfirst($receita->recurring_frequency) }}
                                                </span>
                                            </div>
                                            @if($receita->notes)
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 italic">
                                                    "{{ $receita->notes }}"
                                                </p>
                                            @endif
                                        </div>
                                        
                                        <!-- Valor -->
                                        <div class="text-right">
                                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                                                R$ {{ number_format($receita->amount, 2, ',', '.') }}
                                            </div>
                                            @if($receita->recurring_end_date)
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    Até {{ \Carbon\Carbon::parse($receita->recurring_end_date)->format('d/m/Y') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Ações -->
                                <div class="flex items-center gap-2 lg:flex-col lg:gap-1">
                                    @if(\Carbon\Carbon::parse($receita->date)->isToday())
                                        <form action="{{ route('finance.fixed-incomes.receive', $receita->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                <i class="fa-solid fa-check mr-1"></i>
                                                Receber Hoje
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <a href="{{ route('finance.fixed-incomes.edit', $receita->id) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                        <i class="fa-solid fa-edit mr-1"></i>
                                        Editar
                                    </a>
                                    
                                    <form action="{{ route('finance.fixed-incomes.destroy', $receita->id) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('Tem certeza que deseja excluir esta receita fixa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                            <i class="fa-solid fa-trash mr-1"></i>
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Estado vazio -->
                <div class="p-12 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full mb-6">
                        <i class="fa-solid fa-arrow-up text-green-600 dark:text-green-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        Nenhuma receita fixa cadastrada
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                        Comece cadastrando suas receitas recorrentes para ter um melhor controle financeiro mensal.
                    </p>
                    <a href="{{ route('finance.fixed-incomes.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                        <i class="fa-solid fa-plus mr-2"></i>
                        Cadastrar Primeira Receita Fixa
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    // Adicionar animação de fade-in aos cards
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.bg-white');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate-fade-in');
        });
    });
</script>
@endsection 