document.querySelectorAll('th.sortable').forEach(th => {
    th.addEventListener('click', function () {
        const col          = this.dataset.col;
        const currentOrder = parseInt(this.dataset.order || '0');
        const newOrder     = currentOrder === 1 ? 2 : 1;

        const params = new URLSearchParams(window.location.search);
        params.set('tri_col', col);
        params.set('tri_ordre', newOrder);

        window.location.href = '?' + params.toString();
    });
});

// Met à jour les icônes au chargement selon l'URL
const urlParams = new URLSearchParams(window.location.search);
const currentCol    = urlParams.get('tri_col');
const currentOrdre  = parseInt(urlParams.get('tri_ordre') || '0');

document.querySelectorAll('th.sortable').forEach(th => {
    const icon = th.querySelector('.sort-icon');
    if (th.dataset.col === currentCol) {
        // Colonne active : flèche haut ou bas
        icon.textContent = currentOrdre === 2 ? '▼' : '▲';
        th.classList.add('active');
    } else {
        // Colonne inactive : tiret horizontal
        icon.textContent = '—';
        th.classList.remove('active');
    }
});