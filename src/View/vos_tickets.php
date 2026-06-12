<?php require_once __DIR__ . '/../Controller/ControllerHeader.php'; ?>

<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Historique de mes tickets</title>
    <link rel="icon" type="image/png" href="../img/Logo_Iwan.png" />
    <link rel="stylesheet" href="public/styles/vos_tickets.css" />
    <link rel="stylesheet" href="public/styles/Global.css" />
</head>

<body>
    <main>
        <div class="tableau-de-bord">
            <div class="header-text">
                <h1>Mes tickets</h1>
                <p>Retrouvez ici l'historique et l'état d'avancement de toutes vos sollicitations.</p>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </div>

                        <div class="date-range-wrapper">
                            <div class="date-field">
                                <label>Du</label>
                                <div class="input-clearable-wrapper">
                                    <input type="date" id="date_debut" name="date_debut" value="<?= htmlspecialchars($_GET['date_debut'] ?? '') ?>">
                                    <label for="date_debut" class="btn-calendar-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </div>

                        <div class="search-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" name="recherche" placeholder="Rechercher un ticket" value="<?= trim(htmlspecialchars($_GET['recherche'] ?? '')) ?>" />
                        </div>

                        <button type="submit" class="btn-filtre">Appliquer les filtres</button>
                    </form>
                </div>

                <div class="ticket-list">
                    <?php foreach ($lst_tickets ?? [] as $ticket) : ?>

                        <div class="ticket-card">
                            <div class="ticket-ligne-principale">
                                <div class="ticket-badges">
                                    <h4 class="ticket-titre"><?= htmlspecialchars($ticket['titre']) ?></h4>

                                    <h3 class="badge-urgence urgence-<?= (int)($ticket['id_urgence'] ?? 3) ?>">
                                        <?= htmlspecialchars($ticket['libelle_urgence']) ?>
                                    </h3>
                                    <?php if ($ticket['declarant_nom'] && !($_SESSION['is_admin'] ?? false)): ?>
                                        <div class="nom-entreprise">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="#4a5d78">
                                                <path d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5Z" />
                                                <path d="M12 14c-4.42 0-8 2.58-8 6v2h16v-2c0-3.42-3.58-6-8-6Z" />
                                            </svg>
                                            <p><?= htmlspecialchars($ticket['declarant_nom']) . " " . htmlspecialchars($ticket['declarant_prenom']) ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <?php
                                    $statut_id = $ticket['id_statut'] ?? null;
                                    $statut_labels = [1 => 'En attente', 2 => 'En cours', 3 => 'Résolu'];
                                    $label = $statut_labels[$statut_id] ?? 'Archivé';
                                    $statut_class = match ($statut_id) {
                                        1 => 'badge-statut-1',
                                        2 => 'badge-statut-2',
                                        3 => 'badge-statut-3',
                                        default => 'badge-statut-archive'
                                    };
                                    ?>
                                    <span class="<?= $statut_class ?>"><?= $label ?></span>
                                </div>

                                <div class="ticket-actions">
                                    <?php
                                    $date_creation = (new DateTime($ticket['date_creation']))->format('d/m/y à H:i');
                                    $date_maj = !empty($ticket['date_maj']) ? (new DateTime($ticket['date_maj']))->format('d/m/Y à H:i') : null;
                                    ?>
                                    <?php if ($_SESSION['is_admin'] ?? false): ?>
                                        <span class="ticket-date"><?= $date_creation ?></span>
                                    <?php else : ?>
                                        <?php if ($ticket['derniere_action'] === "Ticket créé"): ?>
                                            <span class="ticket-date"><?= htmlspecialchars($ticket['derniere_action']) ?> le <?= htmlspecialchars($ticket['date_creation']) ?></span>
                                        <?php else : ?>
                                            <span class="ticket-date">Mis à jour le <?= $date_maj ?> : <?= $ticket['derniere_action'] ?? "" ?></span>
                                        <?php endif ?>
                                    <?php endif ?>

                                    <a href="index.php?page=detail_ticket&ticket=<?= urlencode($ticket['numero_ticket']) ?>" class="btn-ouvrir">Ouvrir</a>
                                </div>
                            </div>

                            <div class="ticket-body">
                                <p dir="ltr">
                                    <?php
                                    $texte = $ticket['description'];
                                    if (mb_strlen($texte, 'UTF-8') > 300) {
                                        $coupe = mb_substr($texte, 0, 300, 'UTF-8');
                                        $pos = mb_strrpos($coupe, ' ', 0, 'UTF-8');
                                        if ($pos !== false && $pos > 0) {
                                            $coupe = mb_substr($coupe, 0, $pos, 'UTF-8');
                                        }
                                        echo htmlspecialchars($coupe) . '...';
                                    } else {
                                        echo htmlspecialchars($texte);
                                    }
                                    ?>
                                </p>
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