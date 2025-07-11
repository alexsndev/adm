@extends('layouts.app')

@section('content')
<div class="simple-test">
    <h1>✅ Layout Funcionando!</h1>
    <p>Esta página usa o layout correto com @extends e @section.</p>
    
    <div class="test-box">
        <h2>Teste de Conteúdo</h2>
        <p>Verifique se:</p>
        <ul>
            <li>✅ O header está visível no desktop</li>
            <li>✅ O conteúdo não é sobreposto</li>
            <li>✅ A bottom navigation aparece no mobile</li>
            <li>✅ Tudo está responsivo</li>
        </ul>
    </div>
    
    <div class="info-box">
        <h3>Como usar este layout:</h3>
        <pre><code>@extends('layouts.app')

@section('content')
    Seu conteúdo aqui
@endsection</code></pre>
    </div>
</div>

<style>
.simple-test {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.simple-test h1 {
    color: #10b981;
    text-align: center;
    margin-bottom: 20px;
}

.test-box {
    background: white;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.test-box h2 {
    color: #1f2937;
    margin-bottom: 16px;
}

.test-box ul {
    padding-left: 20px;
}

.test-box li {
    margin-bottom: 8px;
    color: #4b5563;
}

.info-box {
    background: #f3f4f6;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #3b82f6;
}

.info-box h3 {
    color: #1f2937;
    margin-bottom: 12px;
}

.info-box pre {
    background: #1f2937;
    color: #e5e7eb;
    padding: 16px;
    border-radius: 6px;
    overflow-x: auto;
    font-size: 14px;
}

.info-box code {
    font-family: 'Courier New', monospace;
}
</style>
@endsection 