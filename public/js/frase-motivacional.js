// Frase motivacional animada
(function() {
    var frases = window.frasesMotivacionais || [];
    var el = document.getElementById('frase-motivacional');
    if (!el || !frases.length) return;
    var fraseIndex = 0;
    function typeWriter(frase, i) {
        i = i || 0;
        if (i <= frase.length) {
            el.textContent = frase.slice(0, i);
            setTimeout(function() { typeWriter(frase, i + 1); }, 30);
        } else {
            setTimeout(function() { eraseWriter(frase); }, 2500);
        }
    }
    function eraseWriter(frase, i) {
        if (i === undefined) i = frase.length;
        if (i >= 0) {
            el.textContent = frase.slice(0, i);
            setTimeout(function() { eraseWriter(frase, i - 1); }, 10);
        } else {
            fraseIndex = (fraseIndex + 1) % frases.length;
            setTimeout(function() { typeWriter(frases[fraseIndex]); }, 300);
        }
    }
    typeWriter(frases[fraseIndex]);
})();

// Ajuste dinâmico do padding-top do conteúdo
(function() {
    function ajustarPadding() {
        var header = document.querySelector('header');
        var barra = document.querySelector('.barra-motivacional');
        var mainContainer = document.querySelector('.main-content-padding');
        if (!header || !mainContainer) return;
        var headerH = header.offsetHeight || 0;
        var barraH = barra ? barra.offsetHeight : 0;
        mainContainer.style.paddingTop = (headerH + barraH) + 'px';
    }
    window.addEventListener('resize', ajustarPadding);
    document.addEventListener('DOMContentLoaded', ajustarPadding);
    setTimeout(ajustarPadding, 100); // fallback para garantir
})(); 