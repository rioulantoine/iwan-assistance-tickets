<?php
// ModelNouveau_suivi.php
//Execute les requetes sql pour créé un suivi
require_once __DIR__ . '/ModelBDD.php';

/**
 * Trouve l'id de l'entreprise à partir de son nom, ou retourne false si elle n'existe pas
 */
function trouver_id_entreprise($nom_entreprise)
{
    $pdo = get_bdd();

    $sql = "SELECT id_client
            FROM CLIENT
            WHERE nom_entreprise = ? 
            LIMIT 1 ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom_entreprise]);
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultat ? $resultat['id_client'] : false;
}


/**
 * Génere un numero de ticket unique 
 */
function generer_numero_suivi()
{
    $pdo = get_bdd();

    $est_unique = false;
    $nouveau_numero = '';

    while ($est_unique === false) {
        // On récupere l'année et le mois    
        $date = date('ym');

        // génere une suite de 4 caractères et les mets en majuscule
        $aleatoire = strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));

        $nouveau_numero = "SV-{$date}-{$aleatoire}";
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




function inserer_nouveau_suivi(
    $numero_suivi,
    $id_entreprise,
    $date,
    $logiciel,
    $type_suivi,
    $nom_contact,
    $prenom_contact,
    $email,
    $telephone,
    $titre,
    $id_statut,
    $notes
) {
    $pdo = get_bdd();
    $sql = "INSERT INTO TICKETS (
        type,
        numero_ticket,
        declarant_nom,
        declarant_prenom,
        declarant_telephone,
        declarant_email,
        type_suivi,
        logiciel,
        titre,
        description,
        date_creation,
        id_entreprise,
        id_statut)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $resultat = $stmt->execute([
        1,
        $numero_suivi,
        $nom_contact,
        $prenom_contact,
        $telephone,
        $email,
        $type_suivi,
        $logiciel,
        $titre,
        $notes,
        $date,
        $id_entreprise,
        $id_statut
    ]);

    if (!$resultat) {
        print_r($stmt->errorInfo());
        return false;
    }

    return $pdo->lastInsertId();
}
