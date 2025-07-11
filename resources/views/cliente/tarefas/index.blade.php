@extends('layouts.client')

@section('content')
    <h2 class="text-2xl font-bold text-blue-200 mb-6">Minhas Tarefas</h2>
    @if($tarefas->isEmpty())
        <p class="text-gray-400">Nenhuma tarefa encontrada.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($tarefas as $tarefa)
                <div class="bg-[#23232b] rounded-xl p-6 shadow border border-gray-800 mb-2">
                    <h3 class="text-lg font-semibold text-gray-100 mb-1">{{ $tarefa->title }}</h3>
                    <p class="text-gray-400 text-sm mb-1">Projeto: {{ $tarefa->project->name ?? '-' }}</p>
                    <span class="text-xs px-2 py-1 rounded-full {{ $tarefa->status == 'concluída' ? 'bg-green-700 text-green-200' : 'bg-yellow-700 text-yellow-200' }}">{{ ucfirst($tarefa->status) }}</span>
                </div>
            @endforeach
        </div>
    @endif
@endsection 