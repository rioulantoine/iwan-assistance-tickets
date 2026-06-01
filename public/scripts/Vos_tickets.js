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

