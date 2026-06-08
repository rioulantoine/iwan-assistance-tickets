<?php
// ControllerNouveau_ticket.php
// Fichier qui permet de gérer la page Nouveau ticket
require_once __DIR__ . '/../Model/ModelNouveau_ticket.php';

// On récupère l'onglet demandé dans l'URL ('ticket' par défaut)
$tab_actif = $_GET['tab'] ?? 'ticket';

// SÉCURITÉ : Si l'utilisateur N'EST PAS admin, il est verrouillé sur 'ticket'
if (!($_SESSION['is_admin'] ?? false)) {
    $tab_actif = 'ticket';
}

// =======================================================
//    GESTION DE LA MODALE ET DE LA PAGINATION (Via GET)
// =======================================================
$recherche = trim($_GET['recherche'] ?? '');
// On s'assure que la page est au moins à 1 (pas de page 0)
$page_entreprise = max(1, (int)($_GET['page_entreprise'] ?? 1));
$limite = 10;
$offset = ($page_entreprise - 1) * $limite;

// Récupération des données pour le tableau de la modale (avec LIMIT et OFFSET)
$liste_entreprises = obtenir_entreprises_filtres_pagine($recherche, $limite, $offset);
$total_entreprises = compter_entreprises_filtres($recherche);
$total_pages = ceil($total_entreprises / $limite);
$nb_entreprises = count($liste_entreprises);

// =======================================================
//      GESTION DE L'AUTOCOMPLÉTION (DATALIST ADMIN)
// =======================================================
// On récupère la liste complète uniquement pour les suggestions de la barre de saisie
$liste_nom_entreprise = obtenir_liste_entreprise();
$entreprises_noms = array_column($liste_nom_entreprise, 'nom_entreprise');
if (!in_array('IWAN', $entreprises_noms, true)) {
    $liste_nom_entreprise[] = ['nom_entreprise' => 'IWAN'];
}

// =======================================================
//   INFOS DU CLIENT CONNECTÉ (Si ce n'est pas un Admin)
// =======================================================
if (!($_SESSION['is_admin'] ?? false)) {
    $id_client = $_SESSION['id_client'] ?? null;
    $infos_client = get_info_client($id_client);
} else {
    $infos_client = []; // Initialisation vide pour éviter les erreurs côté vue
}

// =======================================================
//    TRAITEMENT DES FORMULAIRES (Via POST)
// =======================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Action A : L'Admin clique sur "Sélectionner" dans la modale (ou double Entrée JS)
    if (isset($_POST['selectionner_entreprise'])) {
        // CORRECTION : Sauvegarde en Session pour persister après la redirection
        $_SESSION['entreprise_selectionnee'] = [
            'nom_entreprise' => $_POST['nom_entreprise'] ?? '',
            'nom'            => $_POST['nom'] ?? '',
            'prenom'         => $_POST['prenom'] ?? '',
            'email'          => $_POST['email'] ?? '',
            'telephone'      => $_POST['telephone'] ?? ''
        ];

        // Redirection immédiate sans paramètres GET pour nettoyer l'URL et fermer la modale
        header("Location: index.php?page=nouveau_ticket&tab=" . $tab_actif);
        exit();
    }

    // Action B : Soumission du ticket
    if (isset($_POST['nouveau-ticket'])) {

        $nom_declarant = trim($_POST['nom'] ?? '');
        $prenom_declarant = trim($_POST['prenom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telephone = trim($_POST['telephone'] ?? '');
        $niveau_urgence = trim($_POST['niveau_urgence'] ?? '');
        $titre = trim($_POST['titre'] ?? '');
        $description = trim($_POST['description'] ?? '');

        $erreurs = [];

        // --- Vérifications des champs ---
        if (empty($nom_declarant) && !($_SESSION['is_admin'] ?? false)) {
            $erreurs[] = "Le nom est obligatoire.";
        }

        if (empty($prenom_declarant) && !($_SESSION['is_admin'] ?? false)) {
            $erreurs[] = "Le prénom est obligatoire.";
        }

        if (empty($email) && !($_SESSION['is_admin'] ?? false)) {
            $erreurs[] = "L'email est obligatoire.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !($_SESSION['is_admin'] ?? false)) {
            $erreurs[] = "L'email n'est pas valide.";
        }

        if (empty($telephone) && !($_SESSION['is_admin'] ?? false)) {
            $erreurs[] = "Le téléphone est obligatoire.";
        } elseif (strlen($telephone) > 50) {
            $erreurs[] = "Le numéro de téléphone est trop long.";
        }

        $urgences_valides = ['1', '2', '3', '4'];
        if (!in_array($niveau_urgence, $urgences_valides)) {
            $erreurs[] = "Le niveau d'urgence est invalide.";
        }

        if (empty($titre)) {
            $erreurs[] = "Le titre est obligatoire.";
        } elseif (strlen($titre) > 255) {
            $erreurs[] = "Le titre est trop long.";
        }

        if (empty($description)) {
            $erreurs[] = "La description est obligatoire.";
        }

        // --- Récupération sécurisée de l'ID Entreprise ---
        if ($_SESSION['is_admin'] ?? false) {
            $nom_entreprise = trim($_POST['nom_entreprise'] ?? '');
            $id_entreprise = trouver_id_entreprise($nom_entreprise);

            if (empty($id_entreprise)) {
                $erreurs[] = "Veuillez sélectionner une entreprise valide avant de créer le ticket.";
            }
        } else {
            $id_entreprise = $_SESSION['id_client'];
        }

        // --- Gestion des erreurs de validation avec PRG ---
        if (!empty($erreurs)) {
            $_SESSION['flash_message'] = implode('<br>', $erreurs);
            $_SESSION['flash_type'] = "error";

            // Sauvegarde des données saisies pour les réafficher après redirection
            $_SESSION['form_data'] = [
                'nom'            => $nom_declarant,
                'prenom'         => $prenom_declarant,
                'email'          => $email,
                'telephone'      => $telephone,
                'niveau_urgence' => $niveau_urgence,
                'titre'          => $titre,
                'description'    => $description,
            ];

            header("Location: index.php?page=nouveau_ticket&tab=" . $tab_actif);
            exit();
        }

        // --- Insertion dans la base de données ---
        $numero_ticket = null;
        $numero_ticket = generer_numero_ticket();
        $date_creation = date('Y-m-d H:i:s');
        $id_statut = 1;

        $id_ticket = inserer_nouveau_ticket(
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
        );

        // --- Upload des fichiers joints ---
        $fichiers = $_FILES['fichier'] ?? null;

        if (!empty($fichiers['name'][0]) && $id_ticket) {

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
                    // On note l'erreur mais on ne bloque pas la redirection
                    $_SESSION['flash_message'] = "Ticket créé mais erreur lors de l'upload du fichier : " . htmlspecialchars($nom_original);
                    $_SESSION['flash_type'] = "warning";
                    continue;
                }

                inserer_piece_jointe(
                    $nom_original,
                    $nom_stockage,
                    $type,
                    $taille,
                    date('Y-m-d H:i:s'),
                    $id_ticket
                );
            }
        }

        // --- Redirection de succès ---
        // Nettoyage de la mémoire tampon de l'entreprise après soumission finale réussie
        unset($_SESSION['entreprise_selectionnee']);

        if ($_SESSION['is_admin'] ?? false) {
            header("Location: index.php?page=accueil");
            exit();
        } else {
            header("Location: index.php?page=detail_ticket&ticket=" . $numero_ticket);
            exit();
        }
    }
}

// =======================================================
//   RÉCUPÉRATION DES DONNÉES DU FORMULAIRE (Après erreur)
// =======================================================
$form_data = $_SESSION['form_data'] ?? [];
unset($_SESSION['form_data']);

require_once __DIR__ . '/../View/Nouveau_ticket.php';
