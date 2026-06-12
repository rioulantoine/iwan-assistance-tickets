<?php
// 💡 CONFIGURATION DE TON TEST
$email_expediteur  = 'noreply@iwan.fr';          // ⚠️ Doit appartenir au domaine du serveur de test !
$nom_expediteur    = 'Test Serveur Iwan';
$email_destinataire = 'timeo.dupe@gmail.com';     // L'adresse qui doit recevoir le mail de test
$sujet_mail         = '🚀 Test d\'envoi depuis le nouveau serveur';

// 📄 CORPS DU MAIL (Format HTML)
$message_html = "
<!DOCTYPE html>
<html>
<head><meta charset='UTF-8'></head>
<body style='font-family: Arial, sans-serif; background-color: #f4f6f8; padding: 20px;'>
    <div style='background-color: #ffffff; padding: 30px; border-radius: 8px; max-width: 500px; margin: 0 auto; box-shadow: 0 2px 4px rgba(0,0,0,0.1);'>
        <h2 style='color: #0f2e48; margin-top: 0;'>Le script fonctionne !</h2>
        <p>Ce mail a été généré automatiquement pour valider les capacités d'envoi de ton serveur.</p>
        <hr style='border: 0; border-top: 1px solid #eeeeee; margin: 20px 0;'>
        <p style='font-size: 12px; color: #888888; margin-bottom: 0;'>Date du test : " . date('d/m/Y à H:i:s') . "</p>
    </div>
</body>
</html>
";

// =========================================================================
//   BLOC TECHNIQUE D'ENVOI
// =========================================================================

echo "<h2>🧪 Diagnostic de l'envoi de mail</h2>";
echo "Tentative d'envoi de <code>{$email_expediteur}</code> vers <code>{$email_destinataire}</code>...<br><br>";

// 1. Préparation des Headers
$headers = [];
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-Type: text/html; charset=UTF-8';
$headers[] = 'From: ' . $nom_expediteur . ' <' . $email_expediteur . '>';
$headers[] = 'Reply-To: ' . $email_expediteur;
$headers[] = 'X-Mailer: PHP/' . phpversion();

// 2. Encodage du sujet pour éviter les filtres anti-spam
$sujet_encode = '=?UTF-8?B?' . base64_encode($sujet_mail) . '?=';

// 3. Option d'enveloppe système (-f)
$options_serveur = "-f" . $email_expediteur;

// 4. Envoi du mail
$succes = mail(
    $email_destinataire,
    $sujet_encode,
    $message_html,
    implode("\r\n", $headers),
    $options_serveur
);

// =========================================================================
//   AFFICHAGE DU RÉSULTAT
// =========================================================================

if ($succes) {
    echo "<div style='padding: 15px; background-color: #d4edda; color: #155724; border-radius: 5px; font-weight: bold;'>";
    echo "✅ SUCCÈS : La fonction mail() a validé l'envoi ! Vérifie la boîte de réception (et les spams) de {$email_destinataire}.";
    echo "</div>";
} else {
    $derniere_erreur = error_get_last();

    echo "<div style='padding: 15px; background-color: #f8d7da; color: #721c24; border-radius: 5px;'>";
    echo "<strong>❌ ÉCHEC : Le serveur a refusé d'envoyer le mail.</strong><br><br>";
    echo "<strong>Rapport d'erreur PHP brut :</strong>";
    echo "<pre style='background: #ffffff; padding: 10px; border: 1px solid #ebccd1; border-radius: 4px;'>";
    if ($derniere_erreur) {
        print_r($derniere_erreur);
    } else {
        echo "Le serveur a renvoyé 'false' de manière silencieuse (la fonction mail() est probablement désactivée ou bridée par le pare-feu du nouvel hébergeur).";
    }
    echo "</pre>";
    echo "</div>";
}

echo "<br><p><a href='?retry=1'>🔄 Recommencer le test</a></p>";
