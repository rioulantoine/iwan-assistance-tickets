<?php
// ControllerNouveau_ticket.php
require_once __DIR__ . '/../Model/ModelNouveau_ticket.php';

// ==========================================================================
// 1. INTERCEPTION DE LA CRÉATION RAPIDE (AJAX MODALE) - PRIORITÉ HAUTE
// ==========================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action_creation_rapide'])) {
    require_once __DIR__ . '/../Model/ModelNouveau_Client.php';

    $id_client      = trim($_POST['id_client'] ?? '');
    $nom_entreprise = trim($_POST['nom_entreprise'] ?? '');
    $cp             = trim($_POST['cp'] ?? '');
    $ville          = trim($_POST['ville'] ?? '');
    $nom            = trim($_POST['nom'] ?? '');
    $prenom         = trim($_POST['prenom'] ?? '');
    $email          = trim($_POST['email'] ?? '');
    $telephone      = trim($_POST['telephone'] ?? '');
    $id_logiciel    = !empty($_POST['id_logiciel']) ? (int)$_POST['id_logiciel'] : null;
    $observation    = "";

    $succes = inserer_nouveau_client($id_client, $nom_entreprise, $cp, $ville, $nom, $prenom, $email, $telephone, $id_logiciel, $observation);

    echo $succes ? "success" : "error";
    exit(); // Stoppe net pour ne pas corrompre la réponse AJAX avec le HTML de la vue
}

// ==========================================================================
// 2. INITIALISATION ET PARAMÉTRAGE DES ONGLETS / RECHERCHES
// ==========================================================================
$logiciel_couleur = '#64748b';
$tab_actif = $_GET['tab'] ?? 'ticket';

if (!($_SESSION['is_admin'] ?? false)) {
    $tab_actif = 'ticket';
}

// Nettoyage de sécurité basique si premier accès à froid
if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_GET['ouvrir_modal'])) {
    $_POST = [];
}

// Données nécessaires à la vue (Liste des logiciels)
$liste_logiciels = get_liste_logiciels();

// Pagination et filtres pour la modale liste des entreprises (Admins uniquement)
$recherche = trim($_GET['recherche'] ?? '');
$page_entreprise = max(1, (int)($_GET['page_entreprise'] ?? 1));
$limite = 10;
$offset = ($page_entreprise - 1) * $limite;

$liste_entreprises = obtenir_entreprises_filtres_pagine($recherche, $limite, $offset);
$total_entreprises = compter_entreprises_filtres($recherche);
$total_pages = ceil($total_entreprises / $limite);
$nb_entreprises = count($liste_entreprises);

// Autocomplétion de la datalist pour la saisie manuelle de secours
$liste_nom_entreprise = obtenir_liste_entreprise();
$entreprises_noms = array_column($liste_nom_entreprise, 'nom_entreprise');
if (!in_array('IWAN', $entreprises_noms, true)) {
    $liste_nom_entreprise[] = ['nom_entreprise' => 'IWAN'];
}

// Contexte Client standard
if (!($_SESSION['is_admin'] ?? false)) {
    $id_client = $_SESSION['id_client'] ?? null;
    $infos_client = get_info_client($id_client);
} else {
    $infos_client = [];
}

// ==========================================================================
// 3. TRAITEMENT DE LA SOUMISSION TRADITIONNELLE DU TICKET
// ==========================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {



    // Action B : Enregistrement du ticket final
    if (isset($_POST['nouveau-ticket'])) {
        $nom_declarant = trim($_POST['nom'] ?? '');
        $prenom_declarant = trim($_POST['prenom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telephone = trim($_POST['telephone'] ?? '');
        $id_logiciel = $_POST['id_logiciel'] ?? null;
        $niveau_urgence = trim($_POST['niveau_urgence'] ?? '3');
        $titre = trim($_POST['titre'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $erreurs = [];

        if ($id_logiciel === '') $id_logiciel = null;

        // Validations spécifiques pour les clients (les admins ont le droit de modifier ces infos)
        if (empty($nom_declarant) && !($_SESSION['is_admin'] ?? false)) $erreurs[] = "Le nom est obligatoire.";
        if (empty($prenom_declarant) && !($_SESSION['is_admin'] ?? false)) $erreurs[] = "Le prénom est obligatoire.";
        if (empty($email) && !($_SESSION['is_admin'] ?? false)) {
            $erreurs[] = "L'email est obligatoire.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !($_SESSION['is_admin'] ?? false)) {
            $erreurs[] = "L'email n'est pas valide.";
        }
        if (empty($telephone) && !($_SESSION['is_admin'] ?? false)) $erreurs[] = "Le téléphone est obligatoire.";

        $urgences_valides = ['1', '2', '3', '4'];
        if (!in_array($niveau_urgence, $urgences_valides)) $erreurs[] = "Le niveau d'urgence est invalide.";
        if (empty($titre)) $erreurs[] = "Le titre est obligatoire.";
        if (empty($description)) $erreurs[] = "La description est obligatoire.";

        // Résolution de l'ID entreprise cible
        if ($_SESSION['is_admin'] ?? false) {
            $nom_entreprise = trim($_POST['nom_entreprise'] ?? '');
            $id_entreprise = trouver_id_entreprise($nom_entreprise);
            if (empty($id_entreprise)) {
                $erreurs[] = "Veuillez sélectionner une entreprise valide avant de créer le ticket.";
            }
        } else {
            $id_entreprise = $_SESSION['id_client'];
        }

        if (!empty($erreurs)) {
            $_SESSION['flash_message'] = implode('<br>', $erreurs);
            $_SESSION['flash_type'] = "error";
        } else {
            $numero_ticket = generer_numero_ticket();
            $date_creation = date('Y-m-d H:i:s');
            $id_statut = 1; // En attente par défaut

            $id_ticket = inserer_nouveau_ticket(
                $numero_ticket,
                $nom_declarant,
                $prenom_declarant,
                $telephone,
                $email,
                $id_logiciel,
                $titre,
                $description,
                $date_creation,
                $id_entreprise,
                $niveau_urgence,
                $id_statut
            );
            if ($id_ticket) {
                require_once __DIR__ . '/../Mail/Mail.php';
                require_once __DIR__ . '/../Model/ModelMail.php';

                $urgences = ['1' => 'Bloquant / Très urgent', '2' => 'Urgent', '3' => 'Normal', '4' => 'Non urgent'];
                $libelle_urgence = $urgences[$niveau_urgence] ?? 'Normal';
                $date_formatee = (new DateTime($date_creation))->format('d/m/Y à H:i');
                $nom_entreprise = get_nom_client_par_id($id_entreprise);
                $sujet = "Nouveau ticket créé : {$titre}";
                $corps = template_nouveau_ticket_admin(
                    $numero_ticket,
                    $nom_entreprise,
                    $prenom_declarant,
                    $nom_declarant,
                    $email,
                    $titre,
                    $description,
                    $libelle_urgence,
                    $date_formatee
                );
                $notifier_client = isset($_POST['notifier_client']) && $_POST['notifier_client'] === '1';

                if ($_SESSION['is_admin'] && $notifier_client) {
                    $mail_envoye = envoyer_mail($email, $sujet, $corps);

                    if ($mail_envoye) {
                        $_SESSION['flash_message'] = "Le ticket <strong>{$numero_ticket}</strong> a été créé et notifié.";
                        $_SESSION['flash_type']    = "success";
                    } else {

                        $raison_serveur = $_SESSION['serveur_mail_erreur'] ?? "Le serveur a refusé la commande mail().";
                        unset($_SESSION['serveur_mail_erreur']);

                        $_SESSION['flash_message'] = "Ticket créé, mais échec du mail.<br><small style='color:#ffcccc;'>Rapport serveur : " . htmlspecialchars($raison_serveur) . "</small>";
                        $_SESSION['flash_type']    = "error";
                    }
                } elseif ($_SESSION['id_client']) {
                    $email_admin = "timeo.dupe@gmail.com"; //get_email_admin();
                    $mail_envoye = envoyer_mail($email_admin, $sujet, $corps);
                }



                if ($_SESSION['is_admin'] ?? false) {
                    header("Location: index.php?page=accueil");
                } else {
                    header("Location: index.php?page=detail_ticket&ticket=" . $numero_ticket);
                }
                exit();
            }

            // Gestion optionnelle des fichiers téléversés
            $fichiers = $_FILES['fichier'] ?? null;
            if (!empty($fichiers['name'][0]) && $id_ticket) {
                $dossier = __DIR__ . '/../../public/uploads/';
                if (!is_dir($dossier)) mkdir($dossier, 0777, true);

                for ($i = 0; $i < count($fichiers['name']); $i++) {
                    $nom_original = preg_replace('/[^a-zA-Z0-9._-]/', '_', $fichiers['name'][$i]);
                    $tmp = $fichiers['tmp_name'][$i];
                    $type = $fichiers['type'][$i];
                    $taille = $fichiers['size'][$i];
                    $extension = pathinfo($nom_original, PATHINFO_EXTENSION);
                    $nom_stockage = uniqid() . '.' . $extension;

                    if (move_uploaded_file($tmp, $dossier . $nom_stockage)) {
                        inserer_piece_jointe($nom_original, $nom_stockage, $type, $taille, date('Y-m-d H:i:s'), $id_ticket);
                    }
                }
            }

            if ($id_ticket) {
                if ($_SESSION['is_admin'] ?? false) {
                    header("Location: index.php?page=accueil");
                } else {
                    header("Location: index.php?page=detail_ticket&ticket=" . $numero_ticket);
                }
                exit();
            }
        }
    }
}

// Appel final de la vue unifiée
require_once __DIR__ . '/../View/Nouveau_ticket.php';
