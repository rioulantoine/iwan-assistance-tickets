<?php
// Config/Config.php


define('MAIL_FROM', 'tadeo.dupe@gmail.com'); // 👈 Ton adresse Gmail (ou IONOS)
define('MAIL_FROM_NAME', 'Iwan Assistance');

// ⚙️ PARAMÈTRES DE CONNEXION SMTP
define('SMTP_HOST', 'smtp.ionos.fr');       // 👈 Si tu utilises IONOS, remplace par : 'smtp.ionos.fr'
define('SMTP_PORT', 587);                    // Port standard sécurisé TLS

// 🔑 L'ENDROIT OÙ METTRE TON MOT DE PASSE :
define('SMTP_PASSWORD', 'prhp0896'); // 👈 Mets tes 16 caractères de mot de passe ici !