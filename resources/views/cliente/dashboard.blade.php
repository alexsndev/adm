@extends('layouts.client')

@section('content')
    <div class="text-center py-12">
        <h2 class="text-3xl font-bold text-purple-200 mb-4">Bem-vindo, {{ $client->name }}!</h2>
        <p class="text-lg text-gray-300 mb-6">Aqui você pode acompanhar todos os seus projetos, tarefas e interagir com nossa equipe.</p>
        <div class="flex flex-col items-center gap-4 mt-8">
            <a href="{{ route('cliente.projetos') }}" class="px-6 py-3 rounded-full bg-purple-700 hover:bg-purple-800 text-white font-semibold shadow transition">Ver Projetos</a>
            <a href="{{ route('cliente.tarefas') }}" class="px-6 py-3 rounded-full bg-blue-700 hover:bg-blue-800 text-white font-semibold shadow transition">Ver Tarefas</a>
            <a href="{{ route('cliente.chat') }}" class="px-6 py-3 rounded-full bg-green-700 hover:bg-green-800 text-white font-semibold shadow transition">Abrir Chat</a>
        </div>
    </div>
@endsection 