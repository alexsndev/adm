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
                    </div>
                </div>
            </div>
            <!-- Anexos do Projeto -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 mr-2 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a4 4 0 10-5.656-5.656l-6.586 6.586"></path>
                    </svg>
                    Anexos do Projeto
                </h3>
                <!-- Formulário de Upload -->
                <div class="bg-slate-50 dark:bg-slate-700/50 rounded-xl p-6 mb-6">
                    <form id="attachment-form" class="flex flex-col sm:flex-row gap-4">
                        @csrf
                        <div class="flex-1">
                            <input type="file" name="arquivo" accept="*/*" required
                                   class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-slate-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400 transition-all duration-200">
                        </div>
                        <div class="flex-1">
                            <input type="text" name="descricao" placeholder="Descrição do anexo" 
                                   class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200">
                        </div>
                        <button type="submit" id="upload-btn"
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-xl font-semibold transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span id="upload-text">Anexar</span>
                        </button>
                    </form>
                    <div id="upload-status" class="mt-3 text-sm hidden"></div>
                </div>
                <!-- Lista de Anexos -->
                <div id="attachments-list">
                    @if($project->attachments->isEmpty())
                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-xl p-8 text-center">
                            <svg class="w-12 h-12 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a4 4 0 10-5.656-5.656l-6.586 6.586"></path>
                            </svg>
                            <p class="text-slate-600 dark:text-slate-300">Nenhum anexo cadastrado.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($project->attachments as $anexo)
                                <div class="attachment-item bg-slate-50 dark:bg-slate-700/50 rounded-xl p-4 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all duration-200" data-id="{{ $anexo->id }}">
                                    @php
                                        $extension = strtolower(pathinfo($anexo->name, PATHINFO_EXTENSION));
                                        $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']);
                                        $isPdf = $extension === 'pdf';
                                        $isDoc = in_array($extension, ['doc', 'docx']);
                                        $isExcel = in_array($extension, ['xls', 'xlsx']);
                                        $isPpt = in_array($extension, ['ppt', 'pptx']);
                                        $isZip = in_array($extension, ['zip', 'rar', '7z']);
                                        $isVideo = in_array($extension, ['mp4', 'avi', 'mov', 'wmv']);
                                        $isAudio = in_array($extension, ['mp3', 'wav', 'ogg']);
                                    @endphp
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 rounded-lg flex items-center justify-center overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-600 dark:to-slate-700 border border-slate-200 dark:border-slate-600 shadow-sm hover:shadow-md transition-all duration-200" title="{{ strtoupper($extension) }}">
                                            
                                            @if($isImage)
                                                <img src="{{ Storage::url($anexo->file) }}" alt="Preview" class="w-full h-full object-cover">
                                            @elseif($isPdf)
                                                <div class="w-full h-full bg-red-500 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                                    </svg>
                                                </div>
                                            @elseif($isDoc)
                                                <div class="w-full h-full bg-blue-500 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                                    </svg>
                                                </div>
                                            @elseif($isExcel)
                                                <div class="w-full h-full bg-green-500 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                                    </svg>
                                                </div>
                                            @elseif($isPpt)
                                                <div class="w-full h-full bg-orange-500 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                                    </svg>
                                                </div>
                                            @elseif($isZip)
                                                <div class="w-full h-full bg-purple-500 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M20,6H16V4A2,2 0 0,0 14,2H10A2,2 0 0,0 8,4V6H4A2,2 0 0,0 2,8V19A2,2 0 0,0 4,21H20A2,2 0 0,0 22,19V8A2,2 0 0,0 20,6M10,4H14V6H10V4Z"/>
                                                    </svg>
                                                </div>
                                            @elseif($isVideo)
                                                <div class="w-full h-full bg-pink-500 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M17,10.5V7A1,1 0 0,0 16,6H4A1,1 0 0,0 3,7V17A1,1 0 0,0 4,18H16A1,1 0 0,0 17,17V13.5L21,17.5V6.5L17,10.5Z"/>
                                                    </svg>
                                                </div>
                                            @elseif($isAudio)
                                                <div class="w-full h-full bg-indigo-500 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12,3V12.26C11.5,12.09 11,12 10.5,12C7.46,12 5,14.46 5,17.5C5,20.54 7.46,23 10.5,23C13.54,23 16,20.54 16,17.5V6H22V3H12Z"/>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-full h-full bg-slate-500 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <a href="{{ Storage::url($anexo->file) }}" target="_blank" 
                                               class="font-medium text-slate-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                                {{ $anexo->descricao ?? $anexo->name }}
                                            </a>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                                {{ \Carbon\Carbon::parse($anexo->created_at)->format('d/m/Y H:i') }} • {{ strtoupper($extension) }}
                                            </p>
                                        </div>
                                        <button onclick="deleteAttachment({{ $anexo->id }})" class="text-red-500 hover:text-red-700 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
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
                    @if($project->links->isEmpty())
                        <div class="col-span-full text-center py-12">
                            <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fa-solid fa-link text-blue-600 dark:text-blue-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Nenhum link importante</h3>
                            <p class="text-gray-500 dark:text-gray-400">Adicione links importantes para este projeto.</p>
                        </div>
                    @else
                        @foreach($project->links as $link)
                        <div class="rounded-xl bg-blue-50 dark:bg-gray-800 border border-blue-200 dark:border-gray-700 p-4 flex flex-col gap-2 shadow relative min-h-[120px] hover:shadow-lg hover:border-blue-300 dark:hover:border-gray-600 transition-all duration-200">
                            <div class="flex items-start gap-3 mb-2">
                                @if($link->image)
                                    <img src="{{ asset('storage/' . $link->image) }}" alt="Imagem do link" class="w-10 h-10 rounded shadow border object-cover flex-shrink-0">
                                @else
                                    <img src="https://www.google.com/s2/favicons?domain={{ parse_url($link->url, PHP_URL_HOST) }}&sz=64" alt="Favicon" class="w-10 h-10 rounded shadow border object-cover flex-shrink-0">
                                @endif
                                <div class="flex-1 min-w-0">
                                    <div class="font-bold text-lg text-blue-900 dark:text-blue-100 truncate" title="{{ $link->title }}">{{ $link->title }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-300 line-clamp-2" title="{{ $link->description }}">
                                        {{ $link->description ?: 'Sem descrição' }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex-1 flex flex-col justify-between">
                                <a href="{{ $link->url }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm flex items-start gap-1 group">
                                    <i class="fa-solid fa-arrow-up-right-from-square mt-0.5 flex-shrink-0"></i>
                                    <span class="break-all line-clamp-2 group-hover:underline" title="{{ $link->url }}">{{ $link->url }}</span>
                                </a>
                                <div class="flex gap-2 mt-3">
                                    <button type="button" onclick="deleteProjectLink({{ $link->id }})" class="text-red-600 hover:text-red-800 text-xs font-bold flex items-center gap-1 px-2 py-1 rounded hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                        <i class="fa-solid fa-trash"></i> 
                                        <span class="hidden sm:inline">Remover</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
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
            <!-- Bloco de Notas Simples do Projeto -->
            <div class="bg-slate-900/80 dark:bg-slate-800/80 rounded-2xl shadow-xl border border-blue-900/40 p-6 mt-8 mb-8">
                <h3 class="text-xl font-bold text-blue-200 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-sticky-note text-yellow-400"></i> Notas do Projeto
                </h3>
                <form id="notes-form" class="flex flex-col gap-4">
                    <textarea id="notes-textarea" name="notes" rows="6" maxlength="1000"
                        class="w-full bg-slate-800 text-slate-100 border border-blue-900/40 rounded-xl p-4 focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-slate-400 resize-vertical transition-all duration-200"
                        placeholder="Digite suas notas do projeto...">{{ $project->notes }}</textarea>
                    <div class="flex items-center gap-2">
                        <button type="submit" class="px-6 py-2 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-semibold flex items-center gap-2 transition-all duration-200">
                            <i class="fa fa-save"></i> Salvar
                        </button>
                        <span id="notes-status" class="text-sm ml-2"></span>
                    </div>
                </form>
            </div>
            @push('scripts')
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('notes-form');
                const textarea = document.getElementById('notes-textarea');
                const status = document.getElementById('notes-status');
                form.onsubmit = function(e) {
                    e.preventDefault();
                    const value = textarea.value.trim();
                    if (!value) {
                        status.textContent = 'As notas não podem estar vazias.';
                        status.className = 'text-sm text-red-400 ml-2';
                        return;
                    }
                    if (value.length > 1000) {
                        status.textContent = 'Limite de 1000 caracteres.';
                        status.className = 'text-sm text-red-400 ml-2';
                        return;
                    }
                    status.textContent = 'Salvando...';
                    status.className = 'text-sm text-blue-400 ml-2';
                    fetch(`{{ route('projetos.update-notes', $project->id) }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ notes: value })
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            status.textContent = 'Notas salvas!';
                            status.className = 'text-sm text-green-400 ml-2';
                        } else {
                            status.textContent = data.message || 'Erro ao salvar notas.';
                            status.className = 'text-sm text-red-400 ml-2';
                        }
                    })
                    .catch(() => {
                        status.textContent = 'Erro ao salvar notas.';
                        status.className = 'text-sm text-red-400 ml-2';
                    });
                };
            });
            </script>
            @endpush
        </div>
    </div>

    <!-- Modal de criação de tarefa -->
    <div id="taskModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black hidden">
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

@section('after_content')
<style>
/* Scrollbar personalizada para o chat */
#chat-messages::-webkit-scrollbar {
    width: 6px;
}

/* Estilos para line-clamp */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Quebra de palavras para URLs longas */
.break-all {
    word-break: break-all;
}

/* Truncate para títulos longos */
.truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

#chat-messages::-webkit-scrollbar-track {
    background: transparent;
}

#chat-messages::-webkit-scrollbar-thumb {
    background: #CBD5E0;
    border-radius: 3px;
}

#chat-messages::-webkit-scrollbar-thumb:hover {
    background: #A0AEC0;
}

/* Animações para mensagens */
@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.message-own {
    animation: slideInRight 0.3s ease-out;
}

.message-other {
    animation: slideInLeft 0.3s ease-out;
}

/* Efeito de hover nas mensagens */
.message-bubble {
    transition: all 0.2s ease;
}

.message-bubble:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Indicador de digitação */
.typing-indicator {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 8px 12px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 12px;
    font-size: 12px;
    color: #666;
}

.typing-dots {
    display: flex;
    gap: 2px;
}

.typing-dots span {
    width: 4px;
    height: 4px;
    background: #999;
    border-radius: 50%;
    animation: typing 1.4s infinite ease-in-out;
}

.typing-dots span:nth-child(1) { animation-delay: -0.32s; }
.typing-dots span:nth-child(2) { animation-delay: -0.16s; }

@keyframes typing {
    0%, 80%, 100% {
        transform: scale(0.8);
        opacity: 0.5;
    }
    40% {
        transform: scale(1);
        opacity: 1;
    }
}
</style>

<!-- Chat Flutuante do Projeto -->
<div x-data="{ chatAberto: true }">
    <template x-if="chatAberto">
        <div id="floating-chat" style="position: fixed; bottom: 30px; right: 30px; z-index: 9999; width: 380px; max-width: 90vw;">
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Header do Chat -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-comments text-white text-lg"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-bold text-lg">Chat do Projeto</h4>
                                <p class="text-blue-100 text-sm">{{ $project->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-blue-100 text-xs">Online</span>
                            <button @click="chatAberto = false" class="ml-2 text-white hover:text-red-300 text-lg px-2 py-1 rounded-full focus:outline-none" title="Fechar chat">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Área de Mensagens -->
                <div id="chat-messages" class="h-80 overflow-y-auto p-4 space-y-4 bg-gray-50 dark:bg-gray-800" style="scrollbar-width: thin; scrollbar-color: #CBD5E0 #F7FAFC;">
                    @foreach($project->clientChats as $msg)
                        <div class="flex {{ $msg->user_id == auth()->id() ? 'justify-end' : 'justify-start' }}" data-message-id="{{ $msg->id }}">
                            @if($msg->user_id != auth()->id())
                                <!-- Avatar do outro usuário -->
                                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3">
                                    {{ strtoupper(substr($msg->user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="max-w-xs lg:max-w-md">
                                @if($msg->user_id != auth()->id())
                                    <!-- Nome do usuário -->
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium">
                                        {{ $msg->user->name }}
                                    </div>
                                @endif
                                <!-- Mensagem -->
                                <div class="relative">
                                    <div class="px-4 py-3 rounded-2xl {{ $msg->user_id == auth()->id() 
                                        ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-br-md' 
                                        : 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-200 dark:border-gray-600 rounded-bl-md' }}">
                                        <p class="text-sm leading-relaxed">{{ $msg->message }}</p>
                                    </div>
                                    <!-- Timestamp -->
                                    <div class="text-xs text-gray-400 dark:text-gray-500 mt-1 {{ $msg->user_id == auth()->id() ? 'text-right' : 'text-left' }}">
                                        {{ $msg->created_at->format('H:i') }}
                                        @if($msg->created_at->isToday())
                                            <span class="ml-1">• Hoje</span>
                                        @elseif($msg->created_at->isYesterday())
                                            <span class="ml-1">• Ontem</span>
                                        @else
                                            <span class="ml-1">• {{ $msg->created_at->format('d/m') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if($msg->user_id == auth()->id())
                                <!-- Avatar do usuário atual -->
                                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white text-sm font-bold ml-3">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <!-- Área de Input -->
                <div class="p-4 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                    <form id="floating-chat-form" class="flex gap-3">
                        <div class="flex-1 relative">
                            <input type="text" name="message" id="floating-message" 
                                   class="w-full px-4 py-3 pr-12 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                                   placeholder="Digite sua mensagem..." required maxlength="2000">
                            <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-500 transition-colors">
                                <i class="fa-solid fa-paperclip text-sm"></i>
                            </button>
                        </div>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center gap-2">
                            <i class="fa-solid fa-paper-plane text-sm"></i>
                            <span class="hidden sm:inline">Enviar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </template>
    <button x-show="!chatAberto" @click="chatAberto = true"
        class="fixed bottom-6 right-6 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-4 shadow-lg z-50 flex items-center justify-center"
        title="Abrir chat">
        <i class="fa-solid fa-comments text-2xl"></i>
    </button>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatForm = document.getElementById('floating-chat-form');
    const messageInput = document.getElementById('floating-message');
    const chatList = document.getElementById('chat-messages');
    let lastMessageId = 0;
    let autoRefreshInterval;
    
    if (!chatForm || !messageInput || !chatList) {
        console.error('Elementos do chat não encontrados');
        return;
    }
    
    // Função para rolar para o final do chat
    function scrollToBottom() {
        chatList.scrollTop = chatList.scrollHeight;
    }
    
    // Definir o último ID de mensagem baseado nas mensagens existentes
    const existingMessages = chatList.querySelectorAll('[data-message-id]');
    if (existingMessages.length > 0) {
        const lastMsg = existingMessages[existingMessages.length - 1];
        lastMessageId = parseInt(lastMsg.getAttribute('data-message-id'));
    }
    scrollToBottom();
    
    // Função para criar mensagem com design moderno
    function createMessageElement(message, userName, isOwnMessage, timestamp, id) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'flex ' + (isOwnMessage ? 'justify-end' : 'justify-start') + ' ' + (isOwnMessage ? 'message-own' : 'message-other');
        if (id) messageDiv.setAttribute('data-message-id', id);
        const currentTime = new Date();
        const messageTime = new Date(timestamp.replace(/(\d{2})\/(\d{2})\/(\d{4})/, '$2/$1/$3'));
        let timeDisplay = messageTime.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
        if (currentTime.toDateString() === messageTime.toDateString()) {
            timeDisplay += ' • Hoje';
        } else if (new Date(currentTime.getTime() - 24*60*60*1000).toDateString() === messageTime.toDateString()) {
            timeDisplay += ' • Ontem';
        } else {
            timeDisplay += ' • ' + messageTime.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit' });
        }
        const userInitial = userName.charAt(0).toUpperCase();
        const avatarColor = isOwnMessage ? 'from-blue-500 to-indigo-600' : 'from-purple-500 to-pink-500';
        messageDiv.innerHTML = `
            ${!isOwnMessage ? `<div class=\"flex-shrink-0 w-8 h-8 bg-gradient-to-br ${avatarColor} rounded-full flex items-center justify-center text-white text-sm font-bold mr-3 shadow-lg\">${userInitial}</div>` : ''}
            <div class=\"max-w-xs lg:max-w-md\">
                ${!isOwnMessage ? `<div class=\"text-xs text-gray-500 dark:text-gray-400 mb-1 font-medium\">${userName}</div>` : ''}
                <div class=\"relative\">
                    <div class=\"px-4 py-3 rounded-2xl message-bubble ${isOwnMessage ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-br-md shadow-lg' : 'bg-white dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-200 dark:border-gray-600 rounded-bl-md shadow-md'}\"><p class=\"text-sm leading-relaxed\">${message}</p></div>
                    <div class=\"text-xs text-gray-400 dark:text-gray-500 mt-1 ${isOwnMessage ? 'text-right' : 'text-left'}\">${timeDisplay}</div>
                </div>
            </div>
            ${isOwnMessage ? `<div class=\"flex-shrink-0 w-8 h-8 bg-gradient-to-br ${avatarColor} rounded-full flex items-center justify-center text-white text-sm font-bold ml-3 shadow-lg\">${userInitial}</div>` : ''}
        `;
        return messageDiv;
    }
    
    // Função para carregar mensagens automaticamente (incremental)
    function loadNewMessages() {
        const projectId = {{ $project->id }};
        const url = '/projetos/' + projectId + '/chat';
        fetch(url + '?ajax=1&last_id=' + lastMessageId, {
            method: 'GET',
            headers: { 'Accept': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.messages && data.messages.length > 0) {
                data.messages.forEach(msg => {
                    // Só adiciona se ainda não existe
                    if (!chatList.querySelector(`[data-message-id="${msg.id}"]`)) {
                        const isOwnMessage = msg.user_name === '{{ auth()->user()->name }}';
                        const newMsg = createMessageElement(
                            msg.message,
                            msg.user_name,
                            isOwnMessage,
                            msg.created_at,
                            msg.id
                        );
                        chatList.appendChild(newMsg);
                        lastMessageId = Math.max(lastMessageId, msg.id);
                    }
                });
                setTimeout(scrollToBottom, 100);
            }
        })
        .catch(error => {
            console.log('Erro ao carregar mensagens:', error);
        });
    }
    autoRefreshInterval = setInterval(loadNewMessages, 3000);
    
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (!message) return;
        const projectId = {{ $project->id }};
        const url = '/projetos/' + projectId + '/chat';
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const submitButton = chatForm.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-sm"></i><span class="hidden sm:inline ml-2">Enviando...</span>';
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Adicionar mensagem na tela
                const newMsg = createMessageElement(
                    data.message,
                    '{{ auth()->user()->name }}',
                    true,
                    data.created_at,
                    data.id || Date.now()
                );
                chatList.appendChild(newMsg);
                lastMessageId = Math.max(lastMessageId, data.id || lastMessageId);
                messageInput.value = '';
                setTimeout(scrollToBottom, 100);
            } else {
                alert('Erro ao enviar mensagem');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao enviar mensagem');
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fa-solid fa-paper-plane text-sm"></i><span class="hidden sm:inline">Enviar</span>';
        });
    });
    // Parar atualização quando a página for fechada
    window.addEventListener('beforeunload', function() {
        if (autoRefreshInterval) {
            clearInterval(autoRefreshInterval);
        }
    });
});

// Upload de anexos via AJAX
document.addEventListener('DOMContentLoaded', function() {
    const attachmentForm = document.getElementById('attachment-form');
    const uploadBtn = document.getElementById('upload-btn');
    const uploadText = document.getElementById('upload-text');
    const uploadStatus = document.getElementById('upload-status');
    const attachmentsList = document.getElementById('attachments-list');
    
    if (!attachmentForm) return;
    
    attachmentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData();
        const fileInput = attachmentForm.querySelector('input[name="arquivo"]');
        const descricaoInput = attachmentForm.querySelector('input[name="descricao"]');
        
        if (!fileInput.files[0]) {
            showStatus('Por favor, selecione um arquivo.', 'error');
            return;
        }
        
        // Adicionar arquivo e descrição ao FormData
        formData.append('arquivo', fileInput.files[0]);
        if (descricaoInput.value) {
            formData.append('descricao', descricaoInput.value);
        }
        
        // Mostrar loading
        uploadBtn.disabled = true;
        uploadText.textContent = 'Enviando...';
        uploadBtn.innerHTML = '<svg class="w-5 h-5 inline mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Enviando...';
        
        fetch('{{ route('projetos.attachments.store', $project->id) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showStatus('Anexo enviado com sucesso!', 'success');
                addAttachmentToList(data.attachment);
                attachmentForm.reset();
            } else {
                showStatus(data.message || 'Erro ao enviar anexo.', 'error');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            showStatus('Erro ao enviar anexo.', 'error');
        })
        .finally(() => {
            uploadBtn.disabled = false;
            uploadText.textContent = 'Anexar';
            uploadBtn.innerHTML = '<svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg><span id="upload-text">Anexar</span>';
        });
    });
    
    function showStatus(message, type) {
        uploadStatus.textContent = message;
        uploadStatus.className = `mt-3 text-sm ${type === 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}`;
        uploadStatus.classList.remove('hidden');
        
        setTimeout(() => {
            uploadStatus.classList.add('hidden');
        }, 3000);
    }
    
    function addAttachmentToList(attachment) {
        // Remover mensagem de "nenhum anexo" se existir
        const emptyMessage = attachmentsList.querySelector('.bg-slate-50.rounded-xl.p-8.text-center');
        if (emptyMessage) {
            emptyMessage.remove();
        }
        
        // Verificar se já existe um grid, senão criar
        let grid = attachmentsList.querySelector('.grid');
        if (!grid) {
            grid = document.createElement('div');
            grid.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4';
            attachmentsList.appendChild(grid);
        }
        
        // Criar novo item de anexo
        const attachmentItem = document.createElement('div');
        attachmentItem.className = 'attachment-item bg-slate-50 dark:bg-slate-700/50 rounded-xl p-4 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all duration-200';
        attachmentItem.setAttribute('data-id', attachment.id);
        
        // Determinar o tipo de arquivo e criar o preview
        const extension = attachment.name.split('.').pop().toLowerCase();
        const isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'].includes(extension);
        const isPdf = extension === 'pdf';
        const isDoc = ['doc', 'docx'].includes(extension);
        const isExcel = ['xls', 'xlsx'].includes(extension);
        const isPpt = ['ppt', 'pptx'].includes(extension);
        const isZip = ['zip', 'rar', '7z'].includes(extension);
        const isVideo = ['mp4', 'avi', 'mov', 'wmv'].includes(extension);
        const isAudio = ['mp3', 'wav', 'ogg'].includes(extension);
        
        let previewHtml = '';
        
        if (isImage) {
            previewHtml = `<img src="${attachment.url}" alt="Preview" class="w-full h-full object-cover">`;
        } else if (isPdf) {
            previewHtml = `
                <div class="w-full h-full bg-red-500 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                    </svg>
                </div>
            `;
        } else if (isDoc) {
            previewHtml = `
                <div class="w-full h-full bg-blue-500 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                    </svg>
                </div>
            `;
        } else if (isExcel) {
            previewHtml = `
                <div class="w-full h-full bg-green-500 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                    </svg>
                </div>
            `;
        } else if (isPpt) {
            previewHtml = `
                <div class="w-full h-full bg-orange-500 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                    </svg>
                </div>
            `;
        } else if (isZip) {
            previewHtml = `
                <div class="w-full h-full bg-purple-500 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20,6H16V4A2,2 0 0,0 14,2H10A2,2 0 0,0 8,4V6H4A2,2 0 0,0 2,8V19A2,2 0 0,0 4,21H20A2,2 0 0,0 22,19V8A2,2 0 0,0 20,6M10,4H14V6H10V4Z"/>
                    </svg>
                </div>
            `;
        } else if (isVideo) {
            previewHtml = `
                <div class="w-full h-full bg-pink-500 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17,10.5V7A1,1 0 0,0 16,6H4A1,1 0 0,0 3,7V17A1,1 0 0,0 4,18H16A1,1 0 0,0 17,17V13.5L21,17.5V6.5L17,10.5Z"/>
                    </svg>
                </div>
            `;
        } else if (isAudio) {
            previewHtml = `
                <div class="w-full h-full bg-indigo-500 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12,3V12.26C11.5,12.09 11,12 10.5,12C7.46,12 5,14.46 5,17.5C5,20.54 7.46,23 10.5,23C13.54,23 16,20.54 16,17.5V6H22V3H12Z"/>
                    </svg>
                </div>
            `;
        } else {
            previewHtml = `
                <div class="w-full h-full bg-slate-500 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                    </svg>
                </div>
            `;
        }
        
        attachmentItem.innerHTML = `
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 rounded-lg flex items-center justify-center overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-600 dark:to-slate-700 border border-slate-200 dark:border-slate-600 shadow-sm hover:shadow-md transition-all duration-200" title="${extension.toUpperCase()}">
                    ${previewHtml}
                </div>
                <div class="flex-1">
                    <a href="${attachment.url}" target="_blank" 
                       class="font-medium text-slate-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                        ${attachment.descricao || attachment.name}
                    </a>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        ${attachment.created_at} • ${extension.toUpperCase()}
                    </p>
                </div>
                <button onclick="deleteAttachment(${attachment.id})" class="text-red-500 hover:text-red-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        `;
        
        grid.appendChild(attachmentItem);
    }
});

// Função para deletar anexo
function deleteAttachment(attachmentId) {
    if (!confirm('Tem certeza que deseja excluir este anexo?')) {
        return;
    }
    
    fetch(`{{ route('projetos.attachments.destroy', [$project, 'attachment' => 'ATTACHMENT_ID']) }}`.replace('ATTACHMENT_ID', attachmentId), {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const attachmentItem = document.querySelector(`[data-id="${attachmentId}"]`);
            if (attachmentItem) {
                attachmentItem.remove();
                
                // Verificar se não há mais anexos
                const remainingAttachments = document.querySelectorAll('.attachment-item');
                if (remainingAttachments.length === 0) {
                    const grid = document.querySelector('#attachments-list .grid');
                    if (grid) {
                        grid.remove();
                    }
                    
                    const attachmentsList = document.getElementById('attachments-list');
                    attachmentsList.innerHTML = `
                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-xl p-8 text-center">
                            <svg class="w-12 h-12 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a4 4 0 10-5.656-5.656l-6.586 6.586"></path>
                            </svg>
                            <p class="text-slate-600 dark:text-slate-300">Nenhum anexo cadastrado.</p>
                        </div>
                    `;
                }
            }
        } else {
            alert('Erro ao excluir anexo.');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Erro ao excluir anexo.');
    });
}
</script>
@endsection

@push('scripts')
// ... existing code ...
<script>
// Corrige múltiplos espaços na visualização das notas
function fixSpacesInNotesView() {
    const notesView = document.getElementById('notes-view');
    if (!notesView) return;
    // Só processa se não estiver editando
    if (notesView.classList.contains('hidden')) return;
    // Substitui 2 ou mais espaços por &nbsp; (mas só fora de tags HTML)
    let html = notesView.innerHTML;
    // Regex: só substitui espaços fora de tags
    html = html.replace(/(>[^<]*)  /g, function(match) {
        return match.replace(/  /g, ' &nbsp;');
    });
    notesView.innerHTML = html;
}
document.addEventListener('DOMContentLoaded', fixSpacesInNotesView);
// Também corrige após salvar notas
if (typeof saveBtn !== 'undefined') {
    saveBtn.addEventListener('click', function() {
        setTimeout(fixSpacesInNotesView, 300);
    });
}
</script>
// ... existing code ...