@extends('layouts.app')

@section('content')
    <div class="py-4 md:py-6 px-2 md:px-4 bg-gray-900 w-full max-w-full overflow-x-hidden">
        <div class="container mx-auto w-full max-w-full overflow-x-hidden">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-8 w-full max-w-full overflow-x-hidden">
                <!-- Card Finanças -->
                <a href="{{ route('dashboard') }}" class="group bg-white dark:bg-gray-900 rounded-xl shadow p-4 md:p-8 flex flex-col items-center justify-center hover:scale-105 transition-transform duration-200 text-gray-900 dark:text-white w-full max-w-full">
                    <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-500 text-white shadow mb-4">
                        <i class="fa-solid fa-coins fa-2x"></i>
                    </span>
                    <h3 class="text-xl font-extrabold mb-2">Finanças</h3>
                    <p class="text-gray-500 text-center">Controle financeiro pessoal, contas, transações, dívidas e metas.</p>
                </a>
                <!-- Card Projetos Profissionais -->
                <a href="{{ route('projetos.index') }}" class="group bg-white dark:bg-gray-900 rounded-xl shadow p-4 md:p-8 flex flex-col items-center justify-center hover:scale-105 transition-transform duration-200 text-gray-900 dark:text-white w-full max-w-full">
                    <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-purple-500 text-white shadow mb-4">
                        <i class="fa-solid fa-briefcase fa-2x"></i>
                    </span>
                    <h3 class="text-xl font-extrabold mb-2">Projetos Profissionais</h3>
                    <p class="text-gray-500 text-center">Gestão de projetos, tarefas, clientes, horas e faturamento.</p>
                </a>
                <!-- Card Tarefas Domésticas -->
                <a href="{{ route('household-tasks.dashboard') }}" class="group bg-white dark:bg-gray-900 rounded-xl shadow p-4 md:p-8 flex flex-col items-center justify-center hover:scale-105 transition-transform duration-200 text-gray-900 dark:text-white w-full max-w-full">
                    <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-orange-500 text-white shadow mb-4">
                        <i class="fa-solid fa-house-chimney fa-2x"></i>
                    </span>
                    <h3 class="text-xl font-extrabold mb-2">Tarefas Domésticas</h3>
                    <p class="text-gray-500 text-center">Organização de tarefas e rotinas da casa.</p>
                </a>
                <!-- Card Próximos Eventos -->
                <div class="group bg-white dark:bg-gray-900 rounded-xl shadow p-4 md:p-8 flex flex-col items-center justify-center min-h-[320px] text-gray-900 dark:text-white w-full max-w-full">
                    <span class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-500 text-white shadow mb-4">
                        <i class="fa-solid fa-calendar-days fa-2x"></i>
                    </span>
                    <h3 class="text-xl font-extrabold mb-2">Próximos Eventos</h3>
                    @php
                        $upcomingOccurrences = \App\Models\EventOccurrence::whereHas('event', function($query) { $query->where('user_id', Auth::id()); })
                            ->where('occurrence_date', '>=', now()->format('Y-m-d'))
                            ->where('status', 'pending')
                            ->with(['event.predictabilityPeople'])
                            ->orderBy('occurrence_date')
                            ->limit(3)
                            ->get();
                    @endphp
                    @if($upcomingOccurrences->count())
                        <ul class="w-full space-y-3 mb-4">
                            @foreach($upcomingOccurrences as $occurrence)
                                <li class="flex flex-col items-start bg-gray-100 dark:bg-gray-800 rounded-xl p-3 w-full">
                                    <div class="flex items-center w-full justify-between">
                                        <span class="font-semibold">{{ $occurrence->event->title }}</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500 text-white ml-2">{{ ucfirst($occurrence->event->type) }}</span>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ \Carbon\Carbon::parse($occurrence->occurrence_date)->format('d/m/Y') }}
                                        @if($occurrence->formatted_time)
                                            às {{ $occurrence->formatted_time }}
                                        @endif
                                    </div>
                                    @if($occurrence->event->predictabilityPeople && $occurrence->event->predictabilityPeople->count())
                                        <div class="flex mt-2 -space-x-2">
                                            @foreach($occurrence->event->predictabilityPeople as $person)
                                                <a href="{{ route('previsibilidade.show', $person->id) }}" title="{{ $person->name }} ({{ ucfirst($person->category) }})">
                                                    <img src="{{ $person->photo ? asset('storage/' . $person->photo) : asset('images/user-default.png') }}" class="w-6 h-6 rounded-full border-2 border-gray-300 shadow" alt="{{ $person->name }}">
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('events.index') }}" class="w-full text-center bg-gray-200 hover:bg-blue-500 text-gray-900 hover:text-white font-bold py-2 px-4 rounded mb-2 transition-colors">Ver todos</a>
                    @else
                        <p class="text-gray-500 text-center py-8">Nenhum evento próximo.</p>
                    @endif
                    <a href="{{ route('events.create') }}" class="w-full text-center bg-blue-500 hover:bg-gray-200 text-white hover:text-gray-900 font-bold py-2 px-4 rounded transition-colors">Novo Evento</a>
                </div>
            </div>
        </div>
    </div>
@endsection 