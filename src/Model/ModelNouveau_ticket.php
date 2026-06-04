<?php
// ModelAccueil.php
// Fichier qui permet de récuperer les données pour le controlleur de la page Nouveau ticket
require_once __DIR__ . '/ModelBDD.php';

/**
 * Récupère la liste des entreprises ayant déjà créé un ticket
 */
function obtenir_liste_entreprise()
{
    $pdo = get_bdd();

    $sql = "SELECT DISTINCT nom_entreprise
            FROM CLIENT
            WHERE nom_entreprise IS NOT NULL";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Trouve l'id de l'entreprise à partir de son nom, ou retourne false si elle n'existe pas
 * innutile avec la table client
 */
function trouver_id_entreprise($nom_entreprise)
{
    $pdo = get_bdd();

    $sql = "SELECT id_entreprise 
            FROM TICKETS
            WHERE nom_entreprise = ? 
            LIMIT 1 ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom_entreprise]);
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultat ? $resultat['id_entreprise'] : false;
}


/**
 * Récupérer les informations client
 * @param id_client
 */
function get_info_client($id_client)
{
    $pdo = get_bdd();
    $sql = "SELECT id_client, nom, prenom, email, telephone 
            FROM CLIENT
            WHERE id_client = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_client]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
/**
 * Génere un numero de ticket unique 
 */
function generer_numero_ticket()
{
    $pdo = get_bdd();

    $est_unique = false;
    $nouveau_numero = '';

    while ($est_unique === false) {
        // On récupere l'année et le mois    
        $date = date('ym');

        // génere une suite de 4 caractères et les mets en majuscule
        $aleatoire = strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));

        $nouveau_numero = "TKT-{$date}-{$aleatoire}";
        // On vérifie que le numéro n'existe pas dans la bdd

        $sql = "SELECT COUNT(id_ticket) FROM TICKETS WHERE numero_ticket = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nouveau_numero]);

        $compteur = (int)$stmt->fetchColumn();

        if ($compteur === 0) {
            $est_unique = true;
        }
    }
    return $nouveau_numero;
}

/**
 * Insere le ticket dans la base de données
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
    numero_ticket,
    declarant_nom,
    declarant_prenom,
    declarant_telephone,
    declarant_email,
    titre,
    description,
    date_creation,
    id_entreprise,
    id_urgence,
    id_statut)
    VALUES(?,?,?,?,?,?,?,?,?,?,?)";
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

    if (!$resultat) {
        print_r($stmt->errorInfo());
        return false;
    }

    return $pdo->lastInsertId();
}

/**
 * Ajoute les pieces jointes 
 */

function inserer_piece_jointe(
    $nom_origine,
    $nom_stockage,
    $type,
    $taille_octets,
    $date_upload,
    $id_ticket
) {

    $pdo = get_bdd();

    $sql = "INSERT INTO PIECES_JOINTES (
        nom_origine,
        nom_stockage,
        type,
        taille_octets,
        date_upload,
        id_reponse,
        id_ticket
    ) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        $nom_origine,
        $nom_stockage,
        $type,
        $taille_octets,
        $date_upload,
        null,
        $id_ticket
    ]);
}
