@extends('layouts.app')

@section('content')
<div class="w-full py-6" style="max-width:100%;">
    <h1 class="text-2xl font-bold mb-4">Detalhes da Fatura</h1>
    <div class="bg-white p-6 rounded shadow max-w-lg">
        <div class="mb-2"><strong>ID:</strong> {{ $fatura->id }}</div>
        <div class="mb-2"><strong>Cliente:</strong> {{ $fatura->client->name ?? '-' }}</div>
        <div class="mb-2"><strong>Valor Total:</strong> R$ {{ number_format($fatura->total ?? 0, 2, ',', '.') }}</div>
        <div class="mb-2"><strong>Status:</strong> {{ $fatura->status ?? '-' }}</div>
    </div>
    <div class="mt-4 flex gap-2">
        <a href="{{ route('faturas.edit', $fatura->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Editar</a>
        <a href="{{ route('faturas.pdf', $fatura->id) }}" class="bg-red-500 text-white px-4 py-2 rounded">Baixar PDF</a>
        <a href="{{ route('faturas.index') }}" class="bg-gray-300 px-4 py-2 rounded">Voltar</a>
    </div>
</div>
@endsection 