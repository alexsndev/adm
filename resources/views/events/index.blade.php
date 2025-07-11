@extends('layouts.app')

@section('content')
    <div class="py-6 bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header com estatísticas rápidas -->
            <div class="mb-8">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 lg:gap-6 mb-6">
                    <div class="w-full lg:w-auto">
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-2">
                            <i class="fa-solid fa-calendar-days text-blue-600 mr-2 lg:mr-3"></i>
                            Sistema de Previsibilidade
                        </h1>
                        <p class="text-sm lg:text-base text-gray-600 dark:text-gray-300">Gerencie seus eventos importantes e mantenha tudo organizado</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2 lg:gap-3 w-full lg:w-auto">
                        <a href="{{ route('events.calendar') }}" class="inline-flex items-center justify-center px-3 lg:px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl text-sm lg:text-base">
                            <i class="fa-solid fa-calendar-week mr-2"></i>
                            Calendário
                        </a>
                        <a href="{{ route('events.create') }}" class="inline-flex items-center justify-center px-3 lg:px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl text-sm lg:text-base">
                            <i class="fa-solid fa-plus mr-2"></i>
                            Novo Evento
                        </a>
                    </div>
                </div>

                <!-- Cards de estatísticas -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-6 mb-8">
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 lg:p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <div class="p-2 lg:p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                <i class="fa-solid fa-calendar text-blue-600 dark:text-blue-400 text-lg lg:text-xl"></i>
                            </div>
                            <div class="ml-3 lg:ml-4">
                                <p class="text-xs lg:text-sm font-medium text-gray-600 dark:text-gray-400">Total de Eventos</p>
                                <p class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">{{ $events->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 lg:p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <div class="p-2 lg:p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                                <i class="fa-solid fa-clock text-green-600 dark:text-green-400 text-lg lg:text-xl"></i>
                            </div>
                            <div class="ml-3 lg:ml-4">
                                <p class="text-xs lg:text-sm font-medium text-gray-600 dark:text-gray-400">Próximos Eventos</p>
                                <p class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">{{ $upcomingOccurrences->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 lg:p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <div class="p-2 lg:p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                                <i class="fa-solid fa-users text-yellow-600 dark:text-yellow-400 text-lg lg:text-xl"></i>
                            </div>
                            <div class="ml-3 lg:ml-4">
                                <p class="text-xs lg:text-sm font-medium text-gray-600 dark:text-gray-400">Pessoas Vinculadas</p>
                                <p class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">{{ $events->flatMap->predictabilityPeople->unique('id')->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 lg:p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <div class="p-2 lg:p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                                <i class="fa-solid fa-chart-line text-purple-600 dark:text-purple-400 text-lg lg:text-xl"></i>
                            </div>
                            <div class="ml-3 lg:ml-4">
                                <p class="text-xs lg:text-sm font-medium text-gray-600 dark:text-gray-400">Tipos de Eventos</p>
                                <p class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">{{ $events->groupBy('type')->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg mb-6 flex items-center">
                    <i class="fa-solid fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filtros e busca avançados -->
            <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-gray-800 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 rounded-2xl shadow-2xl border border-gray-700 mb-10">
                <div class="p-6 lg:p-8">
                    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-center">
                        <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
                            <div>
                                <label for="event-type-filter" class="block text-base font-semibold text-gray-200 mb-3">Tipo de Evento</label>
                                <select id="event-type-filter" class="w-full border-none rounded-xl px-4 py-3 bg-gray-700 text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent text-base shadow-sm transition-all">
                                    <option value="">Todos os tipos</option>
                                    <option value="birthday">Aniversário</option>
                                    <option value="anniversary">Aniversário de Casamento</option>
                                    <option value="holiday">Feriado</option>
                                    <option value="custom">Personalizado</option>
                                </select>
                            </div>
                            <div>
                                <label for="event-search" class="block text-base font-semibold text-gray-200 mb-3">Buscar Evento</label>
                                <div class="relative">
                                    <input type="text" id="event-search" placeholder="Digite o nome do evento..." 
                                           class="w-full border-none rounded-xl pl-12 pr-4 py-3 bg-gray-700 text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent text-base shadow-sm transition-all placeholder-gray-400">
                                    <i class="fa-solid fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-orange-400 text-lg"></i>
                                </div>
                            </div>
                            <div class="sm:col-span-2 lg:col-span-1">
                                <label for="event-status-filter" class="block text-base font-semibold text-gray-200 mb-3">Status</label>
                                <select id="event-status-filter" class="w-full border-none rounded-xl px-4 py-3 bg-gray-700 text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent text-base shadow-sm transition-all">
                                    <option value="">Todos</option>
                                    <option value="upcoming">Próximos</option>
                                    <option value="past">Passados</option>
                                    <option value="today">Hoje</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex flex-row gap-4 w-full lg:w-auto mt-4 lg:mt-0 justify-center">
                            <button id="clear-filters" class="flex items-center justify-center w-40 px-4 py-3 text-orange-400 hover:text-white font-semibold text-base rounded-xl border border-orange-400 hover:bg-orange-500 transition-all duration-200 shadow-sm">
                                <i class="fa-solid fa-times mr-2"></i> Limpar
                            </button>
                            <form method="POST" action="{{ route('events.force-generate-occurrences') }}" class="inline w-40">
                                @csrf
                                <button type="submit" class="flex items-center justify-center w-full px-4 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl transition-all duration-200 text-base shadow-lg" 
                                        onclick="return confirm('Deseja realmente regenerar todas as ocorrências dos eventos ativos?')">
                                    <i class="fa-solid fa-sync-alt mr-2"></i> Regenerar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Próximos Eventos -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-0 mb-6">
                    <h2 class="text-xl lg:text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                        <i class="fa-solid fa-bolt text-yellow-500 mr-2 lg:mr-3"></i>
                        Próximos Eventos
                    </h2>
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $upcomingOccurrences->count() }} eventos próximos</span>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6" id="upcoming-events-list">
                    @forelse($upcomingOccurrences as $occurrence)
                        <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-4 lg:p-6 hover:shadow-xl transition-all duration-300 event-card"
                             data-type="{{ $occurrence->event->type }}"
                             data-title="{{ strtolower($occurrence->event->title) }}"
                             data-date="{{ $occurrence->occurrence_date }}">
                            
                            <!-- Header do card -->
                            <div class="flex items-center justify-between mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium" 
                                      style="background-color: {{ $occurrence->event->color }}20; color: {{ $occurrence->event->color }};">
                                    <i class="fa-solid fa-calendar-days mr-1"></i>
                                    {{ ucfirst($occurrence->event->type) }}
                                </span>
                                @if(\Carbon\Carbon::parse($occurrence->occurrence_date)->isToday())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 animate-pulse">
                                        <i class="fa-solid fa-fire mr-1"></i>Hoje
                                    </span>
                                @elseif(\Carbon\Carbon::parse($occurrence->occurrence_date)->isTomorrow())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                                        <i class="fa-solid fa-clock mr-1"></i>Amanhã
                                    </span>
                                @endif
                            </div>

                            <!-- Conteúdo do card -->
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">{{ $occurrence->event->title }}</h3>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                    <i class="fa-solid fa-calendar-day mr-2 text-blue-500"></i>
                                    {{ $occurrence->formatted_date }}
                                    @if($occurrence->formatted_time)
                                        às {{ $occurrence->formatted_time }}
                                    @endif
                                </div>
                                
                                @if($occurrence->event->location)
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                        <i class="fa-solid fa-map-marker-alt mr-2 text-green-500"></i>
                                        {{ $occurrence->event->location }}
                                    </div>
                                @endif
                            </div>

                            <!-- Pessoas vinculadas -->
                            @if($occurrence->event->predictabilityPeople && $occurrence->event->predictabilityPeople->count())
                                <div class="mb-4">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Pessoas:</p>
                                    <div class="flex -space-x-2">
                                        @foreach($occurrence->event->predictabilityPeople->take(5) as $person)
                                            <a href="{{ route('previsibilidade.show', $person->id) }}" 
                                               title="{{ $person->name }} ({{ ucfirst($person->category) }})"
                                               class="inline-block">
                                                <img src="{{ $person->photo ? asset('storage/' . $person->photo) : asset('images/user-default.png') }}" 
                                                     class="w-8 h-8 rounded-full border-2 border-white dark:border-gray-800 shadow" 
                                                     alt="{{ $person->name }}">
                                            </a>
                                        @endforeach
                                        @if($occurrence->event->predictabilityPeople->count() > 5)
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 border-2 border-white dark:border-gray-800 text-xs font-medium text-gray-600 dark:text-gray-300">
                                                +{{ $occurrence->event->predictabilityPeople->count() - 5 }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Ações -->
                            <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-gray-700">
                                <button class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium text-sm flex items-center show-event-modal" 
                                        data-occur-id="{{ $occurrence->id }}">
                                    <i class="fa-solid fa-eye mr-1"></i>
                                    Detalhes
                                </button>
                                <form method="POST" action="{{ route('event-occurrences.status', $occurrence) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="status" value="completed" 
                                            class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 font-medium text-sm flex items-center">
                                        <i class="fa-solid fa-check mr-1"></i>
                                        Concluir
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <div class="text-gray-400 dark:text-gray-500 mb-4">
                                <i class="fa-solid fa-calendar-times text-6xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Nenhum evento próximo</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">Crie seu primeiro evento para começar a organizar sua agenda</p>
                            <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-200">
                                <i class="fa-solid fa-plus mr-2"></i>
                                Criar Evento
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Todos os Eventos -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-0 mb-6">
                    <h2 class="text-xl lg:text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                        <i class="fa-solid fa-list text-gray-600 mr-2 lg:mr-3"></i>
                        Todos os Eventos
                    </h2>
                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $events->count() }} eventos cadastrados</span>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6" id="all-events-list">
                    @php
                        $upcomingEventIds = $upcomingOccurrences->pluck('event.id')->unique();
                    @endphp
                    @forelse($events->whereNotIn('id', $upcomingEventIds) as $event)
                        <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-4 lg:p-6 hover:shadow-xl transition-all duration-300 event-card"
                             data-type="{{ $event->type }}"
                             data-title="{{ strtolower($event->title) }}">
                            
                            <!-- Header do card -->
                            <div class="flex items-center justify-between mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium" 
                                      style="background-color: {{ $event->color }}20; color: {{ $event->color }};">
                                    <i class="fa-solid fa-calendar-days mr-1"></i>
                                    {{ ucfirst($event->type) }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $event->recurrence_type }}
                                </span>
                            </div>

                            <!-- Conteúdo do card -->
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">{{ $event->title }}</h3>
                            
                            @if($event->description)
                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">{{ $event->description }}</p>
                            @endif

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                    <i class="fa-solid fa-calendar-day mr-2 text-blue-500"></i>
                                    Início: {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }}
                                </div>
                                
                                @if($event->location)
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                        <i class="fa-solid fa-map-marker-alt mr-2 text-green-500"></i>
                                        {{ $event->location }}
                                    </div>
                                @endif
                            </div>

                            <!-- Pessoas vinculadas -->
                            @if($event->predictabilityPeople && $event->predictabilityPeople->count())
                                <div class="mb-4">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Pessoas:</p>
                                    <div class="flex -space-x-2">
                                        @foreach($event->predictabilityPeople->take(5) as $person)
                                            <a href="{{ route('previsibilidade.show', $person->id) }}" 
                                               title="{{ $person->name }} ({{ ucfirst($person->category) }})"
                                               class="inline-block">
                                                <img src="{{ $person->photo ? asset('storage/' . $person->photo) : asset('images/user-default.png') }}" 
                                                     class="w-8 h-8 rounded-full border-2 border-white dark:border-gray-800 shadow" 
                                                     alt="{{ $person->name }}">
                                            </a>
                                        @endforeach
                                        @if($event->predictabilityPeople->count() > 5)
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 border-2 border-white dark:border-gray-800 text-xs font-medium text-gray-600 dark:text-gray-300">
                                                +{{ $event->predictabilityPeople->count() - 5 }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Ações -->
                            <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('events.show', $event) }}" 
                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium text-sm flex items-center">
                                    <i class="fa-solid fa-eye mr-1"></i>
                                    Ver
                                </a>
                                <a href="{{ route('events.edit', $event) }}" 
                                   class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 font-medium text-sm flex items-center">
                                    <i class="fa-solid fa-edit mr-1"></i>
                                    Editar
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <div class="text-gray-400 dark:text-gray-500 mb-4">
                                <i class="fa-solid fa-calendar-plus text-6xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Nenhum evento cadastrado</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">Comece criando seu primeiro evento</p>
                            <a href="{{ route('events.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-200">
                                <i class="fa-solid fa-plus mr-2"></i>
                                Criar Evento
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Detalhes do Evento -->
    <div id="event-modal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 relative animate-fade-in-up">
            <button id="close-event-modal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-2xl">&times;</button>
            <div id="event-modal-content"></div>
        </div>
    </div>

    <script>
        // Filtros
        const typeFilter = document.getElementById('event-type-filter');
        const searchFilter = document.getElementById('event-search');
        const statusFilter = document.getElementById('event-status-filter');
        const clearFiltersBtn = document.getElementById('clear-filters');

        function filterEvents() {
            const type = typeFilter.value.toLowerCase();
            const search = searchFilter.value.toLowerCase();
            const status = statusFilter.value;
            const today = new Date().toISOString().split('T')[0];

            document.querySelectorAll('.event-card').forEach(card => {
                const cardType = card.dataset.type;
                const cardTitle = card.dataset.title;
                const cardDate = card.dataset.date;
                
                let show = true;

                // Filtro por tipo
                if (type && cardType !== type) show = false;

                // Filtro por busca
                if (search && !cardTitle.includes(search)) show = false;

                // Filtro por status
                if (status) {
                    if (status === 'upcoming' && cardDate && cardDate < today) show = false;
                    if (status === 'past' && cardDate && cardDate >= today) show = false;
                    if (status === 'today' && cardDate !== today) show = false;
                }

                card.style.display = show ? 'block' : 'none';
            });
        }

        typeFilter.addEventListener('change', filterEvents);
        searchFilter.addEventListener('input', filterEvents);
        statusFilter.addEventListener('change', filterEvents);

        clearFiltersBtn.addEventListener('click', () => {
            typeFilter.value = '';
            searchFilter.value = '';
            statusFilter.value = '';
            filterEvents();
        });

        // Modal de detalhes
        document.querySelectorAll('.show-event-modal').forEach(btn => {
            btn.addEventListener('click', function() {
                const occurId = this.dataset.occurId;
                // Aqui você pode implementar a lógica para carregar os detalhes do evento
                document.getElementById('event-modal').classList.remove('hidden');
            });
        });

        document.getElementById('close-event-modal').addEventListener('click', () => {
            document.getElementById('event-modal').classList.add('hidden');
        });

        // Fechar modal ao clicar fora
        document.getElementById('event-modal').addEventListener('click', (e) => {
            if (e.target === e.currentTarget) {
                e.target.classList.add('hidden');
            }
        });
    </script>

    <style>
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