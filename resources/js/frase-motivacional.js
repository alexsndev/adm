document.addEventListener('DOMContentLoaded', function() {
    const frases = window.frasesMotivacionais || [];
    const el = document.getElementById('frase-motivacional');
    if (!el || !frases.length) return;
    let fraseIndex = 0;
    let typing = true;

    function typeWriter(frase, i = 0) {
        if (i <= frase.length) {
            el.textContent = frase.slice(0, i);
            setTimeout(() => typeWriter(frase, i + 1), 30);
        } else {
            typing = false;
            setTimeout(() => eraseWriter(frase), 2500);
        }
    }

    function eraseWriter(frase, i = null) {
        if (i === null) i = frase.length;
        if (i >= 0) {
            el.textContent = frase.slice(0, i);
            setTimeout(() => eraseWriter(frase, i - 1), 10);
        } else {
            fraseIndex = (fraseIndex + 1) % frases.length;
            typing = true;
            setTimeout(() => typeWriter(frases[fraseIndex]), 300);
        }
    }

    // Iniciar animação
    typeWriter(frases[fraseIndex]);
}); 