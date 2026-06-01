<?php
// ControllerAccueil.php

if (!isset($_SESSION['is_admin']) && !isset($_SESSION['id_client'])) {
    header('Location: index.php');
    exit();
}

require_once __DIR__ . '/../Model/ModelBDD.php';
require_once __DIR__ . '/../Model/ModelAccueil.php';

try {
    if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
        $id_cible = 0;
        $nom_affichage = '';
    } else {
        $id_cible = $_SESSION['id_client'];
        $nom_affichage = $_SESSION['client_nom'] ?? $_SESSION['id_client'];
    }

    // =========================================================================
    // Calcul des statistiques
    // =========================================================================

    $nb_tickets_actif  = count_tickets($id_cible, [1, 2]);
    $nb_tickets_resolu = count_tickets($id_cible, 3);
    $nb_tickets_urgent = count_tickets($id_cible, null, [1, 2]);

    // Écarts mensuels - Tickets ACTIFS
    $actifs_ce_mois = count_tickets_mensuels('courante', $id_cible, [1, 2]);
    $actifs_mois_dernier = count_tickets_mensuels('derniere', $id_cible, [1, 2]);
    $ecart_actifs = ($actifs_mois_dernier > 0) ? round((($actifs_ce_mois - $actifs_mois_dernier) / $actifs_mois_dernier) * 100, 1) : 0;

    // Écarts mensuels - Tickets RÉSOLUS
    $resolus_ce_mois = count_tickets_mensuels('courante', $id_cible, 3);
    $resolus_mois_dernier = count_tickets_mensuels('derniere', $id_cible, 3);
    $ecart_resolus = ($resolus_mois_dernier > 0) ? round((($resolus_ce_mois - $resolus_mois_dernier) / $resolus_mois_dernier) * 100, 1) : 0;

    // Écarts mensuels - Tickets URGENTS
    $urgents_ce_mois = count_tickets_mensuels('courante', $id_cible, null, [1, 2]);
    $urgents_mois_dernier = count_tickets_mensuels('derniere', $id_cible, null, [1, 2]);
    $ecart_urgents = ($urgents_mois_dernier > 0) ? round((($urgents_ce_mois - $urgents_mois_dernier) / $urgents_mois_dernier) * 100, 1) : 0;

    // Statistiques globales d'activité
    $total_crees_ce_mois = $actifs_ce_mois + $resolus_ce_mois;

    // Calcul du taux de résolution global
    $nb_tickets_total = $nb_tickets_actif + $nb_tickets_resolu;
    $taux_resolution = ($nb_tickets_total > 0) ? round(($nb_tickets_resolu / $nb_tickets_total) * 100, 1) : 0;

    // Comparaison du taux de résolution avec le mois dernier
    $taux_ce_mois = get_taux_resolution_mensuel('courante', $id_cible);
    $taux_mois_dernier = get_taux_resolution_mensuel('derniere', $id_cible);
    $ecart_taux = $taux_ce_mois - $taux_mois_dernier;
} catch (PDOException $e) {
    die("Erreur de base de données sur l'accueil : " . $e->getMessage());
}

// =========================================================================
// Données pour les graphiques
// =========================================================================

// Graphique radar selon la criticité
$id_urgence_bloquant = 1;
$id_urgence_urgent = 2;
$id_urgence_normal = 3;
$id_urgence_non_urgent = 4;


$nb_bloquant = count_tickets_non_archives_par_urgence($id_cible, $id_urgence_bloquant);
$nb_urgent   = count_tickets_non_archives_par_urgence($id_cible, $id_urgence_urgent);
$nb_normal = count_tickets_non_archives_par_urgence($id_cible, $id_urgence_normal);
$nb_non_urgent = count_tickets_non_archives_par_urgence($id_cible, $id_urgence_non_urgent);

$labels_radar = ['Bloquant', 'Urgent', 'Normal', 'Non_urgent'];
$valeurs_radar = [$nb_bloquant, $nb_urgent, $nb_normal, $nb_non_urgent];

// Diagramme à barres 
$date_debut_semaine = date('d/m/y', strtotime('monday this week'));
$date_fin_semaine = date('d/m/y', strtotime('sunday this week'));

$labels_barres = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
$valeurs_barres = get_tickets_resolus_semaine_en_cours();

// Simulation ou compte des nouveaux tickets pour la sidebar admin
$nb_nouveaux_tickets = 26;

//======================================
// Données nouveau tickets aujourd'hui
//======================================
$nb_tickets_du_jour = get_nb_tickets_du_jour();


//===========================================
// Affichage des tickets de l'utilisateur
//===========================================

if ($_SESSION['is_admin'] ?? false) {
    $is_admin = true;
    $ticket_maj_user = get_ticket_maj(null, $is_admin);
} else {
    $id_client = $_SESSION['id_client'];
    $ticket_maj_user = get_ticket_maj($id_client, false);
}






require_once __DIR__ . '/../View/Accueil.php';
