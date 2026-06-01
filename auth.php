<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id_iwan = $_ENV['ID_IWAN'] ?? 'Erreur ID';

// Détection si client ou IWAN
if (isset($_GET['ID']) && !empty($_GET['ID'])) {

    $id_url = $_GET['ID'];

    if ($id_url === $id_iwan) {
        $_SESSION['is_admin'] = true;
        $_SESSION['id_admin'] = $id_iwan;
        unset($_SESSION['id_client']); // enleve l'ancien id si il y en a un
        $_SESSION['name'] = 'IWAN';
    } else {

        $nom_url = $_GET['NOM'] ?? 'Client';
        $_SESSION['is_admin'] = false;
        $_SESSION['id_client'] = htmlspecialchars($id_url);
        $_SESSION['name'] = strtoupper(trim(htmlspecialchars($nom_url)));
    }
} else {
    // Si il n'y a aucun id on vérifie si on n'en a pas déjà un
    if (!isset($_SESSION['is_admin']) && !isset($_SESSION['id_client'])) {
        die("ERREUR : Lien invalide ou expiré. Impossible d'ouvrir l'application sans identification");
    }
}
