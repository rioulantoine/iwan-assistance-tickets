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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre']);
    $contenu = trim($_POST['contenu']);
    $id_ticket = $details_ticket['id_ticket'];
    $id_parent = trim($_POST['id_parent']);

    if ($_SESSION['is_admin'] ?? false) {
        $est_admin = 1;
    } else {
        $est_admin = 0;
    }

    // Vérification titre
    if (empty($titre)) {
        $erreurs[] = "Le titre est obligatoire";
    }

    // Vérification contenu
    if (empty($contenu)) {
        $erreurs[] = "Le message doit avoir un contenu";
    }

    // Vérification id_ticket
    if (empty($id_ticket)) {
        $erreurs[] = "Il n'y a pas de ticket";
    }
    if (!empty($erreurs)) {
        $_SESSION['flash_message'] = implode('<br>', $erreurs);
        $_SESSION['flash_type'] = "error";
    }

    if (empty($erreurs)) {
        $date_envoi = date('Y-m-d H:i:s');
        if (!empty($id_parent)) {


            $id_reponse = inserer_nouvelle_reponse(
                $titre,
                $contenu,
                $date_envoi,
                $est_admin,
                $id_ticket,
                $id_parent
            );
        } else {
            $id_reponse = inserer_nouvelle_reponse(
                $titre,
                $contenu,
                $date_envoi,
                $est_admin,
                $id_ticket,
            );
        }

        maj($id_ticket);
    }

    header("Location: index.php?page=detail_ticket&ticket=" . $details_ticket['numero_ticket'] . "#formulaire-reponse");
}


require_once __DIR__ . '/../View/Details_ticket.php';
