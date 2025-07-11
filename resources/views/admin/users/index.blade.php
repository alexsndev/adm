@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white flex items-center gap-2">
        <i class="fa-solid fa-users-cog text-blue-500"></i> Gerenciar Usuários
    </h1>
    @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded bg-green-100 text-green-800 border border-green-300 dark:bg-green-900 dark:text-green-200 dark:border-green-700 animate-fade-in">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 px-4 py-3 rounded bg-red-100 text-red-800 border border-red-300 dark:bg-red-900 dark:text-red-200 dark:border-red-700 animate-fade-in">
            {{ session('error') }}
        </div>
    @endif
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.cliente-users.create') }}" class="px-5 py-2 rounded bg-purple-700 hover:bg-purple-800 text-white font-semibold shadow transition flex items-center gap-2">
            <i class="fa-solid fa-user-plus"></i> Gerar usuário para cliente
        </a>
    </div>
    <div class="overflow-x-auto rounded-xl shadow-lg bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nome</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Administrador?</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipo</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cliente Vinculado</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                @foreach($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($user->is_admin)
                                <span class="inline-block px-3 py-1 rounded-full bg-green-500/20 text-green-700 dark:bg-green-700/30 dark:text-green-200 text-xs font-semibold">Sim</span>
                            @else
                                <span class="inline-block px-3 py-1 rounded-full bg-gray-400/20 text-gray-700 dark:bg-gray-700/30 dark:text-gray-300 text-xs font-semibold">Não</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($user->is_admin)
                                <span class="inline-block px-3 py-1 rounded-full bg-blue-500/20 text-blue-700 dark:bg-blue-700/30 dark:text-blue-200 text-xs font-semibold">Admin</span>
                            @elseif($user->is_client)
                                <span class="inline-block px-3 py-1 rounded-full bg-green-500/20 text-green-700 dark:bg-green-700/30 dark:text-green-200 text-xs font-semibold">Cliente</span>
                            @else
                                <span class="inline-block px-3 py-1 rounded-full bg-gray-400/20 text-gray-700 dark:bg-gray-700/30 dark:text-gray-300 text-xs font-semibold">Usuário</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($user->is_client && $user->client)
                                <span class="inline-block px-3 py-1 rounded-full bg-purple-500/20 text-purple-700 dark:bg-purple-700/30 dark:text-purple-200 text-xs font-semibold">{{ $user->client->name }}</span>
                            @elseif($user->is_client)
                                <span class="inline-block px-3 py-1 rounded-full bg-red-500/20 text-red-700 dark:bg-red-700/30 dark:text-red-200 text-xs font-semibold">Sem vínculo</span>
                            @else
                                <span class="inline-block px-3 py-1 rounded-full bg-gray-400/20 text-gray-700 dark:bg-gray-700/30 dark:text-gray-300 text-xs font-semibold">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if(auth()->id() !== $user->id)
                            <form method="POST" action="{{ route('admin.users.toggle', $user) }}" class="inline-block">
                                @csrf
                                <button type="submit" class="px-4 py-1 rounded text-xs font-semibold transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 {{ $user->is_admin ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-blue-600 hover:bg-blue-700 text-white' }}">
                                    {{ $user->is_admin ? 'Remover Admin' : 'Tornar Admin' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.toggle-client', $user) }}" class="inline-block ml-1">
                                @csrf
                                <button type="submit" class="px-4 py-1 rounded text-xs font-semibold transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 {{ $user->is_client ? 'bg-red-500 hover:bg-red-600 text-white' : 'bg-green-600 hover:bg-green-700 text-white' }}">
                                    {{ $user->is_client ? 'Remover Cliente' : 'Tornar Cliente' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline-block ml-1" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-1 rounded text-xs font-semibold bg-gray-700 hover:bg-red-700 text-white transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Excluir</button>
                            </form>
                            @else
                                <span class="text-gray-400 text-xs">(você)</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection 