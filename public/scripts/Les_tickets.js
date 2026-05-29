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



// Fonction pour vider le champ de date au clic sur la croix
function viderChampDate(idChamp) {
    const input = document.getElementById(idChamp);
    if (input) {
        input.value = ""; // On vide la date
        toggleCroixDate(input); // On masque la croix
    }
}

// Fonction pour afficher/masquer la croix dynamiquement
function toggleCroixDate(input) {
    const container = input.closest('.input-clearable-wrapper');
    if (container) {
        const btnClear = container.querySelector('.btn-clear-date');
        if (btnClear) {
            // Si le champ a une valeur, on affiche la croix, sinon on la cache
            if (input.value !== "") {
                btnClear.style.visibility = "visible";
                btnClear.style.opacity = "1";
            } else {
                btnClear.style.visibility = "hidden";
                btnClear.style.opacity = "0";
            }
        }
    }
}

// Au chargement de la page et lors des changements, on gère l'état initial des croix
document.addEventListener("DOMContentLoaded", function() {
    const inputsDate = [document.getElementById('date_debut'), document.getElementById('date_fin')];
    
    inputsDate.forEach(input => {
        if (input) {
            // Init au chargement de la page (si filtres déjà appliqués)
            toggleCroixDate(input);
            
            // Écouteur pour dès que l'utilisateur modifie la date
            input.addEventListener('input', function() {
                toggleCroixDate(this);
            });
        }
    });
});

