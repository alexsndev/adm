@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Receitas Fixas</h1>
        <a href="{{ route('finance.fixed-incomes.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Nova Receita Fixa</a>
    </div>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    <div class="bg-gray-800 rounded shadow p-4">
        <table class="min-w-full text-left">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Categoria</th>
                    <th>Conta</th>
                    <th>Frequência</th>
                    <th>Dia</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($receitasFixas as $receita)
                    <tr class="border-b border-gray-700 @if($receita->date->isToday()) bg-green-900/30 @endif">
                        <td>{{ $receita->description }}</td>
                        <td>R$ {{ number_format($receita->amount, 2, ',', '.') }}</td>
                        <td>{{ $receita->category->name ?? '-' }}</td>
                        <td>{{ $receita->account->name ?? '-' }}</td>
                        <td>{{ ucfirst($receita->recurring_frequency) }}</td>
                        <td>{{ \Carbon\Carbon::parse($receita->date)->format('d') }}</td>
                        <td class="flex gap-2">
                            <a href="{{ route('finance.fixed-incomes.edit', $receita->id) }}" class="text-blue-500 hover:underline">Editar</a>
                            <form action="{{ route('finance.fixed-incomes.destroy', $receita->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Excluir</button>
                            </form>
                            @if($receita->date->isToday())
                                <form action="{{ route('finance.fixed-incomes.receive', $receita->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded">Receber</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-gray-400">Nenhuma receita fixa cadastrada.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection 