@extends('layouts.app')

@section('content')
<div class="py-8 max-w-2xl mx-auto">
    <h2 class="text-3xl font-bold mb-6 text-center">Editar Projeto Profissional</h2>
    <form action="{{ route('projetos.update', $project) }}" method="POST" class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl p-8 space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label class="block font-semibold mb-1">Cliente</label>
            <select name="client_id" class="w-full border rounded px-3 py-2" required>
                <option value="">Selecione o cliente</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ $project->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block font-semibold mb-1">Nome do Projeto</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ old('name', $project->name) }}" required>
        </div>
        <div>
            <label class="block font-semibold mb-1">Descrição</label>
            <textarea name="description" class="w-full border rounded px-3 py-2" rows="3">{{ old('description', $project->description) }}</textarea>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-1">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2" required>
                    <option value="planning" {{ $project->status == 'planning' ? 'selected' : '' }}>Planejamento</option>
                    <option value="in_progress" {{ $project->status == 'in_progress' ? 'selected' : '' }}>Em andamento</option>
                    <option value="on_hold" {{ $project->status == 'on_hold' ? 'selected' : '' }}>Em espera</option>
                    <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>Concluído</option>
                    <option value="cancelled" {{ $project->status == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>
            <div>
                <label class="block font-semibold mb-1">Prioridade</label>
                <select name="priority" class="w-full border rounded px-3 py-2" required>
                    <option value="low" {{ $project->priority == 'low' ? 'selected' : '' }}>Baixa</option>
                    <option value="medium" {{ $project->priority == 'medium' ? 'selected' : '' }}>Média</option>
                    <option value="high" {{ $project->priority == 'high' ? 'selected' : '' }}>Alta</option>
                    <option value="urgent" {{ $project->priority == 'urgent' ? 'selected' : '' }}>Urgente</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block font-semibold mb-1">Data de Início</label>
                <input type="date" name="start_date" class="w-full border rounded px-3 py-2" value="{{ old('start_date', $project->start_date ? $project->start_date->format('Y-m-d') : '') }}">
            </div>
            <div>
                <label class="block font-semibold mb-1">Data de Entrega</label>
                <input type="date" name="due_date" class="w-full border rounded px-3 py-2" value="{{ old('due_date', $project->due_date ? $project->due_date->format('Y-m-d') : '') }}">
            </div>
            <div>
                <label class="block font-semibold mb-1">Orçamento (R$)</label>
                <input type="number" name="budget" step="0.01" min="0" class="w-full border rounded px-3 py-2" value="{{ old('budget', $project->budget) }}">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-1">Taxa por Hora (R$)</label>
                <input type="number" name="hourly_rate" step="0.01" min="0" class="w-full border rounded px-3 py-2" value="{{ old('hourly_rate', $project->hourly_rate) }}">
            </div>
            <div>
                <label class="block font-semibold mb-1">Horas Estimadas</label>
                <input type="number" name="estimated_hours" min="0" class="w-full border rounded px-3 py-2" value="{{ old('estimated_hours', $project->estimated_hours) }}">
            </div>
        </div>
        <div>
            <label class="block font-semibold mb-1">Notas</label>
            <textarea name="notes" class="w-full border rounded px-3 py-2" rows="2">{{ old('notes', $project->notes) }}</textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-lg shadow-md transition-all duration-200">Salvar Alterações</button>
        </div>
    </form>
    </div>
@endsection 