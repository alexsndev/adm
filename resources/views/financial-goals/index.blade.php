@extends('layouts.app')

@section('content')
    @section('header')
        <div class="flex justify-between items-center mb-2">
            <h2 class="font-extrabold text-3xl md:text-4xl text-gray-900 dark:text-white tracking-tight drop-shadow-lg animate-fade-in">
                <i class="fa-solid fa-seedling mr-2 text-green-400"></i> Metas Verdes
            </h2>
            <a href="{{ route('financial-goals.create') }}" class="inline-flex items-center px-5 py-2 border border-transparent text-base font-bold rounded-xl text-white bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 shadow transition-all duration-200 animate-fade-in">
                <i class="fa-solid fa-plus mr-2"></i> Nova Meta
            </a>
        </div>
    @endsection

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white/60 dark:bg-gray-900/60 rounded-3xl shadow-xl p-8 border border-white/30 dark:border-gray-700/30 backdrop-blur-lg animate-fade-in">
                @if($financialGoals->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($financialGoals as $goal)
                            <div class="bg-white/80 dark:bg-gray-800/80 rounded-2xl p-6 border border-white/20 dark:border-gray-700/20 shadow hover:shadow-lg transition-shadow">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 shadow border border-green-200 dark:border-green-700 mr-3">
                                            <i class="fa-solid {{ $goal->goal_type_icon }} fa-lg"></i>
                                        </span>
                                        <div>
                                            <h3 class="font-bold text-lg text-gray-900 dark:text-white">{{ $goal->name }}</h3>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $goal->goal_type_label }}</p>
                                        </div>
                                    </div>
                                    @if($goal->is_eco_friendly)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs font-bold">
                                            <i class="fa-solid fa-leaf mr-1"></i> Verde
                                        </span>
                                    @endif
                                </div>
                                <div class="mb-4">
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="text-gray-600 dark:text-gray-400">Progresso</span>
                                        <span class="font-bold text-gray-900 dark:text-white">{{ $goal->progress_percentage }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                                        <div class="bg-gradient-to-r from-green-400 to-blue-500 h-3 rounded-full" style="width: {{ $goal->progress_percentage }}%"></div>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    <div class="flex justify-between">
                                        <span>Atual: R$ {{ number_format($goal->current_amount, 2, ',', '.') }}</span>
                                        <span>Meta: R$ {{ number_format($goal->target_amount, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        <i class="fa-solid fa-calendar mr-1"></i> {{ $goal->target_date->format('d/m/Y') }}
                                    </span>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('financial-goals.show', $goal) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-bold text-sm transition">Ver</a>
                                        <a href="{{ route('financial-goals.edit', $goal) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300 font-bold text-sm transition">Editar</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fa-solid fa-seedling fa-3x text-green-300 mb-4"></i>
                        <h3 class="mt-2 text-xl font-extrabold text-gray-900 dark:text-white">Nenhuma meta verde cadastrada</h3>
                        <p class="mt-1 text-base text-gray-500 dark:text-gray-400">Comece planejando seu futuro sustentável agora mesmo.</p>
                        <div class="mt-6">
                            <a href="{{ route('financial-goals.create') }}" class="inline-flex items-center px-5 py-2 border border-transparent shadow-sm text-base font-bold rounded-xl text-white bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 transition-all duration-200">
                                <i class="fa-solid fa-plus mr-2"></i> Nova Meta Verde
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection 