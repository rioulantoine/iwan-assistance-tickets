<?php
// ControlLes_ticket.php
// Fichier qui permet de gérer la page Les ticket
require_once __DIR__ . '/../Model/ModelLes_tickets.php';

// Sécurité admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: index.php?page=accueil');
    exit();
}

$filtres = [
    'date_filtre' => $_GET['date_filtre'] ?? '',
    'statut'      => $_GET['statut_filtre'] ?? '',
    'urgence'     => $_GET['urgence_filtre'] ?? '',
    'recherche'   => trim($_GET['recherche'] ?? ''),
];

$nb_ticket = get_nb_tickets($filtres);
$liste_tickets = get_tickets($filtres);

require_once __DIR__ . '/../View/Les_tickets.php';
