<?php

require_once __DIR__ . '/ModelBDD.php';

function get_nb_tickets_user($id)
{
    $pdo = get_bdd();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM TICKETS WHERE id_entreprise = :id_user");
    $stmt->execute(['id_user' => $id]);
    return $stmt->fetchColumn();
}
