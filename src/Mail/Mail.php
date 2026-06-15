<?php
// src/Mail/Mail.php
require_once __DIR__ . '/../Config/Config.php';

// Chargement sécurisé de l
$racine_projet = dirname(__DIR__, 2);
require_once $racine_projet . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function envoyer_mail(string $destinataire, string $sujet, string $corps_html): bool
{
    $destinataire = filter_var(trim($destinataire), FILTER_VALIDATE_EMAIL);
    if (!$destinataire) return false;

    $mail = new PHPMailer(true);

    try {
        // CONNEXION SMTP IONOS
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = MAIL_FROM;
        $mail->Password   = SMTP_PASSWORD;

        // On utilise ENCRYPTION_SMTPS pour le SSL/TLS pur
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = SMTP_PORT;

        $mail->CharSet    = 'UTF-8';

        // EXPÉDITEUR ET DESTINATAIRE
        $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
        $mail->addAddress($destinataire);

        // CONTENU
        $mail->isHTML(true);
        $mail->Subject = $sujet;
        $mail->Body    = $corps_html;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Échec SMTP Iwan Assistance : " . $mail->ErrorInfo);
        return false;
    }
}

// ... Tes fonctions de templates "template_nouveau_ticket_admin" restent en dessous sans changement
// ... Tes fonctions de templates (template_nouveau_ticket_admin, etc.) restent en dessous sans changement
function template_nouveau_ticket_admin(
    string $numero_ticket,
    string $nom_entreprise,
    string $prenom,
    string $nom,
    string $email,
    string $titre,
    string $description,
    string $urgence,
    string $date_creation
): string {
    // Protection XSS
    $prenom      = htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8');
    $nom         = htmlspecialchars($nom, ENT_QUOTES, 'UTF-8');
    $email       = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    $titre       = htmlspecialchars($titre, ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
    $nom_entreprise = htmlspecialchars($nom_entreprise, ENT_QUOTES, 'UTF-8');

    return "
<!DOCTYPE html>
    <html lang='fr'>
    <head>
        <meta charset='UTF-8'>
    </head>
    <body style='margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, sans-serif;'>

        <table width='100%' cellpadding='0' cellspacing='0' style='background-color:#f4f6f8; padding: 40px 0;'>
            <tr>
                <td align='center'>
                    <table width='600' cellpadding='0' cellspacing='0' style='background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08);'>

                        <tr>
                            <td style='background-color:#0f2e48; padding: 32px 40px; text-align:center;'>
                                <h1 style='margin:0; color:#ffffff; font-size:22px; font-weight:600; letter-spacing:0.5px;'>
                                    Iwan Assistance
                                </h1>
                                <p style='margin:6px 0 0; color:#a8c4d8; font-size:13px;'>
                                    Nouveau ticket créé
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <td style='padding: 36px 40px;'>
                                <table width='100%' cellpadding='0' cellspacing='0' style='margin-bottom: 28px;'>
                                    <tr>
                                        <td style='padding:8px 0; border-bottom:1px solid #eeeeee;'>
                                            <span style='color:#888888; font-size:13px;'>Entreprise</span>
                                        </td>
                                        <td style='padding:8px 0; border-bottom:1px solid #eeeeee; text-align:right;'>
                                            <span style='color:#333333; font-size:13px; font-weight:600;'>{$nom_entreprise}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 8px 0; border-bottom:1px solid #eeeeee;'>
                                            <span style='color:#888888; font-size:13px;'>Déclarant</span>
                                        </td>
                                        <td style='padding: 8px 0; border-bottom:1px solid #eeeeee; text-align:right;'>
                                            <span style='color:#333333; font-size:13px; font-weight:600;'>{$prenom} {$nom}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 8px 0; border-bottom:1px solid #eeeeee;'>
                                            <span style='color:#888888; font-size:13px;'>Email</span>
                                        </td>
                                        <td style='padding: 8px 0; border-bottom:1px solid #eeeeee; text-align:right;'>
                                            <span style='color:#333333; font-size:13px;'>{$email}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 8px 0; border-bottom:1px solid #eeeeee;'>
                                            <span style='color:#888888; font-size:13px;'>Urgence</span>
                                        </td>
                                        <td style='padding: 8px 0; border-bottom:1px solid #eeeeee; text-align:right;'>
                                            <span style='color:#333333; font-size:13px;'>{$urgence}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 8px 0; border-bottom:1px solid #eeeeee;'>
                                            <span style='color:#888888; font-size:13px;'>Date</span>
                                        </td>
                                        <td style='padding: 8px 0; border-bottom:1px solid #eeeeee; text-align:right;'>
                                            <span style='color:#333333; font-size:13px;'>{$date_creation}</span>
                                        </td>
                                    </tr>
                                </table>

                                <div style='background-color:#f0f4f8; border-left:4px solid #0f2e48; border-radius:4px; padding:14px 18px; margin-bottom:24px;'>
                                    <p style='margin:4px 0 0; color:#555555; font-size:15px;'>{$titre}</p>
                                </div>

                                <div style='margin-top:24px;'>
                                    <p style='margin:0 0 8px; color:#888888; font-size:13px;'>Description</p>
                                    <p style='margin:0; color:#333333; font-size:14px; line-height:1.6; background-color:#f9fafb; border-radius:4px; padding:14px;'>
                                    " . nl2br($description) . "                                    </p>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style='padding: 0 40px 36px;' align='center'>
                            <a href='http://localhost/iwan-assistance-tickets/index.php?page=detail_ticket&ticket={$numero_ticket}&ID=1'
                                style='display:inline-block; background-color:#0f2e48; color:#ffffff; text-decoration:none; font-size:14px; font-weight:600; padding:14px 32px; border-radius:6px; letter-spacing:0.5px;'>
                                Voir le ticket
                                </a>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style='background-color:#f0f4f8; padding:20px 40px; text-align:center;'>
                                <p style='margin:0; color:#aaaaaa; font-size:12px;'>
                                    Iwan Assistance — Ceci est un mail automatique, merci de ne pas y répondre.
                                    <br>
                                    Utilisez le système de ticket pour répondre.        
                                    <br>
                                    Nous contacter au 02 40 28 86 38 ou par mail à contact@iwan.fr 
                                </p>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>

    </body>
    </html>";
}

function template_reponse_ticket(
    string $id_lien,
    string $numero_ticket,
    string $titre_ticket,
    string $nom_entreprise,
    string $titre_reponse,
    string $contenu,
    string $date_envoi
): string {
    // Protection XSS
    $nom_entreprise = htmlspecialchars($nom_entreprise, ENT_QUOTES, 'UTF-8');
    $titre_reponse  = htmlspecialchars($titre_reponse, ENT_QUOTES, 'UTF-8');
    $contenu        = htmlspecialchars($contenu, ENT_QUOTES, 'UTF-8');
    return "
    <!DOCTYPE html>
    <html lang='fr'>
    <head><meta charset='UTF-8'></head>
    <body style='margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, sans-serif;'>
        <table width='100%' cellpadding='0' cellspacing='0' style='background-color:#f4f6f8; padding:40px 0;'>
            <tr>
                <td align='center'>
                    <table width='600' cellpadding='0' cellspacing='0' style='background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.08);'>

                        <!-- HEADER -->
                        <tr>
                            <td style='background-color:#0f2e48; padding:32px 40px; text-align:center;'>
                                <h1 style='margin:0; color:#ffffff; font-size:22px; font-weight:600;'>Iwan Assistance</h1>
                            " . (($_SESSION['is_admin'] ?? false) ? "
                            <p style='margin:6px 0 0; color:#a8c4d8; font-size:13px;'>
                                Nouvelle réponse d'IWAN
                            </p>
                        " : "
                            <p style='margin:6px 0 0; color:#a8c4d8; font-size:13px;'>
                                Nouvelle réponse client
                            </p>
                        ") . "                            
                        </td>
                        </tr>

                        <!-- BODY -->
                        <tr>
                            <td style='padding:36px 40px;'>
                        " . (($_SESSION['is_admin'] ?? false) ? "
                            <p style='margin:0 0 12px; color:#333333; font-size:15px;'>
                                Bonjour,
                            </p>
                            <p style='margin:0 0 24px; color:#333333; font-size:15px; line-height: 1.5;'>
                                IWAN a apporté une réponse à votre ticket. Vous trouverez les détails de cette mise à jour ci-dessous.
                            </p>
                        " : "
                            <p style='margin:0 0 24px; color:#333333; font-size:15px; line-height: 1.5;'>
                                Un client a apporté une nouvelle réponse sur le ticket suivant et est en attente de traitement.
                            </p>
                        ") . "
                                <!-- Détails -->
                                <table width='100%' cellpadding='0' cellspacing='0'>
                                    <tr>
                                        <td style='padding:8px 0; border-bottom:1px solid #eeeeee;'>
                                            <span style='color:#888888; font-size:13px;'>Entreprise</span>
                                        </td>
                                        <td style='padding:8px 0; border-bottom:1px solid #eeeeee; text-align:right;'>
                                            <span style='color:#333333; font-size:13px; font-weight:600;'>{$nom_entreprise}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='padding:8px 0; border-bottom:1px solid #eeeeee;'>
                                            <span style='color:#888888; font-size:13px;'>Titre du ticket</span>
                                        </td>
                                        <td style='padding:8px 0; border-bottom:1px solid #eeeeee; text-align:right;'>
                                            <span style='color:#333333; font-size:13px;'>{$titre_ticket}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='padding:8px 0;'>
                                            <span style='color:#888888; font-size:13px;'>Date</span>
                                        </td>
                                        <td style='padding:8px 0; text-align:right;'>
                                            <span style='color:#333333; font-size:13px;'>{$date_envoi}</span>
                                        </td>
                                    </tr>
                                </table>
                                <!-- Nom du ticket -->
                                <p style='margin:0 0 8px; color:#888888; font-size:13px;'>Titre de la réponse</p>
                                <div style='background-color:#f0f4f8; border-left:4px solid #0f2e48; border-radius:4px; padding:14px 18px; margin-bottom:24px;'>
                                    <p style='margin:4px 0 0; color:#555555; font-size:15px;'>{$titre_reponse}</p>
                                </div>
                                <!-- Contenu -->
                                <div style='margin-top:24px;'>
                                    <p style='margin:0 0 8px; color:#888888; font-size:13px;'>Message</p>
                                    <p style='margin:0; color:#333333; font-size:14px; line-height:1.6; background-color:#f9fafb; border-radius:4px; padding:14px;'>
                                        {$contenu}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    <!-- BOUTON -->
                    <tr>
                        <td style='padding: 0 40px 36px;' align='center'>
                            <a href='http://localhost/iwan-assistance-tickets/index.php?page=detail_ticket&ticket={$numero_ticket}&ID={$id_lien}'
                            style='display:inline-block; background-color:#0f2e48; color:#ffffff; text-decoration:none; font-size:14px; font-weight:600; padding:14px 32px; border-radius:6px; letter-spacing:0.5px;'>
                            Voir le ticket
                            </a>
                        </td>
                    </tr>
                        <!-- FOOTER -->
                        <tr>
                            <td style='background-color:#f0f4f8; padding:20px 40px; text-align:center;'>
                                <p style='margin:0; color:#aaaaaa; font-size:12px;'>
                                    Iwan Assistance — Ceci est un mail automatique, merci de ne pas y répondre.
                                    <br>
                                    Utilisez le système de ticket pour répondre.        
                                    <br>
                                    Nous contacter au 02 40 28 86 38 ou par mail à contact@iwan.fr 
                                </p>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>
    ";
}



function template_nouveau_suivi(
    string $id_lien,
    string $numero_suivi,
    string $nom_entreprise,
    string $date,
    string $type_suivi,
    string $prenom_contact,
    string $nom_contact,
    string $email,
    string $telephone,
    string $titre,
    string $notes
): string {
    $id_lien         = htmlspecialchars($id_lien, ENT_QUOTES, 'UTF-8');
    $numero_suivi    = htmlspecialchars($numero_suivi, ENT_QUOTES, 'UTF-8');
    $nom_entreprise  = htmlspecialchars($nom_entreprise, ENT_QUOTES, 'UTF-8');
    $date            = htmlspecialchars($date, ENT_QUOTES, 'UTF-8');
    $type_suivi      = htmlspecialchars($type_suivi, ENT_QUOTES, 'UTF-8');
    $prenom_contact  = htmlspecialchars($prenom_contact, ENT_QUOTES, 'UTF-8');
    $nom_contact     = htmlspecialchars($nom_contact, ENT_QUOTES, 'UTF-8');
    $email           = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    $telephone       = htmlspecialchars($telephone, ENT_QUOTES, 'UTF-8');
    $titre           = htmlspecialchars($titre, ENT_QUOTES, 'UTF-8');
    $notes           = htmlspecialchars($notes, ENT_QUOTES, 'UTF-8');

    return "
<!DOCTYPE html>
    <html lang='fr'>
    <head>
        <meta charset='UTF-8'>
    </head>
    <body style='margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, sans-serif;'>

        <table width='100%' cellpadding='0' cellspacing='0' style='background-color:#f4f6f8; padding: 40px 0;'>
            <tr>
                <td align='center'>
                    <table width='600' cellpadding='0' cellspacing='0' style='background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08);'>

                        <tr>
                            <td style='background-color:#0f2e48; padding: 32px 40px; text-align:center;'>
                                <h1 style='margin:0; color:#ffffff; font-size:22px; font-weight:600; letter-spacing:0.5px;'>
                                    Iwan Assistance
                                </h1>
                                <p style='margin:6px 0 0; color:#a8c4d8; font-size:13px;'>
                                    Nouveau suivi créé
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td style='padding: 36px 40px;'>
                                <p style='margin:0 0 24px; color:#333333; font-size:15px; line-height:1.5;'>
                                    IWAN a enregistré un nouveau suivi sur votre dossier
                                </p>

                                <table width='100%' cellpadding='0' cellspacing='0' style='margin-bottom: 28px;'>
                                    <tr>
                                        <td style='padding:8px 0; border-bottom:1px solid #eeeeee;'>
                                            <span style='color:#888888; font-size:13px;'>Entreprise</span>
                                        </td>
                                        <td style='padding:8px 0; border-bottom:1px solid #eeeeee; text-align:right;'>
                                            <span style='color:#333333; font-size:13px; font-weight:600;'>{$nom_entreprise}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 8px 0; border-bottom:1px solid #eeeeee;'>
                                            <span style='color:#888888; font-size:13px;'>Contact</span>
                                        </td>
                                        <td style='padding: 8px 0; border-bottom:1px solid #eeeeee; text-align:right;'>
                                            <span style='color:#333333; font-size:13px; font-weight:600;'>{$prenom_contact} {$nom_contact}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 8px 0; border-bottom:1px solid #eeeeee;'>
                                            <span style='color:#888888; font-size:13px;'>E-mail</span>
                                        </td>
                                        <td style='padding: 8px 0; border-bottom:1px solid #eeeeee; text-align:right;'>
                                            <span style='color:#333333; font-size:13px;'>{$email} </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 8px 0; border-bottom:1px solid #eeeeee;'>
                                            <span style='color:#888888; font-size:13px;'>Téléphone</span>
                                        </td>
                                        <td style='padding: 8px 0; border-bottom:1px solid #eeeeee; text-align:right;'>
                                            <span style='color:#333333; font-size:13px;'>{$telephone} </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 8px 0; border-bottom:1px solid #eeeeee;'>
                                            <span style='color:#888888; font-size:13px;'>Type d'action</span>
                                        </td>
                                        <td style='padding: 8px 0; border-bottom:1px solid #eeeeee; text-align:right;'>
                                            <span style='color:#333333; font-size:13px; font-weight:600; color:#0f2e48;'>{$type_suivi}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 8px 0; border-bottom:1px solid #eeeeee;'>
                                            <span style='color:#888888; font-size:13px;'>Date de l'action</span>
                                        </td>
                                        <td style='padding: 8px 0; border-bottom:1px solid #eeeeee; text-align:right;'>
                                            <span style='color:#333333; font-size:13px;'>{$date}</span>
                                        </td>
                                    </tr>
                                </table>

                                <div style='background-color:#f0f4f8; border-left:4px solid #0f2e48; border-radius:4px; padding:14px 18px; margin-bottom:24px;'>
                                    <p style='margin:0; color:#0f2e48; font-size:12px; font-weight:bold; letter-spacing:0.5px; text-transform:uppercase;'>Sujet concerné</p>
                                    <p style='margin:4px 0 0; color:#555555; font-size:15px; font-weight:600;'>{$titre}</p>
                                </div>

                                <div style='margin-top:24px;'>
                                    <p style='margin:0 0 8px; color:#888888; font-size:13px;'>Notes d'intervention et compte-rendu</p>
                                    <p style='margin:0; color:#333333; font-size:14px; line-height:1.6; background-color:#f9fafb; border-radius:4px; padding:14px; border:1px solid #f1f5f9;'>
                                        " . nl2br($notes) . "
                                    </p>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style='padding: 0 40px 36px;' align='center'>
                                <a href='http://localhost/iwan-assistance-tickets/index.php?page=detail_ticket&ticket={$numero_suivi}&ID={$id_lien}'
                                   style='display:inline-block; background-color:#0f2e48; color:#ffffff; text-decoration:none; font-size:14px; font-weight:600; padding:14px 32px; border-radius:6px; letter-spacing:0.5px;'>
                                    Consulter le dossier d'assistance
                                </a>
                            </td>
                        </tr>
                        
                        <tr>
                            <td style='background-color:#f0f4f8; padding:20px 40px; text-align:center;'>
                                <p style='margin:0; color:#aaaaaa; font-size:12px; line-height:1.5;'>
                                    Iwan Assistance — Ceci est un mail automatique, merci de ne pas y répondre.
                                    <br><br>
                                    Nous contacter au <strong>02 40 28 86 38</strong> ou par mail à <a href='mailto:contact@iwan.fr' style='color:#94a3b8;'>contact@iwan.fr</a>
                                </p>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>

    </body>
    </html>";
}
