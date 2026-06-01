// Tri des colonnes du tableau
document.querySelectorAll('th.sortable').forEach(th => {
    th.addEventListener('click', function () {
        const col          = this.dataset.col;
        const currentOrder = parseInt(this.dataset.order || '0');
        const newOrder     = currentOrder === 1 ? 2 : 1;
        const params       = new URLSearchParams(window.location.search);
        params.set('tri_col', col);
        params.set('tri_ordre', newOrder);
        window.location.href = '?' + params.toString();
    });
});

// Met à jour les icônes au chargement selon l'URL
const urlParams    = new URLSearchParams(window.location.search);
const currentCol   = urlParams.get('tri_col');
const currentOrdre = parseInt(urlParams.get('tri_ordre') || '0');

document.querySelectorAll('th.sortable').forEach(th => {
    const icon = th.querySelector('.sort-icon');
    if (th.dataset.col === currentCol) {
        icon.textContent = currentOrdre === 2 ? '▼' : '▲';
        th.classList.add('active');
    } else {
        icon.textContent = '—';
        th.classList.remove('active');
    }
});

// Fonction pour vider le champ de date au clic sur la croix
function viderChampDate(idChamp) {
    const input = document.getElementById(idChamp);
    if (input) {
        input.value = "";
        input.classList.add('empty-date');
        toggleCroixDate(input);
    }
}

// Fonction pour afficher/masquer la croix dynamiquement
function toggleCroixDate(input) {
    const container = input.closest('.input-clearable-wrapper');
    if (container) {
        const btnClear = container.querySelector('.btn-clear-date');
        if (btnClear) {
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

// Fonction pour gérer la classe empty-date (masque la date par défaut sur Safari)
function gererDateVide(input) {
    if (!input.value) {
        input.classList.add('empty-date');
    } else {
        input.classList.remove('empty-date');
    }
}

// Un seul DOMContentLoaded qui gère tout
document.addEventListener("DOMContentLoaded", function () {
    const inputsDate = [document.getElementById('date_debut'), document.getElementById('date_fin')];

    inputsDate.forEach(input => {
        if (input) {
            if (!input.getAttribute('value')) {
                input.value = '';
            }

            gererDateVide(input);
            toggleCroixDate(input);

            input.addEventListener('input', function () {
                toggleCroixDate(this);
                gererDateVide(this);
            });

            input.addEventListener('change', function () {
                toggleCroixDate(this);
                gererDateVide(this);
            });
        }
    });
});