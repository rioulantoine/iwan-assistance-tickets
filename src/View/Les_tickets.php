<?php require_once __DIR__ . '/../Controller/ControllerHeader.php'; ?>

<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Tableau de bord</title>
    <link rel="icon" type="image/png" href="img/Logo_Iwan.png" />
    <link rel="stylesheet" href="public/styles/Les_tickets.css" />

    <link rel="stylesheet" href="public/styles/Global.css" />
</head>
<main>
    <div class="container-tickets">


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
                // On vide le message pour qu'il ne se re affiche pas 
                unset($_SESSION['flash_message']);
                unset($_SESSION['flash_type']);
                ?>
            <?php endif; ?>


            <p>
                <?php if (($nb_ticket ?? 0) > 1) : ?>
                    Un total de <span class="ticket-count"><?= htmlspecialchars($nb_ticket ?? 0) ?></span> tickets ont été trouvés.
                <?php elseif (($nb_ticket ?? 0) === 1) : ?>
                    Un total de <span class="ticket-count">1</span> ticket a été trouvé.
                <?php else : ?>
                    Aucun ticket n'a été trouvé.
                <?php endif; ?>


                <!-- FILTRES -->


            <form method="GET" action="" class="filtre-bar">
                <input type="hidden" name="page" value="admin_tickets">

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

                <div class="select-wrapper">
                    <select name="ticket_suivi">
                        <option value="2" <?= (!isset($_GET['ticket_suivi']) || $_GET['ticket_suivi'] === '2') ? 'selected' : '' ?>>Tickets et suivis</option>
                        <option value="0" <?= (isset($_GET['ticket_suivi']) && $_GET['ticket_suivi'] === '0') ? 'selected' : '' ?>>Tickets</option>
                        <option value="1" <?= (isset($_GET['ticket_suivi']) && $_GET['ticket_suivi'] === '1') ? 'selected' : '' ?>>Suivis</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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


            <!-- Liste des tickets -->


            <table class="table-tickets">
                <!-- Haut du tableau -->
                <thead>
                    <tr>
                        <th class="sortable" data-col="ref"
                            data-order="<?= (($filtres['tri_col'] ?? '') === 'ref') ? $filtres['tri_ordre'] ?? '' : 0 ?>">
                            Réf. <span class="sort-icon"><?= (($filtres['tri_col'] ?? '') === 'ref') ? ($filtres['tri_ordre'] ?? '' == 2 ? '▼' : '▲') : '▲' ?></span>
                        </th>
                        <th class="sortable" data-col="titre"
                            data-order="<?= (($filtres['tri_col'] ?? '') === 'titre') ? $filtres['tri_ordre'] ?? '' : 0 ?>">
                            Titre <span class="sort-icon"><?= (($filtres['tri_col'] ?? '') === 'titre') ? ($filtres['tri_ordre'] ?? '' == 2 ? '▼' : '▲') : '▲' ?></span>
                        </th>
                        <th>Établissement</th>
                        <th>Logiciel</th>
                        <th>Auteur</th>
                        <th class="sortable" data-col="date_creation"
                            data-order="<?= (($filtres['tri_col'] ?? '') === 'date_creation') ? $filtres['tri_ordre'] ?? '' : 0 ?>">
                            Demandé le <span class="sort-icon"><?= (($filtres['tri_col'] ?? '') === 'date_creation') ? ($filtres['tri_ordre'] ?? '' == 2 ? '▼' : '▲') : '▲' ?></span>
                        </th>
                        <th class="sortable" data-col="date_maj"
                            data-order="<?= (($filtres['tri_col'] ?? '') === 'date_maj') ? $filtres['tri_ordre'] ?? '' : 0 ?>">
                            Modifié le <span class="sort-icon"><?= (($filtres['tri_col'] ?? '') === 'date_maj') ? ($filtres['tri_ordre'] ?? '' == 2 ? '▼' : '▲') : '▲' ?></span>
                        </th>
                        <th class="sortable" data-col="date_resolution"
                            data-order="<?= (($filtres['tri_col'] ?? '') === 'date_resolution') ? $filtres['tri_ordre'] ?? '' : 0 ?>">
                            Résolu le <span class="sort-icon"><?= (($filtres['tri_col'] ?? '') === 'date_resolution') ? ($filtres['tri_ordre'] ?? '' == 2 ? '▼' : '▲') : '▲' ?></span>
                        </th>
                        <th class="sortable" data-col="id_statut"
                            data-order="<?= (($filtres['tri_col'] ?? '') === 'id_statut') ? $filtres['tri_ordre'] ?? '' : 0 ?>">
                            Statut <span class="sort-icon"><?= (($filtres['tri_col'] ?? '') === 'id_statut') ? ($filtres['tri_ordre'] ?? '' == 2 ? '▼' : '▲') : '▲' ?></span>
                        </th>
                        <th>Accès aux détails</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (($nb_ticket ?? 0) === 0) : ?>
                        <td colspan="10" class="no-tickets">Aucun ticket trouvé avec les critères sélectionnés.</td>
                    <?php endif; ?>
                    <?php foreach ($liste_tickets ?? [] as $ticket) : ?>
                        <?php
                        // Gestion de la couleur du texte de l'urgence
                        $classe_urgence = 'text-non-urgent';
                        if ($ticket['id_urgence'] == 1) $classe_urgence = 'text-bloquant';
                        if ($ticket['id_urgence'] == 2) $classe_urgence = 'text-urgent';
                        if ($ticket['id_urgence'] == 3) $classe_urgence = 'text-normal';
                        if ($ticket['type'] == 1) $classe_urgence = 'suivi';

                        // Formatage des dates
                        $date_creation = (new DateTime($ticket['date_creation']))->format('d/m/y à H:i');
                        $date_resolution = !empty($ticket['date_resolution']) ? (new DateTime($ticket['date_resolution']))->format('d/m/y à H:i') : '---';
                        $date_maj = !empty($ticket['date_maj']) ? (new DateTime($ticket['date_maj']))->format('d/m/y à H:i') : '---';

                        ?>
                        <tr>
                            <td class="<?= $classe_urgence ?> font-bold"><?= htmlspecialchars($ticket['numero_ticket']) ?></td>
                            <td><?= htmlspecialchars($ticket['titre']) ?></td>
                            <td><?= htmlspecialchars($ticket['nom_entreprise'] ?? '') ?></td>
                            <td><?= htmlspecialchars($ticket['logiciel'] ?? '') ?></td>
                            <td><?= htmlspecialchars($ticket['declarant_prenom'] . ' ' . $ticket['declarant_nom']) ?></td>
                            <td><?= $date_creation ?></td>
                            <td><?= $date_maj ?></td>
                            <td><?= $date_resolution ?></td>

                            <td class="font-bold"><?= htmlspecialchars($ticket['libelle_statut']) ?></td>
                            <td>
                                <div class="actions-cell">
                                    <a href="index.php?page=detail_ticket&ticket=<?= urlencode($ticket['numero_ticket']) ?>" class="btn-voir-plus">
                                        Voir plus
                                    </a>
                                    <a href="#" class="btn-download" title="Télécharger">
                                        <i class="icon-download">📥</i> </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
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