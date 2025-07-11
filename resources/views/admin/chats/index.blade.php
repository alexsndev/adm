@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fa-solid fa-comments text-green-500"></i> Conversas com Clientes
    </h1>
    @if($clientes->isEmpty())
        <p class="text-gray-400">Nenhuma conversa iniciada ainda.</p>
    @else
        <ul class="divide-y divide-gray-200 dark:divide-gray-800">
            @foreach($clientes as $cliente)
                <li class="py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        @if($cliente->logo)
                            <img src="{{ Storage::url($cliente->logo) }}" class="h-10 w-10 rounded bg-white/10 object-contain" alt="Logo">
                        @else
                            <span class="inline-flex items-center justify-center h-10 w-10 rounded bg-purple-700 text-white font-bold text-xl">
                                <i class="fa-solid fa-user"></i>
                            </span>
                        @endif
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $cliente->name }}</span>
                    </div>
                    <a href="{{ route('admin.chats.show', $cliente->id) }}" class="px-4 py-2 rounded bg-green-700 hover:bg-green-800 text-white font-semibold shadow transition flex items-center gap-2">
                        <i class="fa-solid fa-comments"></i> Abrir Chat
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection 