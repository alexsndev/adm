@extends('layouts.app')

@section('content')
<div class="py-8 px-4 sm:px-8 md:px-16 lg:px-32 xl:px-48 2xl:px-64 w-full min-h-screen bg-[#18181b]">
    <h1 class="text-4xl font-extrabold mb-2 text-purple-300">Gerenciar Clientes</h1>
    <p class="mb-8 text-lg text-gray-300">Organize e acompanhe todos os seus clientes em um só lugar</p>
    <div class="flex items-center space-x-4 mb-8">
        <div class="relative w-full max-w-md">
            <input id="search" type="text" placeholder="Buscar por nome, e-mail ou empresa..." class="px-4 py-2 rounded-lg shadow focus:ring-2 focus:ring-blue-400 border border-gray-700 w-full bg-[#23232b] text-gray-100 placeholder-gray-400" />
            <button onclick="document.getElementById('search').value=''; document.getElementById('search').dispatchEvent(new Event('input'))" class="absolute right-2 top-2 px-2 py-1 rounded bg-gray-700 hover:bg-gray-600 transition text-gray-300" title="Limpar busca" aria-label="Limpar busca">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>
        <div class="flex items-center space-x-2">
            <label for="filter" class="text-gray-300">Filtrar:</label>
            <select id="filter" class="rounded px-2 py-1 bg-[#23232b] text-gray-100 border border-gray-700">
                <option value="all">Todos</option>
                <option value="active">Ativos</option>
                <option value="inactive">Inativos</option>
            </select>
        </div>
        <a href="{{ route('clientes.create') }}" class="btn-gradient text-white px-6 py-3 rounded-full font-semibold shadow-lg flex items-center space-x-2 transition-transform duration-200 hover:-translate-y-1 focus:ring-2 focus:ring-blue-400" aria-label="Novo Cliente">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="#fff2"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8" />
            </svg>
            <span class="font-bold">Novo Cliente</span>
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 fade-in-up">
        <div class="bg-[#23232b]/80 rounded-2xl p-6 shadow-lg border border-gray-800 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Total de Clientes</p>
                    <p class="text-2xl font-bold text-blue-300">{{ $clientes->count() }}</p>
                </div>
                <div class="p-3 bg-blue-900 rounded-full">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-[#23232b]/80 rounded-2xl p-6 shadow-lg border border-gray-800 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Clientes Ativos</p>
                    <p class="text-2xl font-bold text-green-300">{{ $clientes->where('is_active', true)->count() }}</p>
                </div>
                <div class="p-3 bg-green-900 rounded-full">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-[#23232b]/80 rounded-2xl p-6 shadow-lg border border-gray-800 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Com Foto</p>
                    <p class="text-2xl font-bold text-purple-300">{{ $clientes->whereNotNull('photo')->count() }}</p>
                </div>
                <div class="p-3 bg-purple-900 rounded-full">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-[#23232b]/80 rounded-2xl p-6 shadow-lg border border-gray-800 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Empresas</p>
                    <p class="text-2xl font-bold text-orange-300">{{ $clientes->whereNotNull('company')->count() }}</p>
                </div>
                <div class="p-3 bg-orange-900 rounded-full">
                    <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

        <!-- Clients Grid -->
        @if($clientes->isEmpty())
            <div class="text-center py-16 fade-in-up" style="animation-delay: 0.3s;">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Nenhum cliente encontrado</h3>
                <p class="text-gray-600 mb-6">Comece criando seu primeiro cliente para organizar seus contatos.</p>
                <a href="{{ route('clientes.create') }}" 
                   class="btn-gradient text-white px-6 py-3 rounded-full font-semibold shadow-lg">
                    Criar Primeiro Cliente
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($clientes as $cliente)
                    <div class="client-card bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden group fade-in-up transition-transform duration-200 hover:-translate-y-2 hover:shadow-2xl">
                        <!-- Client Photo Header -->
                        <div class="relative h-32 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center photo-container">
                            @if($cliente->photo)
                                <img src="{{ Storage::url($cliente->photo) }}" 
                                     alt="Foto de {{ $cliente->name }}" 
                                     class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-lg">
                            @else
                                <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center border-4 border-white shadow-lg">
                                    <svg class="w-10 h-10 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Status Badge -->
                            <div class="absolute top-3 right-3">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold {{ $cliente->is_active ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}" aria-label="Status do cliente">
                                    {{ $cliente->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </div>
                        </div>

                        <!-- Client Info -->
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">
                                {{ $cliente->name }}
                            </h3>
                            
                            <div class="space-y-2 text-sm text-gray-600">
                                @if($cliente->email)
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="truncate">{{ $cliente->email }}</span>
                                    </div>
                                @endif
                                
                                @if($cliente->phone)
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        <span>{{ $cliente->phone }}</span>
                                    </div>
                                @endif
                                
                                @if($cliente->company)
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <span class="truncate">{{ $cliente->company }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-100">
                                <a href="{{ route('clientes.show', $cliente->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center space-x-1 group-hover:underline">
                                    <span>Ver detalhes</span>
                                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                                
                                <div class="flex space-x-2">
                                    <a href="{{ route('clientes.edit', $cliente->id) }}" 
                                       class="p-2 text-yellow-600 hover:text-yellow-800 hover:bg-yellow-50 rounded-full transition-colors" title="Editar cliente" aria-label="Editar cliente">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
// Search functionality
document.getElementById('search').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.client-card');
    
    cards.forEach(card => {
        const name = card.querySelector('h3').textContent.toLowerCase();
        const email = card.querySelector('.text-gray-600')?.textContent.toLowerCase() || '';
        const company = card.querySelectorAll('.text-gray-600')[1]?.textContent.toLowerCase() || '';
        
        if (name.includes(searchTerm) || email.includes(searchTerm) || company.includes(searchTerm)) {
            card.style.display = 'block';
            card.style.animation = 'fadeInUp 0.3s ease-out';
        } else {
            card.style.display = 'none';
        }
    });
});

// Add stagger animation to cards
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.client-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${0.3 + (index * 0.1)}s`;
    });
});
</script>
@endsection 