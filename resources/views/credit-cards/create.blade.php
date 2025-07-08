@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-6">
                    Novo Cartão de Crédito
                </h2>
                <form method="POST" action="{{ route('credit-cards.store') }}" enctype="multipart/form-data">
                    @csrf
                    @include('credit-cards._form', ['creditCard' => null])
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded shadow hover:bg-blue-700">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 