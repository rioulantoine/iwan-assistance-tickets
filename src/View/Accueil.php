<?php require_once __DIR__ . '/Templates/Header.php'; ?>
<?php
$total = "a";
var_dump($total); ?>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Tableau de bord</title>
    <link rel="icon" type="image/png" href="img/Logo_Iwan.png" />
    <link rel="stylesheet" href="public/styles/Accueil.css" />
    <link rel="stylesheet" href="public/styles/Global.css" />
</head>

<body>
    <main>
        <div class="tableau-de-bord">
            <h1>Tableau de bord</h1>
            <p>
                <!-- Revoir avec le php pour adapter en fonction du statut-->

                Forte activité ce mois-ci : nos équipes sont mobilisées sur vos
                dossiers.
            </p>
        </div>

        <div class="container-boxes">
            <div class="box">
                <div class="box-header">
                    <div class="box-badge">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="16" rx="2" />
                            <polyline points="8 12 12 16 16 12" />
                            <line x1="12" y1="8" x2="12" y2="16" />
                        </svg>
                    </div>
                    <h3>Tickets actifs</h3>
                </div>
                <!--Inclure le php ici -->
                <p class="box-desc">
                    Augmentation de <strong>7%</strong> du nombre de tickets par rapport
                    à avril 2026
                </p>
                <div class="box-value">210</div>
                <div
                    class="box-watermark"
                    style="transform: rotate(-15deg); right: -10px; bottom: -20px">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="16" rx="2" />
                        <polyline points="8 12 12 16 16 12" />
                        <line x1="12" y1="8" x2="12" y2="16" />
                    </svg>
                </div>
            </div>

            <div class="box active">
                <div class="box-header">
                    <div class="box-badge">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <h3>Tickets résolus</h3>
                </div>
                <!--Inclure le php ici -->

                <p class="box-desc">
                    Augmentation de <strong>20%</strong> de tickets résolus par rapport
                    à avril 2026
                </p>
                <div class="box-value">178</div>
                <div class="box-watermark" style="right: -15px; bottom: -25px">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
            </div>

            <div class="box urgent">
                <div class="box-header">
                    <div class="box-badge">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="currentColor">
                            <circle cx="12" cy="12" r="10" />
                            <line
                                x1="12"
                                y1="8"
                                x2="12"
                                y2="12"
                                stroke="#ffffff"
                                stroke-width="2"
                                stroke-linecap="round" />
                            <circle cx="12" cy="16" r="1" fill="#ffffff" />
                        </svg>
                    </div>
                    <h3>Tickets Urgents</h3>
                </div>
                <!--Inclure le php ici -->

                <p class="box-desc">
                    Augmentation de <strong class="text-red">2%</strong> du nombre de
                    tickets urgent par rapport à avril 2026
                </p>
                <div class="box-value">08</div>
                <div
                    class="box-watermark"
                    style="
              transform: rotate(28deg);
              right: -30px;
              bottom: -40px;
              color: rgba(225, 82, 82, 0.18);
              opacity: 1;
            ">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor">
                        <circle cx="12" cy="12" r="11" />
                        <line
                            x1="12"
                            y1="6"
                            x2="12"
                            y2="13"
                            stroke="#ffffff"
                            stroke-width="2.5"
                            stroke-linecap="round" />
                        <circle cx="12" cy="17" r="1.5" fill="#ffffff" />
                    </svg>
                </div>
            </div>

            <div class="box">
                <div class="box-header">
                    <div class="box-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="bg-percent-icon">
                            <path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z" />
                            <line x1="8" y1="16" x2="16" y2="8" />
                            <path d="M9 9.5h.01" stroke-width="2.5" />
                            <path d="M15 14.5h.01" stroke-width="2.5" />
                        </svg>
                    </div>
                    <h3>Taux de Résolution</h3>
                </div>
                <!--Inclure le php ici -->

                <p class="box-desc">
                    Le taux de résolution à baissé de
                    <strong class="text-red">2%</strong> depuis avril 2026
                </p>
                <div class="box-value">74%</div>
                <div class="box-watermark" style="right: -15px; bottom: -20px">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="bg-percent-icon">
                        <path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z" />
                        <line x1="8" y1="16" x2="16" y2="8" />
                        <path d="M9 9.5h.01" stroke-width="2.5" />
                        <path d="M15 14.5h.01" stroke-width="2.5" />
                    </svg>
                </div>
            </div>
        </div>
        <div class="container-tickets">
            <!--Implémenter le php-->
            <p>Les Tickets de L&M Evasion</p>
            <a href="index.php?page=nouveau_ticket" class="btn-nouveau-ticket">
                <div class="icon-button">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M12 20h9"></path>
                        <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                    </svg>
                </div>
                <span>Nouveau ticket</span>
            </a>
            <div class="dashboard-content">
                <div class="filter-bar">
                    <div class="select-wrapper">
                        <select>
                            <option>Cette semaine</option>
                        </select>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </div>

                    <div class="select-wrapper">
                        <select>
                            <option>Choisir le niveau d'urgence</option>
                        </select>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </div>

                    <div class="search-wrapper">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" placeholder="Rechercher un ticket" />
                    </div>

                    <button class="btn-filter">Appliquer les filtres</button>
                </div>

                <div class="ticket-list">
                    <div class="ticket-card">
                        <div class="ticket-header">
                            <div class="ticket-title-block">
                                <span class="status-dot critique"></span>
                                <h3>Critique - Ticket# 2026-CS123</h3>
                            </div>
                            <div class="ticket-author">
                                <div class="avatar-placeholder"></div>
                                <span>John Snow</span>
                            </div>
                        </div>
                        <div class="ticket-body">
                            <h4>Le site est inaccessible</h4>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.Lorem
                                ipsum dolor sit amet, consectetur adipiscing elit.Lorem ipsum
                                dolor sit amet, consectetur adipiscing elit.
                            </p>
                        </div>
                        <div class="ticket-footer">
                            <span class="ticket-date">12:45, 22/04/2026</span>
                            <a href="index.php?page=detail_ticket" class="ticket-link">Ouvrir le ticket</a>
                        </div>
                    </div>

                    <div class="ticket-card">
                        <div class="ticket-header">
                            <div class="ticket-title-block">
                                <span class="status-dot majeur"></span>
                                <h3>Majeur - Ticket# 2026-CS124</h3>
                            </div>
                            <div class="ticket-author">
                                <div class="avatar-placeholder"></div>
                                <span>John Cow</span>
                            </div>
                        </div>
                        <div class="ticket-body">
                            <h4>
                                Le site est mets une erreur lorsque l'on cherche "%admin%"
                            </h4>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.Lorem
                                ipsum dolor sit amet, consectetur adipiscing elit.Lorem ipsum
                                dolor sit amet, consectetur adipiscing elit.
                            </p>
                        </div>
                        <div class="ticket-footer">
                            <span class="ticket-date">12:45, 22/04/2026</span>
                            <a href="index.php?page=detail_ticket" class="ticket-link">Ouvrir le ticket</a>
                        </div>
                    </div>

                    <div class="ticket-card">
                        <div class="ticket-header">
                            <div class="ticket-title-block">
                                <span class="status-dot standard"></span>
                                <h3>Standard - Ticket# 2026-CS125</h3>
                            </div>
                            <div class="ticket-author">
                                <div class="avatar-placeholder"></div>
                                <span>John Doe</span>
                            </div>
                        </div>
                        <div class="ticket-body">
                            <h4>Augmenter la taille des titres de séjour</h4>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.Lorem
                                ipsum dolor sit amet, consectetur adipiscing elit.Lorem ipsum
                                dolor sit amet, consectetur adipiscing elit.
                            </p>
                        </div>
                        <div class="ticket-footer">
                            <span class="ticket-date">12:45, 22/04/2026</span>
                            <a href="index.php?page=detail_ticket" class="ticket-link">Ouvrir le ticket</a>
                        </div>
                    </div>
                </div>

                <div class="pagination">
                    <button class="page-nav disabled">Précédent</button>
                    <button class="page-num active">1</button>
                    <button class="page-num">2</button>
                    <button class="page-nav">Suivant</button>
                </div>
            </div>
        </div>
    </main>
</body>

</html>


<?php require_once __DIR__ . '/Templates/Footer.php'; ?>