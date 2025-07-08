@extends('layouts.app')

@section('content')
    <div class="py-6 max-w-xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-center">Editar Tarefa</h2>
        <form action="{{ route('tarefas.update', $task->id) }}" method="POST" class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl p-8 space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label class="block font-semibold mb-1">Título da Tarefa</label>
                <input type="text" name="title" class="w-full border rounded px-3 py-2" value="{{ old('title', $task->title) }}" required>
            </div>
            <div>
                <label class="block font-semibold mb-1">Descrição</label>
                <textarea name="description" class="w-full border rounded px-3 py-2" rows="3">{{ old('description', $task->description) }}</textarea>
            </div>
            <div>
                <label class="block font-semibold mb-1">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2" required>
                    <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>A Fazer</option>
                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>Em Andamento</option>
                    <option value="paused" {{ $task->status == 'paused' ? 'selected' : '' }}>Pausado</option>
                    <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Concluído</option>
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-lg shadow-md transition-all duration-200">Salvar Alterações</button>
            </div>
        </form>
    </div>
@endsection 