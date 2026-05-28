<?php
//ControllerChanger_urgence.php
//Permet de changer le niveau d'urgence du ticket et de rediriger vers la page du ticket$
require_once __DIR__ . '/../Model/ModelDetails_ticket.php';
$num_ticket = $_GET['ticket'] ?? '';
$nouvel_id_urgence = isset($_GET['urgence']) ? (int)$_GET['urgence'] : 0;
if (!empty($num_ticket) && $nouvel_id_urgence >= 1 && $nouvel_id_urgence <= 4) {

    modifier_urgence_ticket($num_ticket, $nouvel_id_urgence);
}
header("Location: index.php?page=detail_ticket&ticket=" . urlencode($num_ticket));

exit();
