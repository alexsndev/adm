@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-4 px-1 sm:px-2 md:px-0 w-full max-w-full overflow-x-hidden">
    <!-- Breadcrumbs e topo -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-2 text-gray-500 dark:text-gray-300 text-sm">
            <a href="{{ route('dashboard') }}" class="hover:underline flex items-center"><i class="fa fa-home mr-1"></i> Início</a>
            <span>/</span>
            <a href="{{ route('household-tasks.index') }}" class="hover:underline">Tarefas Domésticas</a>
            <span>/</span>
            <span class="font-semibold text-blue-700 dark:text-blue-300">{{ $householdTask->title }}</span>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('household-tasks.edit', $householdTask) }}" class="btn btn-sm bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 hover:bg-blue-200 dark:hover:bg-blue-800 px-3 py-1 rounded flex items-center"><i class="fa fa-pen mr-1"></i> Editar</a>
            <form action="{{ route('household-tasks.destroy', $householdTask) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta tarefa?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 hover:bg-red-200 dark:hover:bg-red-800 px-3 py-1 rounded flex items-center"><i class="fa fa-trash mr-1"></i> Excluir</button>
            </form>
        </div>
    </div>

    <!-- Header da tarefa -->
    <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-blue-100 dark:border-blue-900 p-8 mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
        <div class="flex-1 flex flex-col gap-2">
            <div class="flex items-center gap-3 mb-2">
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 text-2xl font-bold">
                    <i class="fa fa-{{ $householdTask->taskCategory->icon ?? 'list' }}"></i>
                </span>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">{{ $householdTask->title }}</h1>
                @if($householdTask->is_favorite)
                    <i class="fa fa-star text-yellow-400 ml-2"></i>
                @endif
            </div>
            <div class="flex flex-wrap gap-2 items-center text-sm">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200"><i class="fa fa-folder mr-1"></i> {{ $householdTask->taskCategory->name ?? 'Sem categoria' }}</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200"><i class="fa fa-user mr-1"></i> {{ ucfirst($householdTask->assigned_to) }}</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200"><i class="fa fa-bolt mr-1"></i> {{ ucfirst($householdTask->priority) }}</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200"><i class="fa fa-clock mr-1"></i> {{ $householdTask->status === 'in_progress' ? 'Em andamento' : ucfirst($householdTask->status) }}</span>
            </div>
        </div>
        <!-- Cronômetro centralizado -->
        @if($householdTask->status === 'in_progress')
        <div class="flex flex-col items-center justify-center gap-2">
            <div id="timer-container" class="flex flex-col items-center gap-2">
                <div id="timer-display" class="px-8 py-5 rounded-2xl bg-gradient-to-r from-blue-500 to-purple-600 text-white font-mono text-3xl font-bold shadow-lg flex items-center gap-2">
                    <i class="fa-solid fa-clock mr-3 text-yellow-300"></i>
                    <span id="timer-hours">00</span>
                    <span class="mx-1">:</span>
                    <span id="timer-minutes">00</span>
                    <span class="mx-1">:</span>
                    <span id="timer-seconds">00</span>
                </div>
                <div class="flex gap-2 mt-2">
                    <button id="start-timer" class="timer-tooltip bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow-md transition-all duration-200 transform hover:scale-105" data-tooltip="Iniciar (Espaço)"><i class="fa-solid fa-play"></i></button>
                    <button id="pause-timer" class="timer-tooltip bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow-md transition-all duration-200 transform hover:scale-105" style="display: none;" data-tooltip="Pausar (Espaço)"><i class="fa-solid fa-pause"></i></button>
                    <button id="reset-timer" class="timer-tooltip bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow-md transition-all duration-200 transform hover:scale-105" data-tooltip="Reiniciar (Ctrl+R)"><i class="fa-solid fa-rotate-left"></i></button>
                </div>
                <div id="timer-status" class="text-sm text-gray-600 dark:text-gray-300 relative mt-1">
                    <span id="status-text">Iniciado</span>
                    <div class="timer-active-indicator hidden"></div>
                </div>
            </div>
            <link rel="stylesheet" href="{{ asset('css/timer.css') }}">
            <script src="{{ asset('js/modern-timer.js') }}"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Sempre tente usar o valor de segundos salvo localmente
                    let baseSeconds = 0;
                    const storageKey = 'timer_{{ $householdTask->id }}';
                    const saved = localStorage.getItem(storageKey);
                    if (saved) {
                        try {
                            const data = JSON.parse(saved);
                            if (typeof data.baseSeconds === 'number') {
                                baseSeconds = data.baseSeconds;
                            } else if (typeof data.totalSeconds === 'number') {
                                baseSeconds = data.totalSeconds;
                            }
                        } catch (e) {}
                    }
                    // Se não houver valor local, use os minutos do backend (sem precisão de segundos)
                    if (!baseSeconds) {
                        baseSeconds = ({{ $householdTask->actual_minutes ?? 0 }}) * 60;
                    }
                    window.currentTimer = new RobustTimer(
                        {{ $householdTask->id }},
                        baseSeconds / 60,
                        @json($householdTask->started_at),
                        @json($householdTask->paused_at),
                        @json($householdTask->status)
                    );
                });
                // Para precisão absoluta entre dispositivos, é necessário persistir os segundos no backend.
            </script>
        </div>
        @elseif($householdTask->status === 'pending')
        <div class="flex flex-col items-center justify-center gap-2">
            <div class="text-center">
                <div class="px-8 py-5 rounded-2xl bg-gradient-to-r from-gray-500 to-gray-600 text-white font-mono text-3xl font-bold shadow-lg flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-clock mr-3 text-gray-300"></i>
                    <span>00:00:00</span>
                </div>
                <form action="{{ route('household-tasks.start', $householdTask) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg shadow-md transition-all duration-200 transform hover:scale-105 font-bold flex items-center mx-auto">
                        <i class="fa-solid fa-play mr-2"></i>Iniciar Tarefa
                    </button>
                </form>
            </div>
        </div>
        @elseif($householdTask->status === 'completed')
        <div class="flex flex-col items-center justify-center gap-2">
            <div class="text-center">
                <div class="px-8 py-5 rounded-2xl bg-gradient-to-r from-green-500 to-green-600 text-white font-mono text-3xl font-bold shadow-lg flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-check-circle mr-3 text-yellow-300"></i>
                    <span>Concluída</span>
                </div>
                @if($householdTask->actual_minutes)
                <div class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                    <i class="fa-solid fa-clock mr-1"></i>
                    Tempo total: {{ $householdTask->actual_minutes }} minutos
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Cards de informações -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-6 mb-8 w-full max-w-full overflow-x-hidden">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-3 md:p-6 flex flex-col gap-2 md:gap-4 w-full max-w-full overflow-x-hidden">
            <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-2 flex items-center"><i class="fa fa-align-left mr-2"></i>Descrição</h3>
            <div class="text-gray-700 dark:text-gray-200 text-base">{{ $householdTask->description ?? 'Sem descrição.' }}</div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-3 md:p-6 flex flex-col gap-2 md:gap-4 w-full max-w-full overflow-x-hidden">
            <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-2 flex items-center"><i class="fa fa-calendar-alt mr-2"></i>Prazo</h3>
            <div class="flex flex-col gap-1">
                @if($householdTask->due_date)
                    <span class="text-gray-900 dark:text-gray-100 text-base"><i class="fa fa-calendar mr-1"></i> {{ $householdTask->due_date->format('d/m/Y') }}</span>
                    @if($householdTask->due_time)
                        <span class="text-gray-900 dark:text-gray-100 text-base"><i class="fa fa-clock mr-1"></i> {{ $householdTask->due_time->format('H:i') }}</span>
                    @endif
                @else
                    <span class="text-gray-500 dark:text-gray-400">Sem prazo definido</span>
                @endif
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-3 md:p-6 flex flex-col gap-2 md:gap-4 w-full max-w-full overflow-x-hidden">
            <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-2 flex items-center"><i class="fa fa-stopwatch mr-2"></i>Tempo</h3>
            <div class="flex flex-col gap-1">
                @if($householdTask->estimated_minutes)
                    <span class="text-gray-900 dark:text-gray-100 text-base">Estimado: {{ $householdTask->estimated_minutes }} minutos</span>
                @else
                    <span class="text-gray-500 dark:text-gray-400">Não informado</span>
                @endif
                @if($householdTask->actual_minutes)
                    <span class="text-gray-900 dark:text-gray-100 text-base">Total: {{ $householdTask->actual_minutes }} minutos</span>
                @endif
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-3 md:p-6 flex flex-col gap-2 md:gap-4 w-full max-w-full overflow-x-hidden">
            <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mb-2 flex items-center"><i class="fa fa-sticky-note mr-2"></i>Notas</h3>
            <div class="text-gray-700 dark:text-gray-200 text-base">{{ $householdTask->notes ?? 'Sem notas.' }}</div>
        </div>
    </div>

    <!-- Ações rápidas -->
    <div class="flex flex-wrap gap-3 justify-end mb-8">
        @if($householdTask->status === 'in_progress' && !$householdTask->paused_at)
            <form action="{{ route('household-tasks.pause', $householdTask) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded flex items-center"><i class="fa-solid fa-pause mr-2"></i>Pausar</button>
            </form>
        @endif
        @if($householdTask->status === 'in_progress' && $householdTask->paused_at)
            <form action="{{ route('household-tasks.resume', $householdTask) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center"><i class="fa-solid fa-play mr-2"></i>Despausar</button>
            </form>
        @endif
        @if(in_array($householdTask->status, ['in_progress']) && ($householdTask->paused_at || $householdTask->started_at))
            <button type="button" id="toPendingBtn" class="bg-gray-700 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded flex items-center border-2 border-gray-400 shadow-lg transition-all duration-200"><i class="fa-solid fa-arrow-rotate-left mr-2"></i>Voltar para Pendente</button>
            <form id="toPendingForm" action="{{ route('household-tasks.toPending', $householdTask) }}" method="POST" class="hidden">@csrf</form>
        @endif
        @if($householdTask->status !== 'completed')
            <form id="completeForm" action="{{ route('household-tasks.complete', $householdTask) }}" method="POST" class="inline">
                @csrf
                <button type="submit" id="completeBtn" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded flex items-center"><i class="fa-solid fa-check mr-2"></i>Concluir</button>
            </form>
        @endif
        @if($householdTask->status === 'completed')
            <form action="{{ route('household-tasks.reopen', $householdTask) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded flex items-center shadow-lg transition-all duration-200"><i class="fa-solid fa-rotate-left mr-2"></i>Retomar Tarefa</button>
            </form>
        @endif
    </div>

    <!-- Modal de confirmação para voltar para pendente -->
    <div id="toPendingModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-8 max-w-md w-full flex flex-col items-center">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center"><i class="fa-solid fa-arrow-rotate-left mr-2 text-gray-700"></i>Voltar para Pendente</h2>
            <p class="text-gray-700 dark:text-gray-200 mb-6 text-center">Tem certeza que deseja voltar esta tarefa para pendente?<br><b>O cronômetro será desativado e o tempo será zerado.</b></p>
            <div class="flex gap-4">
                <button id="cancelToPending" class="px-4 py-2 rounded bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-bold hover:bg-gray-400 dark:hover:bg-gray-600">Cancelar</button>
                <button id="confirmToPending" class="px-4 py-2 rounded bg-red-600 text-white font-bold hover:bg-red-700">Sim, voltar</button>
            </div>
        </div>
    </div>
    <script>
        // Modal de confirmação para voltar para pendente
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('toPendingBtn');
            const modal = document.getElementById('toPendingModal');
            const cancel = document.getElementById('cancelToPending');
            const confirm = document.getElementById('confirmToPending');
            const form = document.getElementById('toPendingForm');
            if(btn && modal && cancel && confirm && form) {
                btn.onclick = () => { modal.classList.remove('hidden'); };
                cancel.onclick = () => { modal.classList.add('hidden'); };
                confirm.onclick = () => {
                    // Limpa o localStorage do timer
                    localStorage.removeItem('timer_{{ $householdTask->id }}');
                    form.submit();
                };
            }
            
            // Interceptar clique no botão de concluir para salvar o tempo do cronômetro
            const completeBtn = document.getElementById('completeBtn');
            const completeForm = document.getElementById('completeForm');
            if(completeBtn && completeForm) {
                completeBtn.onclick = async function(e) {
                    e.preventDefault();
                    if(window.currentTimer) {
                        // Salva o tempo no backend antes de concluir
                        await new Promise(resolve => {
                            window.currentTimer.saveToServer();
                            // Aguarda 500ms para garantir que o backend processe
                            setTimeout(resolve, 500);
                        });
                        window.destroyCurrentTimer && window.destroyCurrentTimer({{ $householdTask->id }});
                    }
                    completeForm.submit();
                };
            }
        });
    </script>

    <!-- Toast de feedback -->
    @if(session('success'))
    <div class="fixed top-6 right-6 z-50 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg animate-bounce-in">
        <i class="fa fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="fixed top-6 right-6 z-50 bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg animate-bounce-in">
        <i class="fa fa-times-circle mr-2"></i>{{ session('error') }}
    </div>
    @endif

    <!-- Informações de conclusão -->
    @if($householdTask->completed_date)
        <div class="bg-green-50 border border-green-200 rounded-lg p-6 flex flex-col gap-2">
            <h3 class="text-lg font-semibold text-green-800 mb-2 flex items-center"><i class="fas fa-check-circle mr-2"></i>Concluída</h3>
            <div class="flex flex-wrap gap-4">
                <div>
                    <label class="block text-sm font-medium text-green-700 mb-1">Data de Conclusão</label>
                    <p class="text-green-800">{{ $householdTask->completed_date->format('d/m/Y') }}</p>
                </div>
                @if($householdTask->actual_minutes)
                <div>
                    <label class="block text-sm font-medium text-green-700 mb-1">Tempo Total</label>
                    <p class="text-green-800">{{ $householdTask->actual_hours }} horas</p>
                </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Fotos da tarefa doméstica -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-2 sm:p-4 md:p-6 flex flex-col gap-3 mt-6 w-full max-w-full overflow-x-hidden">
        <h3 class="text-sm md:text-base font-semibold text-blue-800 dark:text-blue-200 mb-1 flex items-center">
            <i class="fa fa-camera mr-2"></i>Fotos da Tarefa
        </h3>
        <div class="flex flex-wrap gap-1 md:gap-3 mb-3 justify-center md:justify-start">
            @foreach($householdTask->photos as $photo)
                <div class="relative group">
                    <img src="{{ Storage::url($photo->photo) }}" alt="Foto da tarefa" class="w-16 h-16 md:w-24 md:h-24 object-cover rounded-lg border-2 border-blue-200 shadow">
                    <form action="{{ route('household-tasks.delete-photo', [$householdTask, $photo]) }}" method="POST" class="absolute top-1 right-1 hidden group-hover:block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white rounded-full p-1 hover:bg-red-800"><i class="fa fa-trash"></i></button>
                    </form>
                </div>
            @endforeach
        </div>
        @if($householdTask->photos->count() < 5)
        <form action="{{ route('household-tasks.upload-photo', $householdTask) }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row items-center gap-2 md:gap-4 w-full">
            @csrf
            <label for="photo-input" class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg cursor-pointer w-full md:w-auto justify-center text-center">
                <i class="fa fa-camera text-lg"></i>
                <span class="text-sm font-semibold">Tirar Foto</span>
                <input id="photo-input" type="file" name="photo" accept="image/*" capture="environment" class="hidden" required onchange="this.form.submit()">
            </label>
            <span class="text-gray-500 text-xs md:text-sm mt-2 md:mt-0">Máx. 5 fotos</span>
        </form>
        @else
        <div class="text-gray-500 text-xs md:text-sm">Limite de 5 fotos atingido.</div>
        @endif
    </div>
</div>
@endsection 

@if(session('success') && (
    str_contains(session('success'), 'Tarefa retomada') ||
    str_contains(session('success'), 'Tarefa pausada') ||
    str_contains(session('success'), 'Tarefa iniciada') ||
    str_contains(session('success'), 'Tarefa despausada')
))
<script>
    // Limpa o localStorage do timer ao retomar, pausar ou despausar
    localStorage.removeItem('timer_{{ $householdTask->id }}');
</script>
@endif 