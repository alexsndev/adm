<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Bottom Navigation - HTML/CSS/JS Puro</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f3f4f6;
            color: #1f2937;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .test-section {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
        }
        
        .feature-list li {
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .feature-list li:last-child {
            border-bottom: none;
        }
        
        .feature-list li::before {
            content: "✅ ";
            margin-right: 8px;
        }
        
        .content-section {
            background: #f9fafb;
            padding: 16px;
            border-radius: 8px;
            margin: 16px 0;
        }
        
        h1 {
            color: #1f2937;
            margin: 0 0 16px 0;
        }
        
        h2 {
            color: #374151;
            margin: 0 0 12px 0;
        }
        
        h3 {
            color: #4b5563;
            margin: 0 0 8px 0;
        }
        
        p {
            color: #6b7280;
            line-height: 1.6;
            margin: 0 0 12px 0;
        }
        
        .success {
            background: #d1fae5;
            border: 1px solid #10b981;
            color: #065f46;
            padding: 12px;
            border-radius: 8px;
            margin: 16px 0;
        }
        
        .info {
            background: #dbeafe;
            border: 1px solid #3b82f6;
            color: #1e40af;
            padding: 12px;
            border-radius: 8px;
            margin: 16px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 Bottom Navigation - HTML/CSS/JS Puro</h1>
            <p>Teste da nova implementação sem dependências externas</p>
        </div>
        
        <div class="test-section">
            <h2>✨ Características da Nova Implementação</h2>
            <ul class="feature-list">
                <li>HTML semântico e limpo</li>
                <li>CSS puro com variáveis e animações</li>
                <li>JavaScript vanilla sem frameworks</li>
                <li>FontAwesome carregado via CDN</li>
                <li>Modais responsivos e acessíveis</li>
                <li>Animações suaves e modernas</li>
                <li>Design escuro consistente</li>
                <li>Funciona offline (exceto ícones)</li>
            </ul>
        </div>
        
        <div class="test-section">
            <h2>🧪 Como Testar</h2>
            <div class="content-section">
                <h3>1. Bottom Navigation</h3>
                <p>Role para baixo e veja a bottom navigation fixa na parte inferior da tela.</p>
            </div>
            
            <div class="content-section">
                <h3>2. Modais</h3>
                <p>Clique nos ícones: Finanças, Eventos, Casa, Profissional</p>
                <p>Cada um abre um modal com as opções correspondentes.</p>
            </div>
            
            <div class="content-section">
                <h3>3. Fechamento</h3>
                <p>Teste fechar os modais de 3 formas:</p>
                <ul>
                    <li>Clique no X no canto superior direito</li>
                    <li>Clique fora do modal (área escura)</li>
                    <li>Pressione a tecla ESC</li>
                </ul>
            </div>
            
            <div class="content-section">
                <h3>4. Links</h3>
                <p>Clique nos itens dentro dos modais para testar se os links funcionam.</p>
            </div>
        </div>
        
        <div class="success">
            <strong>✅ Vantagens desta abordagem:</strong>
            <ul>
                <li>Não depende de arquivos externos</li>
                <li>CSS inline não causa problemas de carregamento</li>
                <li>JavaScript simples e direto</li>
                <li>Funciona em qualquer ambiente</li>
                <li>Fácil de manter e modificar</li>
            </ul>
        </div>
        
        <div class="info">
            <strong>ℹ️ Informações:</strong>
            <p>Esta implementação usa apenas HTML, CSS e JavaScript puro. O FontAwesome é carregado via CDN para os ícones, mas tem fallback caso não carregue.</p>
        </div>
        
        <!-- Conteúdo para testar scroll -->
        @for($i = 1; $i <= 20; $i++)
            <div class="test-section">
                <h3>Seção de Teste {{ $i }}</h3>
                <p>Esta é a seção {{ $i }} para testar o scroll da página e verificar se a bottom navigation permanece fixa na parte inferior.</p>
                <div class="content-section">
                    <p>Conteúdo adicional para criar altura suficiente e testar o comportamento da navegação durante o scroll.</p>
                </div>
            </div>
        @endfor
    </div>
    
    <!-- Inclui a nova bottom navigation -->
    @include('components.bottom-nav')
</body>
</html> 