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
require_once __DIR__ . '/auth.php';

// Définition de la variable $base pour les chemins relatifs
$base = $_ENV['BASE_URL'] ?? '';

// Récupération des paramètres de l'URL
$page = $_GET['page'] ?? 'accueil';

// Routeur des pages
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
    case 'premier_ticket':
        require __DIR__ . '/src/Controller/ControllerPremier_ticket.php';
        break;
    case 'detail_ticket':
        require __DIR__ . '/src/Controller/ControllerDetails_ticket.php';
        break;
    case 'admin_tickets':
        require __DIR__ . '/src/Controller/ControllerLes_tickets.php';
        break;
    default:
        require __DIR__ . '/src/View/Template/erreur.php';
        exit();
}
