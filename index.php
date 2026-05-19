<?php
//ajout de l'autoload de composer pour charger les classes automatiquement
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Définition de la variable $base pour les chemins relatifs
$base = $_ENV['BASE_URL'] ?? '';

session_start();
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
    default:
        require __DIR__ . '/src/View/Template/erreur.php';
        exit();
}
