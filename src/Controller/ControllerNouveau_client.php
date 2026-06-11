<?php
// ControllerNouveau_client.php

if (!isset($_SESSION['is_admin']) && !isset($_SESSION['id_client'])) {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/../Model/ModelNouveau_Client.php';
$liste_logiciels = get_liste_logiciels_nouveau_client();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données POST
    $id_client      = trim($_POST['id_client'] ?? '');
    $nom_entreprise = trim($_POST['nom_entreprise'] ?? '');
    $code_postal    = trim($_POST['cp'] ?? '');
    $ville          = trim($_POST['ville'] ?? '');
    $nom            = trim($_POST['nom'] ?? '');
    $prenom         = trim($_POST['prenom'] ?? '');
    $email          = trim($_POST['email'] ?? '');
    $telephone      = trim($_POST['telephone'] ?? '');
    $observation    = trim($_POST['observation'] ?? '');

    // Évite le Warning "Undefined array key" si aucun logiciel n'est sélectionné
    $logiciel = !empty($_POST['id_logiciel']) ? $_POST['id_logiciel'] : null;

    $erreurs = [];

    // Vérification de l'ID client
    if (empty($id_client)) {
        $erreurs[] = "L'id client est obligatoire.";
    }

    // Vérification du nom de l'entreprise
    if (empty($nom_entreprise)) {
        $erreurs[] = "Le nom de l'entreprise est obligatoire.";
    }

    // Validation du format d'email
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) && !($_SESSION['is_admin'] ?? false)) {
        $erreurs[] = "L'email n'est pas valide.";
    }

    // On ne vérifie l'unicité de l'ID en BDD QUE si l'utilisateur a bien saisi quelque chose
    if (!empty($id_client)) {
        $id_existant = verifier_id($id_client);
        if ($id_existant) {
            $erreurs[] = "L'id client existe déjà pour l'entreprise : " . htmlspecialchars($id_existant);
        }
    }

    // ---- Traitement des erreurs ou Insertion ----
    if (!empty($erreurs)) {
        // Centralisation de toutes les erreurs dans un seul message Flash
        $_SESSION['flash_message'] = implode('<br>', $erreurs);
        $_SESSION['flash_type']    = 'error';

        // Redirection vers le formulaire pour afficher les erreurs proprement
        header("Location: index.php?page=nouveau_client");
        exit();
    } else {
        // Si aucune erreur, on insère en base de données
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

// Chargement de la vue
require_once __DIR__ . '/../View/Nouveau_client.php';
