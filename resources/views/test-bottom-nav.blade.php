<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Bottom Navigation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Teste da Bottom Navigation</h1>
        
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Instruções de Teste</h2>
            <ul class="list-disc list-inside space-y-2 text-gray-700">
                <li>Clique nos ícones da bottom navigation para abrir o menu de tela completa</li>
                <li>Teste todos os menus: Finanças, Eventos, Casa, Profissional</li>
                <li>Verifique se o menu abre corretamente com as opções</li>
                <li>Teste fechar clicando no X, clicando fora ou pressionando ESC</li>
                <li>Verifique se o scroll do body é bloqueado quando o menu está aberto</li>
                <li>Teste a responsividade em diferentes tamanhos de tela</li>
            </ul>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Conteúdo de Teste</h2>
            <p class="text-gray-700 mb-4">
                Este é um conteúdo de teste para verificar se a bottom navigation está funcionando corretamente.
                Role a página para baixo e teste os menus da bottom navigation.
            </p>
            
            <!-- Conteúdo adicional para testar scroll -->
            @for($i = 1; $i <= 20; $i++)
                <div class="bg-gray-50 rounded p-4 mb-4">
                    <h3 class="font-semibold text-gray-800">Seção de Teste {{ $i }}</h3>
                    <p class="text-gray-600">Esta é a seção {{ $i }} para testar o scroll da página.</p>
                </div>
            @endfor
        </div>
    </div>
    
    <!-- Inclui a bottom navigation -->
    @include('components.bottom-nav')
</body>
</html> 