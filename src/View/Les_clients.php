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
                                            data-email="<?= htmlspecialchars($entreprise['email'] ?? '') ?>"
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

        <div id="modalEditionEntreprise" class="modal-edition" onclick="fermerModalEdition(event)">
            <div class="modal-edition-content">

                <div class="modal-edition-top-bar">
                    <div class="client-badge-groupe">
                        <div class="client-icon-wrapper">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0f2e48" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 21h8V5a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v16Z" />
                                <path d="M11 21h10v-9a1 1 0 0 0-1-1h-8v10Z" />
                            </svg>
                        </div>
                        <div class="client-badge-textes">
                            <h2 id="badge_nom_entreprise">Nom de l'entreprise</h2>
                            <p class="sub-date">Fiche client enregistrée</p>
                        </div>
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
                            <label for="edit_nom">Nom <span class="required">*</span></label>
                            <input type="text" id="edit_nom" name="nom" required>
                        </div>
                        <div class="groupe-input">
                            <label for="edit_prenom">Prénom <span class="required">*</span></label>
                            <input type="text" id="edit_prenom" name="prenom" required>
                        </div>
                        <div class="groupe-input">
                            <label for="edit_cp">Code postal <span class="required">*</span></label>
                            <input type="text" id="edit_cp" name="cp" required>
                        </div>
                        <div class="groupe-input">
                            <label for="edit_ville">Ville <span class="required">*</span></label>
                            <input type="text" id="edit_ville" name="ville" required>
                        </div>
                        <div class="groupe-input">
                            <label for="edit_email">Email <span class="required">*</span></label>
                            <input type="email" id="edit_email" name="email" required>
                        </div>
                        <div class="groupe-input">
                            <label for="edit_telephone">Téléphone <span class="required">*</span></label>
                            <input type="tel" id="edit_telephone" name="telephone" required>
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

    <script>
        function ouvrirModalEdition(bouton) {
            const modal = document.getElementById('modalEditionEntreprise');
            const nomEntreprise = bouton.getAttribute('data-entreprise');

            document.getElementById('badge_nom_entreprise').innerText = nomEntreprise;

            // C'est cette ligne qui donne la valeur au formulaire !
            document.getElementById('edit_id_client').value = bouton.getAttribute('data-id');

            document.getElementById('edit_nom_entreprise').value = nomEntreprise;
            document.getElementById('edit_nom').value = bouton.getAttribute('data-nom');
            document.getElementById('edit_prenom').value = bouton.getAttribute('data-prenom');
            document.getElementById('edit_cp').value = bouton.getAttribute('data-cp');
            document.getElementById('edit_ville').value = bouton.getAttribute('data-ville');
            document.getElementById('edit_email').value = bouton.getAttribute('data-email');
            document.getElementById('edit_telephone').value = bouton.getAttribute('data-telephone');
            document.getElementById('edit_observation').value = bouton.getAttribute('data-observation');

            modal.style.display = 'flex';
        }

        function fermerModalEditionForce() {
            document.getElementById('modalEditionEntreprise').style.display = 'none';
        }

        function fermerModalEdition(event) {
            const modal = document.getElementById('modalEditionEntreprise');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>

</html>
<?php require_once __DIR__ . '/Templates/Footer.php'; ?>