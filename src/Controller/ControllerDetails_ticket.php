<?php
// ControllerDetails_ticket.php
// Fichier qui permet de gérer la page Détails ticket
require_once __DIR__ . '/../Model/ModelDetails_ticket.php';

// 1. Récupération des informations de base du ticket
$num_ticket = $_GET['ticket'] ?? 'Numéro de ticket non spécifié';
$details_ticket = get_ticket_par_numero($num_ticket);
$pieces_jointes = get_pieces_jointes_par_ticket($num_ticket);

if ($details_ticket === false) {
    header("Location: index.php?page=accueil");
    exit;
}

// 2. Formatage de la date de création
$date_ticket = isset($details_ticket['date_creation']) ? date('d/m/Y H:i', strtotime($details_ticket['date_creation'])) : 'Date non spécifiée';
$ecart_date_ticket = '';

// =========================================================================
// 🛠️ BLOC DE CALCUL DE LA DURÉE / ANCIENNETÉ (INTÉGRÉ ICI)
// =========================================================================
$est_resolu = ((int)($details_ticket['id_statut'] ?? 0) === 3 || !empty($details_ticket['date_resolution']));

if (isset($details_ticket['date_creation'])) {
    $date_creation_obj = new DateTime($details_ticket['date_creation']);

    if ($est_resolu) {
        // CAS 1 : Le ticket est résolu -> On calcule le temps qu'a pris le traitement
        $date_fin_obj = new DateTime($details_ticket['date_resolution']);
        $interval = $date_creation_obj->diff($date_fin_obj);

        if ($interval->days > 0) {
            $ecart_date_ticket = 'Résolu en : ' . $interval->format('%aj %hh');
        } elseif ($interval->h > 0) {
            $ecart_date_ticket = 'Résolu en : ' . $interval->format('%hh %imin');
        } else {
            $ecart_date_ticket = 'Résolu en : ' . $interval->format('%imin');
        }
    } else {
        // CAS 2 : Le ticket est toujours ouvert -> On calcule son ancienneté par rapport à "maintenant"
        $date_fin_obj = new DateTime();
        $interval = $date_creation_obj->diff($date_fin_obj);

        if ($interval->days > 0) {
            $ecart_date_ticket = $interval->days . ($interval->days > 1 ? ' jours' : ' jour') . ' plus tôt';
        } elseif ($interval->h > 0) {
            $ecart_date_ticket = $interval->format('%hh%I') . ' plus tôt';
        } else {
            $ecart_date_ticket = $interval->format('%i') . 'min plus tôt';
        }
    }
}
// =========================================================================

// 3. Récupération et liaison des réponses avec leurs pièces jointes
$id_ticket = $details_ticket['id_ticket'];
$reponses = get_reponse_ticket($id_ticket);

foreach ($reponses as &$reponse) {
    // On crée une nouvelle clé 'pieces_jointes' dans le tableau de la réponse
    $reponse['pieces_jointes'] = get_pieces_jointes_par_reponse($reponse['id_reponse']);
}
unset($reponse);

// 4. Gestion des actions du formulaire (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // ==========================================
    // ACTION : MODIFICATION DES NOTES DU SUIVI
    // ==========================================
    if ($action === 'modifier_notes') {
        $nouvelle_desc = trim($_POST['description'] ?? '');

        if (modifier_description_ticket($num_ticket, $nouvelle_desc)) {
            maj($details_ticket['id_ticket'], $num_ticket, "Modification des notes de suivi");
        }

        header("Location: index.php?page=detail_ticket&ticket=" . urlencode($num_ticket));
        exit;
    }

    // ==========================================
    // ACTION : AJOUT D'UNE NOUVELLE RÉPONSE
    // ==========================================
    if ($action === 'ajouter_reponse') {
        $titre = trim($_POST['titre'] ?? '');
        $contenu = trim($_POST['contenu'] ?? '');
        $id_ticket_post = $details_ticket['id_ticket'];
        $id_parent = trim($_POST['id_parent'] ?? '');

        if ($_SESSION['is_admin'] ?? false) {
            $est_admin = 1;
        } else {
            $est_admin = 0;
        }

        $erreurs = [];

        // Vérification titre
        if (empty($titre) && !($_SESSION['is_admin'] ?? false)) {
            $erreurs[] = "Le titre est obligatoire";
        }

        // Vérification contenu
        if (empty($contenu)) {
            $erreurs[] = "Le message doit avoir un contenu";
        }

        // Vérification id_ticket
        if (empty($id_ticket_post)) {
            $erreurs[] = "Il n'y a pas de ticket";
        }

        if (!empty($erreurs)) {
            $_SESSION['flash_message'] = implode('<br>', $erreurs);
            $_SESSION['flash_type'] = "error";
        } else {
            $date_envoi = date('Y-m-d H:i:s');

            if (!empty($id_parent)) {
                $id_reponse = inserer_nouvelle_reponse(
                    $titre,
                    $contenu,
                    $date_envoi,
                    $est_admin,
                    $id_ticket_post,
                    $id_parent
                );
            } else {
                $id_reponse = inserer_nouvelle_reponse(
                    $titre,
                    $contenu,
                    $date_envoi,
                    $est_admin,
                    $id_ticket_post
                );
            }

            maj($id_ticket_post, null, "Nouvelle réponse");

            $fichiers = $_FILES['fichier'] ?? null;
            if (!empty($fichiers['name'][0]) && $id_reponse) {
                $dossier = __DIR__ . '/../../public/uploads/';
                if (!is_dir($dossier)) {
                    mkdir($dossier, 0777, true);
                }
                for ($i = 0; $i < count($fichiers['name']); $i++) {
                    $nom_original = $fichiers['name'][$i];
                    $nom_original = preg_replace('/[^a-zA-Z0-9._-]/', '_', $nom_original);
                    $tmp = $fichiers['tmp_name'][$i];
                    $type = $fichiers['type'][$i];
                    $taille = $fichiers['size'][$i];
                    $extension = pathinfo($nom_original, PATHINFO_EXTENSION);
                    $nom_stockage = uniqid() . '.' . $extension;
                    $chemin = $dossier . $nom_stockage;

                    if (!move_uploaded_file($tmp, $chemin)) {
                        $erreurs[] = "Erreur lors de l'upload du fichier : " . $nom_original;
                        continue;
                    }

                    inserer_piece_jointe(
                        $nom_original,
                        $nom_stockage,
                        $type,
                        $taille,
                        date('Y-m-d H:i:s'),
                        $id_reponse
                    );
                }
            }
            header("Location: index.php?page=detail_ticket&ticket=" . urlencode($details_ticket['numero_ticket']) . "#reponse-" . $id_reponse);
            exit;
        }
    }
}

// Chargement de la vue
require_once __DIR__ . '/../View/Details_ticket.php';
