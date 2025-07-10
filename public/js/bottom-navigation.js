// Bottom Navigation Dropdown Manager
document.addEventListener('DOMContentLoaded', function() {
    
    // Função para posicionar dropdowns inteligentemente
    function positionDropdown(dropdown, button) {
        const buttonRect = button.getBoundingClientRect();
        const dropdownHeight = dropdown.offsetHeight;
        const viewportHeight = window.innerHeight;
        const spaceAbove = buttonRect.top;
        const spaceBelow = viewportHeight - buttonRect.bottom;
        
        // Reset classes de posicionamento
        dropdown.classList.remove('bottom-16', 'top-16', 'left-0', 'left-1/2', 'right-0', '-translate-x-1/2');
        
        // Determinar posição vertical
        if (spaceAbove >= dropdownHeight + 10) {
            // Tem espaço acima - posicionar para cima
            dropdown.classList.add('bottom-16');
        } else {
            // Não tem espaço acima - posicionar para baixo
            dropdown.classList.add('top-16');
        }
        
        // Determinar posição horizontal baseada no botão
        const buttonIndex = Array.from(button.parentElement.parentElement.children).indexOf(button.parentElement);
        const totalButtons = button.parentElement.parentElement.children.length;
        
        if (buttonIndex === 0) {
            // Primeiro botão - alinhar à esquerda
            dropdown.classList.add('left-0');
        } else if (buttonIndex === totalButtons - 1) {
            // Último botão - alinhar à direita
            dropdown.classList.add('right-0');
        } else {
            // Botões do meio - centralizar
            dropdown.classList.add('left-1/2', '-translate-x-1/2');
        }
    }

    // Dropdown logic com posicionamento inteligente
    document.querySelectorAll('.nav-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            
            // Fecha todos os outros dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.add('hidden');
            });
            
            // Abre o dropdown correspondente
            const dropdown = document.getElementById(this.dataset.dropdown);
            if (dropdown && dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
                // Posiciona o dropdown inteligentemente
                setTimeout(() => positionDropdown(dropdown, this), 10);
            } else if (dropdown) {
                dropdown.classList.add('hidden');
            }
        });
    });

    // Fecha dropdown ao clicar fora
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.nav-btn') && !e.target.closest('.dropdown-menu')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });

    // Reposiciona dropdowns quando a janela é redimensionada
    window.addEventListener('resize', function() {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (!menu.classList.contains('hidden')) {
                const button = document.querySelector(`[data-dropdown="${menu.id}"]`);
                if (button) {
                    positionDropdown(menu, button);
                }
            }
        });
    });

    // Reposiciona dropdowns quando o scroll da página muda
    window.addEventListener('scroll', function() {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (!menu.classList.contains('hidden')) {
                const button = document.querySelector(`[data-dropdown="${menu.id}"]`);
                if (button) {
                    positionDropdown(menu, button);
                }
            }
        });
    });

    // Fecha dropdowns quando a orientação do dispositivo muda
    window.addEventListener('orientationchange', function() {
        setTimeout(() => {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.add('hidden');
            });
        }, 100);
    });

    // Previne que dropdowns sejam cortados pela tela
    function ensureDropdownVisibility(dropdown) {
        const rect = dropdown.getBoundingClientRect();
        const viewportWidth = window.innerWidth;
        const viewportHeight = window.innerHeight;
        
        // Ajustar posição horizontal se necessário
        if (rect.right > viewportWidth) {
            dropdown.style.right = '0';
            dropdown.style.left = 'auto';
            dropdown.style.transform = 'none';
        }
        
        if (rect.left < 0) {
            dropdown.style.left = '0';
            dropdown.style.right = 'auto';
            dropdown.style.transform = 'none';
        }
        
        // Ajustar posição vertical se necessário
        if (rect.bottom > viewportHeight) {
            dropdown.classList.remove('bottom-16');
            dropdown.classList.add('top-16');
        }
        
        if (rect.top < 0) {
            dropdown.classList.remove('top-16');
            dropdown.classList.add('bottom-16');
        }
    }

    // Aplica verificação de visibilidade aos dropdowns abertos
    document.addEventListener('click', function(e) {
        if (e.target.closest('.nav-btn')) {
            setTimeout(() => {
                const dropdown = document.querySelector('.dropdown-menu:not(.hidden)');
                if (dropdown) {
                    ensureDropdownVisibility(dropdown);
                }
            }, 50);
        }
    });
}); 