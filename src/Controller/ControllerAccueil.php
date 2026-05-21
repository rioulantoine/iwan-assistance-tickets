<?php
// ControllerAccueil.php

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redirection simple si pas de session
    exit();
}

require_once __DIR__ . '/../Model/ModelBDD.php';
require_once __DIR__ . '/../Model/ModelAccueil.php';

try {
    $role_utilisateur = $_SESSION['user_role'] ?? 3;
    $id_cible = ($role_utilisateur == 1 || $role_utilisateur == 2) ? 0 : $_SESSION['user_id'];

    // Données principales des box
    $nb_tickets_actif  = count_tickets($id_cible, [1, 2]);
    $nb_tickets_resolu = count_tickets($id_cible, 3);
    $nb_tickets_urgent = count_tickets($id_cible, null, 3);


    // Tickets ACTIFS
    $actifs_ce_mois = count_tickets_mensuels('courante', $id_cible, [1, 2]);
    $actifs_mois_dernier = count_tickets_mensuels('derniere', $id_cible, [1, 2]);
    $ecart_actifs = ($actifs_mois_dernier > 0) ? round((($actifs_ce_mois - $actifs_mois_dernier) / $actifs_mois_dernier) * 100, 1) : 0;

    // Tickets RÉSOLUS
    $resolus_ce_mois = count_tickets_mensuels('courante', $id_cible, 3);
    $resolus_mois_dernier = count_tickets_mensuels('derniere', $id_cible, 3);
    $ecart_resolus = ($resolus_mois_dernier > 0) ? round((($resolus_ce_mois - $resolus_mois_dernier) / $resolus_mois_dernier) * 100, 1) : 0;

    // Tickets URGENT
    $urgents_ce_mois = count_tickets_mensuels('courante', $id_cible, null, 3);
    $urgents_mois_dernier = count_tickets_mensuels('derniere', $id_cible, null, 3);
    $ecart_urgents = ($urgents_mois_dernier > 0) ? round((($urgents_ce_mois - $urgents_mois_dernier) / $urgents_mois_dernier) * 100, 1) : 0;


    // Calcul taux de résolution global

    $nb_tickets_total = $nb_tickets_actif + $nb_tickets_resolu;
    $taux_resolution = ($nb_tickets_total > 0) ? round(($nb_tickets_resolu / $nb_tickets_total) * 100, 1) : 0;

    // Comparaison taux de résolution 
    $taux_ce_mois = get_taux_resolution_mensuel('courante', $id_cible);
    $taux_mois_dernier = get_taux_resolution_mensuel('derniere', $id_cible);

    $ecart_taux = $taux_ce_mois - $taux_mois_dernier;
} catch (PDOException $e) {
    die("Erreur de base de données sur l'accueil : " . $e->getMessage());
}






// Chargement de la vue
require_once __DIR__ . '/../View/Accueil.php';
