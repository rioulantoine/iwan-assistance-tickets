<?php
require_once __DIR__ . '/../Model/ModelLes_Clients.php';

$id_client_a_supprimer = (int)($_GET['client'] ?? 0);

if ($id_client_a_supprimer > 0) {
    if (supprimer_client_sans_ticket($id_client_a_supprimer)) {
        $_SESSION['flash_message'] = "Le client a été supprimé avec succès.";
        $_SESSION['flash_type']    = "success";
    } else {
        $_SESSION['flash_message'] = "Impossible de supprimer ce client car il possède des tickets ou des suivis d'appels enregistrés.";
        $_SESSION['flash_type']    = "error";
    }
} else {
    $_SESSION['flash_message'] = "Identifiant client invalide ou introuvable.";
    $_SESSION['flash_type']    = "error";
}

// Redirection vers la liste des clients
header("Location: index.php?page=les_clients");
exit();
