<?php
// ModelNouveau_ticket.php
require_once __DIR__ . '/ModelBDD.php';

/**
 * Récupère les entreprises avec une limite, un filtre de recherche et leur logiciel
 */
function obtenir_entreprises_filtres_pagine($recherche, $limite, $offset)
{
    $pdo = get_bdd();

    $sql = "SELECT DISTINCT c.id_client, c.nom_entreprise, c.cp, c.ville, c.nom, c.prenom, c.email, c.telephone, c.id_logiciel, l.logiciel
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
 * Compte le nombre total d'entreprises correspondant à la recherche 
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
 * Récupère la liste de toutes les entreprises
 */
function obtenir_liste_entreprise()
{
    $pdo = get_bdd();
    $sql = "SELECT DISTINCT id_client, nom_entreprise, ville, nom, prenom, email, telephone FROM CLIENT";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Trouve l'id de l'entreprise à partir de son nom
 */
function trouver_id_entreprise($nom_entreprise)
{
    $pdo = get_bdd();
    $sql = "SELECT id_client FROM CLIENT WHERE nom_entreprise = ? LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom_entreprise]);
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultat ? $resultat['id_client'] : false;
}

/**
 * Récupérer les informations du client avec son logiciel
 */
function get_info_client($id_client)
{
    $pdo = get_bdd();
    $sql = "SELECT c.id_client, c.nom, c.prenom, c.email, c.id_logiciel, l.logiciel, c.telephone 
            FROM CLIENT c
            LEFT JOIN LOGICIEL l ON c.id_logiciel = l.id_logiciel
            WHERE c.id_client = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_client]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Récupère tous les logiciels pour le select de la vue
 */
function get_liste_logiciels()
{
    $pdo = get_bdd();
    $sql = "SELECT id_logiciel, logiciel FROM LOGICIEL ORDER BY id_logiciel ASC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Génère un numéro de ticket unique 
 */
function generer_numero_ticket()
{
    $pdo = get_bdd();
    $est_unique = false;
    $nouveau_numero = '';

    while ($est_unique === false) {
        $date = date('ym');
        $aleatoire = strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
        $nouveau_numero = "TKT-{$date}-{$aleatoire}";

        $sql = "SELECT COUNT(id_ticket) FROM TICKETS WHERE numero_ticket = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nouveau_numero]);

        if ((int)$stmt->fetchColumn() === 0) {
            $est_unique = true;
        }
    }
    return $nouveau_numero;
}

/**
 * Insère le ticket dans la base de données
 */
function inserer_nouveau_ticket(
    $numero_ticket,
    $nom_declarant,
    $prenom_declarant,
    $telephone,
    $email,
    $titre,
    $description,
    $date_creation,
    $id_entreprise,
    $niveau_urgence,
    $id_statut
) {
    $pdo = get_bdd();
    $sql = "INSERT INTO TICKETS (
                type, numero_ticket, declarant_nom, declarant_prenom, 
                declarant_telephone, declarant_email, titre, description, 
                date_creation, id_entreprise, id_urgence, id_statut
            ) VALUES (0, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $resultat = $stmt->execute([
        $numero_ticket,
        $nom_declarant,
        $prenom_declarant,
        $telephone,
        $email,
        $titre,
        $description,
        $date_creation,
        $id_entreprise,
        $niveau_urgence,
        $id_statut
    ]);

    return $resultat ? $pdo->lastInsertId() : false;
}

/**
 * Ajoute les pièces jointes 
 */
function inserer_piece_jointe($nom_original, $nom_stockage, $type, $taille_octets, $date_upload, $id_ticket)
{
    $pdo = get_bdd();
    $sql = "INSERT INTO PIECES_JOINTES (
                nom_origine, nom_stockage, type, taille_octets, date_upload, id_reponse, id_ticket
            ) VALUES (?, ?, ?, ?, ?, null, ?)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$nom_original, $nom_stockage, $type, $taille_octets, $date_upload, $id_ticket]);
}
