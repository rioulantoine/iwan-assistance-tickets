<?php
// ModelLesTickets.php
// Fichier qui permet de récuperer les données pour le controlleur de la page Les_tickets
require_once __DIR__ . '/ModelBDD.php';


/**
 * Récupère le nombre total de tickets dans la base de données
 */
function get_nb_tickets($filtres)
{
    $pdo = get_bdd();
    $sql = "SELECT COUNT(id_ticket) FROM TICKETS WHERE 1=1";
    $params = [];

    if (empty($filtres['date_debut']) && empty($filtres['date_fin'])) {
        if (!empty($filtres['date_filtre'])) {
            if ($filtres['date_filtre'] === '1') {
                $sql .= " AND date_creation >= DATE_SUB(NOW(), INTERVAL 1 WEEK)";
            } elseif ($filtres['date_filtre'] === '2') {
                $sql .= " AND date_creation >= DATE_SUB(NOW(), INTERVAL 14 DAY)";
            } elseif ($filtres['date_filtre'] === '3') {
                $sql .= " AND date_creation >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
            } elseif ($filtres['date_filtre'] === '4') {
                $sql .= " AND date_creation >= DATE_SUB(NOW(), INTERVAL 3 MONTH)";
            } elseif ($filtres['date_filtre'] === '5') {
                $sql .= " AND date_creation >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
            }
        }
    }

    // Filtre date personnalisée (prioritaire sur le select si renseigné)
    if (!empty($filtres['date_debut'])) {
        $sql .= " AND date_creation >= :date_debut";
        $params['date_debut'] = $filtres['date_debut'] . ' 00:00:00';
    }
    if (!empty($filtres['date_fin'])) {
        $sql .= " AND date_creation <= :date_fin";
        $params['date_fin'] = $filtres['date_fin'] . ' 23:59:59';
    }

    // Filtre statut 
    if (!empty($filtres['statut'])) {
        $sql .= " AND id_statut = :id_statut";
        $params['id_statut'] = (int)$filtres['statut'];
    }

    // Filtre urgence 
    if (!empty($filtres['urgence'])) {
        $sql .= " AND id_urgence = :id_urgence";
        $params['id_urgence'] = (int)$filtres['urgence'];
    }

    // Filtre recherche 
    if (!empty($filtres['recherche'])) {
        $sql .= " AND (titre LIKE :recherche OR numero_ticket LIKE :recherche OR nom_entreprise LIKE :recherche OR declarant_prenom LIKE :recherche OR declarant_nom LIKE :recherche OR description LIKE :recherche)";
        $params['recherche'] = '%' . $filtres['recherche'] . '%';
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return (int) $stmt->fetchColumn();
}
/**
 * Récupère la liste de tous les tickets avec leurs urgences et statuts associés
 * Trié par date de création décroissante par défaut (les plus récents en premier)
 * Trié en fonction des filtres appliqués 
 * @param array $filtres Un tableau associatif contenant les filtres appliqués (date, statut, urgence, recherche)
 * @return array Un tableau associatif contenant les données des tickets
 */
function get_tickets($filtres)
{
    $pdo = get_bdd();

    $sql = "SELECT t.*, 
                   u.libelle_urgence, 
                   s.libelle_statut
            FROM TICKETS t
            LEFT JOIN NIVEAU_URGENCE u ON t.id_urgence = u.id_urgence
            LEFT JOIN STATUT s ON t.id_statut = s.id_statut
            WHERE 1=1";

    $params = [];

    // Filtre date
    if (empty($filtres['date_debut']) && empty($filtres['date_fin'])) {
        if (!empty($filtres['date_filtre'])) {
            if ($filtres['date_filtre'] === '1') {
                $sql .= " AND date_creation >= DATE_SUB(NOW(), INTERVAL 1 WEEK)";
            } elseif ($filtres['date_filtre'] === '2') {
                $sql .= " AND date_creation >= DATE_SUB(NOW(), INTERVAL 14 DAY)";
            } elseif ($filtres['date_filtre'] === '3') {
                $sql .= " AND date_creation >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
            } elseif ($filtres['date_filtre'] === '4') {
                $sql .= " AND date_creation >= DATE_SUB(NOW(), INTERVAL 3 MONTH)";
            } elseif ($filtres['date_filtre'] === '5') {
                $sql .= " AND date_creation >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
            }
        }
    }

    // Filtre date personnalisée (prioritaire sur le select si renseigné)
    if (!empty($filtres['date_debut'])) {
        $sql .= " AND date_creation >= :date_debut";
        $params['date_debut'] = $filtres['date_debut'] . ' 00:00:00';
    }
    if (!empty($filtres['date_fin'])) {
        $sql .= " AND date_creation <= :date_fin";
        $params['date_fin'] = $filtres['date_fin'] . ' 23:59:59';
    }
    // Filtre statut 
    if (!empty($filtres['statut'])) {
        $sql .= " AND t.id_statut = :statut";
        $params['statut'] = $filtres['statut'];
    }

    // Filtre urgence 
    if (!empty($filtres['urgence'])) {
        $sql .= " AND t.id_urgence = :id_urgence";
        $params['id_urgence'] = (int)$filtres['urgence'];
    }

    // Filtre recherche 
    if (!empty($filtres['recherche'])) {
        $sql .= " AND (titre LIKE :recherche OR numero_ticket LIKE :recherche OR nom_entreprise LIKE :recherche OR declarant_prenom LIKE :recherche OR declarant_nom LIKE :recherche OR description LIKE :recherche)";
        $params['recherche'] = '%' . $filtres['recherche'] . '%';
    }

    $colonnes_autorisees = ['id_urgence', 'titre', 'date_creation', 'date_maj', 'date_resolution', 'id_statut'];
    $tri_col = in_array($filtres['tri_col'] ?? '', $colonnes_autorisees) ? $filtres['tri_col'] : 'date_creation';
    $tri_ordre = (int)($filtres['tri_ordre'] ?? 2) === 2 ? 'DESC' : 'ASC';

    $sql .= " ORDER BY t.{$tri_col} {$tri_ordre}";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
