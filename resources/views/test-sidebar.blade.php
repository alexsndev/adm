@extends('layouts.app')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold text-white mb-6">Teste da Sidebar</h1>
    
    <div class="bg-gray-800 p-6 rounded-lg mb-6">
        <h2 class="text-xl font-semibold text-blue-300 mb-4">Status da Sidebar</h2>
        <div id="sidebar-status" class="text-green-400">Carregando...</div>
    </div>
    
    <div class="bg-gray-800 p-6 rounded-lg mb-6">
        <h2 class="text-xl font-semibold text-purple-300 mb-4">Teste de Botões</h2>
        <button onclick="testToggleSidebar()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mr-4">
            Testar Toggle Sidebar
        </button>
        <button onclick="checkSidebarStatus()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            Verificar Status
        </button>
    </div>
    
    <div class="bg-gray-800 p-6 rounded-lg">
        <h2 class="text-xl font-semibold text-yellow-300 mb-4">Log de Eventos</h2>
        <div id="event-log" class="text-gray-300 text-sm max-h-40 overflow-y-auto">
            <div>Página carregada...</div>
        </div>
    </div>
</div>

<script>
function logEvent(message) {
    const log = document.getElementById('event-log');
    const timestamp = new Date().toLocaleTimeString();
    log.innerHTML += `<div>[${timestamp}] ${message}</div>`;
    log.scrollTop = log.scrollHeight;
}

function checkSidebarStatus() {
    const sidebar = document.getElementById('side-nav');
    const status = document.getElementById('sidebar-status');
    
    if (!sidebar) {
        status.innerHTML = '<span class="text-red-400">❌ Sidebar não encontrada</span>';
        logEvent('Sidebar não encontrada');
        return;
    }
    
    const isCollapsed = sidebar.classList.contains('collapsed');
    const width = sidebar.offsetWidth;
    const isVisible = sidebar.style.display !== 'none';
    
    status.innerHTML = `
        <span class="text-green-400">✅ Sidebar encontrada</span><br>
        <span class="text-gray-300">Colapsada: ${isCollapsed ? 'Sim' : 'Não'}</span><br>
        <span class="text-gray-300">Largura: ${width}px</span><br>
        <span class="text-gray-300">Visível: ${isVisible ? 'Sim' : 'Não'}</span>
    `;
    
    logEvent(`Status verificado - Colapsada: ${isCollapsed}, Largura: ${width}px`);
}

function testToggleSidebar() {
    logEvent('Testando toggle da sidebar...');
    if (typeof toggleSidebar === 'function') {
        toggleSidebar();
        logEvent('Função toggleSidebar executada');
        setTimeout(checkSidebarStatus, 100);
    } else {
        logEvent('❌ Função toggleSidebar não encontrada');
    }
}

// Verificar status inicial
document.addEventListener('DOMContentLoaded', function() {
    logEvent('Página carregada');
    setTimeout(checkSidebarStatus, 500);
});
</script>
@endsection 