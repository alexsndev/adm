@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Meus Cartões de Crédito</h2>
            <a href="{{ route('credit-cards.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700">Novo Cartão</a>
        </div>
        <div class="bg-white/5 dark:bg-gray-800/60 overflow-hidden shadow-xl sm:rounded-lg p-6">
            @if($creditCards->count())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($creditCards as $card)
                        <div class="rounded-2xl shadow-lg bg-white dark:bg-gray-900 p-6 flex flex-col justify-between relative border border-blue-200 dark:border-gray-700">
                            <div class="flex items-center mb-4">
                                @if($card->logo_url)
                                    <img src="{{ $card->logo_url }}" alt="Logo" class="h-12 w-20 rounded shadow bg-white mr-4">
                                @else
                                    <div class="h-12 w-20 rounded bg-gray-200 flex items-center justify-center mr-4">
                                        <i class="fa-solid fa-credit-card text-3xl text-blue-700"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="text-lg font-extrabold text-gray-900 dark:text-gray-100 flex items-center">
                                        {{ $card->display_name }}
                                        @if($card->is_active)
                                            <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-bold bg-green-500/80 text-white">Ativo</span>
                                        @else
                                            <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-bold bg-red-500/80 text-white">Inativo</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-700 dark:text-gray-300 mt-1 font-semibold">
                                        Banco: {{ $card->account->name ?? '-' }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-4 items-center mb-4">
                                <div class="flex items-center text-gray-800 dark:text-gray-200">
                                    <i class="fa-solid fa-credit-card mr-1"></i>
                                    <span class="font-bold">Bandeira:</span> <span class="ml-1">{{ $card->brand_label }}</span>
                                </div>
                                <div class="flex items-center text-gray-800 dark:text-gray-200">
                                    <i class="fa-solid fa-bullseye mr-1"></i>
                                    <span class="font-bold">Limite:</span> <span class="ml-1">R$ {{ number_format($card->credit_limit, 2, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center text-gray-800 dark:text-gray-200">
                                    <i class="fa-solid fa-calendar-day mr-1"></i>
                                    <span class="font-bold">Vencimento:</span> <span class="ml-1">Dia {{ $card->due_day ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="flex justify-end gap-3 mt-2">
                                <a href="{{ route('credit-cards.edit', $card) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-lg shadow transition"><i class="fa-solid fa-pen-to-square mr-2"></i> Editar</a>
                                <form action="{{ route('credit-cards.destroy', $card) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este cartão?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg shadow transition"><i class="fa-solid fa-trash mr-2"></i> Excluir</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-gray-400 py-12 text-lg font-semibold">Nenhum cartão cadastrado.</div>
            @endif
        </div>
    </div>
</div>
@endsection 