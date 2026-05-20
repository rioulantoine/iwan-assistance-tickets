<?php
// ModelBDD.php
// Fichier utilitaire pour la connexion à la base de données

function get_bdd()
{
    $hostname = $_ENV['DB_HOST'];
    $user = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASSWORD'];
    $db_name = $_ENV['DB_NAME'];

    $dsn = "mysql:host=$hostname;dbname=$db_name;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $password);
    return $pdo;
}

// Exemple d'utilisation
// Fonction pour obtenir le nombre d'objets
function get_nb_objets_reserves()
{
    $pdo = get_bdd();
    $sql = "SELECT COUNT(*) AS total
            FROM  OBJET_RECYCLABLE
            WHERE id_statut_recyclage_obj != 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}

function getall()
{
    $pdo = get_bdd();
    $sql = "SELECT COUNT(*) AS total
            FROM  USER;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return (int)$stmt->fetchColumn();
};
