@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 max-w-lg">
    <h1 class="text-2xl font-bold mb-6">Nova Receita Fixa</h1>
    <form action="{{ route('finance.fixed-incomes.store') }}" method="POST" class="bg-gray-800 rounded shadow p-6">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-white">Descrição</label>
            <input type="text" name="description" class="w-full rounded px-3 py-2 bg-gray-900 text-gray-900" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-white">Valor</label>
            <input type="number" step="0.01" name="amount" class="w-full rounded px-3 py-2 bg-gray-900 text-gray-900" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-white">Categoria</label>
            <div class="flex gap-2 items-center">
                <select name="category_id" id="category_id" class="w-full rounded px-3 py-2 bg-gray-900 text-gray-900" required>
                    <option value="">Selecione</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                <button type="button" onclick="document.getElementById('modalNovaCategoria').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm font-semibold shadow transition">+ Nova</button>
            </div>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-white">Conta</label>
            <select name="account_id" class="w-full rounded px-3 py-2 bg-gray-900 text-gray-900" required>
                <option value="">Selecione</option>
                @foreach($contas as $conta)
                    <option value="{{ $conta->id }}">{{ $conta->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-white">Frequência</label>
            <select name="recurring_frequency" class="w-full rounded px-3 py-2 bg-gray-900 text-gray-900" required>
                <option value="monthly">Mensal</option>
                <option value="weekly">Semanal</option>
                <option value="yearly">Anual</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-white">Data inicial (primeiro recebimento)</label>
            <input type="date" name="date" class="w-full rounded px-3 py-2 bg-gray-900 text-gray-900" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-white">Data final (opcional)</label>
            <input type="date" name="recurring_end_date" class="w-full rounded px-3 py-2 bg-gray-900 text-gray-900">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-white">Observação</label>
            <textarea name="notes" class="w-full rounded px-3 py-2 bg-gray-900 text-gray-900"></textarea>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('finance.fixed-incomes.index') }}" class="mr-4 text-gray-400 hover:underline">Cancelar</a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">Salvar</button>
        </div>
    </form>
    <!-- Modal Nova Categoria -->
    <div id="modalNovaCategoria" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md relative">
            <button type="button" onclick="document.getElementById('modalNovaCategoria').classList.add('hidden')" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
            <h2 class="text-xl font-bold mb-4 text-gray-900">Nova Categoria</h2>
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf
                <input type="hidden" name="type" value="income">
                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-gray-700">Nome</label>
                    <input type="text" name="name" class="w-full rounded px-3 py-2 border border-gray-300 text-gray-900" required>
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-gray-700">Cor (opcional)</label>
                    <input type="color" name="color" class="w-12 h-8 p-0 border-0 bg-transparent">
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('modalNovaCategoria').classList.add('hidden')" class="px-4 py-2 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">Cancelar</button>
                    <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 font-semibold">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 