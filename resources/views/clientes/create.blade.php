@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 py-8">
    <div class="max-w-4xl mx-auto px-2 sm:px-4 w-full">
        <!-- Header -->
        <div class="text-center mb-8 fade-in-up w-full flex flex-col items-center justify-center">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-4 w-full">Criar Novo Cliente</h1>
            <p class="text-slate-600 dark:text-slate-300 text-base sm:text-lg max-w-2xl mx-auto w-full">Cadastre um novo cliente para gerenciar projetos e tarefas.</p>
        </div>

        <!-- Formulário -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden fade-in-up w-full" style="animation-delay: 0.1s;">
            <form action="{{ route('clientes.store') }}" method="POST" enctype="multipart/form-data" class="p-4 sm:p-8 w-full">
                @csrf
                
                @if ($errors->any())
                    <div class="bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-400 px-4 py-3 rounded-xl mb-6">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Foto do Cliente -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Foto do Cliente
                    </h3>
                    
                    <div class="flex items-center space-x-6">
                        <!-- Preview da foto -->
                        <div class="w-24 h-24 rounded-full bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 flex items-center justify-center border-2 border-dashed border-slate-300 dark:border-slate-600 overflow-hidden" id="photo-preview-container">
                            <div id="photo-placeholder" class="text-slate-400 dark:text-slate-500">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <img id="photo-preview" src="{{ asset('images/default-avatar.png') }}" 
                                 alt="Preview" class="w-full h-full object-cover hidden">
                        </div>

                        <!-- Upload -->
                        <div class="flex-1">
                            <label for="photo" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Foto do Cliente
                            </label>
                            <input type="file" id="photo" name="photo" accept="image/*"
                                   class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900/30 dark:file:text-blue-400 transition-all duration-200">
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Formatos aceitos: JPG, PNG, GIF. Máximo 2MB.</p>
                        </div>
                    </div>
                </div>

                <!-- Informações Básicas -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informações Básicas
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nome -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Nome *
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                   class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200"
                                   placeholder="Digite o nome do cliente">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Email
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200"
                                   placeholder="exemplo@email.com">
                        </div>

                        <!-- Telefone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Telefone
                            </label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200"
                                   placeholder="(11) 99999-9999">
                        </div>

                        <!-- Empresa -->
                        <div>
                            <label for="company" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Empresa
                            </label>
                            <input type="text" id="company" name="company" value="{{ old('company') }}"
                                   class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200"
                                   placeholder="Nome da empresa">
                        </div>
                    </div>
                </div>

                <!-- Informações Adicionais -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Informações Adicionais
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Endereço -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Endereço
                            </label>
                            <textarea id="address" name="address" rows="3"
                                      class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200 resize-none"
                                      placeholder="Endereço completo">{{ old('address') }}</textarea>
                        </div>

                        <!-- Observações -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                Observações
                            </label>
                            <textarea id="notes" name="notes" rows="3"
                                      class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 transition-all duration-200 resize-none"
                                      placeholder="Observações sobre o cliente">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="flex flex-col sm:flex-row justify-end items-center gap-4 pt-6 border-t border-slate-200 dark:border-slate-700">
                    <a href="{{ route('clientes.index') }}" 
                       class="w-full sm:w-auto px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl font-medium hover:bg-slate-50 dark:hover:bg-slate-700 transition-all duration-200 text-center">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-xl font-semibold shadow-lg transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Cadastrar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview da foto
    const photoInput = document.getElementById('photo');
    const photoPreview = document.getElementById('photo-preview');
    const photoPlaceholder = document.getElementById('photo-placeholder');
    const photoPreviewContainer = document.getElementById('photo-preview-container');

    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.src = e.target.result;
                photoPreview.classList.remove('hidden');
                photoPlaceholder.classList.add('hidden');
                photoPreviewContainer.classList.add('ring-2', 'ring-blue-500');
            };
            reader.readAsDataURL(file);
        } else {
            photoPreview.classList.add('hidden');
            photoPlaceholder.classList.remove('hidden');
            photoPreviewContainer.classList.remove('ring-2', 'ring-blue-500');
        }
    });

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

    document.querySelectorAll('.fade-in-up').forEach(element => {
        observer.observe(element);
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

/* Dark mode transitions */
* {
    transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
}
</style>
@endsection 