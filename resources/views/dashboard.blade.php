@extends('layouts.app')

@section('nav-classes', 'bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800')
@section('background')
    <div class="fixed inset-0 z-0 bg-gray-100 dark:bg-gray-900 transition-colors duration-300"></div>
@endsection

@section('header-classes', 'bg-white dark:bg-gray-900 shadow-none')
@section('main-classes', 'relative z-10')

@section('content')
    <div class="py-8 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                            <i class="fa-solid fa-chart-line text-blue-600 mr-3"></i>
                            Dashboard
                        </h1>
                        <p class="text-gray-600 dark:text-gray-300">Bem-vindo ao seu painel de controle personalizado</p>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Última atualização: {{ now()->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>

            <!-- Cards de Estatísticas Principais -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total de Eventos -->
                <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-800">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <i class="fa-solid fa-calendar text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total de Eventos</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $eventsCount ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('events.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                            Ver todos <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Próximos Eventos -->
                <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-800">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                            <i class="fa-solid fa-clock text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Próximos Eventos</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $upcomingEventsCount ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('events.calendar') }}" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 text-sm font-medium">
                            Ver calendário <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Tarefas Ativas -->
                <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-800">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                            <i class="fa-solid fa-tasks text-yellow-600 dark:text-yellow-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tarefas Ativas</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $activeTasksCount ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('tarefas.index') }}" class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 text-sm font-medium">
                            Ver tarefas <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>

                <!-- Projetos Ativos -->
                <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-800">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                            <i class="fa-solid fa-project-diagram text-purple-600 dark:text-purple-400 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Projetos Ativos</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $activeProjectsCount ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('projetos.index') }}" class="text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300 text-sm font-medium">
                            Ver projetos <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Seção Principal -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Atividades Recentes -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                <i class="fa-solid fa-history text-blue-500 mr-2"></i>
                                Atividades Recentes
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @forelse($recentActivities ?? [] as $activity)
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                                <i class="fa-solid fa-circle text-blue-600 dark:text-blue-400 text-xs"></i>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-gray-900 dark:text-white">{{ $activity->description }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <i class="fa-solid fa-inbox text-gray-400 text-4xl mb-4"></i>
                                        <p class="text-gray-500 dark:text-gray-400">Nenhuma atividade recente</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navegação Rápida -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                <i class="fa-solid fa-rocket text-green-500 mr-2"></i>
                                Navegação Rápida
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <a href="{{ route('events.create') }}" class="flex items-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                                    <i class="fa-solid fa-plus-circle text-blue-600 dark:text-blue-400 mr-3"></i>
                                    <span class="text-blue-900 dark:text-blue-100 font-medium">Criar Evento</span>
                                </a>
                                
                                <a href="{{ route('tarefas.create') }}" class="flex items-center p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-900/30 transition-colors">
                                    <i class="fa-solid fa-plus text-yellow-600 dark:text-yellow-400 mr-3"></i>
                                    <span class="text-yellow-900 dark:text-yellow-100 font-medium">Nova Tarefa</span>
                                </a>
                                
                                <a href="{{ route('projetos.create') }}" class="flex items-center p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
                                    <i class="fa-solid fa-folder-plus text-purple-600 dark:text-purple-400 mr-3"></i>
                                    <span class="text-purple-900 dark:text-purple-100 font-medium">Novo Projeto</span>
                                </a>
                                
                                <a href="{{ route('events.calendar') }}" class="flex items-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                                    <i class="fa-solid fa-calendar-week text-green-600 dark:text-green-400 mr-3"></i>
                                    <span class="text-green-900 dark:text-green-100 font-medium">Ver Calendário</span>
                                </a>
                                
                                <a href="{{ route('household-tasks.index') }}" class="flex items-center p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg hover:bg-orange-100 dark:hover:bg-orange-900/30 transition-colors">
                                    <i class="fa-solid fa-home text-orange-600 dark:text-orange-400 mr-3"></i>
                                    <span class="text-orange-900 dark:text-orange-100 font-medium">Tarefas Domésticas</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seção de Módulos -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <i class="fa-solid fa-th-large text-gray-600 mr-3"></i>
                    Módulos do Sistema
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Eventos -->
                    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-6 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                <i class="fa-solid fa-calendar-days text-blue-600 dark:text-blue-400 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Eventos</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Gerencie seus eventos importantes</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('events.index') }}" class="block text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                                <i class="fa-solid fa-list mr-2"></i>Lista de Eventos
                            </a>
                            <a href="{{ route('events.calendar') }}" class="block text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                                <i class="fa-solid fa-calendar-week mr-2"></i>Calendário
                            </a>
                            <a href="{{ route('events.create') }}" class="block text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                                <i class="fa-solid fa-plus mr-2"></i>Novo Evento
                            </a>
                        </div>
                    </div>

                    <!-- Tarefas -->
                    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-6 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                                <i class="fa-solid fa-tasks text-yellow-600 dark:text-yellow-400 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tarefas</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Organize suas tarefas profissionais</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('tarefas.index') }}" class="block text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 text-sm">
                                <i class="fa-solid fa-list mr-2"></i>Lista de Tarefas
                            </a>
                            <a href="{{ route('tarefas.create') }}" class="block text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 text-sm">
                                <i class="fa-solid fa-plus mr-2"></i>Nova Tarefa
                            </a>
                            <a href="{{ route('task-categories.index') }}" class="block text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 text-sm">
                                <i class="fa-solid fa-tags mr-2"></i>Categorias
                            </a>
                        </div>
                    </div>

                    <!-- Projetos -->
                    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-6 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                                <i class="fa-solid fa-project-diagram text-purple-600 dark:text-purple-400 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Projetos</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Gerencie seus projetos profissionais</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('projetos.index') }}" class="block text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300 text-sm">
                                <i class="fa-solid fa-list mr-2"></i>Lista de Projetos
                            </a>
                            <a href="{{ route('projetos.create') }}" class="block text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300 text-sm">
                                <i class="fa-solid fa-plus mr-2"></i>Novo Projeto
                            </a>
                            <a href="{{ route('clientes.index') }}" class="block text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300 text-sm">
                                <i class="fa-solid fa-users mr-2"></i>Clientes
                            </a>
                        </div>
                    </div>

                    <!-- Tarefas Domésticas -->
                    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-6 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-orange-100 dark:bg-orange-900 rounded-lg">
                                <i class="fa-solid fa-home text-orange-600 dark:text-orange-400 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tarefas Domésticas</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Organize as tarefas da casa</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('household-tasks.index') }}" class="block text-orange-600 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-300 text-sm">
                                <i class="fa-solid fa-list mr-2"></i>Lista de Tarefas
                            </a>
                            <a href="{{ route('household-tasks.create') }}" class="block text-orange-600 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-300 text-sm">
                                <i class="fa-solid fa-plus mr-2"></i>Nova Tarefa
                            </a>
                            <a href="{{ route('household-tasks.dashboard') }}" class="block text-orange-600 hover:text-orange-800 dark:text-orange-400 dark:hover:text-orange-300 text-sm">
                                <i class="fa-solid fa-chart-bar mr-2"></i>Dashboard
                            </a>
                        </div>
                    </div>

                    <!-- Finanças -->
                    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-6 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                                <i class="fa-solid fa-dollar-sign text-green-600 dark:text-green-400 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Finanças</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Controle suas finanças pessoais</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('transactions.index') }}" class="block text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 text-sm">
                                <i class="fa-solid fa-exchange-alt mr-2"></i>Transações
                            </a>
                            <a href="{{ route('accounts.index') }}" class="block text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 text-sm">
                                <i class="fa-solid fa-wallet mr-2"></i>Contas
                            </a>
                            <a href="{{ route('financial-goals.index') }}" class="block text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 text-sm">
                                <i class="fa-solid fa-bullseye mr-2"></i>Metas
                            </a>
                        </div>
                    </div>

                    <!-- Configurações -->
                    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-6 hover:shadow-xl transition-all duration-300">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-gray-100 dark:bg-gray-900 rounded-lg">
                                <i class="fa-solid fa-cog text-gray-600 dark:text-gray-400 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Configurações</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Personalize o sistema</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('profile.edit') }}" class="block text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300 text-sm">
                                <i class="fa-solid fa-user mr-2"></i>Perfil
                            </a>
                            <a href="{{ route('categories.index') }}" class="block text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300 text-sm">
                                <i class="fa-solid fa-tags mr-2"></i>Categorias
                            </a>
                            <a href="{{ route('previsibilidade.index') }}" class="block text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300 text-sm">
                                <i class="fa-solid fa-users mr-2"></i>Pessoas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .animate-fade-in-up {
            animation: fadeInUp 0.3s ease-out;
        }
        @keyframes fadeInUp {
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('pieChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Receitas', 'Despesas'],
                datasets: [{
                    data: [{{ $monthlyIncome }}, {{ $monthlyExpenses }}],
                    backgroundColor: [
                        'rgba(34,197,94,0.8)', // verde
                        'rgba(239,68,68,0.8)'  // vermelho
                    ],
                    borderColor: [
                        'rgba(34,197,94,1)',
                        'rgba(239,68,68,1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            color: document.documentElement.classList.contains('dark') ? '#fff' : '#222',
                            font: { size: 16 }
                        }
                    }
                }
            }
        });

        // AJAX exclusão transação
        document.querySelectorAll('.btn-excluir-transacao').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if (!confirm('Tem certeza que deseja excluir esta transação?')) return;
                const url = this.dataset.url;
                const card = this.closest('.transacao-card');
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: new URLSearchParams({ _method: 'DELETE' })
                })
                .then(resp => resp.ok ? resp.json().catch(()=>({success:true})) : Promise.reject())
                .then(() => {
                    card.remove();
                    showDashMsg('Transação excluída com sucesso!', 'success');
                })
                .catch(() => showDashMsg('Erro ao excluir transação!', 'error'));
            });
        });
        // Mensagem dinâmica
        window.showDashMsg = function(msg, type) {
            let el = document.getElementById('dash-msg');
            if (!el) {
                el = document.createElement('div');
                el.id = 'dash-msg';
                el.className = 'fixed top-6 right-6 z-50 px-6 py-3 rounded-xl font-bold shadow-lg text-white';
                document.body.appendChild(el);
            }
            el.textContent = msg;
            el.style.background = type === 'success' ? '#22c55e' : '#ef4444';
            el.style.display = 'block';
            setTimeout(()=>{ el.style.display='none'; }, 2500);
        }

        // Toggle Resumo Visual
        const toggleBtn = document.getElementById('toggle-resumo-visual');
        const resumoSection = document.getElementById('resumo-visual-section');
        const toggleIcon = toggleBtn.querySelector('i');
        const floatingBtn = document.getElementById('floating-toggle-resumo');
        
        // Verificar estado salvo
        const resumoHidden = localStorage.getItem('resumo-visual-hidden') === 'true';
        if (resumoHidden) {
            resumoSection.style.display = 'none';
            toggleIcon.className = 'fa-solid fa-eye text-sm';
            toggleBtn.title = 'Mostrar Resumo Visual';
            floatingBtn.classList.remove('hidden');
        }
        
        toggleBtn.addEventListener('click', function() {
            const isHidden = resumoSection.style.display === 'none';
            
            if (isHidden) {
                // Mostrar
                resumoSection.style.display = 'block';
                resumoSection.style.animation = 'fadeIn 0.3s ease-in-out';
                toggleIcon.className = 'fa-solid fa-eye-slash text-sm';
                toggleBtn.title = 'Ocultar Resumo Visual';
                floatingBtn.classList.add('hidden');
                localStorage.setItem('resumo-visual-hidden', 'false');
            } else {
                // Ocultar
                resumoSection.style.display = 'none';
                toggleIcon.className = 'fa-solid fa-eye text-sm';
                toggleBtn.title = 'Mostrar Resumo Visual';
                floatingBtn.classList.remove('hidden');
                localStorage.setItem('resumo-visual-hidden', 'true');
            }
        });

        // Botão flutuante
        floatingBtn.querySelector('button').addEventListener('click', function() {
            resumoSection.style.display = 'block';
            resumoSection.style.animation = 'fadeIn 0.3s ease-in-out';
            toggleIcon.className = 'fa-solid fa-eye-slash text-sm';
            toggleBtn.title = 'Ocultar Resumo Visual';
            floatingBtn.classList.add('hidden');
            localStorage.setItem('resumo-visual-hidden', 'false');
        });

        // Carrossel de frases
        const frases = [
            {
                texto: '"Cada centavo que você economiza hoje é um investimento no seu amanhã. <span class=\'text-blue-600 dark:text-blue-400 font-bold\'>Controle suas finanças, controle seu futuro.</span>"',
                dica: '💡 Dica do dia: Revise suas despesas mensais e identifique oportunidades de economia'
            },
            {
                texto: '"Disciplina financeira é a ponte entre sonhos e realizações. <span class=\'text-purple-600 dark:text-purple-400 font-bold\'>Planeje, aja, conquiste.</span>"',
                dica: '🔎 Analise pequenos gastos: eles fazem grande diferença no final do mês.'
            },
            {
                texto: '"O melhor momento para plantar uma árvore foi há 20 anos. O segundo melhor é agora. <span class=\'text-green-600 dark:text-green-400 font-bold\'>Invista no seu futuro hoje.</span>"',
                dica: '🌱 Comece a investir, mesmo que pouco, e colha os frutos amanhã.'
            },
            {
                texto: '"Não é sobre quanto você ganha, mas quanto você guarda. <span class=\'text-yellow-600 dark:text-yellow-400 font-bold\'>Poupar é poder.</span>"',
                dica: '💰 Defina uma meta de economia mensal e seja fiel a ela.'
            },
            {
                texto: '"Grandes conquistas financeiras começam com pequenas atitudes diárias. <span class=\'text-pink-600 dark:text-pink-400 font-bold\'>Valorize cada passo.</span>"',
                dica: '📅 Anote seus gastos e acompanhe sua evolução.'
            },
            {
                texto: '"O controle financeiro é o maior ato de autocuidado. <span class=\'text-blue-500 dark:text-blue-300 font-bold\'>Cuide do seu dinheiro, cuide de você.</span>"',
                dica: '🧘‍♂️ Reserve um tempo semanal para revisar suas finanças.'
            }
        ];
        let fraseAtual = 0;
        const fraseEl = document.getElementById('frase-carrossel');
        const fraseTexto = fraseEl.querySelectorAll('p')[0];
        const fraseDica = fraseEl.querySelectorAll('p')[1];
        function renderFrase(idx) {
            fraseTexto.innerHTML = frases[idx].texto;
            fraseDica.innerHTML = frases[idx].dica;
        }
        renderFrase(fraseAtual);
        setInterval(() => {
            fraseEl.style.opacity = 0;
            setTimeout(() => {
                fraseAtual = (fraseAtual + 1) % frases.length;
                renderFrase(fraseAtual);
                fraseEl.style.opacity = 1;
            }, 700);
        }, 8000);
    });
</script>
@endpush
