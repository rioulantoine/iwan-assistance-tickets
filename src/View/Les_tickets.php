<?php require_once __DIR__ . '/Templates/Header.php'; ?>
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
            <p>
                Un total de <span class="ticket-count"><?php echo $nb_ticket ?? 0 ?></span> tickets ont été trouvés.
            </p>
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
                        <option value="" disabled selected>
                            Choisissez un niveau d'urgence
                        </option>
                        <option value="1">Bloquant/ Très urgent</option>
                        <option value="2">Urgent</option>
                        <option value="3">Normal</option>
                        <option value="4">Non urgent / Demande d'évolution</option>
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
            <!-- Liste des tickets -->
            <table class="table-tickets">
                <thead>
                    <tr>
                        <th>Urgence <span>▲</span></th>
                        <th>Titre <span>▲</span></th>
                        <th>Établissement</th>
                        <th>Auteur</th>
                        <th>Fait le <span>▲</span></th>
                        <th>Demandé le <span>▲</span></th>
                        <th>Statut <span>▲</span></th>
                        <th>Accès aux détails</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($liste_tickets ?? [] as $ticket) : ?>
                        <?php
                        // Gestion de la couleur du texte de l'urgence
                        $classe_urgence = 'text-standard';
                        if ($ticket['id_urgence'] == 1) $classe_urgence = 'text-critique';
                        if ($ticket['id_urgence'] == 2) $classe_urgence = 'text-majeur';

                        // Formatage des dates
                        $date_creation = (new DateTime($ticket['date_creation']))->format('d/m à H:i');

                        $date_fait = !empty($ticket['date_resolution']) ? (new DateTime($ticket['date_resolution']))->format('d/m à H:i') : '---';
                        ?>
                        <tr>
                            <td class="<?= $classe_urgence ?> font-bold"><?= htmlspecialchars($ticket['libelle_urgence']) ?></td>
                            <td><?= htmlspecialchars($ticket['titre']) ?></td>
                            <td><?= htmlspecialchars($ticket['nom_entreprise'] ?? 'L&M Evasion') ?></td>
                            <td><?= htmlspecialchars($ticket['declarant_prenom'] . ' ' . $ticket['declarant_nom']) ?></td>
                            <td><?= $date_fait ?></td>
                            <td><?= $date_creation ?></td>
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

</main>
<?php require_once __DIR__ . '/Templates/Footer.php'; ?>