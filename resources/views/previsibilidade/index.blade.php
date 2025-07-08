@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800">
    <div class="container mx-auto px-4 py-8">
        <!-- Header com estatísticas -->
        <div class="mb-8">
            <div class="text-center mb-8 fade-in-up">
                <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-4">
                    Pessoas de Previsibilidade
                </h1>
                <p class="text-slate-600 dark:text-slate-300 text-lg max-w-2xl mx-auto">
                    Gerencie familiares, amigos e grupos pessoais para previsibilidade.
                </p>
            </div>

            <!-- Cards de estatísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 fade-in-up" style="animation-delay: 0.1s;">
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total de Pessoas</p>
                            <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $pessoas->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Família</p>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $pessoas->where('category', 'familia')->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Amigos</p>
                            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $pessoas->where('category', 'amigo')->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Aniversariantes</p>
                            <p class="text-3xl font-bold text-pink-600 dark:text-pink-400">{{ $pessoas->filter(function($pessoa) { return $pessoa->birthdate && \Carbon\Carbon::parse($pessoa->birthdate)->isBirthday(); })->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros e busca -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 mb-8 fade-in-up" style="animation-delay: 0.2s;">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
                <div class="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                    <!-- Busca -->
                    <div class="relative w-full sm:w-80">
                        <input type="text" id="search" placeholder="Buscar pessoas..." 
                               class="w-full pl-10 pr-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200">
                        <svg class="absolute left-3 top-3.5 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <!-- Filtro por categoria -->
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium text-slate-600 dark:text-slate-300">Categoria:</span>
                        <select id="category-filter" class="border border-slate-300 dark:border-slate-600 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white transition-all duration-200">
                            <option value="">Todas</option>
                            <option value="familia">Família</option>
                            <option value="amigo">Amigo</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>

                    <!-- Filtro por aniversariantes -->
                    <div class="flex items-center space-x-2">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" id="birthday-filter" class="w-4 h-4 text-blue-600 bg-slate-100 border-slate-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                            <span class="text-sm font-medium text-slate-600 dark:text-slate-300">Aniversariantes</span>
                        </label>
                    </div>
                </div>

                <!-- Botão adicionar -->
                <a href="{{ route('previsibilidade.create') }}" 
                   class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg flex items-center space-x-2 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Nova Pessoa</span>
                </a>
            </div>
        </div>

        @if($pessoas->isEmpty())
            <!-- Estado vazio -->
            <div class="text-center py-16 fade-in-up" style="animation-delay: 0.3s;">
                <div class="w-24 h-24 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-2">Nenhuma pessoa cadastrada</h3>
                <p class="text-slate-600 dark:text-slate-300 mb-6">Comece cadastrando uma pessoa para organizar sua previsibilidade.</p>
                <a href="{{ route('previsibilidade.create') }}" 
                   class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg transition-all duration-200 transform hover:scale-105">
                    Cadastrar Pessoa
                </a>
            </div>
        @else
            <!-- Grid de pessoas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="pessoas-grid">
                @foreach($pessoas as $index => $pessoa)
                    <div class="pessoa-card bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-slate-200 dark:border-slate-700 overflow-hidden group hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 fade-in-up" 
                         data-categoria="{{ $pessoa->category }}"
                         data-nome="{{ strtolower($pessoa->name) }}"
                         data-aniversariante="{{ $pessoa->birthdate && \Carbon\Carbon::parse($pessoa->birthdate)->isBirthday() ? 'true' : 'false' }}"
                         style="animation-delay: {{ 0.3 + ($index * 0.1) }}s;">
                        
                        <!-- Header do card -->
                        <div class="relative h-32 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center photo-container">
                            @if($pessoa->photo)
                                <img src="{{ Storage::url($pessoa->photo) }}" 
                                     alt="Foto de {{ $pessoa->name }}" 
                                     class="w-20 h-20 rounded-full object-cover border-4 border-white dark:border-slate-700 shadow-lg transition-transform duration-300 group-hover:scale-110 cursor-pointer"
                                     title="{{ $pessoa->name }}&#10;{{ $pessoa->email }}&#10;{{ $pessoa->phone }}">
                            @else
                                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center border-4 border-white/30">
                                    <span class="text-white text-2xl">👤</span>
                                </div>
                            @endif
                            
                            <!-- Badges -->
                            <div class="absolute top-3 right-3 flex flex-col items-end space-y-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                           {{ $pessoa->category === 'familia' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : ($pessoa->category === 'amigo' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' : 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300') }}">
                                    {{ ucfirst($pessoa->category) }}
                                </span>
                                @if($pessoa->attachments && $pessoa->attachments->count())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400" title="{{ $pessoa->attachments->count() }} anexo(s)">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a4 4 0 10-5.656-5.656l-6.586 6.586"></path></svg>
                                        {{ $pessoa->attachments->count() }}
                                    </span>
                                @endif
                                @if($pessoa->birthdate && \Carbon\Carbon::parse($pessoa->birthdate)->isBirthday())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-pink-100 text-pink-800 dark:bg-pink-900/30 dark:text-pink-400 animate-pulse" title="Aniversariante do mês 🎉">
                                        🎂
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Conteúdo do card -->
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors flex items-center">
                                {{ $pessoa->name }}
                                @if($pessoa->birthdate && \Carbon\Carbon::parse($pessoa->birthdate)->isBirthday())
                                    <span class="ml-2 text-pink-500 animate-bounce" title="Aniversariante do mês">🎉</span>
                                @endif
                            </h3>
                            
                            <div class="space-y-2 text-sm text-slate-600 dark:text-slate-300">
                                @if($pessoa->birthdate)
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($pessoa->birthdate)->format('d/m/Y') }}</span>
                                    </div>
                                @endif
                                @if($pessoa->phone)
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a2 2 0 011.94 1.52l.3 1.2a2 2 0 01-.45 1.95l-1.1 1.1a16.06 16.06 0 006.36 6.36l1.1-1.1a2 2 0 011.95-.45l1.2.3A2 2 0 0121 17.72V21a2 2 0 01-2 2h-1C7.61 23 1 16.39 1 8V7a2 2 0 012-2z"></path>
                                        </svg>
                                        <span>{{ $pessoa->phone }}</span>
                                    </div>
                                @endif
                                @if($pessoa->email)
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 0a4 4 0 11-8 0 4 4 0 018 0zm0 0v4m0-4V8"></path>
                                        </svg>
                                        <span class="truncate">{{ $pessoa->email }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Ações -->
                            <div class="flex justify-between items-center mt-6 pt-4 border-t border-slate-200 dark:border-slate-700">
                                <a href="{{ route('previsibilidade.show', $pessoa->id) }}" 
                                   class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium text-sm flex items-center space-x-1 group-hover:underline transition-colors">
                                    <span>Ver detalhes</span>
                                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                                
                                <div class="flex space-x-1">
                                    @if($pessoa->phone)
                                        <a href="https://wa.me/55{{ preg_replace('/\D/', '', $pessoa->phone) }}" target="_blank" 
                                           class="p-2 text-green-600 hover:text-green-800 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition-all duration-200" title="WhatsApp">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                            </svg>
                                        </a>
                                        <a href="tel:{{ $pessoa->phone }}" 
                                           class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-all duration-200" title="Ligar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a2 2 0 011.94 1.52l.3 1.2a2 2 0 01-.45 1.95l-1.1 1.1a16.06 16.06 0 006.36 6.36l1.1-1.1a2 2 0 011.95-.45l1.2.3A2 2 0 0121 17.72V21a2 2 0 01-2 2h-1C7.61 23 1 16.39 1 8V7a2 2 0 012-2z"></path>
                                            </svg>
                                        </a>
                                    @endif
                                    @if($pessoa->email)
                                        <a href="mailto:{{ $pessoa->email }}" 
                                           class="p-2 text-slate-600 hover:text-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition-all duration-200" title="Enviar e-mail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </a>
                                    @endif
                                    <a href="{{ route('previsibilidade.edit', $pessoa->id) }}" 
                                       class="p-2 text-purple-600 hover:text-purple-800 hover:bg-purple-100 dark:hover:bg-purple-900/30 rounded-lg transition-all duration-200" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('previsibilidade.destroy', $pessoa->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este contato?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-red-600 hover:text-red-800 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-all duration-200" title="Excluir">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Contador de resultados -->
            <div class="mt-8 text-center fade-in-up" style="animation-delay: 0.5s;">
                <p class="text-slate-600 dark:text-slate-300" id="results-count">
                    Mostrando {{ $pessoas->count() }} pessoa(s)
                </p>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const search = document.getElementById('search');
    const categoryFilter = document.getElementById('category-filter');
    const birthdayFilter = document.getElementById('birthday-filter');
    const pessoasGrid = document.getElementById('pessoas-grid');
    const resultsCount = document.getElementById('results-count');
    const pessoaCards = document.querySelectorAll('.pessoa-card');

    function filterPessoas() {
        const searchTerm = search.value.toLowerCase();
        const categoryValue = categoryFilter.value;
        const showBirthdayOnly = birthdayFilter.checked;
        
        let visibleCount = 0;

        pessoaCards.forEach(card => {
            const nome = card.getAttribute('data-nome');
            const categoria = card.getAttribute('data-categoria');
            const isAniversariante = card.getAttribute('data-aniversariante') === 'true';
            
            const matchesSearch = nome.includes(searchTerm);
            const matchesCategory = !categoryValue || categoria === categoryValue;
            const matchesBirthday = !showBirthdayOnly || isAniversariante;
            
            if (matchesSearch && matchesCategory && matchesBirthday) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (resultsCount) {
            resultsCount.textContent = `Mostrando ${visibleCount} pessoa(s)`;
        }
    }

    // Event listeners
    search.addEventListener('input', filterPessoas);
    categoryFilter.addEventListener('change', filterPessoas);
    birthdayFilter.addEventListener('change', filterPessoas);

    // Animações de entrada
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    pessoaCards.forEach(card => {
        observer.observe(card);
    });
});
</script>

<style>
.fade-in-up {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.6s ease-out forwards;
}

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.pessoa-card {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.3s ease;
}

.pessoa-card:hover {
    transform: translateY(-8px);
}

/* Dark mode transitions */
* {
    transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
}
</style>
@endsection 