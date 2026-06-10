<?php
// ModelDetail_ticket.php
require_once __DIR__ . '/ModelBDD.php';

/**
 * Récupère les informations d'un ticket par son numéro unique
 */
function get_ticket_par_numero($num_ticket)
{
    $pdo = get_bdd();

    $sql = "SELECT t.*, s.libelle_statut, u.libelle_urgence, c.nom_entreprise, l.logiciel
            FROM TICKETS t
            LEFT JOIN STATUT s ON t.id_statut = s.id_statut
            LEFT JOIN NIVEAU_URGENCE u ON t.id_urgence = u.id_urgence
            LEFT JOIN CLIENT c ON t.id_entreprise = c.id_client
            LEFT JOIN LOGICIEL l ON t.id_logiciel = l.id_logiciel
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
                SET id_statut = ?, date_resolution = NOW(), date_archivage = NULL, date_maj = NOW()
                WHERE numero_ticket = ? 
                AND id_statut != ?";
    } elseif ($id_statut == $id_archive) {
        $sql = "UPDATE TICKETS
            SET id_statut = ? , date_archivage = NOW(), date_maj = NOW()
            WHERE numero_ticket = ?
            AND id_statut != ?";
    } else {
        $sql = "UPDATE TICKETS
              SET id_statut = ?, date_resolution = NULL, date_archivage = NULL, date_maj = NOW()
              WHERE numero_ticket = ?
              AND id_statut != ?";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_statut, $num_ticket, $id_statut]);
}

function modifier_urgence_ticket($num_ticket, $nouvel_id_urgence)
{
    $pdo = get_bdd();

    $sql = "UPDATE TICKETS
            SET id_urgence = ?
            WHERE numero_ticket = ? 
            AND id_urgence != ?";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$nouvel_id_urgence, $num_ticket, $nouvel_id_urgence]);
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

/**
 * Supprimer la réponse ainsi que les pieces jointes et id_parent
 */
function supprimer_reponse_par_id($id_reponse)
{
    $pdo = get_bdd();
    $dossier_upload = __DIR__ . '/../../public/uploads/';

    try {
        $sqlPJReponse = "SELECT nom_stockage FROM PIECES_JOINTES WHERE id_reponse = ?";
        $stmt1 = $pdo->prepare($sqlPJReponse);
        $stmt1->execute([$id_reponse]);
        $fichiersReponse = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        $pdo->beginTransaction();

        // On supprime les pièces jointes de la réponse en BDD
        $sqlDeletePJReponse = "DELETE FROM PIECES_JOINTES WHERE id_reponse = ?";
        $pdo->prepare($sqlDeletePJReponse)->execute([$id_reponse]);

        // On enleve l'id parent des réponses lié
        $sqlupdateIDparent = "UPDATE REPONSE 
                              SET id_parent = NULL
                              WHERE id_parent = ?";
        $pdo->prepare($sqlupdateIDparent)->execute([$id_reponse]);

        // On supprime la réponse maîtresse en BDD
        $sqlDeleteReponse = "DELETE FROM REPONSE WHERE id_reponse = ?";
        $pdo->prepare($sqlDeleteReponse)->execute([$id_reponse]);

        //Si tout s'est bien passé en BDD, on valide la transaction
        $pdo->commit();

        foreach ($fichiersReponse as $fichier) {
            if (!empty($fichier['nom_stockage'])) {
                $chemin_complet = $dossier_upload . $fichier['nom_stockage'];
                if (file_exists($chemin_complet)) {
                    unlink($chemin_complet);
                }
            }
        }

        return true;
    } catch (Exception $e) {
        // En cas de problème, on annule tout en BDD et les fichiers restent intacts
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        return false;
    }
}

/**
 * Récupère la/les réponse d'un ticket
 */
function get_reponse_ticket($id_ticket)
{
    $pdo = get_bdd();

    $sql = "SELECT r.*, parent.titre AS titre_parent 
        FROM REPONSE r
        LEFT JOIN REPONSE parent ON r.id_parent = parent.id_reponse
        WHERE r.id_ticket = ?
        ORDER BY r.date_envoi ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_ticket]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


/**
 * Insere la réponse
 */
function inserer_nouvelle_reponse(
    $titre,
    $contenu,
    $date_envoi,
    $est_admin,
    $id_ticket,
    $id_parent = null
) {
    $pdo = get_bdd();
    $sql = "INSERT INTO REPONSE (
        titre,
        contenu,
        date_envoi,
        est_admin,
        id_ticket,
        id_parent)
        VALUES (?,?,?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    $resultat = $stmt->execute([
        $titre,
        $contenu,
        $date_envoi,
        $est_admin,
        $id_ticket,
        $id_parent
    ]);

    if (!$resultat) {
        print_r($stmt->errorInfo());
        return false;
    }
    return $pdo->lastInsertId();
}


/**
 * Récupère les pièces jointes d'une réponse
 */
function get_pieces_jointes_par_reponse($id_reponse)
{
    $pdo = get_bdd();
    $sql = "SELECT pj.* FROM PIECES_JOINTES pj
            WHERE id_reponse = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_reponse]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Function pour insérer une piece jointe dans la bdd
 */
function inserer_piece_jointe(
    $nom_origine,
    $nom_stockage,
    $type,
    $taille_octets,
    $date_upload,
    $id_reponse,
    $id_ticket = null
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
        $id_reponse,
        $id_ticket
    ]);
}

/**
 * Mettre a jour la date du ticket
 */
function maj($id_ticket = null, $num_ticket = null, $derniere_action = "Ticket créé")
{
    $pdo = get_bdd();

    $sql = "UPDATE TICKETS
            SET 
                date_maj = NOW(),
                derniere_action = ?
            WHERE id_ticket = ? OR numero_ticket = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$derniere_action, $id_ticket, $num_ticket]);
}

/**
 * Met à jour uniquement la description (les notes) d'un ticket/suivi
 */
function modifier_description_ticket($num_ticket, $nouvelle_description)
{
    $pdo = get_bdd();
    $sql = "UPDATE TICKETS 
            SET description = ? 
            WHERE numero_ticket = ?";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$nouvelle_description, $num_ticket]);
}
