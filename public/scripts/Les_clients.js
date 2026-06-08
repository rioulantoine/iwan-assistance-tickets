// Fonction pour ouvrir le modal et pré-remplir les champs
function ouvrirModalEdition(bouton) {
    const modal = document.getElementById('modalEditionEntreprise');
    
    // Récupération des données via les attributs data-*
    document.getElementById('edit_id_client').value = bouton.getAttribute('data-id');
    document.getElementById('edit_nom_entreprise').value = bouton.getAttribute('data-entreprise');
    document.getElementById('edit_nom').value = bouton.getAttribute('data-nom');
    document.getElementById('edit_prenom').value = bouton.getAttribute('data-prenom');
    document.getElementById('edit_email').value = bouton.getAttribute('data-email');
    document.getElementById('edit_telephone').value = bouton.getAttribute('data-telephone');
    document.getElementById('edit_ville').value = bouton.getAttribute('data-ville');
    
    // Affichage du modal
    modal.style.display = 'flex';
}

// Fermeture forcée (bouton annuler ou croix)
function fermerModalEditionForce() {
    document.getElementById('modalEditionEntreprise').style.display = 'none';
}

// Fermeture en cliquant sur l'arrière-plan gris
function fermerModalEdition(event) {
    const modal = document.getElementById('modalEditionEntreprise');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}