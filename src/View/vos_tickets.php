<?php require_once __DIR__ . '/Templates/Header.php'; ?>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Vos tickets</title>
    <link rel="icon" type="image/png" href="../img/Logo_Iwan.png" />
    <link rel="stylesheet" href="public/styles/Vos_tickets.css" />
    <link rel="stylesheet" href="public/styles/Global.css" />
</head>

<body>
    <main>
        <div class="container-tickets">
            <h1>Vos tickets</h1>
            <p>
                Retrouvez ici l'historique et l'état d'avancement de toutes vos
                sollicitations.
            </p>

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
                            <option>Cette Semaine</option>
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
                                <span class="statut-dot critique"></span>
                                <h3>Critique - Ticket# 2026-CS123</h3>
                            </div>
                            <div class="statut-badge">
                                <svg
                                    width="181"
                                    height="35"
                                    viewBox="0 0 181 35"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="181" height="35" rx="4" fill="#7FAAD4" />
                                    <text
                                        x="50%"
                                        y="54%"
                                        dominant-baseline="middle"
                                        text-anchor="middle"
                                        fill="white"
                                        font-family="-apple-system, BlinkMacSystemFont, sans-serif"
                                        font-weight="700"
                                        font-size="14">
                                        En cours
                                    </text>
                                </svg>

                            </div>
                        </div>
                        <div class="ticket-body">
                            <h4>Le site est inaccessible</h4>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.Lorem
                                ipsum dolor sit amet, consectetur adipiscing elit.Lorem ipsum
                                dolor sit amet, consectetur adipiscing elit.
                            </p>
                            <button type="button" class="btn-delete-ticket" aria-label="Supprimer le ticket">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </button>
                        </div>

                        <div class="ticket-footer">
                            <span class="ticket-date">12:45, 22/04/2026</span>
                            <a href="index.php?page=detail_ticket" class="ticket-link">Ouvrir le ticket</a>
                        </div>
                    </div>

                    <div class="ticket-card">
                        <div class="ticket-header">
                            <div class="ticket-title-block">
                                <span class="statut-dot majeur"></span>
                                <h3>Majeur - Ticket# 2026-CS124</h3>
                            </div>
                            <div class="statut-badge">
                                <svg
                                    width="181"
                                    height="35"
                                    viewBox="0 0 181 35"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="181" height="35" rx="4" fill="#7FD97A" />
                                    <path
                                        d="M67.98 23V13.2H72.362C73.79 13.2 74.8867 13.5267 75.652 14.18C76.4267 14.824 76.814 15.706 76.814 16.826C76.814 17.5633 76.6367 18.2027 76.282 18.744C75.9273 19.276 75.4233 19.6867 74.77 19.976C74.126 20.256 73.356 20.396 72.46 20.396H69.52L70.752 19.234V23H67.98ZM74.042 23L71.606 19.43H74.56L77.01 23H74.042ZM70.752 19.528L69.52 18.254H72.292C72.8707 18.254 73.3 18.128 73.58 17.876C73.8693 17.624 74.014 17.274 74.014 16.826C74.014 16.3687 73.8693 16.014 73.58 15.762C73.3 15.51 72.8707 15.384 72.292 15.384H69.52L70.752 14.11V19.528ZM81.6333 23.126C80.7373 23.126 79.9533 22.958 79.2813 22.622C78.6186 22.2767 78.1006 21.81 77.7273 21.222C77.3633 20.6247 77.1813 19.948 77.1813 19.192C77.1813 18.436 77.3586 17.764 77.7133 17.176C78.0773 16.5787 78.5766 16.1167 79.2113 15.79C79.8459 15.454 80.5599 15.286 81.3533 15.286C82.0999 15.286 82.7813 15.44 83.3973 15.748C84.0133 16.0467 84.5033 16.49 84.8673 17.078C85.2313 17.666 85.4133 18.38 85.4133 19.22C85.4133 19.3133 85.4086 19.4207 85.3993 19.542C85.3899 19.6633 85.3806 19.7753 85.3713 19.878H79.3653V18.478H83.9573L82.9493 18.87C82.9586 18.5247 82.8933 18.226 82.7533 17.974C82.6226 17.722 82.4359 17.526 82.1933 17.386C81.9599 17.246 81.6846 17.176 81.3673 17.176C81.0499 17.176 80.7699 17.246 80.5273 17.386C80.2939 17.526 80.1119 17.7267 79.9813 17.988C79.8506 18.24 79.7853 18.5387 79.7853 18.884V19.29C79.7853 19.6633 79.8599 19.9853 80.0093 20.256C80.1679 20.5267 80.3919 20.7367 80.6813 20.886C80.9706 21.026 81.3159 21.096 81.7173 21.096C82.0906 21.096 82.4079 21.0447 82.6693 20.942C82.9399 20.83 83.2059 20.662 83.4673 20.438L84.8673 21.894C84.5033 22.2953 84.0553 22.6033 83.5233 22.818C82.9913 23.0233 82.3613 23.126 81.6333 23.126ZM79.9253 14.502L81.8013 12.374H84.4613L81.8293 14.502H79.9253ZM88.8377 23.126C88.1937 23.126 87.5637 23.0513 86.9477 22.902C86.341 22.7527 85.851 22.566 85.4777 22.342L86.2757 20.522C86.6304 20.7367 87.0457 20.9093 87.5217 21.04C87.9977 21.1613 88.4644 21.222 88.9217 21.222C89.3697 21.222 89.6777 21.1753 89.8457 21.082C90.023 20.9887 90.1117 20.8627 90.1117 20.704C90.1117 20.5547 90.0277 20.4473 89.8597 20.382C89.701 20.3073 89.4864 20.2513 89.2157 20.214C88.9544 20.1767 88.665 20.1347 88.3477 20.088C88.0304 20.0413 87.7084 19.9807 87.3817 19.906C87.0644 19.822 86.7704 19.7007 86.4997 19.542C86.2384 19.374 86.0284 19.15 85.8697 18.87C85.711 18.59 85.6317 18.2353 85.6317 17.806C85.6317 17.3207 85.7717 16.8913 86.0517 16.518C86.341 16.1353 86.761 15.8367 87.3117 15.622C87.8624 15.398 88.5344 15.286 89.3277 15.286C89.8597 15.286 90.3964 15.342 90.9377 15.454C91.4884 15.5567 91.9504 15.7153 92.3237 15.93L91.5257 17.736C91.1524 17.5213 90.779 17.3767 90.4057 17.302C90.0324 17.218 89.6777 17.176 89.3417 17.176C88.8937 17.176 88.5764 17.2273 88.3897 17.33C88.2124 17.4327 88.1237 17.5587 88.1237 17.708C88.1237 17.8573 88.203 17.974 88.3617 18.058C88.5204 18.1327 88.7304 18.1933 88.9917 18.24C89.2624 18.2773 89.5564 18.3193 89.8737 18.366C90.191 18.4033 90.5084 18.464 90.8257 18.548C91.1524 18.632 91.4464 18.758 91.7077 18.926C91.9784 19.0847 92.193 19.304 92.3517 19.584C92.5104 19.8547 92.5897 20.2047 92.5897 20.634C92.5897 21.1007 92.445 21.5207 92.1557 21.894C91.8757 22.2673 91.4557 22.566 90.8957 22.79C90.345 23.014 89.659 23.126 88.8377 23.126ZM96.984 23.126C96.1533 23.126 95.416 22.958 94.772 22.622C94.128 22.286 93.6193 21.824 93.246 21.236C92.882 20.6387 92.7 19.9573 92.7 19.192C92.7 18.4267 92.882 17.75 93.246 17.162C93.6193 16.574 94.128 16.1167 94.772 15.79C95.416 15.454 96.1533 15.286 96.984 15.286C97.8146 15.286 98.552 15.454 99.196 15.79C99.8493 16.1167 100.358 16.574 100.722 17.162C101.086 17.75 101.268 18.4267 101.268 19.192C101.268 19.9573 101.086 20.6387 100.722 21.236C100.358 21.824 99.8493 22.286 99.196 22.622C98.552 22.958 97.8146 23.126 96.984 23.126ZM96.984 21.012C97.292 21.012 97.5626 20.942 97.796 20.802C98.0386 20.662 98.23 20.4567 98.37 20.186C98.51 19.906 98.58 19.5747 98.58 19.192C98.58 18.8093 98.51 18.4873 98.37 18.226C98.23 17.9553 98.0386 17.75 97.796 17.61C97.5626 17.47 97.292 17.4 96.984 17.4C96.6853 17.4 96.4146 17.47 96.172 17.61C95.9386 17.75 95.7473 17.9553 95.598 18.226C95.458 18.4873 95.388 18.8093 95.388 19.192C95.388 19.5747 95.458 19.906 95.598 20.186C95.7473 20.4567 95.9386 20.662 96.172 20.802C96.4146 20.942 96.6853 21.012 96.984 21.012ZM101.94 23V12.612H104.6V23H101.94ZM108.961 23.126C108.345 23.126 107.79 23.0047 107.295 22.762C106.81 22.5193 106.427 22.1413 106.147 21.628C105.876 21.1053 105.741 20.4473 105.741 19.654V15.412H108.401V19.22C108.401 19.808 108.508 20.228 108.723 20.48C108.947 20.732 109.26 20.858 109.661 20.858C109.922 20.858 110.16 20.7973 110.375 20.676C110.59 20.5547 110.762 20.3633 110.893 20.102C111.024 19.8313 111.089 19.486 111.089 19.066V15.412H113.749V23H111.215V20.858L111.705 21.46C111.444 22.02 111.066 22.44 110.571 22.72C110.076 22.9907 109.54 23.126 108.961 23.126Z"
                                        fill="white" />
                                </svg>
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
                            <button type="button" class="btn-delete-ticket" aria-label="Supprimer le ticket">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </button>
                        </div>
                        <div class="ticket-footer">
                            <span class="ticket-date">12:45, 22/04/2026</span>
                            <a href="index.php?page=detail_ticket" class="ticket-link">Ouvrir le ticket</a>
                        </div>
                    </div>

                    <div class="ticket-card">
                        <div class="ticket-header">
                            <div class="ticket-title-block">
                                <span class="statut-dot standard"></span>
                                <h3>Standard - Ticket# 2026-CS125</h3>
                            </div>
                            <div class="statut-badge">
                                <div class="statut-badge">
                                    <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="181" height="35" rx="4" fill="#D9AD7A" />
                                        <text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">En attente</text>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="ticket-body">
                            <h4>Augmenter la taille des titres de séjour</h4>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.Lorem
                                ipsum dolor sit amet, consectetur adipiscing elit.Lorem ipsum
                                dolor sit amet, consectetur adipiscing elit.
                            </p>
                            <button type="button" class="btn-delete-ticket" aria-label="Supprimer le ticket">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </button>
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
    <!-- Modal pour valider la suppression-->
    <div class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="#e15252" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
                <h3>Supprimer le ticket</h3>
            </div>
            <p>Êtes-vous sûr de vouloir supprimer ce ticket ? Cette action est irréversible.</p>
            <div class="modal-actions">
                <button type="button" class="btn-cancel">Annuler</button>
                <button type="button" class="btn-confirm-delete">Supprimer</button>
            </div>
        </div>
    </div>
    <script src="public/scripts/valider_suppression.js"></script>
</body>

</html>

<?php require_once __DIR__ . '/Templates/Footer.php'; ?>