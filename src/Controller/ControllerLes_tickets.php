<?php
// ControlLes_ticket.php
// Fichier qui permet de gérer la page Les ticket
require_once __DIR__ . '/../Model/ModelLes_tickets.php';

// Sécurité admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: index.php?page=accueil');
    exit();
}
// Filtres par groupe
if (isset($_GET['groupe']) && $_GET['groupe'] !== '') {
    $groupe = (int)$_GET['groupe'];

    // Dans tous les cas (1, 2, 3, 4), la date est forcée sur "Cette semaine" (1) et le statut sur "En cours" (2)
    $_GET['date_filtre'] = '1';
    $_GET['statut_filtre'] = '2';

    switch ($groupe) {
        case 1:
            $_GET['ticket_suivi'] = '1';   // Suivis uniquement
            $_GET['urgence_filtre'] = '';  // Toutes les urgences
            break;

        case 2:
            $_GET['ticket_suivi'] = '1';   // Suivis uniquement
            $_GET['urgence_filtre'] = '2';  // Urgent (ou '1' si tu considères Urgent comme Bloquant)
            break;

        case 3:
            $_GET['ticket_suivi'] = '0';   // Tickets uniquement
            $_GET['urgence_filtre'] = '';  // Toutes les urgences
            break;

        case 4:
            $_GET['ticket_suivi'] = '0';   // Tickets uniquement
            $_GET['urgence_filtre'] = '2';  // Urgent
            break;
    }
}
$tri_col    = $_GET['tri_col']   ?? 'date_creation';
$tri_ordre  = (int)($_GET['tri_ordre'] ?? 2);
$date_debut = $_GET['date_debut'] ?? '';
$date_fin   = $_GET['date_fin'] ?? '';

if (!empty($date_debut) && !empty($date_fin)) {
    if ($date_debut > $date_fin) {
        $_SESSION['flash_message'] = "La date de début ne peut pas être plus récente que la date de fin.";
        $_SESSION['flash_type'] = "error";
    }
}

// CORRECTION WARNING : Ajout de ?? '2' par défaut pour éviter l'index indéfini
$ticket_suivi_value = $_GET['ticket_suivi'] ?? '2';

$filtres = [
    'date_filtre'  => $_GET['date_filtre'] ?? '',
    'date_debut'   => $date_debut,
    'date_fin'     => $date_fin,
    'statut'       => $_GET['statut_filtre'] ?? '',
    'urgence'      => $_GET['urgence_filtre'] ?? '',
    'ticket-suivi' => $ticket_suivi_value,
    'recherche'    => trim($_GET['recherche'] ?? ''),
    'tri_col'      => $tri_col,
    'tri_ordre'    => $tri_ordre,
    'type'         => $ticket_suivi_value,

];

// Gestion propre du comptage selon le filtre sélectionné
$type_selectionne = $filtres['type'] !== '' ? (int)$filtres['type'] : 2;

if ($type_selectionne === 0) {
    $nb_ticket = get_nb_only_tickets($filtres);
    $nb_suivis = 0;
} elseif ($type_selectionne === 1) {
    $nb_ticket = 0;
    $nb_suivis = get_nb_only_suivis($filtres);
} else {
    // Si l'utilisateur demande "Les deux", on force temporairement les filtres pour les fonctions
    $filtres_tickets = $filtres;
    $filtres_tickets['type'] = 0;
    $nb_ticket = get_nb_only_tickets($filtres_tickets);

    $filtres_suivis = $filtres;
    $filtres_suivis['type'] = 1;
    $nb_suivis = get_nb_only_suivis($filtres_suivis);
}

$liste_tickets = get_tickets($filtres);

foreach ($liste_tickets as &$ticket) {
    // Initialisation des objets de date
    $date_creation_obj = new DateTime($ticket['date_creation']);
    $est_resolu = ((int)$ticket['id_statut'] === 3 || !empty($ticket['date_resolution']));

    if ($est_resolu) {
        $date_fin_calcul = new DateTime($ticket['date_resolution']);
    } else {
        $date_fin_calcul = new DateTime();
    }

    // Calcul de la différence
    $interval = $date_creation_obj->diff($date_fin_calcul);

    // Formatage de la chaîne de texte pour la durée
    if ($interval->days > 0) {
        $duree_texte = $interval->format('%aj %hh');
    } elseif ($interval->h > 0) {
        $duree_texte = $interval->format('%hh %imin');
    } else {
        $duree_texte = $interval->format('%imin');
    }

    // On injecte les nouvelles données directement dans le ticket
    $ticket['duree_traitement'] = $duree_texte;
}
unset($ticket);

require_once __DIR__ . '/../View/Les_tickets.php';
