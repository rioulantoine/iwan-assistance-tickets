<?php
// ControlLes_ticket.php
// Fichier qui permet de gérer la page Les ticket
require_once __DIR__ . '/../Model/ModelLes_tickets.php';

// Sécurité admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: index.php?page=accueil');
    exit();
}

$tri_col    = $_GET['tri_col']   ?? 'date_creation';
$tri_ordre  = (int)($_GET['tri_ordre'] ?? 2);
$date_debut = $_GET['date_debut'] ?? '';
$date_fin   = $_GET['date_fin'] ?? '';

if (!empty($date_debut) && !empty($date_fin)) {
    if ($date_debut > $date_fin) {
        $_SESSION['flash_message'] = "La date de début ne peut pas être plus récente que la date de fin.";
        $_SESSION['flash_type'] = "error";
    }
}

// CORRECTION WARNING : Ajout de ?? '2' par défaut pour éviter l'index indéfini
$ticket_suivi_value = $_GET['ticket_suivi'] ?? '2';

$filtres = [
    'date_filtre'  => $_GET['date_filtre'] ?? '',
    'date_debut'   => $date_debut,
    'date_fin'     => $date_fin,
    'statut'       => $_GET['statut_filtre'] ?? '',
    'urgence'      => $_GET['urgence_filtre'] ?? '',
    'ticket-suivi' => $ticket_suivi_value,
    'recherche'    => trim($_GET['recherche'] ?? ''),
    'tri_col'      => $tri_col,
    'tri_ordre'    => $tri_ordre,
    'type'         => $ticket_suivi_value,
];

// Gestion propre du comptage selon le filtre sélectionné
$type_selectionne = $filtres['type'] !== '' ? (int)$filtres['type'] : 2;

if ($type_selectionne === 0) {
    $nb_ticket = get_nb_only_tickets($filtres);
    $nb_suivis = 0;
} elseif ($type_selectionne === 1) {
    $nb_ticket = 0;
    $nb_suivis = get_nb_only_suivis($filtres);
} else {
    // Si l'utilisateur demande "Les deux", on force temporairement les filtres pour les fonctions
    $filtres_tickets = $filtres;
    $filtres_tickets['type'] = 0;
    $nb_ticket = get_nb_only_tickets($filtres_tickets);

    $filtres_suivis = $filtres;
    $filtres_suivis['type'] = 1;
    $nb_suivis = get_nb_only_suivis($filtres_suivis);
}

$liste_tickets = get_tickets($filtres);

require_once __DIR__ . '/../View/Les_tickets.php';
