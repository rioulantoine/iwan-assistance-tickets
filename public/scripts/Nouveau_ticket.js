function ouvrirModalListeEntreprises(){
    const modal = document.getElementById('modalListeEntreprises');
    modal.style.display = 'flex';

    const inputRecherche = modal.querySelector('.search-wrapper input[name="recherche"]');
    if (inputRecherche) {
        setTimeout(() => {
            inputRecherche.focus();
            // Petite astuce pour mettre le curseur tout à la fin du texte après le rechargement PHP
            const valeur = inputRecherche.value;
            inputRecherche.value = '';
            inputRecherche.value = valeur;
        }, 50);
    }
}

function fermerModalListeEntreprises(event){
    const modal = document.getElementById('modalListeEntreprises');
    if (event.target === modal) modal.style.display = 'none';
}

// ==========================================================================
// REDIMENSIONNEMENT DES TEXTAREAS (TICKET & SUIVI)
// ==========================================================================
function ajusterHauteurTextarea(el) {
    el.style.height = 'auto';
    el.style.height = el.scrollHeight + 'px';
}

document.addEventListener("DOMContentLoaded", function() {
    const zonesTexte = document.querySelectorAll('textarea');

    zonesTexte.forEach(textarea => {
        textarea.addEventListener('input', function() {
            ajusterHauteurTextarea(this);
        });
        ajusterHauteurTextarea(textarea);
    });
});

// ==========================================================================
// LE DOUBLE ENTRÉE MAGIQUE : FILTRE PUIS SÉLECTIONNE IMMÉDIATEMENT
// ==========================================================================
document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById('modalListeEntreprises');
    if (!modal) return;

    const inputRecherche = modal.querySelector('.search-wrapper input[name="recherche"]');
    
    if (inputRecherche) {
        inputRecherche.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                const lignes = modal.querySelectorAll('.table-liste-entreprises tbody tr');
                
                if (lignes.length === 1 && !lignes[0].querySelector('.pas-entreprise')) {
                    const btnSelectionner = lignes[0].querySelector('.btn-selectionner-entreprise');
                    
                    if (btnSelectionner) {
                        event.preventDefault(); // Bloque la recherche GET
                        
                        // FORCE LA FERMETURE VISUELLE IMMÉDIATE
                        modal.style.display = 'none'; 
                        
                        btnSelectionner.click(); // Envoie le formulaire POST à PHP
                    }
                }
            }
        });
    }
    
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('ouvrir_modal') === '1') {
        ouvrirModalListeEntreprises();
    }
});