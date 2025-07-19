@extends('layouts.app')

@section('content')
    <div class="py-10 flex justify-center items-center min-h-[80vh]">
        <div class="w-full max-w-xl mx-auto">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 border border-gray-200 dark:border-gray-700">
                <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-8 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-building-columns text-blue-600"></i>
                    Nova Conta
                </h1>
                <form action="{{ route('accounts.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    @include('accounts._form')
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-3 mt-8">
                        <a href="{{ route('accounts.index') }}" class="px-5 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 font-semibold transition text-sm">
                            Cancelar
                        </a>
                        <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold flex items-center gap-2 text-base shadow transition">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Salvar Conta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection 