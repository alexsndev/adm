@extends('layouts.client')

@section('content')
<div class="max-w-xl mx-auto text-center py-12">
    <!-- Navegação acessível -->
    <div class="flex justify-between items-center mb-6">
        <a href="{{ url()->previous() }}" title="Voltar" class="text-2xl text-purple-300 hover:text-purple-500" style="text-decoration: none;">🔙</a>
        <span class="text-xl font-bold text-purple-200">{{ $client->name ?? 'Cliente' }}</span>
        <a href="{{ route('cliente.dashboard') }}" title="Página Inicial" class="text-2xl text-purple-300 hover:text-purple-500" style="text-decoration: none;">🏠</a>
    </div>
    <h2 class="text-2xl font-bold text-green-200 mb-4">Chat com a Equipe</h2>
    <p class="text-gray-300 mb-6">Envie dúvidas, feedbacks ou sugestões para nossa equipe. Responderemos o mais rápido possível!</p>
    @if(isset($projectId) && $projectId)
        <div class="mb-2 text-left text-sm text-purple-300">Projeto: {{ optional(App\Models\Project::find($projectId))->name ?? '-' }}</div>
    @endif
    @if(isset($taskId) && $taskId)
        <div class="mb-2 text-left text-sm text-blue-300">Tarefa: {{ optional(App\Models\Task::find($taskId))->title ?? '-' }}</div>
    @endif
    <div class="bg-[#23232b] rounded-xl p-6 border border-gray-800 shadow mb-4 min-h-[200px] flex flex-col justify-end max-h-96 overflow-y-auto text-left">
        @forelse($messages as $msg)
            <div class="mb-2 flex {{ $msg->user_id == $client->id ? 'justify-end' : 'justify-start' }}">
                <div class="inline-block px-4 py-2 rounded-lg {{ $msg->user_id == $client->id ? 'bg-green-700 text-white' : 'bg-gray-700 text-gray-100' }}">
                    <span class="block text-xs text-gray-300 mb-1">{{ $msg->user->name }}</span>
                    {{ $msg->message }}
                    <span class="block text-xs text-gray-400 mt-1 text-right">{{ $msg->created_at->format('d/m H:i') }}</span>
                    @if($msg->project)
                        <span class="block text-xs text-purple-300 mt-1">Projeto: {{ $msg->project->name }}</span>
                    @endif
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
    <form method="POST" action="{{ route('cliente.chat', array_filter(['project_id' => $projectId ?? null, 'task_id' => $taskId ?? null])) }}" class="flex gap-2 mt-4">
        @csrf
        @if(isset($projectId) && $projectId)
            <input type="hidden" name="project_id" value="{{ $projectId }}">
        @endif
        @if(isset($taskId) && $taskId)
            <input type="hidden" name="task_id" value="{{ $taskId }}">
        @endif
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