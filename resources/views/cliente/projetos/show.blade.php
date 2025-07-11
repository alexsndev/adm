@extends('layouts.client')

@section('content')
    <h2 class="text-2xl font-bold text-purple-200 mb-6">Projeto: {{ $projeto->name }}</h2>
    <a href="{{ route('cliente.chat', ['project_id' => $projeto->id]) }}"
       class="inline-block px-4 py-2 rounded bg-green-700 hover:bg-green-800 text-white font-semibold shadow mb-6">
        Chat deste projeto
    </a>
    <div class="mb-4 text-gray-300">Status: <span class="font-bold">{{ $projeto->status ?? 'Em andamento' }}</span></div>
    <div class="mb-8 text-gray-400 text-sm">Criado em: {{ $projeto->created_at->format('d/m/Y') }}</div>
    <h3 class="text-lg font-semibold text-blue-200 mb-2">Tarefas</h3>
    <ul class="mb-6">
        @forelse($projeto->tasks as $tarefa)
            <li class="mb-2 bg-[#23232b] rounded p-3 border border-gray-800 text-gray-100 flex items-center justify-between">
                <span>{{ $tarefa->title }}</span>
                <span class="text-xs px-2 py-1 rounded-full {{ $tarefa->status == 'concluída' ? 'bg-green-700 text-green-200' : 'bg-yellow-700 text-yellow-200' }}">{{ ucfirst($tarefa->status) }}</span>
            </li>
        @empty
            <li class="text-gray-500">Nenhuma tarefa cadastrada.</li>
        @endforelse
    </ul>
    <h3 class="text-lg font-semibold text-purple-200 mb-2">Links</h3>
    <ul class="mb-6">
        @forelse($projeto->links as $link)
            <li class="mb-2"><a href="{{ $link->url }}" target="_blank" class="text-blue-400 underline">{{ $link->title ?? $link->url }}</a></li>
        @empty
            <li class="text-gray-500">Nenhum link cadastrado.</li>
        @endforelse
    </ul>
    <h3 class="text-lg font-semibold text-gray-400 mb-2">Notas</h3>
    <ul>
        @if(!empty($projeto->notes))
            <li class="mb-2 bg-[#23232b] rounded p-3 border border-gray-800 text-gray-400">{{ $projeto->notes }}</li>
        @else
            <li class="text-gray-500">Nenhuma nota cadastrada.</li>
        @endif
    </ul>

    {{-- Chat do Projeto --}}
    <div class="mt-10">
        <h2 class="text-2xl font-bold text-green-200 mb-4">Chat deste Projeto</h2>
        <div class="bg-[#23232b] rounded-xl p-6 border border-gray-800 shadow mb-4 min-h-[200px] flex flex-col justify-end max-h-96 overflow-y-auto text-left">
            @forelse($messages as $msg)
                <div class="mb-2 flex {{ $msg->user_id == $client->id ? 'justify-end' : 'justify-start' }}">
                    <div class="inline-block px-4 py-2 rounded-lg {{ $msg->user_id == $client->id ? 'bg-green-700 text-white' : 'bg-gray-700 text-gray-100' }}">
                        <span class="block text-xs text-gray-300 mb-1">{{ $msg->user->name }}</span>
                        {{ $msg->message }}
                        <span class="block text-xs text-gray-400 mt-1 text-right">{{ $msg->created_at->format('d/m H:i') }}</span>
                        @if($msg->task)
                            <span class="block text-xs text-blue-300 mt-1">Tarefa: {{ $msg->task->title }}</span>
                        @endif
                        @if($msg->user_id == $client->id)
                            <form method="POST" action="{{ route('cliente.chat.mensagem.destroy', $msg->id) }}" style="display:inline" onsubmit="return confirm('Deseja excluir esta mensagem?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-2 text-xs text-red-300 hover:text-red-500">Excluir</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Nenhuma mensagem ainda.</p>
            @endforelse
        </div>
        <form method="POST" action="{{ route('cliente.chat', ['project_id' => $projectId]) }}" class="flex gap-2 mt-4">
            @csrf
            <input type="hidden" name="project_id" value="{{ $projectId }}">
            <input type="text" name="message" class="flex-1 px-4 py-2 rounded bg-gray-800 text-gray-100 border border-gray-700" placeholder="Digite sua mensagem..." required maxlength="2000">
            <button type="submit" class="px-6 py-2 rounded bg-green-700 hover:bg-green-800 text-white font-semibold shadow">Enviar</button>
        </form>
        <form method="POST" action="{{ route('cliente.chat.mensagens.destroyAll') }}" class="mt-4 text-center" onsubmit="return confirm('Deseja excluir TODAS as suas mensagens?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-6 py-2 rounded bg-red-700 hover:bg-red-800 text-white font-semibold shadow">Excluir todas as minhas mensagens</button>
        </form>
    </div>
@endsection 