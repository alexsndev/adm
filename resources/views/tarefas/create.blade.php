@extends('layouts.app')

@section('content')
    <div class="py-6 max-w-xl mx-auto">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif
        <h2 class="text-2xl font-bold mb-6 text-center">Nova Tarefa Profissional</h2>
        <form action="{{ route('tarefas.store') }}" method="POST" class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl p-8 space-y-6">
            @csrf
            <div>
                <label class="block font-semibold mb-1">Projeto</label>
                <select name="project_id" class="w-full border rounded px-3 py-2" required {{ isset($projectId) && $projectId ? 'readonly disabled' : '' }}>
                    <option value="">Selecione o projeto</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ (old('project_id', $projectId ?? '') == $project->id) ? 'selected' : '' }}>{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-semibold mb-1">Título da Tarefa</label>
                <input type="text" name="title" class="w-full border rounded px-3 py-2" value="{{ old('title') }}" required>
            </div>
            <div>
                <label class="block font-semibold mb-1">Descrição</label>
                <textarea name="description" class="w-full border rounded px-3 py-2" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-lg shadow-md transition-all duration-200">Criar Tarefa</button>
            </div>
        </form>
    </div>
@endsection 