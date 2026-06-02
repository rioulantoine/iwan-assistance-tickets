<?php
// ControllerDetails_ticket.php
// Fichier qui permet de gérer la page Détails ticket
require_once __DIR__ . '/../Model/ModelDetails_ticket.php';
$num_ticket = $_GET['ticket'] ?? 'Numéro de ticket non spécifié';
$details_ticket = get_ticket_par_numero($num_ticket);
$pieces_jointes = get_pieces_jointes_par_ticket($num_ticket);
$date_ticket = isset($details_ticket['date_creation']) ? date('d/m/Y H:i', strtotime($details_ticket['date_creation'])) : 'Date non spécifiée';
$ecart_date_ticket = null;
if (isset($details_ticket['date_creation'])) {
    $diffMinutes = floor((time() - strtotime($details_ticket['date_creation'])) / 60);

    if ($diffMinutes < 60) {
        $ecart_date_ticket = $diffMinutes . 'min plus tôt';
    } else {
        $hours = floor($diffMinutes / 60);
        $minutes = $diffMinutes % 60;
        $ecart_date_ticket = $hours . 'h' . str_pad($minutes, 2, '0', STR_PAD_LEFT) . ' plus tôt';
    }
}
$id_ticket = $details_ticket['id_ticket'];
$reponses = get_reponse_ticket($id_ticket);

require_once __DIR__ . '/../View/Details_ticket.php';
