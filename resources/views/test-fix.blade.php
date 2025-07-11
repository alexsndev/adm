@extends('layouts.app')

@section('content')
<div class="test-page">
    <div class="test-header">
        <h1>🔧 Layout Corrigido</h1>
        <p>Teste do layout simplificado e funcional</p>
    </div>
    
    <div class="test-content">
        <div class="info-card">
            <h2>✅ Layout Funcionando</h2>
            <p>O layout foi simplificado e corrigido para evitar bugs.</p>
        </div>
        
        <div class="info-card">
            <h2>📱 Responsivo</h2>
            <ul>
                <li><strong>Desktop:</strong> Header visível, conteúdo com padding normal</li>
                <li><strong>Mobile:</strong> Header oculto, bottom nav visível</li>
                <li><strong>Conteúdo:</strong> Nunca sobreposto por elementos fixos</li>
            </ul>
        </div>
        
        <div class="info-card">
            <h2>🎯 Como Usar</h2>
            <pre><code>@extends('layouts.app')

@section('content')
    Seu conteúdo aqui
@endsection</code></pre>
        </div>
    </div>
    
    <!-- Conteúdo para testar scroll -->
    @for($i = 1; $i <= 10; $i++)
        <div class="test-section">
            <h3>Seção {{ $i }}</h3>
            <p>Esta é a seção {{ $i }} para testar o scroll e verificar se o layout permanece estável.</p>
        </div>
    @endfor
</div>

<style>
.test-page {
    max-width: 800px;
    margin: 0 auto;
}

.test-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 32px;
    border-radius: 16px;
    margin-bottom: 24px;
    text-align: center;
}

.test-header h1 {
    font-size: 28px;
    margin-bottom: 8px;
}

.test-header p {
    opacity: 0.9;
}

.test-content {
    display: grid;
    gap: 20px;
    margin-bottom: 24px;
}

.info-card {
    background: white;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.info-card h2 {
    color: #1f2937;
    margin-bottom: 16px;
    font-size: 20px;
}

.info-card ul {
    padding-left: 20px;
    margin-top: 12px;
}

.info-card li {
    margin-bottom: 8px;
    color: #4b5563;
}

.info-card pre {
    background: #1f2937;
    color: #e5e7eb;
    padding: 16px;
    border-radius: 8px;
    overflow-x: auto;
    font-size: 14px;
    margin-top: 12px;
}

.test-section {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 16px;
}

.test-section h3 {
    color: #374151;
    margin-bottom: 12px;
}

.test-section p {
    color: #6b7280;
}

@media (max-width: 768px) {
    .test-header {
        padding: 24px 16px;
    }
    
    .test-header h1 {
        font-size: 24px;
    }
    
    .info-card {
        padding: 20px 16px;
    }
}
</style>
@endsection 