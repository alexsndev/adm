<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Bottom Navigation - Nova Versão</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Teste da Nova Bottom Navigation</h1>
        
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Nova Abordagem - Modais Simples</h2>
            <ul class="list-disc list-inside space-y-2 text-gray-700">
                <li>✅ Modais individuais para cada seção</li>
                <li>✅ JavaScript simples e direto</li>
                <li>✅ Sem complexidade de JSON parsing</li>
                <li>✅ Rotas diretas do Laravel</li>
                <li>✅ Design consistente e moderno</li>
            </ul>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Como Testar</h2>
            <ol class="list-decimal list-inside space-y-2 text-gray-700">
                <li>Clique nos ícones da bottom navigation (Finanças, Eventos, Casa, Profissional)</li>
                <li>Verifique se os modais abrem corretamente</li>
                <li>Teste fechar clicando no X, clicando fora ou pressionando ESC</li>
                <li>Verifique se os links funcionam corretamente</li>
                <li>Teste a responsividade em mobile</li>
            </ol>
        </div>
        
        <!-- Conteúdo para testar scroll -->
        @for($i = 1; $i <= 15; $i++)
            <div class="bg-white rounded-lg shadow p-4 mb-4">
                <h3 class="font-semibold text-gray-800">Seção {{ $i }}</h3>
                <p class="text-gray-600">Conteúdo de teste para verificar o comportamento da bottom navigation.</p>
            </div>
        @endfor
    </div>
    
    <!-- Inclui a nova bottom navigation -->
    @include('components.bottom-nav')
</body>
</html> 