@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Editar Despesa Fixa</h1>
    <form action="{{ route('finance.fixed-expenses.update', $despesa->id) }}" method="POST" class="bg-gray-800 rounded shadow p-6">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Descrição</label>
            <input type="text" name="description" value="{{ $despesa->description }}" class="w-full rounded px-3 py-2 bg-gray-900 text-white" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Valor</label>
            <input type="number" step="0.01" name="amount" value="{{ $despesa->amount }}" class="w-full rounded px-3 py-2 bg-gray-900 text-white" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Categoria</label>
            <select name="category_id" class="w-full rounded px-3 py-2 bg-gray-900 text-white" required>
                <option value="">Selecione</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" @if($despesa->category_id == $cat->id) selected @endif>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Conta</label>
            <select name="account_id" class="w-full rounded px-3 py-2 bg-gray-900 text-white" required>
                <option value="">Selecione</option>
                @foreach($contas as $conta)
                    <option value="{{ $conta->id }}" @if($despesa->account_id == $conta->id) selected @endif>{{ $conta->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Frequência</label>
            <select name="recurring_frequency" class="w-full rounded px-3 py-2 bg-gray-900 text-white" required>
                <option value="monthly" @if($despesa->recurring_frequency == 'monthly') selected @endif>Mensal</option>
                <option value="weekly" @if($despesa->recurring_frequency == 'weekly') selected @endif>Semanal</option>
                <option value="yearly" @if($despesa->recurring_frequency == 'yearly') selected @endif>Anual</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Data inicial (primeiro pagamento)</label>
            <input type="date" name="date" value="{{ $despesa->date->format('Y-m-d') }}" class="w-full rounded px-3 py-2 bg-gray-900 text-white" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Data final (opcional)</label>
            <input type="date" name="recurring_end_date" value="{{ $despesa->recurring_end_date ? $despesa->recurring_end_date->format('Y-m-d') : '' }}" class="w-full rounded px-3 py-2 bg-gray-900 text-white">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Observação</label>
            <textarea name="notes" class="w-full rounded px-3 py-2 bg-gray-900 text-white">{{ $despesa->notes }}</textarea>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('finance.fixed-expenses.index') }}" class="mr-4 text-gray-400 hover:underline">Cancelar</a>
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded">Salvar</button>
        </div>
    </form>
</div>
@endsection 