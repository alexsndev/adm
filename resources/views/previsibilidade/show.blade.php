@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800">
    <div class="w-full px-0 py-4 md:py-8" style="max-width:100%;">
        <!-- Header -->
        <div class="text-center mb-8 fade-in-up w-full flex flex-col items-center justify-center">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-4 w-full">Detalhes da Pessoa</h1>
            <p class="text-slate-600 dark:text-slate-300 text-base sm:text-lg max-w-2xl mx-auto w-full">Visualize e gerencie as informações de {{ $pessoa->name }}.</p>
        </div>

        <!-- Card Principal -->
        <div class="max-w-6xl mx-auto">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden fade-in-up" style="animation-delay: 0.1s;">
                
                <!-- Header do Card -->
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-8 text-white">
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <!-- Foto -->
                        <div class="flex-shrink-0">
                            <div class="w-32 h-32 bg-white/20 rounded-full flex items-center justify-center overflow-hidden border-4 border-white/30 shadow-lg">
                                @if($pessoa->photo)
                                    <img src="{{ Storage::url($pessoa->photo) }}" alt="Foto de {{ $pessoa->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-white text-5xl">👤</span>
                                @endif
                            </div>
                        </div>

                        <!-- Informações Principais -->
                        <div class="flex-1 text-center md:text-left">
                            <h2 class="text-3xl font-bold mb-2">{{ $pessoa->name }}</h2>
                            <div class="flex flex-wrap justify-center md:justify-start gap-4 mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 backdrop-blur-sm">
                                    {{ ucfirst($pessoa->category) }}
                                </span>
                                @if($pessoa->birthdate && \Carbon\Carbon::parse($pessoa->birthdate)->isBirthday())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-pink-500/20 backdrop-blur-sm animate-pulse">
                                        🎂 Aniversariante do mês
                                    </span>
                                @endif
                                @if($pessoa->attachments && $pessoa->attachments->count())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 backdrop-blur-sm">
                                        📎 {{ $pessoa->attachments->count() }} anexo(s)
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Ações Rápidas -->
                            <div class="flex flex-wrap justify-center md:justify-start gap-3">
                                @if($pessoa->phone)
                                    <a href="https://wa.me/55{{ preg_replace('/\D/', '', $pessoa->phone) }}" target="_blank" 
                                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 rounded-lg text-white text-sm font-medium transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                        </svg>
                                        WhatsApp
                                    </a>
                                    <a href="tel:{{ $pessoa->phone }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white text-sm font-medium transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a2 2 0 011.94 1.52l.3 1.2a2 2 0 01-.45 1.95l-1.1 1.1a16.06 16.06 0 006.36 6.36l1.1-1.1a2 2 0 011.95-.45l1.2.3A2 2 0 0121 17.72V21a2 2 0 01-2 2h-1C7.61 23 1 16.39 1 8V7a2 2 0 012-2z"></path>
                                        </svg>
                                        Ligar
                                    </a>
                                @endif
                                @if($pessoa->email)
                                    <a href="mailto:{{ $pessoa->email }}" 
                                       class="inline-flex items-center px-4 py-2 bg-slate-600 hover:bg-slate-700 rounded-lg text-white text-sm font-medium transition-all duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        E-mail
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Conteúdo -->
                <div class="p-8">
                    <!-- Informações de Contato -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-xl p-6">
                            <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Informações de Contato
                            </h3>
                            <div class="space-y-3">
                                @if($pessoa->birthdate)
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Data de Nascimento</p>
                                            <p class="text-slate-900 dark:text-white">{{ \Carbon\Carbon::parse($pessoa->birthdate)->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                @endif
                                @if($pessoa->phone)
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a2 2 0 011.94 1.52l.3 1.2a2 2 0 01-.45 1.95l-1.1 1.1a16.06 16.06 0 006.36 6.36l1.1-1.1a2 2 0 011.95-.45l1.2.3A2 2 0 0121 17.72V21a2 2 0 01-2 2h-1C7.61 23 1 16.39 1 8V7a2 2 0 012-2z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Telefone</p>
                                            <p class="text-slate-900 dark:text-white">{{ $pessoa->phone }}</p>
                                        </div>
                                    </div>
                                @endif
                                @if($pessoa->email)
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 0a4 4 0 11-8 0 4 4 0 018 0zm0 0v4m0-4V8"></path>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">E-mail</p>
                                            <p class="text-slate-900 dark:text-white">{{ $pessoa->email }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Informações Adicionais -->
                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-xl p-6">
                            <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Informações Adicionais
                            </h3>
                            <div class="space-y-4">
                                @if($pessoa->details)
                                    <div>
                                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Detalhes</p>
                                        <p class="text-slate-900 dark:text-white">{{ $pessoa->details }}</p>
                                    </div>
                                @endif
                                @if($pessoa->notes)
                                    <div>
                                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-1">Notas Pessoais</p>
                                        <p class="text-slate-900 dark:text-white">{{ $pessoa->notes }}</p>
                                    </div>
                                @endif
                                @if(!$pessoa->details && !$pessoa->notes)
                                    <p class="text-slate-500 dark:text-slate-400 italic">Nenhuma informação adicional cadastrada.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Pessoas Relacionadas -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Pessoas Relacionadas
                        </h3>
                        
                        @if($pessoa->relatedPeople->isEmpty())
                            <div class="bg-slate-50 dark:bg-slate-700/50 rounded-xl p-8 text-center">
                                <svg class="w-12 h-12 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <p class="text-slate-600 dark:text-slate-300">Nenhuma pessoa relacionada cadastrada.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($pessoa->relatedPeople as $relacionada)
                                    <div class="bg-slate-50 dark:bg-slate-700/50 rounded-xl p-4 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all duration-200">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center overflow-hidden">
                                                @if($relacionada->photo)
                                                    <img src="{{ Storage::url($relacionada->photo) }}" alt="Foto de {{ $relacionada->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <span class="text-white text-lg">👤</span>
                                                @endif
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium text-slate-900 dark:text-white">{{ $relacionada->name }}</p>
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                                           {{ $relacionada->category === 'familia' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : ($relacionada->category === 'amigo' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' : 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300') }}">
                                                    {{ ucfirst($relacionada->category) }}
                                                </span>
                                            </div>
                                            <a href="{{ route('previsibilidade.show', $relacionada->id) }}" 
                                               class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Anexos -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a4 4 0 10-5.656-5.656l-6.586 6.586"></path>
                            </svg>
                            Anexos
                        </h3>
                        
                        <!-- Formulário de Upload -->
                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-xl p-6 mb-6">
                            <form action="{{ route('previsibilidade.anexos', $pessoa->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-4">
                                @csrf
                                <div class="flex-1">
                                    <input type="file" name="arquivo" accept="*/*" required
                                           class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-slate-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400 transition-all duration-200">
                                </div>
                                <div class="flex-1">
                                    <input type="text" name="descricao" placeholder="Descrição do anexo" 
                                           class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200">
                                </div>
                                <button type="submit" 
                                        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-xl font-semibold transition-all duration-200 transform hover:scale-105">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Anexar
                                </button>
                            </form>
                        </div>

                        <!-- Lista de Anexos -->
                        @if($pessoa->attachments->isEmpty())
                            <div class="bg-slate-50 dark:bg-slate-700/50 rounded-xl p-8 text-center">
                                <svg class="w-12 h-12 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a4 4 0 10-5.656-5.656l-6.586 6.586"></path>
                                </svg>
                                <p class="text-slate-600 dark:text-slate-300">Nenhum anexo cadastrado.</p>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($pessoa->attachments as $anexo)
                                    <div class="bg-slate-50 dark:bg-slate-700/50 rounded-xl p-4 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all duration-200">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-500 rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a4 4 0 10-5.656-5.656l-6.586 6.586"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <a href="{{ Storage::url($anexo->arquivo) }}" target="_blank" 
                                                   class="font-medium text-slate-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                                    {{ $anexo->descricao ?? 'Anexo' }}
                                                </a>
                                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                                    {{ \Carbon\Carbon::parse($anexo->created_at)->format('d/m/Y H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-6 border-t border-slate-200 dark:border-slate-700">
                        <a href="{{ route('previsibilidade.index') }}" 
                           class="w-full sm:w-auto px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-all duration-200 text-center">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Voltar à Lista
                        </a>
                        
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('previsibilidade.edit', $pessoa->id) }}" 
                               class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white rounded-xl font-semibold transition-all duration-200 transform hover:scale-105 text-center">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Editar Pessoa
                            </a>
                            
                            <form action="{{ route('previsibilidade.destroy', $pessoa->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta pessoa?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white rounded-xl font-semibold transition-all duration-200 transform hover:scale-105">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

/* Dark mode transitions */
* {
    transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
}
</style>
@endsection 