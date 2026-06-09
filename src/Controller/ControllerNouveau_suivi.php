<?php
//ControlelrNouveau_suivi.php
// Gère uniquement la création des suivis
require_once __DIR__ . '/../Model/ModelNouveau_suivi.php';

// Sécurisation du droit d'accès (seuls les admins ont le droit)
if (!($_SESSION['is_admin'] ?? false)) {
    die("Accès refusé. Vous devez être administrateur pour supprimer un ticket.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nouveau-suivi'])) {
        $nom_entreprise = trim($_POST['nom_entreprise']);
        $date = trim($_POST['date_creation']);
        $logiciel = trim($_POST['logiciel']);
        $type_suivi = trim($_POST['type_suivi']);
        $nom_contact = trim($_POST['nom_contact']);
        $prenom_contact = trim($_POST['prenom_contact']);
        $email = trim($_POST['email']);
        $telephone = trim($_POST['telephone']);
        $titre = trim($_POST['titre']);
        $id_statut = trim($_POST['code_statut']);
        $notes = trim($_POST['description']);

        $erreurs = [];

        // ---- Vérifications des champs ----
        if (empty($nom_entreprise)) {
            $erreur[] = "Le nom de l'entreprise est obligatoire";
        } else {
            $id_entreprise = trouver_id_entreprise($nom_entreprise);
        }

        if (empty($date)) {
            $erreur[] = "La date du suivi est obligatoire";
        }

        if (empty($logiciel)) {
            $erreur[] = "Le logiciel est obligatoire";
        }

        if (empty($type_suivi)) {
            $erreur[] = "Le type de suivi est obligatoire";
        }

        if (empty($nom_contact)) {
            $erreur[] = "Le nom du contact est obligatoire";
        }

        if (empty($prenom_contact)) {
            $erreur[] = "Le prénom du contact est obligatoire";
        }

        if (empty($email)) {
            $erreur[] = "L'email est obligatoire";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erreur[] = "L'email n'est pas valide";
        }

        if (empty($telephone)) {
            $erreur[] = "Le téléphone est obligatoire";
        } elseif (strlen($telephone) > 50) {
            $erreur[] = "Le numéro de téléphone est trop long";
        }

        if (empty($titre)) {
            $erreur[] = "Le titre est obligatoire";
        } elseif (strlen($titre) > 255) {
            $erreur[] = "Le titre est trop long";
        }

        if (empty($notes)) {
            $erreur[] = "La description est obligatoire";
        }

        if (!empty($erreurs)) {
            $_SESSION['flash_message'] = implode('<br>', $erreurs);
            $_SESSION['flash_type'] = 'error';
        } else {
            $numero_suivi = generer_numero_suivi();
            $id_suivi = inserer_nouveau_suivi(
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
            );

            // --- Redirection de succès ---
            if ($numero_suivi && empty($erreurs)) {
                // Nettoyage de la mémoire tampon de l'entreprise après soumission finale réussie
                unset($_SESSION['entreprise_selectionnee']);

                if ($_SESSION['is_admin'] ?? false) {
                    header("Location: index.php?page=accueil");
                    exit();
                } else {
                    header("Location: index.php?page=detail_ticket&ticket=" . $numero_ticket);
                    exit();
                }
            } elseif (!empty($erreurs)) {
                $_SESSION['flash_message'] = implode('<br>', $erreurs);
                $_SESSION['flash_type'] = "error";
            }
        }
    }
}


require_once __DIR__ . '/../View/Nouveau_ticket.php';
