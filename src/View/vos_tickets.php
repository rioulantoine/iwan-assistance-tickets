<?php require_once __DIR__ . '/../Controller/ControllerHeader.php'; ?>

<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Historique de mes tickets</title>
    <link rel="icon" type="image/png" href="../img/Logo_Iwan.png" />
    <link rel="stylesheet" href="public/styles/Vos_tickets.css" />
    <link rel="stylesheet" href="public/styles/Global.css" />
</head>

<body>
    <main>
        <div class="tableau-de-bord">
            <div class="header-text">
                <h1>Mes tickets</h1>
                <p>
                    Retrouvez ici l'historique et l'état d'avancement de toutes vos
                    sollicitations.
                </p>
            </div>

            <?php if (isset($_SESSION['id_client'])): ?>
                <a href="index.php?page=nouveau_ticket" class="btn-nouveau-ticket">
                    <div class="icon-button">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </div>
                    <span>Nouveau ticket</span>
                </a>
            <?php endif; ?>
        </div>
        <div class="container-tickets">


            <div class="dashboard-content">
                <!-- Filtre des tickets -->
                <div class="filtre-ticket">
                    <form method="GET" action="" class="filtre-bar">
                        <input type="hidden" name="page" value="tickets">

                        <div class="select-wrapper">
                            <select name="date_filtre">
                                <option value="" <?= (!isset($_GET['date_filtre']) || $_GET['date_filtre'] === '') ? 'selected' : '' ?>>Tout le temps</option>
                                <option value="1" <?= (isset($_GET['date_filtre']) && $_GET['date_filtre'] === '1') ? 'selected' : '' ?>>Cette semaine</option>
                                <option value="2" <?= (isset($_GET['date_filtre']) && $_GET['date_filtre'] === '2') ? 'selected' : '' ?>>14 derniers jours</option>
                                <option value="3" <?= (isset($_GET['date_filtre']) && $_GET['date_filtre'] === '3') ? 'selected' : '' ?>>Ce mois</option>
                                <option value="4" <?= (isset($_GET['date_filtre']) && $_GET['date_filtre'] === '4') ? 'selected' : '' ?>>Dernier trimestre</option>
                                <option value="5" <?= (isset($_GET['date_filtre']) && $_GET['date_filtre'] === '5') ? 'selected' : '' ?>>Cette année</option>
                            </select>
                            <!--iconne de la fleche vers le bas -->
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
                        <div class="date-range-wrapper">
                            <div class="date-field">
                                <label>Du</label>
                                <div class="input-clearable-wrapper">
                                    <input type="date" id="date_debut" name="date_debut" value="<?= htmlspecialchars($_GET['date_debut'] ?? '') ?>">
                                    <!-- Icône calendrier cliquable -->
                                    <label for="date_debut" class="btn-calendar-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                    </label>
                                    <button type="button" class="btn-clear-date" onclick="viderChampDate('date_debut')">&times;</button>
                                </div>
                            </div>

                            <div class="date-field">
                                <label>Au</label>
                                <div class="input-clearable-wrapper">
                                    <input type="date" id="date_fin" name="date_fin" value="<?= htmlspecialchars($_GET['date_fin'] ?? '') ?>">
                                    <label for="date_fin" class="btn-calendar-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                    </label>
                                    <button type="button" class="btn-clear-date" onclick="viderChampDate('date_fin')">&times;</button>
                                </div>
                            </div>
                        </div>
                        <div class="select-wrapper">
                            <select name="statut_filtre">
                                <option value="" <?= (!isset($_GET['statut_filtre']) || $_GET['statut_filtre'] === '') ? 'selected' : '' ?>>Tous les statuts</option>
                                <option value="1" <?= (isset($_GET['statut_filtre']) && $_GET['statut_filtre'] === '1') ? 'selected' : '' ?>>En attente</option>
                                <option value="2" <?= (isset($_GET['statut_filtre']) && $_GET['statut_filtre'] === '2') ? 'selected' : '' ?>>En cours</option>
                                <option value="3" <?= (isset($_GET['statut_filtre']) && $_GET['statut_filtre'] === '3') ? 'selected' : '' ?>>Résolu</option>
                                <option value="4" <?= (isset($_GET['statut_filtre']) && $_GET['statut_filtre'] === '4') ? 'selected' : '' ?>>Archivé</option>
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
                            <select name="urgence_filtre">
                                <option value="" <?= (!isset($_GET['urgence_filtre']) || $_GET['urgence_filtre'] === '') ? 'selected' : '' ?>>Toutes les urgences</option>
                                <option value="1" <?= (isset($_GET['urgence_filtre']) && $_GET['urgence_filtre'] === '1') ? 'selected' : '' ?>>Bloquant / Très urgent</option>
                                <option value="2" <?= (isset($_GET['urgence_filtre']) && $_GET['urgence_filtre'] === '2') ? 'selected' : '' ?>>Urgent</option>
                                <option value="3" <?= (isset($_GET['urgence_filtre']) && $_GET['urgence_filtre'] === '3') ? 'selected' : '' ?>>Normal</option>
                                <option value="4" <?= (isset($_GET['urgence_filtre']) && $_GET['urgence_filtre'] === '4') ? 'selected' : '' ?>>Non urgent / Demande d'évolution</option>
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
                            <input type="text" name="recherche" placeholder="Rechercher un ticket" value="<?= trim(htmlspecialchars($_GET['recherche'] ?? '')) ?>" />
                        </div>

                        <button type="submit" class="btn-filtre">Appliquer les filtres</button>
                    </form>
                </div>
                <!-- Affichage de la liste des tickets -->
                <?php foreach ($lst_tickets  ?? [] as $ticket) : ?>
                    <div class="ticket-list">
                        <div class="ticket-card">
                            <div class="ticket-header">
                                <div class="ticket-title-block">
                                    <?php
                                    if (($ticket['id_urgence'] ?? null) == 1) {
                                        echo '<span class="status-dot red"></span>';
                                    } elseif (($ticket['id_urgence'] ?? null) == 2) {
                                        echo '<span class="status-dot orange"></span>';
                                    } elseif (($ticket['id_urgence'] ?? null) == 3) {
                                        echo '<span class="status-dot blue"></span>';
                                    } else {
                                        echo '<span class="status-dot green"></span>';
                                    }
                                    ?> <h3><?= htmlspecialchars($ticket['libelle_urgence']) . " #" . htmlspecialchars($ticket['numero_ticket']) ?> </h3>
                                </div>
                                <div class="statut-badge">
                                    <?php if (($ticket['id_statut'] ?? null) == 1) : ?>
                                        <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="181" height="35" rx="4" fill="#d97706" />
                                            <text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">En attente</text>
                                        </svg>
                                    <?php elseif (($ticket['id_statut'] ?? null) == 2) : ?>

                                        <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="181" height="35" rx="4" fill="#7FAAD4" />
                                            <text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">En cours</text>
                                        </svg>
                                    <?php elseif (($ticket['id_statut'] ?? null) == 3) : ?>

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
                            </div>
                            <div class="ticket-body">
                                <h4><?= htmlspecialchars($ticket['titre']) ?></h4>
                                <p>
                                    <!-- Affiche les 600 premiers caractères de la description du ticket suivi de "..." si elle dépasse 600 caractères -->
                                    <?= htmlspecialchars(
                                        mb_strlen($ticket['description'], 'UTF-8') > 600

                                            ? mb_substr($ticket['description'], 0, 600, 'UTF-8') . '...'

                                            : $ticket['description']

                                    ) ?>
                                </p>
                            </div>
                            <?php $date_creation = (new DateTime($ticket['date_creation']))->format('d/m/y à H:i'); ?>

                            <div class="ticket-footer">
                                <span class="ticket-date"><?= $date_creation ?></span>
                                <a href="index.php?page=detail_ticket&ticket=<?= urlencode($ticket['numero_ticket']) ?>" class="btn-ouvrir"> Ouvrir le ticket </a>
                            </div>
                        </div>
                    <?php endforeach ?>
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
    <script src="public/scripts/Vos_tickets.js"></script>
</body>

</html>

<?php require_once __DIR__ . '/Templates/Footer.php'; ?>