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
 * * @param int $id_cible ID de l'utilisateur (0 = Tous les utilisateurs / Mode Global)
 * @param int|array|null $statut Un ID de statut (ex: 3), un tableau d'IDs (ex: [1,2]) ou null
 * @param int|null $id_urgence Un ID d'urgence spécifique (ex: 3) ou null
 * @return int Le nombre de tickets correspondants
 */
function count_tickets($id_cible = 0, $statut = null, $id_urgence = null)
{
    $pdo = get_bdd();

    // Base de la requête 
    $sql = "SELECT COUNT(id_ticket) FROM TICKETS WHERE 1=1"; //Le WHERE 1=1 permet d'ajouter des AND dynamiquement
    $params = [];
    // Filtre utilisateur
    if ($id_cible > 0) {
        $sql .= " AND id_entreprise = ?";
        $params[] = $id_cible;
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
    // Filtre urgence (gère désormais un ID seul OU un tableau d'IDs)
    if ($id_urgence !== null) {
        if (is_array($id_urgence)) {
            $les_urgences = implode(',', array_fill(0, count($id_urgence), '?'));
            $sql .= " AND id_urgence IN ($les_urgences) AND id_statut != 3";
            $params = array_merge($params, $id_urgence);
        } else {
            $sql .= " AND id_urgence = ? AND id_statut != 3";
            $params[] = $id_urgence;
        }
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return (int)$stmt->fetchColumn();
}
/**
 * Compte de tickets par période mensuelle 
 * @param string $periode 'courante' ou 'derniere'
 * @param int $id_cible ID de l'utilisateur (0 = Global)
 * @param int|array|null $statut ID de statut ou tableau d'IDs
 * @param int|null $id_urgence ID d'urgence
 * @return int
 */
function count_tickets_mensuels($periode = 'courante', $id_cible = 0, $statut = null, $id_urgence = null)
{
    $pdo = get_bdd();
    $intervalle = ($periode === 'derniere') ? "- INTERVAL 1 MONTH" : "";

    // Base de la requête avec filtre de date mensuel
    $sql = "SELECT COUNT(id_ticket) FROM TICKETS 
            WHERE YEAR(date_creation) = YEAR(NOW() $intervalle)
            AND MONTH(date_creation) = MONTH(NOW() $intervalle)";
    $params = [];

    // Filtre utilisateur
    if ($id_cible > 0) {
        $sql .= " AND id_entreprise = ?";
        $params[] = $id_cible;
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
    // Filtre urgence (gère désormais un ID seul OU un tableau d'IDs)
    if ($id_urgence !== null) {
        if (is_array($id_urgence)) {
            $les_urgences = implode(',', array_fill(0, count($id_urgence), '?'));
            $sql .= " AND id_urgence IN ($les_urgences)";
            $params = array_merge($params, $id_urgence);
        } else {
            $sql .= " AND id_urgence = ?";
            $params[] = $id_urgence;
        }
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return (int)$stmt->fetchColumn();
}
/**
 * Calcule le taux de résolution spécifique à une période mensuelle
 * @param string $periode 'courante' ou 'derniere'
 * @param int $id_cible ID de l'utilisateur (0 = Global)
 * @return float Le taux de résolution en pourcentage
 */
function get_taux_resolution_mensuel($periode = 'courante', $id_cible = 0)
{
    $pdo = get_bdd();
    $intervalle = ($periode === 'derniere') ? "- INTERVAL 1 MONTH" : "";

    // Combien de tickets créer ce mois 
    $sqlTotal = "SELECT COUNT(id_ticket) FROM TICKETS 
                 WHERE YEAR(date_creation) = YEAR(NOW() $intervalle)
                 AND MONTH(date_creation) = MONTH(NOW() $intervalle)";

    // Combien de tickets résolu (id_statut = 3)
    $sqlResolus = $sqlTotal . " AND id_statut = 3";

    $params = [];
    if ($id_cible > 0) {
        $sqlTotal .= " AND id_entreprise = ?";
        $sqlResolus .= " AND id_entreprise = ?";
        $params[] = $id_cible;
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


/**
 * Récupère le nombre de ticket non archivé par urgence
 * @param int $id_cible $id_urgence
 * @return
 */
function count_tickets_non_archives_par_urgence($id_cible, $id_urgence)
{
    $pdo = get_bdd();
    $id_statut_archive = 4;

    $sql = "SELECT COUNT(*) FROM TICKETS 
            WHERE id_urgence = :urgence 
            AND id_statut != :statut_archive";

    $params = [
        ':urgence' => $id_urgence,
        ':statut_archive' => $id_statut_archive
    ];
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return (int)$stmt->fetchColumn();
}

/**
 * Calcule le nombre de tickets passés au statut "Résolu" durant la semaine en cours.
 * Effectue une requête groupée par jour pour optimiser les performances.
 *
 * @global PDO $pdo L'objet de connexion à la base de données.
 * @return array Un tableau indexé de 7 entiers contenant les tickets résolus (Index 0 = Lundi, 6 = Dimanche).
 */
function get_tickets_resolus_semaine_en_cours()
{
    $pdo = get_bdd();

    $debut_semaine = date('Y-m-d', strtotime('monday this week'));
    $fin_semaine   = date('Y-m-d', strtotime('sunday this week'));

    $sql = "SELECT DATE(date_resolution) as jour, COUNT(*) as total 
            FROM TICKETS 
            WHERE id_statut IN (3,4)
            AND DATE(date_resolution) BETWEEN :debut AND :fin 
            GROUP BY DATE(date_resolution)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':debut'  => $debut_semaine,
        ':fin'    => $fin_semaine
    ]);

    $resultats = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    $donnees_semaine = [];

    for ($i = 0; $i < 7; $i++) {
        $jour_courant = date('Y-m-d', strtotime("monday this week +$i days"));

        $donnees_semaine[] = $resultats[$jour_courant] ?? 0;
    }

    return $donnees_semaine;
}

/**
 * Calcul le nombre de tickets crée aujourd'hui et qui ne sont pas encore résolu 
 */
function get_nb_tickets_du_jour()
{
    $pdo = get_bdd();

    $sql = "SELECT COUNT(id_ticket) FROM TICKETS WHERE DATE(date_creation) = CURDATE() AND id_statut != 3";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return (int)$stmt->fetchColumn();
}
/**
 * Retourne les 3 derniers tickets mis a jour pour le client
 */
function get_ticket_maj($id_client = null, $is_admin = false, $id_statut = 2)
{
    $pdo = get_bdd();

    if ($is_admin) {
        if ($id_statut === null) {
            $sql = "SELECT t.*, u.libelle_urgence
                FROM TICKETS t
                LEFT JOIN NIVEAU_URGENCE u ON t.id_urgence = u.id_urgence
                WHERE id_statut IN (1,2,3)
                ORDER BY date_creation DESC
                LIMIT 3";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
        } else {
            $sql = "SELECT t.*, u.libelle_urgence
                FROM TICKETS t
                LEFT JOIN NIVEAU_URGENCE u ON t.id_urgence = u.id_urgence
                WHERE id_statut = ?
                ORDER BY date_creation DESC
                LIMIT 3";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id_statut]);
        }
    } else {
        $sql = "SELECT t.*, u.libelle_urgence
                FROM TICKETS t
                LEFT JOIN NIVEAU_URGENCE u ON t.id_urgence = u.id_urgence
                WHERE t.id_entreprise = ?
                ORDER BY date_maj DESC
                LIMIT 3";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id_client]);
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
