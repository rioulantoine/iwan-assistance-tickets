<?php
function envoyer_mail(string $destinataire, string $sujet, string $corps_html): bool
{
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: Iwan Assistance <noreply@iwan.com>\r\n";

    return mail($destinataire, $sujet, $corps_html, $headers);
}


function template_nouveau_ticket(
    string $numero_ticket,
    string $prenom,
    string $nom,
    string $email,
    string $titre,
    string $description,
    string $urgence,
    string $date_creation
): string {
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

                        <!-- HEADER -->
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

                        <!-- BODY -->
                        <tr>
                            <td style='padding: 36px 40px;'>
                                <p style='margin:0 0 24px; color:#333333; font-size:15px;'>
                                    Un nouveau ticket a été soumis et est en attente de traitement.
                                </p>

                                <!-- Numéro ticket -->
                                <div style='background-color:#f0f4f8; border-left:4px solid #0f2e48; border-radius:4px; padding:14px 18px; margin-bottom:24px;'>
                                    <p style='margin:0; color:#0f2e48; font-size:14px; font-weight:bold; letter-spacing:0.5px;'>
                                        #{$numero_ticket}
                                    </p>
                                    <p style='margin:4px 0 0; color:#555555; font-size:15px;'>{$titre}</p>
                                </div>

                                <!-- Détails -->
                                <table width='100%' cellpadding='0' cellspacing='0'>
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
                                        <td style='padding: 8px 0;'>
                                            <span style='color:#888888; font-size:13px;'>Date</span>
                                        </td>
                                        <td style='padding: 8px 0; text-align:right;'>
                                            <span style='color:#333333; font-size:13px;'>{$date_creation}</span>
                                        </td>
                                    </tr>
                                </table>

                                <!-- Description -->
                                <div style='margin-top:24px;'>
                                    <p style='margin:0 0 8px; color:#888888; font-size:13px;'>Description</p>
                                    <p style='margin:0; color:#333333; font-size:14px; line-height:1.6; background-color:#f9fafb; border-radius:4px; padding:14px;'>
                                        {$description}
                                    </p>
                                </div>
                            </td>
                        </tr>

                        <!-- FOOTER -->
                        <tr>
                            <td style='background-color:#f0f4f8; padding:20px 40px; text-align:center;'>
                                <p style='margin:0; color:#aaaaaa; font-size:12px;'>
                                    Iwan Assistance — Ceci est un mail automatique, merci de ne pas y répondre.
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
