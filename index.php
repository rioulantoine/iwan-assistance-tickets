<?php
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// auth.php profite maintenant de $_ENV qui est chargé juste au-dessus !
require_once __DIR__ . '/auth.php';

$base = $_ENV['BASE_URL'] ?? '';
$page = $_GET['page'] ?? 'accueil';

switch ($page) {
    case 'accueil':
        require __DIR__ . '/src/Controller/ControllerAccueil.php';
        break;

    case 'tickets':
        require __DIR__ . '/src/Controller/ControllerVos_tickets.php';
        break;

    case 'nouveau_ticket':
        require __DIR__ . '/src/Controller/ControllerNouveau_ticket.php';
        break;
    case 'nouveau_suivi':
        require __DIR__ . '/src/Controller/ControllerNouveau_suivi.php';
        break;

    case 'premier_ticket':
        require __DIR__ . '/src/Controller/ControllerPremier_ticket.php';
        break;

    case 'detail_ticket':
        require __DIR__ . '/src/Controller/ControllerDetails_ticket.php';
        break;
    case 'changer_statut':
        require_once __DIR__ . '/src/Controller/ControllerChanger_statut.php';
        break;
    case 'changer_urgence':
        require_once __DIR__ . '/src/Controller/ControllerChanger_urgence.php';
        break;
    case 'supprimer_ticket':
        require_once __DIR__ . '/src/Controller/ControllerSupprimer_ticket.php';
        break;
    case 'supprimer_reponse':
        require_once __DIR__ . '/src/Controller/ControllerSupprimer_reponse.php';
        break;

    case 'admin_tickets':
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
            require __DIR__ . '/src/View/Templates/erreur.php'; // On lui montre une page d'erreur
            exit();
        }
        require __DIR__ . '/src/Controller/ControllerLes_tickets.php';
        break;
    case 'les_clients':
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
            require __DIR__ . '/src/View/Templates/erreur.php'; // On lui montre une page d'erreur
            exit();
        }
        require __DIR__ . '/src/Controller/ControllerLes_Clients.php';
        break;

    case 'nouveau_client':
        if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
            require __DIR__ . '/src/View/Templates/erreur.php'; // On lui montre une page d'erreur
            exit();
        }
        require __DIR__ . '/src/Controller/ControllerNouveau_client.php';
        break;
    default:
        require __DIR__ . '/src/View/Templates/erreur.php';
        exit();
}
