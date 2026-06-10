<?php
// ControllerNouveau_suivi.php
// Gère uniquement la création des suivis
require_once __DIR__ . '/../Model/ModelNouveau_suivi.php';

// Sécurisation du droit d'accès (seuls les admins ont le droit)
if (!($_SESSION['is_admin'] ?? false)) {
    die("Accès refusé. Vous devez être administrateur pour ajouter un suivi.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nouveau-suivi'])) {
        $nom_entreprise = trim($_POST['nom_entreprise'] ?? '');
        $date           = str_replace('T', ' ', $_POST['date_suivi'] ?? '');
        $id_logiciel    = trim($_POST['id_logiciel'] ?? '');
        $type_suivi     = trim($_POST['type_suivi'] ?? '');
        $nom_contact    = trim($_POST['nom_contact'] ?? '');
        $prenom_contact = trim($_POST['prenom_contact'] ?? '');
        $email          = trim($_POST['email'] ?? '');
        $telephone      = trim($_POST['telephone'] ?? '');
        $titre          = trim($_POST['titre'] ?? '');
        $id_statut      = trim($_POST['code_statut'] ?? '');
        $notes          = trim($_POST['description'] ?? '');

        $erreurs = [];

        // ---- Vérifications des champs (Correction de $erreur en $erreurs) ----
        if (empty($nom_entreprise)) {
            $erreurs[] = "Le nom de l'entreprise est obligatoire.";
        } else {
            $id_entreprise = trouver_id_entreprise($nom_entreprise);
            if ($id_entreprise === false) {
                $erreurs[] = "L'entreprise spécifiée n'existe pas.";
            }
        }

        if (empty($date)) {
            $erreurs[] = "La date du suivi est obligatoire.";
        }

        if (empty($id_logiciel)) {
            $erreurs[] = "Le logiciel est obligatoire.";
        }

        if (empty($type_suivi)) {
            $erreurs[] = "Le type de suivi est obligatoire.";
        }

        if (empty($nom_contact)) {
            $erreurs[] = "Le nom du contact est obligatoire.";
        }

        if (empty($prenom_contact)) {
            $erreurs[] = "Le prénom du contact est obligatoire.";
        }

        if (empty($email)) {
            $erreurs[] = "L'email est obligatoire.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erreurs[] = "L'email n'est pas valide.";
        }

        if (empty($telephone)) {
            $erreurs[] = "Le téléphone est obligatoire.";
        } elseif (strlen($telephone) > 50) {
            $erreurs[] = "Le numéro de téléphone est trop long.";
        }

        if (empty($titre)) {
            $erreurs[] = "Le titre est obligatoire.";
        } elseif (strlen($titre) > 255) {
            $erreurs[] = "Le titre est trop long.";
        }

        if (empty($notes)) {
            $erreurs[] = "La description est obligatoire.";
        }

        // ---- Insertion ou affichage des erreurs ----
        if (!empty($erreurs)) {
            $_SESSION['flash_message'] = implode('<br>', $erreurs);
            $_SESSION['flash_type'] = 'error';
        } else {
            $numero_suivi = generer_numero_suivi();
            $id_suivi = inserer_nouveau_suivi(
                $numero_suivi,
                $id_entreprise,
                $date,
                $id_logiciel,
                $type_suivi,
                $nom_contact,
                $prenom_contact,
                $email,
                $telephone,
                $titre,
                $id_statut,
                $notes
            );

            // --- Redirection de succès ---
            if ($id_suivi) {
                unset($_SESSION['entreprise_selectionnee']);
                $_SESSION['flash_message'] = "Le suivi d'appel a été enregistré avec succès.";
                $_SESSION['flash_type'] = "success";

                header("Location: index.php?page=accueil");
                exit();
            } else {
                $_SESSION['flash_message'] = "Une erreur est survenue lors de l'enregistrement du suivi.";
                $_SESSION['flash_type'] = "error";
            }
        }
    }
}

require_once __DIR__ . '/../View/Nouveau_ticket.php';
