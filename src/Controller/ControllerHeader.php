<?php
// ControllerHeader.php
// Fichier qui permet de gérer la page Header
require_once __DIR__ . '/../Model/ModelHeader.php';

if ($_SESSION['is_admin'] ?? false) {
    $id_client = $_SESSION['id_admin'];
} else {
    $id_client = $_SESSION['id_client'];
}
$nb_ticket_client = get_nb_tickets($id_client);

require_once __DIR__ . '/../View/TemplatesHeader.php';
