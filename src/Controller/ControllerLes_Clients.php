<?php
// ControllerLes_clients.php
require_once __DIR__ . '/../Model/ModelLes_Clients.php';
$liste_logiciels = get_liste_logiciels();
// Logique de gestion de la section des entreprises et de sa pagination
$recherche = trim($_GET['recherche'] ?? '');

// On s'assure que la page est au moins à 1
$page_entreprise = max(1, (int)($_GET['page_entreprise'] ?? 1));
$limite = 15; // LIMITE DU NOMBRE DE CLIENT PAR PAGE 
$offset = ($page_entreprise - 1) * $limite;

// Récupération des données pour le tableau (avec LIMIT et OFFSET)
$liste_entreprises = obtenir_entreprises_filtres_pagine($recherche, $limite, $offset);
$total_entreprises = compter_entreprises_filtres($recherche);
$total_pages       = ceil($total_entreprises / $limite);
$nb_entreprises    = count($liste_entreprises);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'modifier_entreprise') {

    $id_client = trim($_POST['id_client'] ?? '');
    $nom_entreprise = trim($_POST['nom_entreprise'] ?? '');
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $id_logiciel = trim($_POST['id_logiciel'] ?? ''); // CORRECTION : On récupère l'ID envoyé par le select
    $cp = trim($_POST['cp'] ?? '');
    $ville = trim($_POST['ville'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $observation = trim($_POST['observation'] ?? '');

    if (!empty($id_client) && !empty($nom_entreprise)) {
        // Envoi de $id_logiciel à la fonction
        $succes = modifier_entreprise_par_id($id_client, $nom_entreprise, $id_logiciel, $nom, $prenom, $cp, $ville, $email, $telephone, $observation);

        if ($succes) {
            $_SESSION['flash_message'] = "Les modifications ont été enregistrées avec succès.";
            $_SESSION['flash_type']    = "success";
        } else {
            $_SESSION['flash_message'] = "Une erreur est survenue lors de la mise à jour en base de données.";
            $_SESSION['flash_type']    = "error";
        }
    } else {
        $_SESSION['flash_message'] = "Veuillez remplir tous les champs obligatoires.";
        $_SESSION['flash_type']    = "error";
    }

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

require_once __DIR__ . '/../View/Les_clients.php';
