@extends('layouts.app')

@include('components.status-dot-style')

@section('content')
<div class="py-8 w-full max-w-full">
    <div class="w-full px-0">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4 sticky top-0 z-30 bg-white/90 dark:bg-gray-900/90 pt-2 pb-4 sm:pb-0">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                <i class="fa-solid fa-briefcase text-blue-500"></i>
                Tarefas Profissionais
            </h2>
            <a href="{{ route('tarefas.create') }}" class="w-full sm:w-auto px-4 py-3 sm:py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700 font-bold transition text-lg sm:text-base text-center">Nova Tarefa</a>
        </div>
        @if($tarefas->count())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 w-full max-w-full">
                @foreach($tarefas as $tarefa)
                    @php
                        $isLate = $tarefa->due_date && $tarefa->status !== 'concluída' && $tarefa->due_date->isPast();
                    @endphp
                    <div class="rounded-2xl shadow-xl bg-gradient-to-br from-blue-100 via-white to-blue-50 dark:from-gray-800 dark:via-gray-900 dark:to-gray-800 border border-blue-200 dark:border-gray-700 p-4 sm:p-6 flex flex-col justify-between relative">
                        <div class="flex items-center gap-3 mb-2">
                            @if($tarefa->status === 'concluída')
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-300"><i class="fa-solid fa-check"></i></span>
                            @elseif($tarefa->due_date && $tarefa->due_date < now() && $tarefa->status !== 'concluída')
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-300"><i class="fa-solid fa-exclamation-triangle"></i></span>
                            @else
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 dark:bg-yellow-900 dark:text-yellow-300"><i class="fa-solid fa-hourglass-half"></i></span>
                            @endif
                            <div class="flex-1">
                                <div class="font-bold text-base sm:text-lg text-gray-900 dark:text-gray-100">{{ $tarefa->title }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-300 mt-1">{{ $tarefa->description }}</div>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mt-4 gap-2 sm:gap-0">
                            <div class="text-xs font-semibold">
                                Prazo:
                                @if($tarefa->due_date)
                                    <span class="ml-1 px-2 py-0.5 rounded-full {{ $isLate ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' : ($tarefa->due_date->isToday() ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300' : 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300') }}">
                                        {{ $tarefa->due_date->format('d/m/Y') }}
                                        @if($isLate)
                                            (Atrasada)
                                        @elseif($tarefa->due_date->isToday())
                                            (Vence hoje)
                                        @endif
                                    </span>
                                @else
                                    <span class="ml-1 text-gray-400">Sem prazo</span>
                                @endif
                            </div>
                            <div class="flex gap-2 flex-wrap mt-2 sm:mt-0">
                                <span class="status-dot status-{{ $tarefa->status }}"></span>
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold capitalize {{ $tarefa->status === 'concluída' ? 'bg-green-200 text-green-800 dark:bg-green-900 dark:text-green-200' : ($isLate ? 'bg-red-200 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-yellow-200 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200') }}">
                                    {{ $tarefa->status }}
                                </span>
                                <a href="{{ route('tarefas.show', $tarefa) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-lg shadow transition text-sm"><i class="fa-solid fa-eye mr-1"></i> Detalhes</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center text-gray-400 py-12 text-lg font-semibold">Nenhuma tarefa profissional cadastrada.</div>
        @endif
    </div>
</div>
@endsection