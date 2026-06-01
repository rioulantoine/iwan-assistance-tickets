<?php

require_once __DIR__ . '/ModelBDD.php';

function get_nb_tickets($id_client)
{
    $pdo = get_bdd();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tickets WHERE id_client = :id_client");
    $stmt->execute(['id_client' => $id_client]);
    return $stmt->fetchColumn();
}
