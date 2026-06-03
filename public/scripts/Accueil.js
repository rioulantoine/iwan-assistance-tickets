document.querySelectorAll('.filtre button').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filtre button').forEach(b => b.classList.remove('actif'));
        btn.classList.add('actif');
    });
});