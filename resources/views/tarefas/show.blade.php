@extends('layouts.app')

@section('content')
    <div class="w-full px-0">
        <h2 class="text-2xl font-bold mb-6 text-center">Detalhes da Tarefa</h2>
        <div class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl p-8 space-y-6">
            <div>
                <strong>Título:</strong> {{ $task->title }}
            </div>
            <div>
                <strong>Descrição:</strong> {{ $task->description }}
            </div>
            <div>
                <strong>Status:</strong> {{ $task->status }}
            </div>
            <div>
                <strong>Prazo:</strong> {{ $task->due_date ? $task->due_date->format('d/m/Y') : 'Sem prazo' }}
            </div>
        </div>
    </div>
@endsection 