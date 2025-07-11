<nav class="fixed bottom-0 left-0 right-0 z-50 bg-gray-900 shadow-2xl border-t border-gray-800 flex justify-around items-center h-16 px-1 md:hidden">
    @php
        $items = [
            [
                'label' => 'Dashboard',
                'icon' => 'fa-house',
                'route' => 'dashboard',
            ],
            [
                'label' => 'Finanças',
                'icon' => 'fa-coins',
                'dropdown' => [
                    ['label' => 'Resumo', 'icon' => 'fa-chart-pie', 'route' => 'finance.dashboard'],
                    ['label' => 'Contas', 'icon' => 'fa-wallet', 'route' => 'accounts.index'],
                    ['label' => 'Transações', 'icon' => 'fa-arrow-right-arrow-left', 'route' => 'transactions.index'],
                    ['label' => 'Cartões', 'icon' => 'fa-credit-card', 'route' => 'credit-cards.index'],
                    ['label' => 'Dívidas', 'icon' => 'fa-money-bill-trend-up', 'route' => 'debts.index'],
                ],
            ],
            [
                'label' => 'Eventos',
                'icon' => 'fa-calendar-days',
                'route' => 'events.index',
            ],
            [
                'label' => 'Casa',
                'icon' => 'fa-house-chimney',
                'route' => 'household-tasks.dashboard',
            ],
            [
                'label' => 'Profissional',
                'icon' => 'fa-briefcase',
                'route' => 'projetos.index',
            ],
        ];
        $current = Route::currentRouteName();
    @endphp
    @foreach($items as $i => $item)
        @if(isset($item['dropdown']))
            <div class="relative flex-1 flex flex-col items-center justify-center">
                <button type="button"
                    class="group flex flex-col items-center justify-center w-full h-full transition relative text-gray-300 hover:text-blue-300 focus:outline-none"
                    aria-label="{{ $item['label'] }}"
                    onclick="toggleBottomDropdown('bottom-dropdown-{{ $i }}', event)">
                    <span class="flex items-center justify-center w-10 h-10 rounded-full transition-all duration-200 group-hover:bg-gray-800/80">
                        <i class="fa-solid {{ $item['icon'] }} text-xl"></i>
                    </span>
                    <span class="text-xs mt-1 font-medium tracking-tight">{{ $item['label'] }}</span>
                </button>
                <div id="bottom-dropdown-{{ $i }}" class="bottom-dropdown-menu hidden absolute bottom-16 left-1/2 -translate-x-1/2 bg-gray-900 border border-gray-700 shadow-2xl rounded-xl flex-nowrap flex-row gap-1 px-2 py-2 z-50 animate-fade-in flex overflow-x-auto no-scrollbar">
                    @foreach($item['dropdown'] as $sub)
                        <a href="{{ route($sub['route']) }}" class="flex flex-col items-center px-3 py-2 rounded-lg hover:bg-blue-800/70 transition text-gray-200 hover:text-white text-xs font-medium whitespace-nowrap">
                            <i class="fa-solid {{ $sub['icon'] }} text-lg mb-1"></i>
                            <span>{{ $sub['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <a href="{{ route($item['route']) }}"
               class="group flex flex-col items-center justify-center flex-1 h-full transition relative {{ $current === $item['route'] ? 'text-blue-400' : 'text-gray-300 hover:text-blue-300' }}"
               aria-label="{{ $item['label'] }}">
                <span class="flex items-center justify-center w-10 h-10 rounded-full transition-all duration-200 {{ $current === $item['route'] ? 'bg-blue-900/60 shadow-lg scale-110' : 'group-hover:bg-gray-800/80' }}">
                    <i class="fa-solid {{ $item['icon'] }} text-xl"></i>
                </span>
                <span class="text-xs mt-1 font-medium tracking-tight transition-all duration-200 {{ $current === $item['route'] ? 'text-blue-400' : 'text-gray-400 group-hover:text-blue-300' }}">
                    {{ $item['label'] }}
                </span>
            </a>
        @endif
    @endforeach
</nav>

<style>
nav.fixed.bottom-0 {
    backdrop-filter: blur(6px);
}
.bottom-dropdown-menu {
    min-width: 180px;
    max-width: 95vw;
    box-shadow: 0 8px 32px 0 rgba(0,0,0,0.25);
    animation: fadeIn 0.18s;
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    overflow-x: auto;
    overflow-y: hidden;
    white-space: nowrap;
    scrollbar-width: none;
}
.bottom-dropdown-menu::-webkit-scrollbar {
    display: none;
}
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px) scale(0.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
@media (max-width: 400px) {
    nav.fixed.bottom-0 span.text-xs { font-size: 0.7rem; }
    nav.fixed.bottom-0 .w-10 { width: 2.2rem; height: 2.2rem; }
    .bottom-dropdown-menu { min-width: 120px; }
}
</style>
<script>
function toggleBottomDropdown(id, event) {
    event.stopPropagation();
    document.querySelectorAll('.bottom-dropdown-menu').forEach(menu => menu.classList.add('hidden'));
    const dropdown = document.getElementById(id);
    if (dropdown) {
        dropdown.classList.toggle('hidden');
    }
}
document.addEventListener('click', function() {
    document.querySelectorAll('.bottom-dropdown-menu').forEach(menu => menu.classList.add('hidden'));
});
</script> 