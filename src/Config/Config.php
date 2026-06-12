<?php
// Config/Config.php
$racine_projet = realpath(__DIR__ . '/../..');
$chemin_autoload = $racine_projet . '/vendor/autoload.php';
if (!file_exists($chemin_autoload)) {
    die("❌ Erreur : Le fichier autoload.php est introuvable à cet endroit : " . $chemin_autoload);
}
// Chargement .env
try {
    $dotenv = Dotenv\Dotenv::createImmutable($racine_projet);
    $dotenv->load();
} catch (Exception $e) {
    die("Fichier .env introuvable ou mal configuré à la racine du projet.");
}
// Définition des valeurs
define('MAIL_FROM',      $_ENV['MAIL_FROM']);
define('MAIL_FROM_NAME', $_ENV['MAIL_FROM_NAME']);
define('SMTP_HOST',      $_ENV['SMTP_HOST']);
define('SMTP_PORT',      (int)($_ENV['SMTP_PORT']));
define('SMTP_PASSWORD',  $_ENV['SMTP_PASSWORD']);
