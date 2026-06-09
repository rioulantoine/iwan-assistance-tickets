<?php
// ControllerSupprimerReponse.php
require_once __DIR__ . '/../Model/ModelDetails_ticket.php';
// Sécurisation du droit d'accès (seuls les admins ont le droit)
if (!($_SESSION['is_admin'] ?? false)) {
    die("Accès refusé. Vous devez être administrateur pour supprimer une réponse.");
}
$id_reponse = (int)($_GET['reponse'] ?? '');
$num_ticket = $_GET['num_ticket'] ?? '';
var_dump($id_reponse);
var_dump($num_ticket);

if (!empty($id_reponse)) {
    $succes = supprimer_reponse_par_id($id_reponse);

    if ($succes) {
        //Enregistrement du message de confirmation en session
        $_SESSION['flash_message'] = "La réponse a bien été supprimé.";
        $_SESSION['flash_type'] = "success";
    } else {
        $_SESSION['flash_message'] = "Une erreur estsurvenue lors de la suppression du ticket.";
        $_SESSION['flash_type'] = "error";
    }
}
header("Location: index.php?page=detail_ticket&ticket=" . urlencode($num_ticket));
exit();
