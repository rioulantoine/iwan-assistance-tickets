<?php require_once __DIR__ . '/../Controller/ControllerHeader.php'; ?>

<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Les tickets</title>
    <link rel="icon" type="image/png" href="img/Logo_Iwan.png" />
    <link rel="stylesheet" href="public/styles/Les_tickets.css" />
    <link rel="stylesheet" href="public/styles/Global.css" />
</head>
<main>
    <div class="container-tickets">
        <?php

        $lien_ticket = (($ticket_suivi ?? 0) === 0)
            ? "index.php?page=nouveau_ticket"
            : "index.php?page=nouveau_ticket&tab=suivi";
        ?>

        <a href="<?= $lien_ticket ?>" class="btn-nouveau-ticket">
            <div class="icon-button">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
            </div>
            <span>Nouveau ticket / suivi</span>
        </a>
        <div class="dashboard-content">
            <h1>Les tickets</h1>

            <?php if (isset($_SESSION['flash_message'])) : ?>
                <div class="flash-alert alert-<?= $_SESSION['flash_type'] ?>" id="flashAlert">
                    <div class="flash-content">
                        <?php if ($_SESSION['flash_type'] === 'success') : ?>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        <?php else : ?>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                        <?php endif; ?>

                        <span><?= $_SESSION['flash_message'] ?></span>
                    </div>
                    <button class="close-flash" onclick="document.getElementById('flashAlert').style.display='none'">&times;</button>
                </div>
                <?php
                unset($_SESSION['flash_message']);
                unset($_SESSION['flash_type']);
                ?>
            <?php endif; ?>

            <p class="stat-text">
                <?php if (($nb_ticket ?? 0) === 0 && ($nb_suivis ?? 0) === 0) : ?>
                    Aucun ticket ni suivi n'a été trouvé.
                <?php else : ?>
                    Un total de
                    <span class="ticket-count"><?= ($nb_ticket ?? 0) === 0 ? 'aucun' : htmlspecialchars($nb_ticket ?? 0) ?></span>
                    ticket<?= ($nb_ticket ?? 0) > 1 ? 's' : '' ?>
                    et
                    <span class="ticket-count"><?= ($nb_suivis ?? 0) === 0 ? 'aucun' : htmlspecialchars($nb_suivis ?? 0) ?></span>
                    suivi<?= ($nb_suivis ?? 0) > 1 ? 's' : '' ?>
                    <?= (($nb_ticket ?? 0) + ($nb_suivis ?? 0)) > 1 ? 'ont été trouvés' : 'a été trouvé' ?>.
                <?php endif; ?>
            </p>

            <form method="GET" action="" class="filtre-bar">
                <input type="hidden" name="page" value="admin_tickets">

                <div class="select-wrapper">
                    <select name="date_filtre" onchange="this.form.submit()">
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
                            <input type="date" id="date_debut" name="date_debut" value="<?= htmlspecialchars($_GET['date_debut'] ?? '') ?>" onchange="this.form.submit()">
                            <label for="date_debut" class="btn-calendar-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </label>
                            <button type="button" class="btn-clear-date" onclick="viderChampDate('date_debut'); this.form.submit();">&times;</button>
                        </div>
                    </div>
                    <div class="date-field">
                        <label>Au</label>
                        <div class="input-clearable-wrapper">
                            <input type="date" id="date_fin" name="date_fin" value="<?= htmlspecialchars($_GET['date_fin'] ?? '') ?>" onchange="this.form.submit()">
                            <label for="date_fin" class="btn-calendar-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </label>
                            <button type="button" class="btn-clear-date" onclick="viderChampDate('date_fin'); this.form.submit();">&times;</button>
                        </div>
                    </div>
                </div>

                <div class="select-wrapper">
                    <select name="statut_filtre" onchange="this.form.submit()">
                        <option value="" <?= (!isset($_GET['statut_filtre']) || $_GET['statut_filtre'] === '') ? 'selected' : '' ?>>Tous les statuts</option>
                        <option value="1" <?= (isset($_GET['statut_filtre']) && $_GET['statut_filtre'] === '1') ? 'selected' : '' ?>>En attente</option>
                        <option value="2" <?= (isset($_GET['statut_filtre']) && $_GET['statut_filtre'] === '2') ? 'selected' : '' ?>>Fait</option>
                        <option value="3" <?= (isset($_GET['statut_filtre']) && $_GET['statut_filtre'] === '3') ? 'selected' : '' ?>>À revoir</option>
                        <option value="4" <?= (isset($_GET['statut_filtre']) && $_GET['statut_filtre'] === '4') ? 'selected' : '' ?>>Archivé</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>

                <div class="select-wrapper">
                    <select name="urgence_filtre" onchange="this.form.submit()">
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

                <div class="select-wrapper">
                    <select name="ticket_suivi" onchange="this.form.submit()">
                        <option value="2" <?= (isset($filtres['type']) && $filtres['type'] === '2') ? 'selected' : '' ?>>Tickets et suivis</option>
                        <option value="0" <?= (isset($filtres['type']) && $filtres['type'] === '0') ? 'selected' : '' ?>>Tickets</option>
                        <option value="1" <?= (isset($filtres['type']) && $filtres['type'] === '1') ? 'selected' : '' ?>>Suivis</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>

                <div class="select-wrapper">
                    <select name="groupe" onchange="this.form.submit()">
                        <option value="" <?= (!isset($_GET['groupe']) || $_GET['groupe'] === '') ? 'selected' : '' ?>>Filtres groupés...</option>
                        <option value="1" <?= (isset($_GET['groupe']) && $_GET['groupe'] === '1') ? 'selected' : '' ?>>Suivi / Cette semaine / En attente</option>
                        <option value="2" <?= (isset($_GET['groupe']) && $_GET['groupe'] === '2') ? 'selected' : '' ?>>Suivi / Cette semaine / Urgent / En attente</option>
                        <option value="3" <?= (isset($_GET['groupe']) && $_GET['groupe'] === '3') ? 'selected' : '' ?>>Ticket / Cette semaine / En attent</option>
                        <option value="4" <?= (isset($_GET['groupe']) && $_GET['groupe'] === '4') ? 'selected' : '' ?>>Ticket / Cette semaine / Urgent / En attente</option>
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
                    <input type="text" name="recherche" placeholder="Rechercher un ticket..." value="<?= trim(htmlspecialchars($_GET['recherche'] ?? '')) ?>" onchange="this.form.submit()" />
                </div>

                <a href="/iwan-assistance-tickets/index.php?page=admin_tickets" class="btn-refresh" title="Réinitialiser et recharger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="icon-refresh">
                        <path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67" />
                    </svg>
                    <span>Tous les tickets</span>
                </a>
            </form>

            <table class="table-tickets">
                <thead>
                    <tr>
                        <th class="sortable" data-col="ref" data-order="<?= (($filtres['tri_col'] ?? '') === 'ref') ? $filtres['tri_ordre'] ?? '' : 0 ?>">
                            Titre <span class="sort-icon"><?= (($filtres['tri_col'] ?? '') === 'titre') ? (($filtres['tri_ordre'] ?? 0) == 2 ? '▼' : '▲') : '▲' ?></span>
                        </th>
                        <th>Établissement</th>
                        <th>Logiciel</th>
                        <th>Auteur</th>
                        <th class="sortable" data-col="date_creation" data-order="<?= (($filtres['tri_col'] ?? '') === 'date_creation') ? $filtres['tri_ordre'] ?? '' : 0 ?>">
                            Demandé le <span class="sort-icon"><?= (($filtres['tri_col'] ?? '') === 'date_creation') ? (($filtres['tri_ordre'] ?? 0) == 2 ? '▼' : '▲') : '▲' ?></span>
                        </th>
                        <th class="sortable" data-col="date_maj" data-order="<?= (($filtres['tri_col'] ?? '') === 'date_maj') ? $filtres['tri_ordre'] ?? '' : 0 ?>">
                            Modifié le <span class="sort-icon"><?= (($filtres['tri_col'] ?? '') === 'date_maj') ? (($filtres['tri_ordre'] ?? 0) == 2 ? '▼' : '▲') : '▲' ?></span>
                        </th>
                        <th class="sortable" data-col="date_resolution" data-order="<?= (($filtres['tri_col'] ?? '') === 'date_resolution') ? $filtres['tri_ordre'] ?? '' : 0 ?>">
                            Résolu le <span class="sort-icon"><?= (($filtres['tri_col'] ?? '') === 'date_resolution') ? (($filtres['tri_ordre'] ?? 0) == 2 ? '▼' : '▲') : '▲' ?></span>
                        </th>
                        <th class="sortable" data-col="duree_traitement" data-order="<?= (($filtres['tri_col'] ?? '') === 'duree_traitement') ? $filtres['tri_ordre'] ?? '' : 0 ?>">
                            Durée de traitement <span class="sort-icon"><?= (($filtres['tri_col'] ?? '') === 'duree_traitement') ? (($filtres['tri_ordre'] ?? 0) == 2 ? '▼' : '▲') : '▲' ?></span>
                        </th>
                        <th class="sortable" data-col="id_statut" data-order="<?= (($filtres['tri_col'] ?? '') === 'id_statut') ? $filtres['tri_ordre'] ?? '' : 0 ?>">
                            Statut <span class="sort-icon"><?= (($filtres['tri_col'] ?? '') === 'id_statut') ? (($filtres['tri_ordre'] ?? 0) == 2 ? '▼' : '▲') : '▲' ?></span>
                        </th>
                        <th>Accès aux détails</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($liste_tickets)) : ?>
                        <tr>
                            <td colspan="10" class="no-tickets">Aucun ticket trouvé avec les critères sélectionnés.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($liste_tickets as $ticket) : ?>
                            <?php
                            $classe_urgence = 'text-non-urgent';
                            if ($ticket['id_urgence'] == 1) $classe_urgence = 'text-bloquant';
                            if ($ticket['id_urgence'] == 2) $classe_urgence = 'text-urgent';
                            if ($ticket['id_urgence'] == 3) $classe_urgence = 'text-normal';
                            if ($ticket['type'] == 1) $classe_urgence = 'suivi';

                            $date_creation = (new DateTime($ticket['date_creation']))->format('d/m/y à H:i');
                            $date_resolution = !empty($ticket['date_resolution']) ? (new DateTime($ticket['date_resolution']))->format('d/m/y à H:i') : '---';
                            $date_maj = !empty($ticket['date_maj']) ? (new DateTime($ticket['date_maj']))->format('d/m/y à H:i') : '---';
                            ?>
                            <tr>
                                <td class="<?= $classe_urgence ?> font-bold"><?= htmlspecialchars($ticket['titre']) ?></td>
                                <td><?= htmlspecialchars($ticket['nom_entreprise'] ?? '') ?></td>
                                <td><?= htmlspecialchars($ticket['logiciel'] ?? '') ?></td>
                                <td><?= htmlspecialchars($ticket['declarant_prenom'] . ' ' . $ticket['declarant_nom']) ?></td>
                                <td><?= $date_creation ?></td>
                                <td><?= $date_maj ?></td>
                                <td><?= $date_resolution ?></td>
                                <td><?= htmlspecialchars($ticket['duree_traitement'] ?? '') ?></td>
                                <td class="font-bold"><?= htmlspecialchars($ticket['libelle_statut']) ?></td>
                                <td>
                                    <div class="actions-cell">
                                        <a href="index.php?page=detail_ticket&ticket=<?= urlencode($ticket['numero_ticket']) ?>" class="btn-voir-plus">
                                            Voir plus
                                        </a>
                                        <a href="#" class="btn-download" title="Télécharger">
                                            <i class="icon-download">📥</i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="pagination">
                <button class="page-nav disabled">Précédent</button>
                <button class="page-num active">1</button>
                <button class="page-num">2</button>
                <button class="page-nav">Suivant</button>
            </div>

        </div>
    </div>
    <script src="public/scripts/Les_tickets.js"></script>
</main>
<?php require_once __DIR__ . '/Templates/Footer.php'; ?>