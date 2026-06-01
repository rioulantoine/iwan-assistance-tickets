<?php
// ModelAccueil.php
// Fichier qui permet de récuperer les données pour le controlleur de la page Vos tickets
require_once __DIR__ . '/ModelBDD.php';

function get_ticket($filtres)
{
    $pdo = get_bdd();

    $sql = "SELECT t.*,
                   u.libelle_urgence
            FROM TICKETS t
            LEFT JOIN NIVEAU_URGENCE u ON t.id_urgence = u.id_urgence
            WHERE id_entreprise = :id_client AND 1=1";
    $params = [];
    $params['id_client'] = $filtres['id_client'];
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
        $sql .= " AND (titre LIKE :recherche OR numero_ticket LIKE :recherche OR declarant_prenom LIKE :recherche OR declarant_nom LIKE :recherche OR description LIKE :recherche)";
        $params['recherche'] = '%' . $filtres['recherche'] . '%';
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
