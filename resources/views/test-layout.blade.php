@extends('layouts.app')

@section('content')
<div class="test-container">
        <div class="test-header">
            <h1>🧪 Teste de Layout - Header e Conteúdo</h1>
            <p>Verificando se o conteúdo nunca é sobreposto pelo header</p>
        </div>
        
        <div class="test-section">
            <h2>✅ Características do Layout</h2>
            <ul class="feature-list">
                <li><strong>Header Fixo:</strong> Sempre visível no desktop, oculto no mobile</li>
                <li><strong>Espaço Reservado:</strong> Conteúdo nunca é sobreposto</li>
                <li><strong>Responsivo:</strong> Adapta-se a diferentes tamanhos de tela</li>
                <li><strong>Bottom Navigation:</strong> Apenas no mobile</li>
                <li><strong>Animações Suaves:</strong> Transições elegantes</li>
                <li><strong>Acessibilidade:</strong> Navegação por teclado</li>
            </ul>
        </div>
        
        <div class="test-section">
            <h2>📱 Teste de Responsividade</h2>
            <div class="responsive-info">
                <div class="info-card desktop">
                    <h3>Desktop (>768px)</h3>
                    <ul>
                        <li>Header visível (70px altura)</li>
                        <li>Conteúdo com margin-top: 70px</li>
                        <li>Bottom nav oculta</li>
                        <li>Padding: 24px</li>
                    </ul>
                </div>
                
                <div class="info-card mobile">
                    <h3>Mobile (≤768px)</h3>
                    <ul>
                        <li>Header oculto</li>
                        <li>Conteúdo com margin-top: 0</li>
                        <li>Bottom nav visível (64px altura)</li>
                        <li>Padding-bottom: 80px</li>
                        <li>Padding: 16px (12px em telas muito pequenas)</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="test-section">
            <h2>🎯 Áreas de Teste</h2>
            
            <div class="test-area">
                <h3>1. Área Superior</h3>
                <p>Esta área deve estar sempre visível e não sobreposta pelo header.</p>
                <div class="color-box top">Área Superior - Sempre Visível</div>
            </div>
            
            <div class="test-area">
                <h3>2. Área Central</h3>
                <p>Conteúdo central que deve ser totalmente acessível.</p>
                <div class="color-box center">Área Central - Totalmente Acessível</div>
            </div>
            
            <div class="test-area">
                <h3>3. Área Inferior</h3>
                <p>Esta área deve estar sempre visível e não sobreposta pela bottom navigation.</p>
                <div class="color-box bottom">Área Inferior - Sempre Visível</div>
            </div>
        </div>
        
        <div class="test-section">
            <h2>🔍 Como Testar</h2>
            <ol class="test-steps">
                <li><strong>Desktop:</strong> Verifique se o header está visível e o conteúdo começa abaixo dele</li>
                <li><strong>Mobile:</strong> Verifique se o header está oculto e a bottom nav está visível</li>
                <li><strong>Scroll:</strong> Role a página e verifique se o conteúdo nunca é sobreposto</li>
                <li><strong>Redimensionar:</strong> Mude o tamanho da janela e verifique a responsividade</li>
                <li><strong>Links:</strong> Teste os links do header e bottom navigation</li>
            </ol>
        </div>
        
        <!-- Conteúdo adicional para testar scroll -->
        @for($i = 1; $i <= 15; $i++)
            <div class="test-section">
                <h3>Seção de Teste {{ $i }}</h3>
                <p>Esta é a seção {{ $i }} para testar o scroll da página e verificar se o layout permanece consistente.</p>
                <div class="content-box">
                    <p>Conteúdo adicional para criar altura suficiente e testar o comportamento durante o scroll.</p>
                    <p>Verifique se esta seção está sempre visível e não é sobreposta por nenhum elemento fixo.</p>
                </div>
            </div>
        @endfor
        
        <div class="test-section final">
            <h2>🎉 Teste Concluído</h2>
            <p>Se você conseguiu ver todas as seções sem sobreposição, o layout está funcionando perfeitamente!</p>
            <div class="success-message">
                ✅ Layout responsivo funcionando corretamente<br>
                ✅ Conteúdo nunca sobreposto<br>
                ✅ Header e bottom navigation no lugar certo<br>
                ✅ Animações suaves e modernas
            </div>
        </div>
    </div>
@endsection

<style>
.test-container {
    max-width: 1200px;
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
    margin: 0 0 12px 0;
    font-size: 28px;
    font-weight: bold;
}

.test-header p {
    margin: 0;
    font-size: 16px;
    opacity: 0.9;
}

.test-section {
    background: white;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 24px;
}

.test-section h2 {
    color: #1f2937;
    margin: 0 0 16px 0;
    font-size: 20px;
    font-weight: 600;
}

.test-section h3 {
    color: #374151;
    margin: 0 0 12px 0;
    font-size: 16px;
    font-weight: 600;
}

.feature-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.feature-list li {
    padding: 8px 0;
    border-bottom: 1px solid #e5e7eb;
    color: #4b5563;
}

.feature-list li:last-child {
    border-bottom: none;
}

.feature-list li strong {
    color: #1f2937;
}

.responsive-info {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.info-card {
    padding: 20px;
    border-radius: 8px;
    border: 2px solid;
}

.info-card.desktop {
    background: #eff6ff;
    border-color: #3b82f6;
}

.info-card.mobile {
    background: #fef3c7;
    border-color: #f59e0b;
}

.info-card h3 {
    margin: 0 0 12px 0;
    font-size: 16px;
    font-weight: 600;
}

.info-card ul {
    margin: 0;
    padding-left: 20px;
    color: #4b5563;
}

.info-card li {
    margin-bottom: 4px;
}

.test-area {
    margin-bottom: 24px;
}

.color-box {
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    font-weight: 600;
    color: white;
    margin: 12px 0;
}

.color-box.top {
    background: linear-gradient(135deg, #10b981, #059669);
}

.color-box.center {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.color-box.bottom {
    background: linear-gradient(135deg, #8b5cf6, #7c3aed);
}

.test-steps {
    padding-left: 20px;
    color: #4b5563;
}

.test-steps li {
    margin-bottom: 8px;
}

.test-steps strong {
    color: #1f2937;
}

.content-box {
    background: #f9fafb;
    padding: 16px;
    border-radius: 8px;
    border-left: 4px solid #3b82f6;
}

.final {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    border: 2px solid #10b981;
}

.success-message {
    background: #10b981;
    color: white;
    padding: 16px;
    border-radius: 8px;
    text-align: center;
    font-weight: 500;
    line-height: 1.6;
}

@media (max-width: 768px) {
    .responsive-info {
        grid-template-columns: 1fr;
    }
    
    .test-header {
        padding: 24px 16px;
    }
    
    .test-header h1 {
        font-size: 24px;
    }
    
    .test-section {
        padding: 20px 16px;
    }
}

@media (max-width: 480px) {
    .test-header h1 {
        font-size: 20px;
    }
    
    .test-section {
        padding: 16px 12px;
    }
    
    .color-box {
        padding: 16px;
    }
}
</style> 