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
