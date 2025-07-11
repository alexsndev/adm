@extends('layouts.app')

@section('content')
<div class="w-full py-6 bg-main" style="max-width:100%;">
    <h1 class="text-2xl font-bold mb-4 text-main">Faturas</h1>
    <a href="{{ route('faturas.create') }}" class="bg-accent text-main px-4 py-2 rounded mb-4 inline-block border border-main hover:bg-main hover:text-accent">Nova Fatura</a>
    @if($faturas->isEmpty())
        <div class="text-accent">Nenhuma fatura cadastrada.</div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-card border border-main">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border border-main text-main">ID</th>
                        <th class="px-4 py-2 border border-main text-main">Cliente</th>
                        <th class="px-4 py-2 border border-main text-main">Valor</th>
                        <th class="px-4 py-2 border border-main text-main">Status</th>
                        <th class="px-4 py-2 border border-main text-main">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($faturas as $fatura)
                        <tr>
                            <td class="px-4 py-2 border border-main text-main">{{ $fatura->id }}</td>
                            <td class="px-4 py-2 border border-main text-main">{{ $fatura->client->name ?? '-' }}</td>
                            <td class="px-4 py-2 border border-main text-accent">R$ {{ number_format($fatura->total ?? 0, 2, ',', '.') }}</td>
                            <td class="px-4 py-2 border border-main text-accent">{{ $fatura->status ?? '-' }}</td>
                            <td class="px-4 py-2 border border-main">
                                <a href="{{ route('faturas.show', $fatura->id) }}" class="text-accent hover:text-main hover:underline">Ver</a>
                                <a href="{{ route('faturas.edit', $fatura->id) }}" class="text-accent hover:text-main hover:underline ml-2">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection 