<?php
// ModedLes_Clients.php

require_once __DIR__ . '/ModelBDD.php';


/**
 * Récupère les entreprises avec une limite et un filtre de recherche
 */
function obtenir_entreprises_filtres_pagine($recherche, $limite, $offset)
{
    $pdo = get_bdd();

    $sql = "SELECT DISTINCT c.id_client, c.nom_entreprise, c.cp, c.ville, c.nom, c.prenom, c.email, c.telephone, c.id_logiciel, l.logiciel, c.observation
        FROM CLIENT c
        LEFT JOIN LOGICIEL l ON c.id_logiciel = l.id_logiciel
            WHERE c.nom_entreprise LIKE :recherche 
            OR c.nom LIKE :recherche 
            OR c.prenom LIKE :recherche
            OR c.email LIKE :recherche 
            OR c.telephone LIKE :recherche 
            OR c.ville LIKE :recherche
            ORDER BY c.nom_entreprise ASC
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
function modifier_entreprise_par_id($id_client, $nom_entreprise, $nouvel_id_client, $id_logiciel, $nom, $prenom, $cp, $ville, $email, $telephone, $observation)
{
    $pdo = get_bdd();

    $sql = "UPDATE CLIENT 
            SET id_client = ?,
                nom_entreprise = ?, 
                nom = ?, 
                prenom = ?, 
                cp = ?, 
                ville = ?, 
                email = ?, 
                telephone = ?, 
                id_logiciel = ?, 
                observation = ? 
            WHERE id_client = ?";

    try {
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $nouvel_id_client,
            $nom_entreprise,
            $nom,
            $prenom,
            $cp,
            $ville,
            $email,
            $telephone,
            $id_logiciel, // ID numérique transmis ici
            $observation,
            $id_client
        ]);
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * Obtenir la liste de tous les logiciels
 */
function get_liste_logiciels()
{
    $pdo = get_bdd();
    $sql = "SELECT id_logiciel, logiciel FROM LOGICIEL ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * Supprimer un client en vérifiant qu'il n'a pas de ticket dans la bdd
 */
function supprimer_client_sans_ticket($id_client)
{
    $pdo = get_bdd();


    $sql = "DELETE FROM CLIENT 
            WHERE id_client = :id_client 
            AND NOT EXISTS (
                SELECT 1 FROM TICKETS WHERE id_entreprise = :id_client_tickets
            )";

    try {
        $stmt = $pdo->prepare($sql);


        $stmt->bindValue(':id_client', $id_client, PDO::PARAM_STR);
        $stmt->bindValue(':id_client_tickets', $id_client, PDO::PARAM_STR);

        $stmt->execute();

        // Retourne true si une ligne a effectivement été supprimée
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("Erreur lors de la suppression du client : " . $e->getMessage());
        return false;
    }
}
