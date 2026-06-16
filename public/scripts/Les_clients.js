function ouvrirModalEdition(bouton) {
    const modal = document.getElementById('modalEditionEntreprise');
    const nomEntreprise = bouton.getAttribute('data-entreprise');
    const id = bouton.getAttribute('data-id'); // On stocke l'ID dans une variable pour s'en servir plusieurs fois

    document.getElementById('badge_nom_entreprise').innerText = nomEntreprise;
    document.getElementById('edit_id_client').value = id;
    document.getElementById('edit_identifiant_client').value = id;
    document.getElementById('edit_nom_entreprise').value = nomEntreprise;
    document.getElementById('edit_nom').value = bouton.getAttribute('data-nom');
    document.getElementById('edit_prenom').value = bouton.getAttribute('data-prenom');
    
    document.getElementById('edit_logiciel').value = bouton.getAttribute('data-id-logiciel');
    
    document.getElementById('edit_cp').value = bouton.getAttribute('data-cp');
    document.getElementById('edit_ville').value = bouton.getAttribute('data-ville');
    document.getElementById('edit_email').value = bouton.getAttribute('data-email');
    document.getElementById('edit_telephone').value = bouton.getAttribute('data-telephone');
    document.getElementById('edit_observation').value = bouton.getAttribute('data-observation');
    
    const lienSuppression = document.getElementById('lien_supprimer_client');
    if (lienSuppression) {
        lienSuppression.href = "index.php?page=supprimer_client&client=" + id;
    }

    modal.style.display = 'flex';
}

function fermerModalEditionForce() {
    document.getElementById('modalEditionEntreprise').style.display = 'none';
}

function fermerModalEdition(event) {
    const modal = document.getElementById('modalEditionEntreprise');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}

