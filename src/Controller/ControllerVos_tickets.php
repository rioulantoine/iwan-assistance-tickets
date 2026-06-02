<?php
// ControllerVos_tickets.php
// Fichier qui permet de gérer la page Vos tickets
require_once __DIR__ . '/../Model/ModelVos_tickets.php';
// Traitement des données pour l'affiche sur la page Vos tickets
$date_debut = $_GET['date_debut'] ?? '';
$date_fin = $_GET['date_fin'] ?? '';

// Il faut ajouter le message dans le html 
if (!empty($date_debut) && !empty($date_fin)) {

    if ($date_debut > $date_fin) {
        $_SESSION['flash_message'] = "La date de début ne peut pas être plus récente que la date de fin.";
        $_SESSION['flash_type'] = "error";
    }
}

if ($_SESSION['is_admin'] ?? false) {
    $id_client = $_SESSION['id_admin'] ?? null;
} else {
    $id_client = $_SESSION['id_client'] ?? null;
    if (!$id_client) {
        die("ERREUR : ID client non spécifié.");
    }
}
$filtres = [
    'id_client' => $id_client,
    'date_filtre' => $_GET['date_filtre'] ?? '',
    'date_debut'  => $date_debut,
    'date_fin'    => $date_fin,
    'statut'      => $_GET['statut_filtre'] ?? '',
    'urgence'     => $_GET['urgence_filtre'] ?? '',
    'recherche'   => trim($_GET['recherche'] ?? ''),
];
$lst_tickets = get_ticket($filtres);

require_once __DIR__ . '/../View/Vos_tickets.php';
