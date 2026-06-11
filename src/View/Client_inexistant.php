<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Compte introuvable</title>
    <link rel="stylesheet" href="public/styles/global.css">
    <style>
        .error-container {
            max-width: 500px;
            margin: 100px auto;
            text-align: center;
            padding: 40px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(15, 46, 72, 0.08);
            font-family: -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .error-container h1 {
            color: #EF1A1A;
            font-size: 24px;
            margin-bottom: 16px;
        }

        .error-container p {
            color: #4a5568;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        /* Bloc pour les coordonnées de contact */
        .contact-info-block {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 16px;
            margin-bottom: 28px;
            text-align: left;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #1e293b;
            font-size: 14px;
            text-decoration: none;
            font-weight: 500;
        }

        .contact-item:hover {
            color: #0f2e48;
        }

        .contact-item svg {
            color: #64748b;
            flex-shrink: 0;
        }

        .btn-home {
            display: inline-block;
            background-color: #0f2e48;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
            width: 100%;
            box-sizing: border-box;
            transition: background-color 0.2s ease;
        }

        .btn-home:hover {
            background-color: #1a3e5d;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#EF1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 8px;">
            <circle cx="12" cy="12" r="10" />
            <line x1="12" y1="8" x2="12" y2="12" />
            <line x1="12" y1="16" x2="12.01" y2="16" />
        </svg>

        <h1>Accès Refusé</h1>
        <p>Votre compte client n'existe pas ou a été archivé par l'administrateur. Si vous pensez qu'il s'agit d'une erreur, veuillez contacter le support IWAN.</p>

        <div class="contact-info-block">
            <a href="tel:0240288638" class="contact-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                </svg>
                <span>Téléphone : 02.40.28.86.38</span>
            </a>
            <a href="mailto:support@iwan.fr" class="contact-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                    <polyline points="22,6 12,13 2,6" />
                </svg>
                <span>Email : support@iwan.fr</span>
            </a>
        </div>

    </div>
</body>

</html>