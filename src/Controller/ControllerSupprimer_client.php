<?php
// ControllerSupprimer_client.php

require_once __DIR__ . '/../Model/ModelLes_Clients.php';

// Sécurisation de l'accès (Seuls les admins peuvent supprimer)
if (!($_SESSION['is_admin'] ?? false)) {
    $_SESSION['flash_message'] = "Accès refusé. Vous n'avez pas les droits nécessaires.";
    $_SESSION['flash_type']    = "error";
    header("Location: index.php?page=les_clients");
    exit();
}

// On vérifie si le paramètre est présent dans l'URL
if (isset($_GET['client'])) {

    // On nettoie les espaces blancs au début et à la fin 
    $id_client_a_supprimer = trim($_GET['client']);

    // On vérifie que l'identifiant n'est pas vide après nettoyage
    if ($id_client_a_supprimer !== '') {

        // Tentative de suppression via le modèle 
        if (supprimer_client_sans_ticket($id_client_a_supprimer)) {
            $_SESSION['flash_message'] = "Le client a été supprimé avec succès.";
            $_SESSION['flash_type']    = "success";
        } else {
            $_SESSION['flash_message'] = "Impossible de supprimer ce client car il possède des tickets ou des suivis d'appels enregistrés.";
            $_SESSION['flash_type']    = "error";
        }
    } else {
        $_SESSION['flash_message'] = "Identifiant client invalide ou vide.";
        $_SESSION['flash_type']    = "error";
    }
}

// Redirection unique et propre vers la liste des clients
header("Location: index.php?page=les_clients");
exit();
