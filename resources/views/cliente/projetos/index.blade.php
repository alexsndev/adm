@extends('layouts.client')

@section('content')
    <h2 class="text-2xl font-bold text-purple-200 mb-6">Meus Projetos</h2>
    @if($projetos->isEmpty())
        <p class="text-gray-400">Nenhum projeto encontrado.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($projetos as $projeto)
                <a href="{{ route('cliente.projetos.show', $projeto->id) }}" class="block bg-[#23232b] rounded-xl p-6 shadow hover:shadow-lg transition border border-gray-800">
                    <h3 class="text-xl font-semibold text-purple-100 mb-2">{{ $projeto->name }}</h3>
                    <p class="text-gray-300 mb-1">Status: <span class="font-bold">{{ $projeto->status ?? 'Em andamento' }}</span></p>
                    <p class="text-gray-400 text-sm">Criado em: {{ $projeto->created_at->format('d/m/Y') }}</p>
                </a>
            @endforeach
        </div>
    @endif
@endsection 