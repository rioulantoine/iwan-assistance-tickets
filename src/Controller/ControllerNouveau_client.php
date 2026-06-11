<?php
// ControllerNouveau_client.php

if (!isset($_SESSION['is_admin']) && !isset($_SESSION['id_client'])) {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/../Model/ModelNouveau_Client.php';
$liste_logiciels = get_liste_logiciels_nouveau_client();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_client = trim($_POST['id_client'] ?? '');
    $nom_entreprise = trim($_POST['nom_entreprise'] ?? '');
    $code_postal = trim($_POST['cp'] ?? '');
    $ville = trim($_POST['ville'] ?? '');
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $logiciel = $_POST['id_logiciel'];
    $observation = trim($_POST['observation'] ?? '');

    $erreurs = [];

    // Vérification id client
    if (empty($id_client)) {
        $erreurs[] = "L'id client est obligatoire";
    }
    // Vérification nom entreprise
    if (empty($nom_entreprise)) {
        $erreurs[] = "Le nom de l'entreprise est obligatoire.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)  && !($_SESSION['is_admin'] ?? false)) {
        $erreurs[] = "L'email n'est pas valide.";
    }


    if (!empty($erreurs)) {
        $_SESSION['flash_message'] = implode('<br>', $erreurs);
        $_SESSION['flash_type'] = 'error';
    }
    $id_existant = verifier_id($id_client);
    if ($id_existant) {
        $_SESSION['flash_message'] = "L'id client existe déjà pour l'entreprise : $id_existant";
        $_SESSION['flash_type'] = 'error';
        header("Location: index.php?page=nouveau_client");
        exit();
    }
    if (empty($erreurs)) {
        inserer_nouveau_client(
            $id_client,
            $nom_entreprise,
            $code_postal,
            $ville,
            $nom,
            $prenom,
            $email,
            $telephone,
            $logiciel,
            $observation
        );
        header("Location: index.php?page=accueil");
        exit();
    }
}











require_once __DIR__ . '/../View/Nouveau_client.php';
