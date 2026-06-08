<?php
// ModedLes_Clients.php

require_once __DIR__ . '/ModelBDD.php';


/**
 * Récupère les entreprises avec une limite et un filtre de recherche
 */
function obtenir_entreprises_filtres_pagine($recherche, $limite, $offset)
{
    $pdo = get_bdd();

    $sql = "SELECT DISTINCT id_client,nom_entreprise,cp,ville, nom, prenom, email, telephone,observation
            FROM CLIENT
            WHERE nom_entreprise LIKE :recherche 
            OR nom LIKE :recherche 
            OR prenom LIKE :recherche
            OR email LIKE :recherche 
            OR telephone LIKE :recherche 
            OR ville LIKE :recherche
            ORDER BY nom_entreprise ASC
            LIMIT :limite OFFSET :offset";

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':recherche', '%' . $recherche . '%', PDO::PARAM_STR);
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



/**
 * Compte le nombre total d'entreprises correspondant a la recherche 
 * Sert a générer les bouton de pagination
 */
function compter_entreprises_filtres($recherche)
{
    $pdo = get_bdd();
    $sql = "SELECT COUNT(DISTINCT nom_entreprise)
            FROM CLIENT
            WHERE nom_entreprise LIKE :recherche";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['recherche' => '%' . $recherche . '%']);

    return (int)$stmt->fetchColumn();
}

/**
 * Modifier les informations d'une entreprise
 */
function modifier_entreprise_par_id($id_client, $nom_entreprise, $nom, $prenom, $cp, $ville, $email, $telephone, $observation)
{
    $pdo = get_bdd();

    $sql = "UPDATE CLIENT 
            SET nom_entreprise = ?, 
                nom = ?, 
                prenom = ?, 
                cp = ?, 
                ville = ?, 
                email = ?, 
                telephone = ?, 
                observation = ? 
            WHERE id_client = ?";

    try {
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $nom_entreprise,
            $nom,
            $prenom,
            $cp,
            $ville,
            $email,
            $telephone,
            $observation,
            $id_client
        ]);
    } catch (PDOException $e) {
        // En cas de debug : error_log($e->getMessage());
        return false;
    }
}
