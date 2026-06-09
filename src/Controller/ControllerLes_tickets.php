<?php
// ControlLes_ticket.php
// Fichier qui permet de gérer la page Les ticket
require_once __DIR__ . '/../Model/ModelLes_tickets.php';

// Sécurité admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: index.php?page=accueil');
    exit();
}
$tri_col   = $_GET['tri_col']   ?? 'date_creation';
$tri_ordre = (int)($_GET['tri_ordre'] ?? 2);
$date_debut = $_GET['date_debut'] ?? '';
$date_fin = $_GET['date_fin'] ?? '';


if (!empty($date_debut) && !empty($date_fin)) {

    if ($date_debut > $date_fin) {
        $_SESSION['flash_message'] = "La date de début ne peut pas être plus récente que la date de fin.";
        $_SESSION['flash_type'] = "error";
    }
}
$filtres = [
    'date_filtre' => $_GET['date_filtre'] ?? '',
    'date_debut'  => $date_debut,
    'date_fin'    => $date_fin,
    'statut'      => $_GET['statut_filtre'] ?? '',
    'urgence'     => $_GET['urgence_filtre'] ?? '',
    'ticket-suivi' => $_GET['ticket_suivi'] ?? '',
    'recherche'   => trim($_GET['recherche'] ?? ''),
    'tri_col'     => $tri_col,
    'tri_ordre'   => $tri_ordre,
];


$nb_ticket = get_nb_tickets($filtres);
$liste_tickets = get_tickets($filtres);

require_once __DIR__ . '/../View/Les_tickets.php';
