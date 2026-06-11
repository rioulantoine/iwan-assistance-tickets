<?php require_once __DIR__ . '/../Controller/ControllerHeader.php'; ?>

<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Liste des clients</title>
    <link rel="icon" type="image/png" href="../img/Logo_Iwan.png" />
    <link rel="stylesheet" href="public/styles/Les_clients.css" />
    <link rel="stylesheet" href="public/styles/global.css" />
</head>

<body>
    <main>
        <div class="liste-clients-container">
            <div class="liste-clients-textes">
                <h1>Liste des clients</h1>
            </div>
            <a href="index.php?page=nouveau_client" class="btn-creer-client">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Créer un nouveau client
            </a>
        </div>
        <div id="sectionListeEntreprises" class="section-liste-entreprises">

            <div class="section-liste-entreprises-content">
                <div class="section-liste-entreprises-header">
                    <div class="header-titre-groupe">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 21h8V5a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v16Z" />
                            <path d="M11 21h10v-9a1 1 0 0 0-1-1h-8v10Z" />
                            <path d="M6 7h2M6 11h2M6 15h2" />
                            <path d="M15 14h2M15 18h2" />
                        </svg>
                        <div class="header-textes">
                            <h2>Liste des entreprises</h2>
                            <p>Retrouvez ici toutes les entreprises enregistrées.</p>
                        </div>
                    </div>
                </div>
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

                <form method="GET" action="index.php" class="section-liste-entreprises-filtre">
                    <input type="hidden" name="page" value="les_clients">

                    <div class="search-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" name="recherche" placeholder="Rechercher une entreprise..." value="<?= htmlspecialchars($_GET['recherche'] ?? '') ?>" />
                    </div>
                    <button type="submit" class="btn-filtre">Appliquer le filtre</button>
                </form>

                <div class="section-liste-entreprises-body">
                    <table class="table-liste-entreprises">
                        <thead>
                            <tr>
                                <th class="sortable" data-col="nom_entreprise">Nom entreprise</th>
                                <th class="sortable" data-col="nom">Nom</th>
                                <th class="sortable" data-col="prenom">Prénom</th>
                                <th class="sortable" data-col="logiciel">Logiciel</th>
                                <th class="sortable" data-col="email">Email</th>
                                <th class="sortable" data-col="telephone">Téléphone</th>
                                <th class="sortable" data-col="ville">Ville</th>
                                <th class="sortable" data-col="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (($nb_entreprises ?? 0) === 0) : ?>
                                <tr>
                                    <td colspan="7" class="pas-entreprise">Aucune entreprise trouvée.</td>
                                </tr>
                            <?php endif; ?>

                            <?php foreach ($liste_entreprises ?? [] as $entreprise) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($entreprise['nom_entreprise']) ?></td>
                                    <td><?= htmlspecialchars($entreprise['nom']) ?></td>
                                    <td><?= htmlspecialchars($entreprise['prenom']) ?></td>
                                    <td><?= htmlspecialchars($entreprise['logiciel'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($entreprise['email']) ?></td>
                                    <td><?= htmlspecialchars($entreprise['telephone']) ?></td>
                                    <td><?= htmlspecialchars($entreprise['ville']) ?></td>
                                    <td>
                                        <button type="button"
                                            class="btn-editer-entreprise"
                                            data-id="<?= htmlspecialchars($entreprise['id_client'] ?? '') ?>"
                                            data-entreprise="<?= htmlspecialchars($entreprise['nom_entreprise'] ?? '') ?>"
                                            data-nom="<?= htmlspecialchars($entreprise['nom'] ?? '') ?>"
                                            data-prenom="<?= htmlspecialchars($entreprise['prenom'] ?? '') ?>"
                                            data-id-logiciel="<?= htmlspecialchars($entreprise['id_logiciel'] ?? '') ?>" data-email="<?= htmlspecialchars($entreprise['email'] ?? '') ?>"
                                            data-telephone="<?= htmlspecialchars($entreprise['telephone'] ?? '') ?>"
                                            data-cp="<?= htmlspecialchars($entreprise['cp'] ?? '') ?>"
                                            data-ville="<?= htmlspecialchars($entreprise['ville'] ?? '') ?>"
                                            data-observation="<?= htmlspecialchars($entreprise['observation'] ?? '') ?>"
                                            onclick="ouvrirModalEdition(this)">
                                            Modifier
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <?php if (($total_pages ?? 0) > 1) : ?>
                        <div class="pagination-container">

                            <?php if (($page_entreprise ?? 0) > 1) : ?>
                                <a href="index.php?page=les_clients&recherche=<?= urlencode($_GET['recherche'] ?? '') ?>&page_entreprise=<?= ($page_entreprise ?? 0) - 1 ?>#sectionListeEntreprises" class="page-link">&laquo; Précédent</a>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= ($total_pages ?? 0); $i++) : ?>
                                <a href="index.php?page=les_clients&recherche=<?= urlencode($_GET['recherche'] ?? '') ?>&page_entreprise=<?= $i ?>#sectionListeEntreprises"
                                    class="page-link <?= ($i === ($page_entreprise ?? 0)) ? 'active' : '' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>

                            <?php if (($page_entreprise ?? 0) < ($total_pages ?? 0)) : ?>
                                <a href="index.php?page=les_clients&recherche=<?= urlencode($_GET['recherche'] ?? '') ?>&page_entreprise=<?= ($page_entreprise ?? 0) + 1 ?>#sectionListeEntreprises" class="page-link">Suivant &raquo;</a>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- MODAL MODIFICATION DONNÉES CLIENT-->
        <div id="modalEditionEntreprise" class="modal-edition" onclick="fermerModalEdition(event)">
            <div class="modal-edition-content">

                <div class="modal-edition-top-bar">
                    <div class="client-badge-groupe" style="display: flex; align-items: center; gap: 16px; width: 100%;">
                        <div class="client-icon-wrapper">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0f2e48" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 21h8V5a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v16Z" />
                                <path d="M11 21h10v-9a1 1 0 0 0-1-1h-8v10Z" />
                            </svg>
                        </div>

                        <div class="client-badge-textes" style="flex-grow: 1;">
                            <h2 id="badge_nom_entreprise">Nom de l'entreprise</h2>
                            <p class="sub-date">Fiche client enregistrée</p>
                        </div>

                        <a href="#" id="lien_supprimer_client" class="suppression-client" style="display: inline-block; text-decoration: none; border: none; background: none; padding: 0; cursor: pointer; margin-right: 20px;">
                            <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.6253 3.25H11.3753C11.1598 3.25 10.9532 3.3356 10.8008 3.48798C10.6484 3.64035 10.5628 3.84701 10.5628 4.0625V4.875H15.4378V4.0625C15.4378 3.84701 15.3522 3.64035 15.1999 3.48798C15.0475 3.3356 14.8408 3.25 14.6253 3.25ZM17.8753 4.875V4.0625C17.8753 3.20055 17.5329 2.3739 16.9234 1.7644C16.3139 1.15491 15.4873 0.8125 14.6253 0.8125H11.3753C10.5134 0.8125 9.68672 1.15491 9.07723 1.7644C8.46774 2.3739 8.12533 3.20055 8.12533 4.0625V4.875H3.6582C3.33497 4.875 3.02498 5.0034 2.79642 5.23196C2.56786 5.46052 2.43945 5.77052 2.43945 6.09375C2.43945 6.41698 2.56786 6.72698 2.79642 6.95554C3.02498 7.1841 3.33497 7.3125 3.6582 7.3125H4.1652L4.68033 19.7031C4.73274 20.96 5.26896 22.1479 6.17688 23.0186C7.08481 23.8892 8.29415 24.3753 9.55208 24.375H16.4502C17.7079 24.3748 18.9168 23.8886 19.8244 23.018C20.7319 22.1474 21.2679 20.9597 21.3203 19.7031L21.8371 7.3125H22.3441C22.6673 7.3125 22.9773 7.1841 23.2059 6.95554C23.4344 6.72698 23.5628 6.41698 23.5628 6.09375C23.5628 5.77052 23.4344 5.46052 23.2059 5.23196C22.9773 5.0034 22.6673 4.875 22.3441 4.875H17.8753ZM19.3963 7.3125H6.60433L7.1162 19.6007C7.14221 20.2293 7.41023 20.8235 7.86421 21.259C8.31819 21.6945 8.92298 21.9376 9.55208 21.9375H16.4502C17.079 21.9372 17.6834 21.6939 18.137 21.2584C18.5907 20.823 18.8585 20.229 18.8845 19.6007L19.3963 7.3125ZM9.34408 10.5625V18.6875C9.34408 19.0107 9.47248 19.3207 9.70104 19.5493C9.9296 19.7778 10.2396 19.9062 10.5628 19.9062C10.8861 19.9062 11.1961 19.7778 11.4246 19.5493C11.6532 19.3207 11.7816 19.0107 11.7816 18.6875V10.5625C11.7816 10.2393 11.6532 9.92927 11.4246 9.70071C11.1961 9.47215 10.8861 9.34375 10.5628 9.34375C10.2396 9.34375 9.9296 9.47215 9.70104 9.70071C9.47248 9.92927 9.34408 10.2393 9.34408 10.5625ZM15.4378 9.34375C15.7611 9.34375 16.0711 9.47215 16.2996 9.70071C16.5282 9.92927 16.6566 10.2393 16.6566 10.5625V18.6875C16.6566 19.0107 16.5282 19.3207 16.2996 19.5493C16.0711 19.7778 15.7611 19.9062 15.4378 19.9062C15.1146 19.9062 14.8046 19.7778 14.576 19.5493C14.3475 19.3207 14.2191 19.0107 14.2191 18.6875V10.5625C14.2191 10.2393 14.3475 9.92927 14.576 9.70071C14.8046 9.47215 15.1146 9.34375 15.4378 9.34375Z" fill="#FF0000" />
                            </svg>
                        </a>
                    </div>
                    <button type="button" class="btn-retour-liste" onclick="fermerModalEditionForce()">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        Retour à la liste
                    </button>
                </div>

                <form method="POST" action="" class="modal-edition-form">
                    <input type="hidden" name="action" value="modifier_entreprise">
                    <input type="hidden" id="edit_id_client" name="id_client">

                    <div class="section-form-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <h3>Informations du client</h3>
                    </div>

                    <div class="modal-grid">
                        <div class="groupe-input">
                            <label for="edit_nom_entreprise">Nom de l'entreprise <span class="required">*</span></label>
                            <input type="text" id="edit_nom_entreprise" name="nom_entreprise" required>
                        </div>
                        <div class="groupe-input">
                            <label for="edit_nom">Nom <span class="required"></span></label>
                            <input type="text" id="edit_nom" name="nom">
                        </div>
                        <div class="groupe-input">
                            <label for="edit_prenom">Prénom <span class="required"></span></label>
                            <input type="text" id="edit_prenom" name="prenom">
                        </div>
                        <div class="groupe-input">
                            <label for="edit_logiciel">Logiciel <span class="required"></span></label>
                            <select id="edit_logiciel" name="id_logiciel">
                                <option value="" disabled>Choisissez un logiciel</option>

                                <?php foreach (($liste_logiciels ?? []) as $log) : ?>
                                    <option value="<?= $log['id_logiciel'] ?>"
                                        <?= (isset($client_actuel['id_logiciel']) && (int)$client_actuel['id_logiciel'] === (int)$log['id_logiciel']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($log['logiciel']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="groupe-input">
                            <label for="edit_cp">Code postal <span class="required"></span></label>
                            <input type="text" id="edit_cp" name="cp">
                        </div>
                        <div class="groupe-input">
                            <label for="edit_ville">Ville <span class="required"></span></label>
                            <input type="text" id="edit_ville" name="ville">
                        </div>
                        <div class="groupe-input">
                            <label for="edit_email">Email <span class="required"></span></label>
                            <input type="email" id="edit_email" name="email">
                        </div>
                        <div class="groupe-input">
                            <label for="edit_telephone">Téléphone <span class="required"></span></label>
                            <input type="tel" id="edit_telephone" name="telephone">
                        </div>

                        <div class="groupe-input full-width">
                            <label for="edit_observation">Observation</label>
                            <textarea id="edit_observation" name="observation" placeholder="Aucune observation particulière."></textarea>
                        </div>
                    </div>

                    <div class="modal-edition-footer">
                        <button type="button" class="btn-annuler" onclick="fermerModalEditionForce()">Annuler</button>
                        <button type="submit" class="btn-enregistrer">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px; vertical-align: middle;">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                <polyline points="7 3 7 8 15 8"></polyline>
                            </svg>
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>

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
    </main>

    <script src="public/scripts/Les_clients.js"></script>

</body>

</html>
<?php require_once __DIR__ . '/Templates/Footer.php'; ?>