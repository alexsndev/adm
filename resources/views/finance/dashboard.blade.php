@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 overflow-x-hidden w-full max-w-full">
    <div class="container mx-auto px-2 md:px-4 py-4 md:py-8 w-full max-w-full">
        <div class="mb-8 text-center fade-in-up w-full max-w-full">
            <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent mb-4 w-full max-w-full">
                Dashboard Financeiro
            </h1>
            <p class="text-slate-600 dark:text-slate-300 text-lg max-w-2xl mx-auto w-full max-w-full">
                Acompanhe o panorama financeiro completo: saldos, receitas, despesas, contas, cartões, dívidas e metas.
            </p>
        </div>
        <!-- Cards de resumo -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8 fade-in-up w-full max-w-full">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 shadow-lg border border-slate-200 dark:border-slate-700 flex flex-col items-center w-full max-w-full">
                <span class="text-xs text-slate-500 dark:text-slate-400 mb-1">Saldo Total</span>
                <span class="text-2xl font-bold text-green-600 dark:text-green-400 break-words">R$ {{ $saldoTotal ?? '0,00' }}</span>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 shadow-lg border border-slate-200 dark:border-slate-700 flex flex-col items-center w-full max-w-full">
                <span class="text-xs text-slate-500 dark:text-slate-400 mb-1">Receitas</span>
                <span class="text-2xl font-bold text-blue-600 dark:text-blue-400 break-words">R$ {{ $totalReceitas ?? '0,00' }}</span>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 shadow-lg border border-slate-200 dark:border-slate-700 flex flex-col items-center w-full max-w-full">
                <span class="text-xs text-slate-500 dark:text-slate-400 mb-1">Despesas</span>
                <span class="text-2xl font-bold text-red-600 dark:text-red-400 break-words">R$ {{ $totalDespesas ?? '0,00' }}</span>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 shadow-lg border border-slate-200 dark:border-slate-700 flex flex-col items-center w-full max-w-full">
                <span class="text-xs text-slate-500 dark:text-slate-400 mb-1">Contas</span>
                <span class="text-2xl font-bold text-slate-900 dark:text-white break-words">{{ $totalContas ?? '0' }}</span>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 shadow-lg border border-slate-200 dark:border-slate-700 flex flex-col items-center w-full max-w-full">
                <span class="text-xs text-slate-500 dark:text-slate-400 mb-1">Cartões</span>
                <span class="text-2xl font-bold text-purple-600 dark:text-purple-400 break-words">{{ $totalCartoes ?? '0' }}</span>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-4 shadow-lg border border-slate-200 dark:border-slate-700 flex flex-col items-center w-full max-w-full">
                <span class="text-xs text-slate-500 dark:text-slate-400 mb-1">Dívidas</span>
                <span class="text-2xl font-bold text-orange-600 dark:text-orange-400 break-words">{{ $totalDividas ?? '0' }}</span>
            </div>
        </div>
        <!-- Gráfico de pizza/barra (placeholder) -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 mb-8 fade-in-up flex flex-col items-center w-full max-w-full overflow-x-auto">
            <h2 class="text-lg font-semibold mb-4 text-slate-700 dark:text-slate-200 w-full max-w-full">Distribuição de Receitas e Despesas</h2>
            <div class="w-full flex justify-center">
                <canvas id="financeChart" style="max-width:300px;width:100%"></canvas>
            </div>
        </div>
        <!-- Atalhos rápidos -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 fade-in-up w-full max-w-full">
            <a href="{{ route('accounts.index') }}" class="bg-gradient-to-r from-green-500 to-blue-500 text-white rounded-xl p-4 flex flex-col items-center shadow-lg hover:scale-105 transition-all w-full max-w-full">
                <i class="fa-solid fa-building-columns text-2xl mb-2"></i>
                <span>Contas</span>
            </a>
            <a href="{{ route('credit-cards.index') }}" class="bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl p-4 flex flex-col items-center shadow-lg hover:scale-105 transition-all w-full max-w-full">
                <i class="fa-solid fa-credit-card text-2xl mb-2"></i>
                <span>Cartões</span>
            </a>
            <a href="{{ route('transactions.index') }}" class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl p-4 flex flex-col items-center shadow-lg hover:scale-105 transition-all w-full max-w-full">
                <i class="fa-solid fa-arrow-right-arrow-left text-2xl mb-2"></i>
                <span>Transações</span>
            </a>
            <a href="{{ route('debts.index') }}" class="bg-gradient-to-r from-orange-500 to-yellow-500 text-white rounded-xl p-4 flex flex-col items-center shadow-lg hover:scale-105 transition-all w-full max-w-full">
                <i class="fa-solid fa-money-bill-wave text-2xl mb-2"></i>
                <span>Dívidas</span>
            </a>
            <a href="{{ route('financial-goals.index') }}" class="bg-gradient-to-r from-pink-500 to-red-500 text-white rounded-xl p-4 flex flex-col items-center shadow-lg hover:scale-105 transition-all w-full max-w-full">
                <i class="fa-solid fa-bullseye text-2xl mb-2"></i>
                <span>Metas</span>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('financeChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Receitas', 'Despesas'],
            datasets: [{
                data: [{{ $totalReceitas ?? 0 }}, {{ $totalDespesas ?? 0 }}],
                backgroundColor: ['#3b82f6', '#ef4444'],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true, position: 'bottom' }
            }
        }
    });
</script>
@endpush 