<?php
// ControllerNouveau_ticket.php
// Fichier qui permet de gérer la page Nouveau ticket
require_once __DIR__ . '/../Model/ModelNouveau_ticket.php';

// On récupère le nom de toutes les entreprises ayant déjà créé un ticket
$liste_nom_entreprise = obtenir_liste_entreprise();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom_declarant = trim($_POST['nom'] ?? '');
    $prenom_declarant = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $niveau_urgence = trim($_POST['niveau_urgence'] ?? '');
    $titre = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');

    $erreurs = [];

    // Vérification nom
    if (empty($nom_declarant)) {
        $erreurs[] = "Le nom est obligatoire.";
    }

    // Vérification prénom
    if (empty($prenom_declarant)) {
        $erreurs[] = "Le prénom est obligatoire.";
    }

    // Vérification email
    if (empty($email)) {
        $erreurs[] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'email n'est pas valide.";
    }

    // Vérification urgence
    $urgences_valides = ['1', '2', '3', '4'];
    if (!in_array($niveau_urgence, $urgences_valides)) {
        $erreurs[] = "Le niveau d'urgence est invalide.";
    }

    // Vérification titre
    if (empty($titre)) {
        $erreurs[] = "Le titre est obligatoire.";
    } elseif (strlen($titre) > 255) {
        $erreurs[] = "Le titre est trop long.";
    }

    // Vérification description
    if (empty($description)) {
        $erreurs[] = "La description est obligatoire.";
    }

    // 🟢 PLACE DE LA VÉRIFICATION DE L'ENTREPRISE (AVANT le if empty erreurs)
    if ($_SESSION['is_admin'] ?? false) {
        $nom_entreprise = strtoupper(trim($_POST['nom_entreprise'] ?? ''));
        $id_entreprise = trouver_id_entreprise($nom_entreprise);

        // Si l'admin a tapé une entreprise inconnue, on lève l'erreur ici !
        if ($id_entreprise === false) {
            $erreurs[] = "L'entreprise '" . htmlspecialchars($nom_entreprise) . "' n'est pas enregistrée dans le système. Impossible de créer ce ticket.";
        }
    } else {
        // Pour un client classique, on prend directement ses données de session
        $nom_entreprise = $_SESSION['name'];
        $id_entreprise = $_SESSION['id_client'];
    }

    // Si aucune erreur (Y compris l'erreur d'entreprise de l'admin)
    $numero_ticket = null;
    if (empty($erreurs)) {

        $numero_ticket = generer_numero_ticket();
        $date_creation = date('Y-m-d H:i:s');
        $id_statut = 1;

        // Appel du modèle (S'exécute uniquement si tout est OK)
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
            $nom_entreprise,
            $niveau_urgence,
            $id_statut
        );

        // Upload de fichier
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
                    $erreurs[] = "Erreur lors de l'upload du fichier : " . $nom_original;
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
    }

    // La redirection ne se fera QUE si le $numero_ticket a bien été généré au-dessus
    if ($numero_ticket) {
        header("Location: index.php?page=detail_ticket&ticket=" . $numero_ticket);
        exit();
    }
}
require_once __DIR__ . '/../View/Nouveau_ticket.php';
