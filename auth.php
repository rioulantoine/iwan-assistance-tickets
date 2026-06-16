<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// On inclut le modèle de la BDD pour pouvoir faire des requêtes
require_once __DIR__ . '/src/Model/ModelBDD.php';

$id_iwan = $_ENV['ID_IWAN'] ?? 'Erreur ID';

// Détection si client ou IWAN
if (isset($_GET['ID']) && !empty($_GET['ID'])) {

    $id_url = $_GET['ID'];

    if ($id_url === $id_iwan) {
        $_SESSION['is_admin'] = true;
        $_SESSION['id_admin'] = $id_iwan;
        unset($_SESSION['id_client']); // enlève l'ancien id s'il y en a un
        $_SESSION['name'] = 'IWAN';
    } else {

        // On vérifie si cet ID existe bien dans notre base de données
        $id_numerique = $id_url;
        $pdo = get_bdd();
        $stmt = $pdo->prepare("SELECT COUNT(id_client) FROM CLIENT WHERE id_client = ?");
        $stmt->execute([$id_numerique]);
        $client_existe = (int)$stmt->fetchColumn() > 0;

        if (!$client_existe) {
            // Si le client n'existe pas, on détruit tout et on affiche la page d'erreur
            session_destroy();
            require_once __DIR__ . '/src/View/Client_inexistant.php';
            exit();
        }

        // Si le client existe, on continue la procédure normale d'authentification
        $nom_url = $_GET['NOM'] ?? 'Client';
        $_SESSION['is_admin'] = false;
        $_SESSION['id_admin'] = "";
        $_SESSION['id_client'] = $id_numerique;
        $_SESSION['name'] = strtoupper(trim(htmlspecialchars($nom_url)));
    }
} else {
    // S'il n'y a aucun ID dans l'URL, on vérifie si on n'en a pas déjà un valide en session
    if (!isset($_SESSION['is_admin']) && !isset($_SESSION['id_client'])) {
        session_destroy();
        require_once __DIR__ . '/src/View/Client_inexistant.php';
        exit();
    }

    // Si l'utilisateur navigue sur le site avec une session existante,
    // on vérifie que son compte n'a pas été supprimé entre-temps
    if (isset($_SESSION['id_client']) && !$_SESSION['is_admin']) {
        $pdo = get_bdd();
        $stmt = $pdo->prepare("SELECT COUNT(id_client) FROM CLIENT WHERE id_client = ?");
        $stmt->execute([$_SESSION['id_client']]);
        if ((int)$stmt->fetchColumn() === 0) {
            session_destroy();
            require_once __DIR__ . '/../View/Client_inexistant.php';
            exit();
        }
    }
}
