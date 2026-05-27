<?php
// ModelLesTickets.php
// Fichier qui permet de récuperer les données pour le controlleur de la page Les_tickets
require_once __DIR__ . '/ModelBDD.php';


/**
 * Récupère le nombre total de tickets dans la base de données
 */
function get_nb_tickets()
{
    $pdo = get_bdd();

    $sql = "SELECT COUNT(id_ticket) FROM TICKETS";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $count = $stmt->fetchColumn();
    return (int) $count;
}

/**
 * Récupère la liste de tous les tickets avec leurs urgences et statuts associés
 * Trié par date de création décroissante (les plus récents en premier)
 * @return array Un tableau associatif contenant les données des tickets
 */
function get_tickets()
{
    $pdo = get_bdd();

    $sql = "SELECT t.*, 
                   u.libelle_urgence, 
                   s.libelle_statut
            FROM TICKETS t
            LEFT JOIN NIVEAU_URGENCE u ON t.id_urgence = u.id_urgence
            LEFT JOIN STATUT s ON t.id_statut = s.id_statut
            ORDER BY t.date_creation DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
