@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white dark:bg-[#23232b] rounded-xl shadow p-8 mt-10">
    <h2 class="text-2xl font-bold mb-6 text-purple-700 dark:text-purple-200">Gerar Usuário para Cliente</h2>
    <form method="POST" action="{{ route('admin.cliente-users.store') }}">
        @csrf
        <div class="mb-4">
            <label for="client_id" class="block mb-1 font-semibold text-gray-700 dark:text-gray-200">Cliente</label>
            <select name="client_id" id="client_id" class="w-full rounded px-3 py-2 border border-gray-300 dark:bg-[#18181b] dark:text-gray-100" required>
                <option value="">Selecione um cliente</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                @endforeach
            </select>
            @error('client_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>
        <div class="mb-4">
            <label for="email" class="block mb-1 font-semibold text-gray-700 dark:text-gray-200">E-mail</label>
            <input type="email" name="email" id="email" class="w-full rounded px-3 py-2 border border-gray-300 dark:bg-[#18181b] dark:text-gray-100" required>
            @error('email')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>
        <div class="mb-6">
            <label for="password" class="block mb-1 font-semibold text-gray-700 dark:text-gray-200">Senha</label>
            <input type="password" name="password" id="password" class="w-full rounded px-3 py-2 border border-gray-300 dark:bg-[#18181b] dark:text-gray-100" required>
            @error('password')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>
        <button type="submit" class="px-6 py-2 rounded bg-purple-700 hover:bg-purple-800 text-white font-semibold shadow">Gerar Conta</button>
    </form>
</div>
@endsection 