<?php
// ModelMail.php
require_once __DIR__ . '/ModelBDD.php';

/**
 * Récupère l'email de l'admin (id_client = 1)
 */
function get_email_admin(): string
{
    $pdo = get_bdd();
    $stmt = $pdo->prepare("SELECT email FROM CLIENT WHERE id_client = 1");
    $stmt->execute();
    return $stmt->fetchColumn();
}

/**
 * Récupère le nom et prénom d'un client par son id
 */
function get_nom_client_par_id(string $id_client): string
{
    $pdo = get_bdd();
    $stmt = $pdo->prepare("SELECT nom_entreprise FROM CLIENT WHERE id_client = ?");
    $stmt->execute([$id_client]);
    return $stmt->fetchColumn() ?: '';
}
