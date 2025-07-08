@extends('layouts.app')

@section('content')
    <div class="py-8 bg-gradient-to-br from-gray-900 via-blue-900 to-gray-800 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Cabeçalho do Projeto -->
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border-2 border-blue-600/20 mb-10 overflow-hidden animate-fade-in">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-8 p-8">
                    <div class="flex flex-col items-center md:items-start gap-4 flex-1">
                        <div class="flex items-center gap-4">
                            @if($project->client && $project->client->photo)
                                <a href="{{ route('clientes.edit', $project->client->id) }}">
                                    <img src="{{ asset('storage/' . $project->client->photo) }}" alt="Foto do Cliente" class="w-20 h-20 rounded-full object-cover border-4 border-blue-500 shadow-lg hover:scale-105 transition-transform">
                                </a>
                            @else
                                <a href="{{ route('clientes.edit', $project->client->id) }}">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($project->client->name ?? 'Cliente') }}&background=3B82F6&color=fff&size=128" alt="Avatar" class="w-20 h-20 rounded-full object-cover border-4 border-blue-500 shadow-lg hover:scale-105 transition-transform">
                                </a>
                            @endif
                            <div>
                                <a href="{{ route('clientes.edit', $project->client->id) }}" class="hover:underline text-3xl font-extrabold text-gray-900 dark:text-white block">
                                    {{ $project->client->name ?? 'Sem cliente' }}
                                </a>
                                <div class="flex gap-2 mt-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 uppercase tracking-wide shadow">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800 uppercase tracking-wide shadow">{{ ucfirst($project->priority) }}</span>
                                </div>
                            </div>
                        </div>
                        @if($project->description)
                            <div class="mt-4 max-w-xl">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Descrição</h4>
                                <p class="text-gray-600 dark:text-gray-300">{{ $project->description }}</p>
                            </div>
                        @endif
                        <!-- Progresso -->
                        <div class="w-full mt-6">
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                                <span>Progresso do Projeto</span>
                                <span>{{ $project->progress_percentage ?? 0 }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 shadow-inner">
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-4 rounded-full transition-all duration-500" style="width: {{ ($project->progress_percentage ?? 0) . '%' }}"></div>
                            </div>
                        </div>
                        <!-- Datas e valores -->
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-6 text-sm text-gray-700 dark:text-gray-300">
                            @if($project->start_date)
                                <div class="flex items-center gap-2"><i class="fa-solid fa-calendar-plus text-blue-500"></i> Início: {{ $project->start_date->format('d/m/Y') }}</div>
                            @endif
                            @if($project->due_date)
                                <div class="flex items-center gap-2"><i class="fa-solid fa-calendar-check text-blue-500"></i> Prazo: {{ $project->due_date->format('d/m/Y') }} @if($project->is_overdue)<span class="ml-2 text-red-600 font-bold">(Atrasado)</span>@endif</div>
                            @endif
                            @if($project->completed_date)
                                <div class="flex items-center gap-2"><i class="fa-solid fa-check-circle text-green-500"></i> Concluído: {{ $project->completed_date->format('d/m/Y') }}</div>
                            @endif
                            @if($project->budget > 0)
                                <div class="flex items-center gap-2"><i class="fa-solid fa-dollar-sign text-green-500"></i> Orçamento: R$ {{ number_format($project->budget, 2, ',', '.') }}</div>
                            @endif
                            @if($project->hourly_rate)
                                <div class="flex items-center gap-2"><i class="fa-solid fa-clock text-indigo-500"></i> Taxa: R$ {{ number_format($project->hourly_rate, 2, ',', '.') }}/h</div>
                            @endif
                            @if($project->estimated_hours)
                                <div class="flex items-center gap-2"><i class="fa-solid fa-hourglass-half text-yellow-500"></i> Estimativa: {{ $project->estimated_hours }}h</div>
                            @endif
                        </div>
                    </div>
                    <!-- Estatísticas -->
                    <div class="flex-1 flex flex-col gap-4">
                        <div class="bg-gradient-to-br from-blue-50 to-white dark:from-gray-800 dark:to-gray-900 rounded-2xl p-6 border shadow-lg">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2"><i class="fa-solid fa-chart-bar text-blue-500"></i> Estatísticas</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500">Total de Horas</span>
                                    <span class="font-bold text-2xl text-gray-900 dark:text-white flex items-center gap-1"><i class="fa-solid fa-clock text-indigo-500"></i> {{ number_format($project->total_hours ?? 0, 1) }}h</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500">Valor Faturado</span>
                                    <span class="font-bold text-2xl text-green-600 flex items-center gap-1"><i class="fa-solid fa-money-bill-wave"></i> R$ {{ number_format($project->total_billed ?? 0, 2, ',', '.') }}</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500">Tarefas</span>
                                    <span class="font-bold text-2xl text-gray-900 dark:text-white flex items-center gap-1"><i class="fa-solid fa-list-check"></i> {{ $project->tasks->count() }}</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="text-xs text-gray-500">Concluídas</span>
                                    <span class="font-bold text-2xl text-green-600 flex items-center gap-1"><i class="fa-solid fa-check-circle"></i> {{ $project->tasks->where('status', 'completed')->count() }}</span>
                                </div>
                            </div>
                        </div>
                        @if($project->notes)
                            <div class="bg-gradient-to-br from-yellow-50 to-white dark:from-gray-800 dark:to-gray-900 rounded-2xl p-6 border shadow-lg">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2"><i class="fa-solid fa-sticky-note text-yellow-500"></i> Notas</h4>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">{{ $project->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Bloco de Notas do Projeto (Rich Text) -->
            <div class="bg-yellow-50 dark:bg-gray-800 rounded-2xl p-6 border border-yellow-200 dark:border-gray-700 shadow-lg mb-8">
                <h4 class="text-lg font-bold text-yellow-800 dark:text-yellow-200 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-note-sticky text-yellow-500"></i> Bloco de Notas Rápido
                </h4>
                <div id="quill-toolbar" style="background: #fff; border-radius: 6px 6px 0 0;">
                  <span class="ql-formats">
                    <select class="ql-font"></select>
                    <select class="ql-size"></select>
                  </span>
                  <span class="ql-formats">
                    <button class="ql-bold"></button>
                    <button class="ql-italic"></button>
                    <button class="ql-underline"></button>
                    <button class="ql-strike"></button>
                  </span>
                  <span class="ql-formats">
                    <select class="ql-color"></select>
                    <select class="ql-background"></select>
                  </span>
                  <span class="ql-formats">
                    <button class="ql-list" value="ordered"></button>
                    <button class="ql-list" value="bullet"></button>
                  </span>
                  <span class="ql-formats">
                    <button class="ql-link"></button>
                  </span>
                </div>
                <div id="project-notes-quill" style="height: 200px; background: #fff; color: #222; border-radius: 0 0 6px 6px;"></div>
                <div class="flex items-center gap-4 mt-2">
                    <span id="notes-status" class="text-xs text-gray-600 dark:text-gray-200">Salvo</span>
                    <button onclick="copyNotes()" class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold px-4 py-2 rounded shadow transition">Copiar Tudo</button>
                </div>
            </div>
            <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
            <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
            <script>
                let timeout;
                const status = document.getElementById('notes-status');
                const quill = new Quill('#project-notes-quill', {
                    theme: 'snow',
                    modules: {
                        toolbar: '#quill-toolbar'
                    }
                });
                // Set initial content
                quill.root.innerHTML = @json($project->notes ?? '');
                quill.on('text-change', function() {
                    status.textContent = 'Salvando...';
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        fetch('{{ route('projetos.update-notes', $project) }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ notes: quill.root.innerHTML })
                        }).then(() => {
                            status.textContent = 'Salvo!';
                            setTimeout(() => status.textContent = 'Salvo', 2000);
                        });
                    }, 800);
                });
                function copyNotes() {
                    const temp = document.createElement('textarea');
                    temp.value = quill.root.innerHTML;
                    document.body.appendChild(temp);
                    temp.select();
                    document.execCommand('copy');
                    document.body.removeChild(temp);
                    status.textContent = 'Copiado!';
                    setTimeout(() => status.textContent = 'Salvo', 2000);
                }
            </script>
            @include('components.attachment-upload', ['project' => $project])
            <!-- Tarefas do Projeto -->
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border-2 border-blue-600/20 mb-10 p-8 animate-fade-in">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white flex items-center gap-2"><i class="fa-solid fa-list-check text-blue-500"></i> Tarefas do Projeto</h3>
                    <button id="openTaskModal" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold px-8 py-3 rounded-xl shadow-lg flex items-center gap-2 text-lg transition-all duration-200"><i class="fa-solid fa-plus"></i> Nova Tarefa</button>
                </div>
                @if($project->tasks->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($project->tasks as $task)
                            <div class="bg-gradient-to-br from-white to-blue-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-6 border shadow-lg hover:scale-[1.03] transition-transform duration-200 flex flex-col gap-3">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <h4 class="font-bold text-gray-900 dark:text-white text-lg">{{ $task->title }}</h4>
                                        <a href="{{ route('tarefas.edit', $task->id) }}" title="Editar tarefa" class="text-blue-600 hover:text-blue-800 ml-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                    </div>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                        <select onchange="updateTaskStatus({{ $task->id }}, this)" class="bg-transparent border-none focus:ring-0 text-xs font-bold">
                                            <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>A Fazer</option>
                                            <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>Em Andamento</option>
                                            <option value="paused" {{ $task->status == 'paused' ? 'selected' : '' }}>Pausado</option>
                                            <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Concluído</option>
                                        </select>
                                    </span>
                                </div>
                                @if($task->description)
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">{{ Str::limit($task->description, 100) }}</p>
                                @endif
                                <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mt-auto">
                                    <span class="inline-flex items-center"><i class="fa-solid fa-clock mr-1"></i> {{ $task->total_hours ?? 0 }}h</span>
                                    @if($task->due_date)
                                        <span class="inline-flex items-center"><i class="fa-solid fa-calendar mr-1"></i> {{ $task->due_date->format('d/m') }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-14 w-14 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-bold text-gray-900 dark:text-white">Nenhuma tarefa</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Comece criando a primeira tarefa do projeto.</p>
                    </div>
                @endif
            </div>
            <!-- Timer do Projeto Profissional -->
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border-2 border-blue-600/20 mb-10 overflow-hidden animate-fade-in">
                <div class="flex flex-col items-center justify-center gap-2 py-8">
                    @if($project->status === 'in_progress')
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
                            let baseSeconds = 0;
                            const storageKey = 'timer_project_{{ $project->id }}';
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
                            if (!baseSeconds) {
                                baseSeconds = ({{ $project->actual_minutes ?? 0 }}) * 60;
                            }
                            window.currentTimer = new RobustTimer(
                                'project_{{ $project->id }}',
                                baseSeconds / 60,
                                @json($project->started_at),
                                @json($project->paused_at),
                                @json($project->status)
                            );
                        });
                    </script>
                    @elseif($project->status === 'pending')
                    <div class="flex flex-col items-center justify-center gap-2">
                        <div class="text-center">
                            <div class="px-8 py-5 rounded-2xl bg-gradient-to-r from-gray-500 to-gray-600 text-white font-mono text-3xl font-bold shadow-lg flex items-center gap-2 mb-4">
                                <i class="fa-solid fa-clock mr-3 text-gray-300"></i>
                                <span>00:00:00</span>
                            </div>
                            <form action="{{ route('projetos.start-timer', $project) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg shadow-md transition-all duration-200 transform hover:scale-105 font-bold flex items-center mx-auto">
                                    <i class="fa-solid fa-play mr-2"></i>Iniciar Projeto
                                </button>
                            </form>
                        </div>
                    </div>
                    @elseif($project->status === 'completed')
                    <div class="flex flex-col items-center justify-center gap-2">
                        <div class="text-center">
                            <div class="px-8 py-5 rounded-2xl bg-gradient-to-r from-green-500 to-green-600 text-white font-mono text-3xl font-bold shadow-lg flex items-center gap-2 mb-4">
                                <i class="fa-solid fa-check-circle mr-3 text-yellow-300"></i>
                                <span>Concluído</span>
                            </div>
                            @if($project->actual_minutes)
                            <div class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                <i class="fa-solid fa-clock mr-1"></i>
                                Tempo total: {{ $project->actual_minutes }} minutos
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <!-- Botão para iniciar o projeto caso não esteja em andamento ou concluído -->
            @if(!in_array($project->status, ['in_progress', 'completed']))
                <div class="flex flex-col items-center justify-center gap-2 my-6">
                    <form action="{{ route('projetos.start-timer', $project) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg shadow-md transition-all duration-200 transform hover:scale-105 font-bold flex items-center mx-auto">
                            <i class="fa-solid fa-play mr-2"></i>Iniciar Projeto
                        </button>
                    </form>
                </div>
            @endif
            <!-- Links Importantes do Projeto -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl p-6 border border-blue-200 dark:border-gray-800 shadow-lg mb-8">
                <h4 class="text-lg font-bold text-blue-800 dark:text-blue-200 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-link text-blue-500"></i> Links Importantes
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6" id="project-links-list">
                    @foreach($project->links as $link)
                        <div class="rounded-xl bg-blue-50 dark:bg-gray-800 border border-blue-200 dark:border-gray-700 p-4 flex flex-col gap-2 shadow relative">
                            <div class="flex items-center gap-3 mb-2">
                                @if($link->image)
                                    <img src="{{ asset('storage/' . $link->image) }}" alt="Imagem do link" class="w-10 h-10 rounded shadow border object-cover">
                                @else
                                    <img src="https://www.google.com/s2/favicons?domain={{ parse_url($link->url, PHP_URL_HOST) }}&sz=64" alt="Favicon" class="w-10 h-10 rounded shadow border object-cover">
                                @endif
                                <div>
                                    <div class="font-bold text-lg text-blue-900 dark:text-blue-100">{{ $link->title }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-300">{{ $link->description }}</div>
                                </div>
                            </div>
                            <a href="{{ $link->url }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm flex items-center gap-1"><i class="fa-solid fa-arrow-up-right-from-square"></i> {{ $link->url }}</a>
                            <div class="flex gap-2 mt-2">
                                <button type="button" onclick="deleteProjectLink({{ $link->id }})" class="text-red-600 hover:text-red-800 text-xs font-bold"><i class="fa-solid fa-trash"></i> Remover</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Formulário para adicionar novo link -->
                <form id="add-link-form" class="flex flex-col md:flex-row gap-4 items-end" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="title" class="border rounded px-3 py-2 w-full md:w-1/5" placeholder="Título" required>
                    <input type="url" name="url" class="border rounded px-3 py-2 w-full md:w-2/5" placeholder="URL (https://...)" required>
                    <input type="text" name="description" class="border rounded px-3 py-2 w-full md:w-1/4" placeholder="Descrição">
                    <input type="file" name="image" accept="image/*" class="border rounded px-3 py-2 w-full md:w-1/5">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2 rounded shadow transition">Adicionar Link</button>
                </form>
                <span id="links-status" class="text-xs text-gray-500 mt-2"></span>
            </div>
            <script>
                document.getElementById('add-link-form').onsubmit = function(e) {
                    e.preventDefault();
                    const form = e.target;
                    const formData = new FormData(form);
                    fetch("{{ route('projetos.links.store', $project) }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: formData
                    })
                    .then(r => r.json())
                    .then(data => {
                        if(data.success) {
                            location.reload();
                        } else {
                            document.getElementById('links-status').textContent = 'Erro ao adicionar link.';
                        }
                    });
                };
                function deleteProjectLink(linkId) {
                    if(!confirm('Tem certeza que deseja remover este link?')) return;
                    fetch("{{ route('projetos.links.destroy', [$project, 'link' => 'LINK_ID']) }}".replace('LINK_ID', linkId), {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        if(data.success) {
                            location.reload();
                        } else {
                            document.getElementById('links-status').textContent = 'Erro ao remover link.';
                        }
                    });
                }
            </script>
        </div>
    </div>

    <!-- Modal de criação de tarefa -->
    <div id="taskModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 hidden">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-10 w-full max-w-lg relative animate-fade-in">
            <button id="closeTaskModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-900 text-3xl">&times;</button>
            <h2 class="text-2xl font-bold mb-6 text-center text-blue-700 dark:text-blue-400 flex items-center gap-2"><i class="fa-solid fa-plus"></i> Nova Tarefa Profissional</h2>
            <form id="taskForm" action="{{ route('tarefas.store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <div>
                    <label class="block font-semibold mb-1">Título da Tarefa</label>
                    <input type="text" name="title" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Descrição</label>
                    <textarea name="description" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" rows="3"></textarea>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Status</label>
                    <select name="status" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" required>
                        <option value="todo">A Fazer</option>
                        <option value="in_progress">Em Andamento</option>
                        <option value="paused">Pausado</option>
                        <option value="completed">Concluído</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold px-8 py-3 rounded-xl shadow-lg transition-all duration-200">Criar Tarefa</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('openTaskModal').onclick = function() {
            document.getElementById('taskModal').classList.remove('hidden');
        };
        document.getElementById('closeTaskModal').onclick = function() {
            document.getElementById('taskModal').classList.add('hidden');
        };
        document.getElementById('taskModal').onclick = function(e) {
            if (e.target === this) this.classList.add('hidden');
        };
        function updateTaskStatus(taskId, select) {
            const status = select.value;
            fetch(`/tarefas/${taskId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({ status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    select.classList.add('ring-2', 'ring-green-400');
                    setTimeout(() => select.classList.remove('ring-2', 'ring-green-400'), 800);
                } else {
                    alert('Erro ao atualizar status!');
                }
            })
            .catch(() => alert('Erro ao atualizar status!'));
        }
    </script>
    @endpush
@endsection