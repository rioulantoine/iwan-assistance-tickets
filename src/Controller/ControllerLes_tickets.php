<?php
// ControlLes_ticket.php
// Fichier qui permet de gérer la page Les ticket
require_once __DIR__ . '/../Model/ModelLes_tickets.php';
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: index.php?page=accueil');
    exit();
}
$nb_ticket = get_nb_tickets();
$liste_tickets = get_tickets();
require_once __DIR__ . '/../View/Les_tickets.php';
