<?php
// ControllerNouveau_suivi.php
// Gère uniquement la création des suivis d'appels

// Sécurisation stricte : require_once pour éviter les conflits de re-déclaration
require_once __DIR__ . '/../Model/ModelNouveau_suivi.php';

// Sécurisation du droit d'accès (seuls les admins ont le droit)
if (!($_SESSION['is_admin'] ?? false)) {
    die("Accès refusé. Vous devez être administrateur pour ajouter un suivi.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nouveau-suivi'])) {
        // Nettoyage et récupération des données du formulaire
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

        // Gestion du cas où aucun logiciel n'est sélectionné
        if ($id_logiciel === '') {
            $id_logiciel = null;
        }

        $erreurs = [];

        // ---- Vérifications de l'existence du client ----
        if (empty($nom_entreprise)) {
            $erreurs[] = "Le nom de l'entreprise est obligatoire.";
        } else {
            $id_entreprise = trouver_id_entreprise($nom_entreprise);
            if ($id_entreprise === false) {
                $erreurs[] = "L'entreprise spécifiée n'existe pas en base de données.";
            }
        }

        if (empty($date)) {
            $erreurs[] = "La date du suivi est obligatoire.";
        }

        if (empty($type_suivi)) {
            $erreurs[] = "Le type de suivi est obligatoire.";
        }

        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erreurs[] = "L'adresse email n'est pas valide.";
        }

        // ---- Traitement final ou Flash des erreurs ----
        if (!empty($erreurs)) {
            $_SESSION['flash_message'] = implode('<br>', $erreurs);
            $_SESSION['flash_type'] = 'error';
        } else {
            // Génération de l'identifiant unique et insertion
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

            // --- Redirection directe en cas de succès ---
            if ($id_suivi) {
                // 🛠️ Nettoyage : Plus besoin d'unset($_SESSION['entreprise_selectionnee']) ici
                header("Location: index.php?page=accueil");
                exit();
            } else {
                $_SESSION['flash_message'] = "Une erreur technique est survenue lors de l'enregistrement du suivi.";
                $_SESSION['flash_type'] = "error";
            }
        }
    }
}

// Chargement de la vue globale
require_once __DIR__ . '/../View/Nouveau_ticket.php';
