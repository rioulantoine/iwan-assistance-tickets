<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'src/Model/ModelBDD.php';

$id_user_test = 7;
$pdo = get_bdd();
$stmt = $pdo->prepare("SELECT * FROM USER WHERE id_user = ?");
$stmt->execute([$id_user_test]);
$user = $stmt->fetch();

if ($user) {
    $_SESSION['user_id']   = $user['id_user'];
    $_SESSION['user_nom']  = $user['nom'];
    $_SESSION['user_role'] = $user['id_role'];
} else {
    die("Erreur : L'ID de test n'existe pas dans ton jeu d'essai !");
}
