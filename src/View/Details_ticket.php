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
            <?php if (($details_ticket['id_statut'] ?? null) == 1) : ?>
                <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="181" height="35" rx="4" fill="#d9ad7a" />
                    <text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">En attente</text>
                </svg>
            <?php elseif (($details_ticket['id_statut'] ?? null) == 2) : ?>

                <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="181" height="35" rx="4" fill="#7FAAD4" />
                    <text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">En cours</text>
                </svg>
            <?php elseif (($details_ticket['id_statut'] ?? null) == 3) : ?>

                <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="181" height="35" rx="4" fill="#38a169" />
                    <text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">Résolu</text>
                </svg>
            <?php else : ?>
                <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="181" height="35" rx="4" fill="#718096" />
                    <text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">Archivé</text>
                </svg>
            <?php endif; ?>
        </div>
        <div class="thread-container">

            <div class="message-card">
                <div class="message-header">
                    <div class="header-left">
                        <?php
                        if (($details_ticket['id_urgence'] ?? null) == 1) {
                            echo '<span class="status-dot red"></span>';
                        } elseif (($details_ticket['id_urgence'] ?? null) == 2) {
                            echo '<span class="status-dot orange"></span>';
                        } elseif (($details_ticket['id_urgence'] ?? null) == 3) {
                            echo '<span class="status-dot blue"></span>';
                        } else {
                            echo '<span class="status-dot green"></span>';
                        }
                        ?>
                        <span class="meta-title"><?= htmlspecialchars($num_ticket ?? 'Numéro de ticket non spécifié') ?></span>
                    </div>
                    <div class="header-right">
                        <span class="message-time"><?= htmlspecialchars($date_ticket ?? 'Date non spécifiée') ?> (<?= $ecart_date_ticket ?? '0' ?>)</span>
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
                    <h3><?= htmlspecialchars($details_ticket['titre'] ?? 'Titre non spécifié') ?></h3>
                    <p class="message-text"><?= htmlspecialchars($details_ticket['description'] ?? 'Description non spécifiée') ?></p>
                    <?php if (!empty($pieces_jointes)): ?>
                        <?php foreach ($pieces_jointes as $pj) :
                            $extension = strtolower(pathinfo($pj['nom_origine'], PATHINFO_EXTENSION));
                            $taille_kb = round($pj['taille_octets'] / 1024);
                        ?>
                            <div class="attachment-card">
                                <div class="file-icon-wrapper file-<?= $extension ?>">
                                    <div class="file-badge"><?= strtoupper($extension) ?></div>
                                </div>
                                <div class="file-info">
                                    <span class="file-title"><?= htmlspecialchars($pj['nom_origine']) ?></span>
                                    <span class="file-size"><?= $taille_kb ?> KB</span>
                                </div>
                                <a href="public/uploads/<?= htmlspecialchars($pj['nom_stockage']) ?>"
                                    download="<?= htmlspecialchars($pj['nom_origine']) ?>"
                                    class="download-btn">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
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
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="100" height="100" fill="currentColor">
                            <path d="M14 9V5l7 7-7 7v-4.1c-5 0-8.5 1.6-11 5.1 1-5 4-10 11-11z" />
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

                                <div class="ajouter-fichier-container">
                                    <input type="file" id="fichier" name="fichier[]" multiple style="display: none;">
                                    <label for="fichier" class="btn-ajouter-fichiers">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                                        </svg>
                                        Ajouter un/des fichier(s)
                                    </label>

                                    <div id="liste-fichiers" class="fichiers-preview-list"></div>
                                </div>

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