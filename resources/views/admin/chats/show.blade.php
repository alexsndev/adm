@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto text-center py-12">
    <h2 class="text-2xl font-bold text-green-200 mb-4">Chat com {{ $client->name }}</h2>
    @if(isset($project) && $project)
        <div class="mb-2 text-left text-sm text-purple-300">Projeto: {{ $project->name }}</div>
    @endif
    @if(isset($task) && $task)
        <div class="mb-2 text-left text-sm text-blue-300">Tarefa: {{ $task->title }}</div>
    @endif
    <div class="bg-[#23232b] rounded-xl p-6 border border-gray-800 shadow mb-4 min-h-[200px] flex flex-col justify-end max-h-96 overflow-y-auto text-left">
        @forelse($messages as $msg)
            <div class="mb-2 flex {{ $msg->user_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="inline-block px-4 py-2 rounded-lg {{ $msg->user_id == auth()->id() ? 'bg-green-700 text-white' : 'bg-gray-700 text-gray-100' }}">
                    <span class="block text-xs text-gray-300 mb-1">{{ $msg->user->name }}</span>
                    {{ $msg->message }}
                    <span class="block text-xs text-gray-400 mt-1 text-right">{{ $msg->created_at->format('d/m H:i') }}</span>
                    @if($msg->project)
                        <span class="block text-xs text-purple-300 mt-1">Projeto: {{ $msg->project->name }}</span>
                    @endif
                    @if($msg->task)
                        <span class="block text-xs text-blue-300 mt-1">Tarefa: {{ $msg->task->title }}</span>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-500">Nenhuma mensagem ainda.</p>
        @endforelse
    </div>
    <form method="POST" action="{{ route('admin.chats.store', $client->id) }}" class="flex gap-2 mt-4">
        @csrf
        <input type="text" name="message" class="flex-1 px-4 py-2 rounded bg-gray-800 text-gray-100 border border-gray-700" placeholder="Digite sua mensagem..." required maxlength="2000">
        <button type="submit" class="px-6 py-2 rounded bg-green-700 hover:bg-green-800 text-white font-semibold shadow">Enviar</button>
    </form>
</div>
@endsection 