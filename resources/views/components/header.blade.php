<header class="site-header">
    <div class="header-container">
        <div class="header-logo">
            @php $user = Auth::user(); @endphp
            @if($user && $user->logo)
                <a href="/">
                    <img src="{{ Storage::url($user->logo) }}" alt="Logo" height="40" style="max-height:40px;max-width:120px;object-fit:contain;">
                </a>
            @else
                <a href="/">
                    <span style="font-size:2rem;color:#38bdf8;">🏷️</span>
                </a>
            @endif
        </div>
        <nav class="header-nav">
            <ul>
                <li><a href="/dashboard">Dashboard</a></li>
                <li><a href="/accounts">Contas</a></li>
                <li><a href="/transactions">Transações</a></li>
                <li><a href="/debts">Dívidas</a></li>
                <li><a href="/financial-goals">Metas</a></li>
                <!-- Adicione mais links conforme necessário -->
            </ul>
        </nav>
    </div>
</header> 