<?php
// ModelDetail_ticket.php
require_once __DIR__ . '/ModelBDD.php';

/**
 * Récupère les informations d'un ticket par son numéro unique
 */
function get_ticket_par_numero($num_ticket)
{
    $pdo = get_bdd();
    $sql = "SELECT t.*, s.libelle_statut, u.libelle_urgence 
            FROM TICKETS t
            LEFT JOIN STATUT s ON t.id_statut = s.id_statut
            LEFT JOIN NIVEAU_URGENCE u ON t.id_urgence = u.id_urgence
            WHERE t.numero_ticket = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$num_ticket]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Récupère les pièces jointes d'un ticket
 */
function get_pieces_jointes_par_ticket($num_ticket)
{
    $pdo = get_bdd();
    $sql = "SELECT pj.* FROM PIECES_JOINTES pj
            INNER JOIN TICKETS t ON t.id_ticket = pj.id_ticket
            WHERE t.numero_ticket = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$num_ticket]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
