<?php
// ControllerSupprimer_ticket.php
// Permet de supprimer un ticket et de rediriger vers la liste des tickets
require_once __DIR__ . '/../Model/ModelDetails_ticket.php';

// Sécurisation du droit d'accès (seuls les admins ont le droit)
if (!($_SESSION['is_admin'] ?? false)) {
    die("Accès refusé. Vous devez être administrateur pour supprimer un ticket.");
}

//Récupération du numéro de ticket depuis l'URL
$num_ticket = $_GET['ticket'] ?? '';

if (!empty($num_ticket)) {
    supprimer_ticket_par_numero($num_ticket);
}

// Redirection vers le tableau de bord principal (la liste des tickets)
header("Location: index.php?page=admin_tickets");
exit();
