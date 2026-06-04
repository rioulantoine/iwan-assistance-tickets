<?php
// ModelNouveau_client.php
// Fichier qui permet d'insérer le nouveau client dans la base de données

require_once __DIR__ . '/ModelBDD.php';

function inserer_nouveau_client(
    $id_client,
    $nom_entreprise,
    $code_postal,
    $ville,
    $nom,
    $prenom,
    $email,
    $telephone,
    $observation = ''
) {
    $pdo = get_bdd();
    $sql = "INSERT INTO CLIENT(
            id_client,
            nom_entreprise,
            cp,
            ville,
            nom,
            prenom,
            email,
            telephone,
            observation)
            VALUES(?,?,?,?,?,?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    $resultat = $stmt->execute(
        [
            $id_client,
            $nom_entreprise,
            $code_postal,
            $ville,
            $nom,
            $prenom,
            $email,
            $telephone,
            $observation
        ]
    );

    if (!$resultat) {
        print_r($stmt->errorInfo());
        return false;
    }
}
