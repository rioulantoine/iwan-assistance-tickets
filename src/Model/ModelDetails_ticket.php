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


/**
 * Met a jour le statut d'un ticket et les dates de résolution et d'archivage en fonction du nouveau statut
 * @param string $num_ticket Le numéro unique du ticket à modifier
 * @param int $id_statut L'ID du nouveau statut (1: En attente, 2: En cours, 3: Résolu, 4: Archivé)
 */
function modifier_statut_ticket($num_ticket, $id_statut)
{
    $pdo = get_bdd();
    $id_resolu = 3;
    $id_archive = 4;

    if ($id_statut == $id_resolu) {
        $sql = "UPDATE TICKETS
                SET id_statut = ?, date_resolution = NOW(), date_archivage = NULL 
                WHERE numero_ticket = ?";
    } elseif ($id_statut == $id_archive) {
        $sql = "UPDATE TICKETS
            SET id_statut = ? , date_archivage = NOW()
            WHERE numero_ticket = ?";
    } else {
        $sql = "UPDATE TICKETS
              SET id_statut = ?, date_resolution = NULL, date_archivage = NULL
              WHERE numero_ticket = ?";
    }


    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_statut, $num_ticket]);
}


function supprimer_ticket_par_numero($num_ticket)
{
    $pdo = get_bdd();
    $dossier_upload = __DIR__ . '/../../public/uploads/';
    try {
        // On récupere l'id 
        $sqlID = "SELECT id_ticket 
              FROM TICKETS
              WHERE numero_ticket = ?";
        $stmtID = $pdo->prepare($sqlID);
        $stmtID->execute([$num_ticket]);
        $ticket = $stmtID->fetch(PDO::FETCH_ASSOC);
        if (!$ticket) {
            return false;
        }
        $id_ticket = $ticket['id_ticket'];
        //On récupère les noms de stockage de toutes les pièces jointes a supprimer

        // Fichiers du ticket
        $sqlPJTicket = "SELECT nom_stockage FROM PIECES_JOINTES WHERE id_ticket = ?";
        $stmt1 = $pdo->prepare($sqlPJTicket);
        $stmt1->execute([$id_ticket]);
        $fichiersTicket = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        // Fichiers des réponses 
        $sqlPJReponse = "SELECT nom_stockage FROM PIECES_JOINTES 
                    WHERE id_reponse IN (SELECT id_reponse FROM REPONSE WHERE id_ticket = ?)";
        $stmt2 = $pdo->prepare($sqlPJReponse);
        $stmt2->execute([$id_ticket]);
        $fichiersReponse = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        $tousLesFichiers = array_merge($fichiersTicket, $fichiersReponse);


        // On supprime les fichiers sur le serveur 
        foreach ($tousLesFichiers as $fichier) {
            if (!empty($fichier['nom_stockage'])) {
                $chemin_complet = $dossier_upload . $fichier['nom_stockage'];
                if (file_exists($chemin_complet)) {
                    unlink($chemin_complet);
                }
            }
        }

        // SUPPRESSION BDD
        $pdo->beginTransaction(); // Tout se passe ou rien 
        // On supprime les pieces jointes des réponses

        $sqlDeletePJReponse = "DELETE FROM PIECES_JOINTES
            WHERE id_reponse IN (SELECT id_reponse FROM REPONSE WHERE id_ticket = ?)";
        $pdo->prepare($sqlDeletePJReponse)->execute([$id_ticket]);
        // On supprime les pieces jointes du ticket
        $sqlDeletePJTicket = "DELETE FROM PIECES_JOINTES
            WHERE id_ticket = ?";
        $pdo->prepare($sqlDeletePJTicket)->execute([$id_ticket]);

        // On supprime les réponses 
        $sqlDeleteReponse = "DELETE FROM REPONSE
            WHERE id_ticket = ?";
        $pdo->prepare($sqlDeleteReponse)->execute([$id_ticket]);

        // On supprime le ticket
        $sqlDeleteTicket = "DELETE FROM TICKETS
            WHERE id_ticket = ? ";
        $pdo->prepare($sqlDeleteTicket)->execute([$id_ticket]);


        $pdo->commit(); // On valide l'execution
        return true;
    } catch (Exception $e) {
        // En cas de problème, on annule tout en BDD
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        return false;
    }
}
