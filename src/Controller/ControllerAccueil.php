<?php
// ControllerAccueil.php
// Fichier qui permet de gérer la page d'accueil
require_once __DIR__ . '/../Model/ModelAccueil.php';
require_once __DIR__ . '/../Model/ModelBDD.php';
$total = getall();
//Traitement des onnées pour l'affichage sur la page d'accueil
require_once __DIR__ . '/../View/Accueil.php';
