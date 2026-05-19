<?php require_once __DIR__ . '/Templates/Header.php'; ?>

<head>
    <meta charset="UTF-8" />
    <title>Détails Ticket</title>
    <link rel="icon" type="image/png" href="img/Logo_Iwan.png" />
    <link rel="stylesheet" href="public/styles/Details_ticket.css" />
    <link rel="stylesheet" href="public/styles/Global.css" />
</head>

<body>
    <main>
        <div class="container-details">
            <h1>Détails du ticket</h1>
            <p>
                Consultez l'historique complet des échanges et l'état d'avancement de votre résolution.
            </p>
            <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="181" height="35" rx="4" fill="#7FAAD4" />
                <text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">En cours</text>
            </svg>
        </div>

        <div class="thread-container">

            <div class="message-card">
                <div class="message-header">
                    <div class="header-left">
                        <span class="status-dot red"></span>
                        <span class="meta-title">Ticket# 2026-CS123</span>
                    </div>
                    <div class="header-right">
                        <span class="message-time">12:10 (4h34 plus tot)</span>
                        <div class="action-icons">
                            <svg class="icon-btn" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                <rect x="6" y="14" width="12" height="8"></rect>
                            </svg>
                            <svg class="icon-btn" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 17 4 12 9 7"></polyline>
                                <path d="M20 18v-2a4 4 0 0 0-4-4H4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="message-body">
                    <h3>Le site est inaccessible</h3>
                    <p class="message-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit.<br><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit.<br><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
            </div>

            <div class="message-card">
                <div class="message-header">
                    <div class="header-left">
                        <span class="meta-title">Transaction Failed</span>
                    </div>
                    <div class="header-right">
                        <span class="message-time">15:44 (4 plus tot)</span>
                        <div class="action-icons">
                            <svg class="icon-btn" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                <rect x="6" y="14" width="12" height="8"></rect>
                            </svg>
                            <svg class="icon-btn" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 17 4 12 9 7"></polyline>
                                <path d="M20 18v-2a4 4 0 0 0-4-4H4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="message-body">
                    <p class="reply-indicator">Réponse à "Le site est inaccessible"</p>
                    <p class="message-text">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>
                </div>
            </div>

            <div class="reply-section">
                <div class="reply-header">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 15l-6-6m0 0l6-6m-6 6h12"></path>
                    </svg>
                    <h3>En réponse à "Transaction Failed"</h3>
                </div>

                <form action="#" method="POST" class="reply-form">
                    <div class="input-group">
                        <label for="reply-title">Titre</label>
                        <input type="text" id="reply-title" name="title" placeholder="Entrez le titre de votre réponse" required>
                    </div>

                    <div class="textarea-wrapper">
                        <textarea name="content" placeholder="Entrez votre réponse..." required></textarea>

                        <div class="textarea-actions">

                            <input type="file" id="fichier" name="fichier[]" multiple style="display: none;">

                            <div id="liste-fichiers" class="file-name"></div>

                            <label for="fichier" class="btn-attach" style="cursor: pointer;" aria-label="Joindre des fichiers">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                                </svg>
                            </label>

                            <button type="submit" class="btn-submit" aria-label="Envoyer">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="22" y1="2" x2="11" y2="13"></line>
                                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <script src="public/scripts/upload_fichiers.js"></script>

    </main>
</body>

<?php require_once __DIR__ . '/Templates/Footer.php'; ?>