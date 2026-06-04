<?php
// ControllerNouveau_client.php

if (!isset($_SESSION['is_admin']) && !isset($_SESSION['id_client'])) {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/../Model/ModelNouveau_client.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_client = trim($_POST['id_client'] ?? '');
    $nom_entreprise = trim($_POST['nom_entreprise'] ?? '');
    $code_postal = trim($_POST['cp'] ?? '');
    $ville = trim($_POST['ville'] ?? '');
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $observation = trim($_POST['observation'] ?? '');

    $erreurs = [];

    // Vérification id client
    if (empty($id_client)) {
        $erreur[] = "L'id client est obligatoire";
    }
    // Vérification nom entreprise
    if (empty($nom_entreprise)) {
        $erreurs[] = "Le nom de l'entreprise est obligatoire.";
    }
    // Vérification code postal
    if (empty($code_postal)) {
        $erreurs[] = "Le code postal est obligatoire.";
    }
    // Vérification ville
    if (empty($ville)) {
        $erreurs[] = "La ville est obligatoire.";
    }
    // Vérification nom
    if (empty($nom)) {
        $erreurs[] = "Le nom est obligatoire.";
    }
    // Vérification prénom
    if (empty($prenom)) {
        $erreurs[] = "Le prénom est obligatoire.";
    }
    // Vérification email
    if (empty($email)) {
        $erreurs[] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)  && !($_SESSION['is_admin'] ?? false)) {
        $erreurs[] = "L'email n'est pas valide.";
    }
    // Vérification téléphone
    if (empty($telephone)) {
        $erreurs[] = "Le telephone est obligatoire.";
    }

    if (!empty($erreurs)) {
        $_SESSION['flashmessage'] = implode('<br>', $erreurs);
        $_SESSION['flash_type'] = 'error';
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
            $observation
        );
    }
    header("Location: index.php?page=accueil");
    exit();
}











require_once __DIR__ . '/../View/Nouveau_client.php';
