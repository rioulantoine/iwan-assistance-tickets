<?php
// ControllerHeader.php
// Fichier qui permet de gérer la page Header
require_once __DIR__ . '/../Model/ModelHeader.php';

if ($_SESSION['is_admin'] ?? false) {
    $id = $_SESSION['id_admin'];
} else {
    $id = $_SESSION['id_client'];
}
// Dans ControllerHeader.php
$GLOBALS['nb_ticket_client'] = get_nb_tickets_user($id);
require_once __DIR__ . '/../View/Templates/Header.php';
