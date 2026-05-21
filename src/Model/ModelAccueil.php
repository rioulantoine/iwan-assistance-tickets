<?php

/**
 * ModelAccueil.php
 * * Modèle gérant les requêtes SQL nécessaires pour l'affichage de la page d'accueil.
 * Regroupe les fonctions de statistiques et de compteurs de tickets.
 * * @project IWAN-ASSISTANCE-TICKETS
 */

require_once __DIR__ . '/ModelBDD.php';
/**
 * Compte générique de tickets (Global ou par Utilisateur)
 * Permet de filtrer à la volée par statut, par liste de statuts ou par urgence.
 * * @param int $id_user ID de l'utilisateur (0 = Tous les utilisateurs / Mode Global)
 * @param int|array|null $statut Un ID de statut (ex: 3), un tableau d'IDs (ex: [1,2]) ou null
 * @param int|null $id_urgence Un ID d'urgence spécifique (ex: 3) ou null
 * @return int Le nombre de tickets correspondants
 */
function count_tickets($id_user = 0, $statut = null, $id_urgence = null)
{
    $pdo = get_bdd();

    // Base de la requête 
    $sql = "SELECT COUNT(id_ticket) FROM TICKETS WHERE 1=1"; //Le WHERE 1=1 permet d'ajouter des AND dynamiquement
    $params = [];
    // Filtre utilisateur
    if ($id_user > 0) {
        $sql .= " AND id_user = ?";
        $params[] = $id_user;
    }
    // Filte statut(s)
    if ($statut !== null) {
        if (is_array($statut)) {

            $les_statuts = implode(',', array_fill(0, count($statut), '?'));
            $sql .= " AND id_statut IN ($les_statuts)";
            $params = array_merge($params, $statut);
        } else {
            $sql .= " AND id_statut = ?";
            $params[] = $statut;
        }
    }
    // Filtre urgence
    if ($id_urgence !== null) {
        $sql .= " AND id_urgence = ?";
        $params[] = $id_urgence;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return (int)$stmt->fetchColumn();
}
/**
 * Compte de tickets par période mensuelle 
 * @param string $periode 'courante' ou 'derniere'
 * @param int $id_user ID de l'utilisateur (0 = Global)
 * @param int|array|null $statut ID de statut ou tableau d'IDs
 * @param int|null $id_urgence ID d'urgence
 * @return int
 */
function count_tickets_mensuels($periode = 'courante', $id_user = 0, $statut = null, $id_urgence = null)
{
    $pdo = get_bdd();
    $intervalle = ($periode === 'derniere') ? "- INTERVAL 1 MONTH" : "";

    // Base de la requête avec filtre de date mensuel
    $sql = "SELECT COUNT(id_ticket) FROM TICKETS 
            WHERE YEAR(date_creation) = YEAR(NOW() $intervalle)
            AND MONTH(date_creation) = MONTH(NOW() $intervalle)";
    $params = [];

    // Filtre utilisateur
    if ($id_user > 0) {
        $sql .= " AND id_user = ?";
        $params[] = $id_user;
    }

    // Filtre Statut(s)
    if ($statut !== null) {
        if (is_array($statut)) {
            $les_statuts = implode(',', array_fill(0, count($statut), '?'));
            $sql .= " AND id_statut IN ($les_statuts)";
            $params = array_merge($params, $statut);
        } else {
            $sql .= " AND id_statut = ?";
            $params[] = $statut;
        }
    }

    // Filtre Urgence
    if ($id_urgence !== null) {
        $sql .= " AND id_urgence = ?";
        $params[] = $id_urgence;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return (int)$stmt->fetchColumn();
}
/**
 * Calcule le taux de résolution spécifique à une période mensuelle
 * @param string $periode 'courante' ou 'derniere'
 * @param int $id_user ID de l'utilisateur (0 = Global)
 * @return float Le taux de résolution en pourcentage
 */
function get_taux_resolution_mensuel($periode = 'courante', $id_user = 0)
{
    $pdo = get_bdd();
    $intervalle = ($periode === 'derniere') ? "- INTERVAL 1 MONTH" : "";

    // 1. On compte le TOTAL des tickets créés ce mois-là
    $sqlTotal = "SELECT COUNT(id_ticket) FROM TICKETS 
                 WHERE YEAR(date_creation) = YEAR(NOW() $intervalle)
                 AND MONTH(date_creation) = MONTH(NOW() $intervalle)";

    // 2. On compte combien de ces tickets sont RÉSOLUS (id_statut = 3)
    $sqlResolus = $sqlTotal . " AND id_statut = 3";

    $params = [];
    if ($id_user > 0) {
        $sqlTotal .= " AND id_user = ?";
        $sqlResolus .= " AND id_user = ?";
        $params[] = $id_user;
    }

    // Exécution du calcul du total
    $stmt = $pdo->prepare($sqlTotal);
    $stmt->execute($params);
    $total = (int)$stmt->fetchColumn();

    if ($total === 0) {
        return 0.0; // Évite la division par zéro si aucun ticket n'a été créé
    }

    // Exécution du calcul des résolus
    $stmt = $pdo->prepare($sqlResolus);
    $stmt->execute($params);
    $resolus = (int)$stmt->fetchColumn();

    // Calcul du pourcentage propre au mois
    return round(($resolus / $total) * 100, 1);
}
