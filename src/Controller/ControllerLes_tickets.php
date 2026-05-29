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

$filtres = [
    'date_filtre' => $_GET['date_filtre'] ?? '',
    'statut'      => $_GET['statut_filtre'] ?? '',
    'urgence'     => $_GET['urgence_filtre'] ?? '',
    'recherche'   => trim($_GET['recherche'] ?? ''),
    'tri_col'   => $tri_col,
    'tri_ordre' => $tri_ordre,
];


$ordre_sql = $tri_ordre === 2 ? 'DESC' : 'ASC';

$query = "SELECT * FROM tickets ORDER BY {$tri_col} {$ordre_sql}";
$nb_ticket = get_nb_tickets($filtres);
$liste_tickets = get_tickets($filtres);

require_once __DIR__ . '/../View/Les_tickets.php';
