@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Despesas Fixas</h1>
        <a href="{{ route('finance.fixed-expenses.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Nova Despesa Fixa</a>
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
                @forelse($despesasFixas as $despesa)
                    <tr class="border-b border-gray-700 @if($despesa->date->isToday()) bg-red-900/30 @endif">
                        <td>{{ $despesa->description }}</td>
                        <td>R$ {{ number_format($despesa->amount, 2, ',', '.') }}</td>
                        <td>{{ $despesa->category->name ?? '-' }}</td>
                        <td>{{ $despesa->account->name ?? '-' }}</td>
                        <td>{{ ucfirst($despesa->recurring_frequency) }}</td>
                        <td>{{ \Carbon\Carbon::parse($despesa->date)->format('d') }}</td>
                        <td class="flex gap-2">
                            <a href="{{ route('finance.fixed-expenses.edit', $despesa->id) }}" class="text-blue-500 hover:underline">Editar</a>
                            <form action="{{ route('finance.fixed-expenses.destroy', $despesa->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Excluir</button>
                            </form>
                            <form action="{{ route('finance.fixed-expenses.pay', $despesa->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded">Pagar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-gray-400">Nenhuma despesa fixa cadastrada.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection 