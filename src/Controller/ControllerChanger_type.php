<?php
//ControllerChangertype.php
//Permet de changer le type 

require_once __DIR__ . '/../Model/ModelDetails_ticket.php';

$num_ticket = $_GET['ticket'] ?? '';
$type = $_GET['type'] ?? ''; // 🎯 On retire le (int) pour garder le texte (ex: "BUG")


if (!empty($num_ticket) && !empty($type)) {
    modifier_type($num_ticket, $type);
}

header("Location: index.php?page=detail_ticket&ticket=" . urlencode($num_ticket));
exit();
