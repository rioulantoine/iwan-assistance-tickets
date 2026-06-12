<?php
// ControllerChanger_statut.php
// Permet de changer le statut d'un ticket et de rediriger vers la page de détails du ticket
require_once __DIR__ . '/../Model/ModelDetails_ticket.php';
$num_ticket = $_GET['ticket'] ?? '';
$nouvel_id_statut = isset($_GET['status']) ? (int)$_GET['status'] : 0;
if (!empty($num_ticket) && $nouvel_id_statut >= 1 && $nouvel_id_statut <= 4) {

    modifier_statut_ticket($num_ticket, $nouvel_id_statut);
}
if ($nouvel_id_statut === 1) {
    $message = "Ticket résolu";
} elseif ($nouvel_id_statut === 3) {
    $message = "Ticket à revoir";
} else {
    $message = "Changement de statut";
}
maj(null, $num_ticket, $message);
header("Location: index.php?page=detail_ticket&ticket=" . urlencode($num_ticket));
exit();
