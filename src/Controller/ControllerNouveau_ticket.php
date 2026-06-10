<?php
// ControllerNouveau_ticket.php
require_once __DIR__ . '/../Model/ModelNouveau_ticket.php';




$logiciel_couleur = '#64748b';



$tab_actif = $_GET['tab'] ?? 'ticket';

if (!($_SESSION['is_admin'] ?? false)) {
    $tab_actif = 'ticket';
}

// Récupération de la liste des logiciels pour la vue
$liste_logiciels = get_liste_logiciels();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_GET['ouvrir_modal']) && !isset($_GET['selection'])) {
    unset($_SESSION['entreprise_selectionnee']);
    $_POST = [];
}

$recherche = trim($_GET['recherche'] ?? '');
$page_entreprise = max(1, (int)($_GET['page_entreprise'] ?? 1));
$limite = 10;
$offset = ($page_entreprise - 1) * $limite;

$liste_entreprises = obtenir_entreprises_filtres_pagine($recherche, $limite, $offset);
$total_entreprises = compter_entreprises_filtres($recherche);
$total_pages = ceil($total_entreprises / $limite);
$nb_entreprises = count($liste_entreprises);

$liste_nom_entreprise = obtenir_liste_entreprise();
$entreprises_noms = array_column($liste_nom_entreprise, 'nom_entreprise');
if (!in_array('IWAN', $entreprises_noms, true)) {
    $liste_nom_entreprise[] = ['nom_entreprise' => 'IWAN'];
}

if (!($_SESSION['is_admin'] ?? false)) {
    $id_client = $_SESSION['id_client'] ?? null;
    $infos_client = get_info_client($id_client);
} else {
    $infos_client = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Action A : Sélection de l'entreprise depuis la modale
    if (isset($_POST['selectionner_entreprise'])) {
        $_SESSION['entreprise_selectionnee'] = [
            'nom_entreprise' => $_POST['nom_entreprise'] ?? '',
            'nom'            => $_POST['nom'] ?? '',
            'prenom'         => $_POST['prenom'] ?? '',
            'email'          => $_POST['email'] ?? '',
            'telephone'      => $_POST['telephone'] ?? '',
            'id_logiciel'    => $_POST['id_logiciel'] ?? '' // Stockage de l'ID à la place du texte
        ];

        header("Location: index.php?page=nouveau_ticket&tab=" . $tab_actif . "&selection=1");
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

        if (empty($nom_declarant) && !($_SESSION['is_admin'] ?? false)) $erreurs[] = "Le nom est obligatoire.";
        if (empty($prenom_declarant) && !($_SESSION['is_admin'] ?? false)) $erreurs[] = "Le prénom est obligatoire.";
        if (empty($email) && !($_SESSION['is_admin'] ?? false)) {
            $erreurs[] = "L'email est obligatoire.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !($_SESSION['is_admin'] ?? false)) {
            $erreurs[] = "L'email n'est pas valide.";
        }
        if (empty($telephone) && !($_SESSION['is_admin'] ?? false)) {
            $erreurs[] = "Le téléphone est obligatoire.";
        }

        $urgences_valides = ['1', '2', '3', '4'];
        if (!in_array($niveau_urgence, $urgences_valides)) $erreurs[] = "Le niveau d'urgence est invalide.";
        if (empty($titre)) $erreurs[] = "Le titre est obligatoire.";
        if (empty($description)) $erreurs[] = "La description est obligatoire.";

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

            if ($numero_ticket && empty($erreurs)) {
                unset($_SESSION['entreprise_selectionnee']);
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

require_once __DIR__ . '/../View/Nouveau_ticket.php';
