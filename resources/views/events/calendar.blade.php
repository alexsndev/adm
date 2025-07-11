@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 py-6 w-full">
    <div class="w-full px-0 w-full" style="max-width:100%;">
        <!-- Header -->
        <div class="mb-8 w-full flex flex-col items-center justify-center text-center">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2 w-full">Calendário de Eventos</h1>
            <p class="text-gray-600 dark:text-gray-300 text-base sm:text-lg w-full">Visualize todos os seus eventos em um calendário interativo</p>
        </div>
        <!-- Navegação do Calendário -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 mb-6 w-full">
            <div class="p-4 sm:p-6 flex flex-col sm:flex-row justify-between items-center gap-4 w-full">
                <div class="flex items-center gap-2">
                    <a href="{{ route('events.calendar', ['year' => $year - 1, 'month' => $month]) }}" class="p-2 text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors"><i class="fa-solid fa-chevron-left text-xl"></i></a>
                    <a href="{{ route('events.calendar', ['year' => $year, 'month' => $month - 1]) }}" class="p-2 text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors"><i class="fa-solid fa-chevron-left text-lg"></i></a>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white w-full text-center">{{ \Carbon\Carbon::createFromDate($year, $month, 1)->format('F Y') }}</h2>
                <div class="flex items-center gap-2">
                    <a href="{{ route('events.calendar', ['year' => $year, 'month' => $month + 1]) }}" class="p-2 text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors"><i class="fa-solid fa-chevron-right text-lg"></i></a>
                    <a href="{{ route('events.calendar', ['year' => $year + 1, 'month' => $month]) }}" class="p-2 text-gray-600 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors"><i class="fa-solid fa-chevron-right text-xl"></i></a>
                </div>
            </div>
        </div>
        <!-- Filtros e busca -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 mb-6 w-full overflow-x-auto">
            <div class="p-4 sm:p-6 flex flex-col lg:flex-row gap-4 items-center w-full">
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 w-full">
                    <div>
                        <label for="event-type-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipo de Evento</label>
                        <select id="event-type-filter" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Todos os tipos</option>
                            <option value="birthday">🎂 Aniversário</option>
                            <option value="anniversary">💖 Aniversário de Casamento</option>
                            <option value="holiday">🏖️ Feriado</option>
                            <option value="custom">📅 Personalizado</option>
                        </select>
                    </div>
                    <div>
                        <label for="event-search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buscar Evento</label>
                        <div class="relative">
                            <input type="text" id="event-search" placeholder="Digite o nome do evento..." class="w-full border border-gray-300 dark:border-gray-600 rounded-lg pl-10 pr-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                    <div>
                        <label for="event-status-filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                        <select id="event-status-filter" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Todos</option>
                            <option value="upcoming">Próximos</option>
                            <option value="past">Passados</option>
                            <option value="today">Hoje</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-3 w-full lg:w-auto justify-center lg:justify-end">
                    <button id="clear-filters" class="px-4 py-2 text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white font-medium w-full lg:w-auto"><i class="fa-solid fa-times mr-2"></i>Limpar</button>
                    <button id="today-btn" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-200 w-full lg:w-auto"><i class="fa-solid fa-calendar-day mr-2"></i>Hoje</button>
                </div>
            </div>
        </div>
        <!-- Calendário -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden w-full">
            <div class="p-2 sm:p-6">
                <!-- Cabeçalho dos dias da semana -->
                <div class="grid grid-cols-7 gap-1 mb-2 sm:mb-4">
                    <div class="text-center font-semibold text-gray-700 dark:text-gray-300 py-2 sm:py-3">Dom</div>
                    <div class="text-center font-semibold text-gray-700 dark:text-gray-300 py-2 sm:py-3">Seg</div>
                    <div class="text-center font-semibold text-gray-700 dark:text-gray-300 py-2 sm:py-3">Ter</div>
                    <div class="text-center font-semibold text-gray-700 dark:text-gray-300 py-2 sm:py-3">Qua</div>
                    <div class="text-center font-semibold text-gray-700 dark:text-gray-300 py-2 sm:py-3">Qui</div>
                    <div class="text-center font-semibold text-gray-700 dark:text-gray-300 py-2 sm:py-3">Sex</div>
                    <div class="text-center font-semibold text-gray-700 dark:text-gray-300 py-2 sm:py-3">Sáb</div>
                </div>
                <!-- Dias do calendário -->
                <div class="grid grid-cols-7 gap-1" id="calendar-days">
                    @php
                        $firstDay = \Carbon\Carbon::createFromDate($year, $month, 1);
                        $lastDay = $firstDay->copy()->endOfMonth();
                        $startDate = $firstDay->copy()->startOfWeek();
                        $endDate = $lastDay->copy()->endOfWeek();
                        $currentDate = $startDate->copy();
                    @endphp
                    @while($currentDate <= $endDate)
                        @php
                            $isCurrentMonth = $currentDate->month === $month;
                            $isToday = $currentDate->isToday();
                            $dayEvents = $occurrences->get($currentDate->format('Y-m-d'), collect());
                        @endphp
                        <div class="min-h-32 sm:min-h-40 border border-gray-200 dark:border-gray-600 p-1 sm:p-3 {{ $isCurrentMonth ? 'bg-white dark:bg-gray-800' : 'bg-gray-50 dark:bg-gray-900' }} {{ $isToday ? 'ring-2 ring-blue-500 bg-blue-50 dark:bg-blue-900/20' : '' }} calendar-day hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors flex flex-col justify-between" data-date="{{ $currentDate->format('Y-m-d') }}">
                            <div class="flex items-center justify-between mb-1 sm:mb-2">
                                <div class="text-xs sm:text-sm font-medium {{ $isCurrentMonth ? 'text-gray-900 dark:text-white' : 'text-gray-400 dark:text-gray-500' }} {{ $isToday ? 'text-blue-600 dark:text-blue-400 font-bold' : '' }}">{{ $currentDate->day }}</div>
                                @if($dayEvents->count() > 0)
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $dayEvents->count() }} evento{{ $dayEvents->count() > 1 ? 's' : '' }}</div>
                                @endif
                            </div>
                            <div class="space-y-1 flex-1">
                                @foreach($dayEvents as $occurrence)
                                    <div class="text-xs p-1 sm:p-2 rounded cursor-pointer calendar-event hover:shadow-md transition-all duration-200" style="background-color: {{ $occurrence->event->color }}15; border-left: 3px solid {{ $occurrence->event->color }};" title="{{ $occurrence->event->title }} - {{ $occurrence->event->type }}" data-type="{{ $occurrence->event->type }}" data-title="{{ strtolower($occurrence->event->title) }}" data-occur-id="{{ $occurrence->id }}" data-event='@json($occurrence->event)' data-people='@json($occurrence->event->predictabilityPeople)' data-date="{{ $occurrence->occurrence_date }}" data-time="{{ $occurrence->formatted_time }}">
                                        <div class="font-medium truncate" style="color: {{ $occurrence->event->color }};">{{ $occurrence->event->title }}</div>
                                        @if($occurrence->formatted_time)
                                            <div class="text-xs" style="color: {{ $occurrence->event->color }};"><i class="fa-solid fa-clock mr-1"></i>{{ $occurrence->formatted_time }}</div>
                                        @endif
                                        @if($occurrence->event->predictabilityPeople && $occurrence->event->predictabilityPeople->count())
                                            <div class="flex mt-1 -space-x-1">
                                                @foreach($occurrence->event->predictabilityPeople->take(3) as $person)
                                                    <a href="{{ route('previsibilidade.show', $person->id) }}" title="{{ $person->name }} ({{ ucfirst($person->category) }})" class="inline-block">
                                                        <img src="{{ $person->photo ? asset('storage/' . $person->photo) : asset('images/user-default.png') }}" class="w-5 h-5 rounded-full border border-white dark:border-gray-800 shadow-sm" alt="{{ $person->name }}">
                                                    </a>
                                                @endforeach
                                                @if($occurrence->event->predictabilityPeople->count() > 3)
                                                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-gray-200 dark:bg-gray-700 border border-white dark:border-gray-800 text-xs font-medium text-gray-600 dark:text-gray-300">+{{ $occurrence->event->predictabilityPeople->count() - 3 }}</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @php $currentDate->addDay(); @endphp
                    @endwhile
                </div>
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
        const todayBtn = document.getElementById('today-btn');

        function filterEvents() {
            const type = typeFilter.value.toLowerCase();
            const search = searchFilter.value.toLowerCase();
            const status = statusFilter.value;
            const today = new Date().toISOString().split('T')[0];

            document.querySelectorAll('.calendar-event').forEach(ev => {
                const cardType = ev.dataset.type;
                const cardTitle = ev.dataset.title;
                const cardDate = ev.dataset.date;
                
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

                ev.style.display = show ? 'block' : 'none';
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

        todayBtn.addEventListener('click', () => {
            const today = new Date();
            const year = today.getFullYear();
            const month = today.getMonth() + 1;
            window.location.href = `{{ route('events.calendar') }}?year=${year}&month=${month}`;
        });

        // Modal de detalhes
        document.querySelectorAll('.calendar-event').forEach(ev => {
            ev.addEventListener('click', function(e) {
                e.preventDefault();
                const event = JSON.parse(this.dataset.event);
                const people = JSON.parse(this.dataset.people);
                const date = this.dataset.date;
                const time = this.dataset.time;
                
                // Ícone do tipo
                let icon = '<i class="fa-solid fa-calendar-days text-blue-500 mr-2"></i>';
                if(event.type === 'birthday') icon = '<i class="fa-solid fa-cake-candles text-pink-500 mr-2"></i>';
                if(event.type === 'anniversary') icon = '<i class="fa-solid fa-heart text-red-500 mr-2"></i>';
                if(event.type === 'holiday') icon = '<i class="fa-solid fa-umbrella-beach text-yellow-500 mr-2"></i>';
                
                // Badge do tipo
                let badge = `<span class='inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ml-2' style='background-color: ${event.color || '#3B82F6'}20; color: ${event.color || '#3B82F6'};'>${event.type}</span>`;
                
                // Título
                let html = `<div class='flex items-center gap-2 mb-4'>${icon}<span class='text-2xl font-bold text-gray-900 dark:text-white'>${event.title}</span>${badge}</div>`;
                
                // Data e hora
                if(date) {
                    const dateObj = new Date(date);
                    const formattedDate = dateObj.toLocaleDateString('pt-BR');
                    html += `<div class='mb-3 text-gray-700 dark:text-gray-200'><span class='font-semibold'>Data:</span> ${formattedDate}${time ? ' às ' + time : ''}</div>`;
                }
                
                // Local
                if(event.location) html += `<div class='mb-3 text-gray-700 dark:text-gray-200'><span class='font-semibold'>Local:</span> ${event.location}</div>`;
                
                // Descrição
                if(event.description) html += `<div class='mb-3 text-gray-700 dark:text-gray-200'><span class='font-semibold'>Descrição:</span> ${event.description}</div>`;
                
                // Pessoas
                if(people && people.length) {
                    html += `<div class='mb-3'><span class='font-semibold text-gray-700 dark:text-gray-200'>Pessoas:</span> <div class='flex mt-2 -space-x-2'>`;
                    people.forEach(p => {
                        html += `<a href='/previsibilidade/${p.id}' title='${p.name} (${p.category})'><img src='${p.photo ? '/storage/' + p.photo : '/images/user-default.png'}' class='w-10 h-10 rounded-full border-2 border-white dark:border-gray-800 shadow-lg inline transition hover:scale-110' alt='${p.name}'></a>`;
                    });
                    html += `</div></div>`;
                }
                
                document.getElementById('event-modal-content').innerHTML = html;
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

        // Adiciona a lista de sugestões logo após o campo de busca
        const suggestions = document.createElement('ul');
        suggestions.id = 'search-suggestions';
        suggestions.className = 'absolute z-50 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg mt-1 w-full hidden';
        searchFilter.parentNode.appendChild(suggestions);

        let lastResults = [];

        // Função para abrir modal de detalhes do evento
        function openEventModal(event, date) {
            // Ícone do tipo
            let icon = '<i class="fa-solid fa-calendar-days text-blue-500 mr-2"></i>';
            if(event.type === 'birthday') icon = '<i class="fa-solid fa-cake-candles text-pink-500 mr-2"></i>';
            if(event.type === 'anniversary') icon = '<i class="fa-solid fa-heart text-red-500 mr-2"></i>';
            if(event.type === 'holiday') icon = '<i class="fa-solid fa-umbrella-beach text-yellow-500 mr-2"></i>';
            // Badge do tipo
            let badge = `<span class='inline-flex items-center px-3 py-1 rounded-full text-xs font-medium ml-2' style='background-color: ${event.color || '#3B82F6'}20; color: ${event.color || '#3B82F6'};'>${event.type}</span>`;
            // Título
            let html = `<div class='flex items-center gap-2 mb-4'>${icon}<span class='text-2xl font-bold text-gray-900 dark:text-white'>${event.title}</span>${badge}</div>`;
            // Data e hora
            if(date) {
                const dateObj = new Date(date);
                const formattedDate = dateObj.toLocaleDateString('pt-BR');
                html += `<div class='mb-3 text-gray-700 dark:text-gray-200'><span class='font-semibold'>Data:</span> ${formattedDate}</div>`;
            }
            document.getElementById('event-modal-content').innerHTML = html;
            document.getElementById('event-modal').classList.remove('hidden');
        }

        // Função para formatar data
        function formatDate(dateStr) {
            const d = new Date(dateStr);
            if (isNaN(d)) return dateStr;
            return d.toLocaleDateString('pt-BR');
        }

        // Fechar sugestões ao clicar fora
        document.addEventListener('click', function(e) {
            if (!searchFilter.contains(e.target) && !suggestions.contains(e.target)) {
                suggestions.classList.add('hidden');
            }
        });

        searchFilter.addEventListener('input', function() {
            const search = searchFilter.value.trim();
            suggestions.innerHTML = '';
            suggestions.classList.add('hidden');
            if (!search) return;

            fetch(`/events/search?q=${encodeURIComponent(search)}`)
                .then(res => res.json())
                .then(results => {
                    lastResults = results;
                    if (results.length > 0) {
                        results.forEach(ev => {
                            const li = document.createElement('li');
                            let icon = '<i class="fa-solid fa-calendar-days text-blue-500 mr-2"></i>';
                            if(ev.type === 'birthday') icon = '<i class="fa-solid fa-cake-candles text-pink-500 mr-2"></i>';
                            if(ev.type === 'anniversary') icon = '<i class="fa-solid fa-heart text-red-500 mr-2"></i>';
                            if(ev.type === 'holiday') icon = '<i class="fa-solid fa-umbrella-beach text-yellow-500 mr-2"></i>';
                            li.innerHTML = `${icon}<span class='font-semibold'>${ev.title}</span> <span class='ml-2 text-xs text-gray-500'>${formatDate(ev.date)}</span>`;
                            li.className = 'flex items-center gap-2 px-4 py-2 cursor-pointer hover:bg-blue-100 dark:hover:bg-blue-900';
                            li.onclick = () => {
                                openEventModal(ev, ev.date);
                                suggestions.classList.add('hidden');
                            };
                            suggestions.appendChild(li);
                        });
                        suggestions.classList.remove('hidden');
                    }
                });
        });
        // Fechar sugestões ao apagar tudo
        searchFilter.addEventListener('blur', function() {
            setTimeout(() => suggestions.classList.add('hidden'), 200);
        });
    </script>

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