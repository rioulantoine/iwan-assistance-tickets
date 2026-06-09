<?php require_once __DIR__ . '/../Controller/ControllerHeader.php'; ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Nouveau ticket</title>
    <link rel="icon" type="image/png" href="../img/Logo_Iwan.png" />
    <link rel="stylesheet" href="public/styles/Nouveau_ticket.css" />
    <link rel="stylesheet" href="public/styles/global.css" />
</head>

<body>
    <main>
        <div class="nouveau-ticket">
            <div class="nouveau-ticket-textes">
                <?php if (($tab_actif ?? '') === 'ticket') : ?>
                    <h1>Nouveau ticket</h1>
                    <p>Aidez-nous à vous aider : détaillez votre demande pour une prise en charge prioritaire.</p>
                <?php else : ?>
                    <h1>Suivi des appels</h1>
                    <p>Enregistrez les échanges et les actions réalisés dans le cadre du suivi client.</p>
                <?php endif; ?>
            </div>

            <?php if ($_SESSION['is_admin'] ?? false) : ?>
                <div class="switch-container">
                    <a href="index.php?page=nouveau_ticket&tab=ticket"
                        class="switch-btn <?= (($tab_actif ?? '') === 'ticket') ? 'active' : '' ?>">
                        Ticket
                    </a>
                    <a href="index.php?page=nouveau_ticket&tab=suivi"
                        class="switch-btn <?= (($tab_actif ?? '') === 'suivi') ? 'active' : '' ?>">
                        Suivi
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($_SESSION['is_admin'] ?? false) : ?>
            <div id="modalListeEntreprises" class="modal-liste-entreprises"
                style="<?= (isset($_GET['ouvrir_modal']) && $_GET['ouvrir_modal'] == '1') ? 'display: flex;' : '' ?>"
                onclick="fermerModalListeEntreprises(event)">
                <div class="modal-liste-entreprises-content">
                    <div class="modal-liste-entreprises-header">
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
                        <button type="button" class="modal-liste-entreprises-close" onclick="document.getElementById('modalListeEntreprises').style.display='none'">&times;</button>
                    </div>

                    <form method="GET" action="index.php" class="modal-liste-entreprises-filtre">
                        <input type="hidden" name="page" value="nouveau_ticket">
                        <input type="hidden" name="ouvrir_modal" value="1">
                        <input type="hidden" name="tab" value="<?= htmlspecialchars($tab_actif ?? '') ?>">

                        <div class="search-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" name="recherche" placeholder="Rechercher une entreprise..." value="<?= htmlspecialchars($_GET['recherche'] ?? '') ?>" />
                        </div>
                        <button type="submit" class="btn-filtre">Appliquer le filtre</button>
                    </form>

                    <div class="modal-liste-entreprises-body">
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
                                        <td colspan="7" class="pas-entreprise"> Aucune entreprise trouvée. </td>
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
                                            <form method="POST" action="" style="margin: 0;">
                                                <input type="hidden" name="action" value="selectionner_entreprise">
                                                <input type="hidden" name="id_client" value="<?= htmlspecialchars($_POST['id_client'] ?? '') ?>">
                                                <input type="hidden" name="nom_entreprise" value="<?= htmlspecialchars($entreprise['nom_entreprise'] ?? '') ?>">
                                                <input type="hidden" name="nom" value="<?= htmlspecialchars($entreprise['nom'] ?? '') ?>">
                                                <input type="hidden" name="prenom" value="<?= htmlspecialchars($entreprise['prenom'] ?? '') ?>">
                                                <input type="hidden" name="email" value="<?= htmlspecialchars($entreprise['email'] ?? '') ?>">
                                                <input type="hidden" name="telephone" value="<?= htmlspecialchars($entreprise['telephone'] ?? '') ?>">

                                                <input type="hidden" name="logiciel" value="<?= htmlspecialchars($entreprise['logiciel'] ?? '') ?>">

                                                <button type="submit" name="selectionner_entreprise" class="btn-selectionner-entreprise">sélectionner</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <?php if (($total_pages ?? 0) > 1) : ?>
                            <div class="pagination-container">
                                <?php if (($page_entreprise ?? 0) > 1) : ?>
                                    <a href="index.php?page=nouveau_ticket&tab=<?= ($tab_actif ?? '') ?>&ouvrir_modal=1&recherche=<?= urlencode($_GET['recherche'] ?? '') ?>&page_entreprise=<?= ($page_entreprise ?? 0) - 1 ?>" class="page-link">&laquo; Précédent</a>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= ($total_pages ?? 0); $i++) : ?>
                                    <a href="index.php?page=nouveau_ticket&tab=<?= ($tab_actif ?? '') ?>&ouvrir_modal=1&recherche=<?= urlencode($_GET['recherche'] ?? '') ?>&page_entreprise=<?= $i ?>"
                                        class="page-link <?= ($i === ($page_entreprise ?? 0)) ? 'active' : '' ?>">
                                        <?= $i ?>
                                    </a>
                                <?php endfor; ?>

                                <?php if (($page_entreprise ?? 0) < ($total_pages ?? 0)) : ?>
                                    <a href="index.php?page=nouveau_ticket&tab=<?= ($tab_actif ?? '') ?>&ouvrir_modal=1&recherche=<?= urlencode($_GET['recherche'] ?? '') ?>&page_entreprise=<?= ($page_entreprise ?? 0) + 1 ?>" class="page-link">Suivant &raquo;</a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

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


        <?php if (($tab_actif ?? '') === 'ticket') : ?>
            <div class="container-nouveau-ticket">
                <div class="en-tete-container">
                    <div class="en-tete-textes">
                        <h2>Créez votre ticket rapidement !</h2>
                        <p>Rédiger et traiter les nouvelles demandes et les nouveaux problèmes.</p>
                    </div>

                    <?php if ($_SESSION['is_admin'] ?? false) : ?>
                        <button type="button" class="btn-modal-liste-entreprises" onclick="ouvrirModalListeEntreprises()">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 21h8V5a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v16Z" />
                                <path d="M11 21h10v-9a1 1 0 0 0-1-1h-8v10Z" />
                                <path d="M6 7h2M6 11h2M6 15h2" />
                                <path d="M15 14h2M15 18h2" />
                            </svg>Liste des entreprises
                        </button>
                    <?php endif; ?>
                </div>

                <div class="formulaire-nouveau-ticket">
                    <form action="" method="POST" enctype="multipart/form-data" auth-form>
                        <?php if ($_SESSION['is_admin'] ?? false): ?>
                            <label for="nom_entreprise">Nom entreprise</label>
                            <input type="text" id="nom_entreprise" name="nom_entreprise" list="entreprises_suggestion" placeholder="Entrez le nom de l'entreprise" autocomplete="off" required
                                value="<?= htmlspecialchars($_POST['nom_entreprise'] ?? $_SESSION['entreprise_selectionnee']['nom_entreprise'] ?? '') ?>">
                            <datalist id="entreprises_suggestion">
                                <?php foreach ($liste_nom_entreprise ?? [] as $entreprise): ?>
                                    <option value="<?= htmlspecialchars($entreprise['nom_entreprise']) ?>">
                                    <?php endforeach; ?>
                            </datalist>
                        <?php endif; ?>

                        <div class="ligne-double">
                            <div class="groupe-input">
                                <label for="nom">Nom</label>
                                <input type="text" id="nom" name="nom" placeholder="Entrez votre nom" <?= !($_SESSION['is_admin'] ?? false) ? 'required' : '' ?>
                                    value="<?= htmlspecialchars($_POST['nom'] ?? $_SESSION['entreprise_selectionnee']['nom'] ?? $infos_client['nom'] ?? '') ?>" />
                            </div>
                            <div class="groupe-input">
                                <label for="prenom">Prénom</label>
                                <input type="text" id="prenom" name="prenom" placeholder="Entrez votre prénom" <?= !($_SESSION['is_admin'] ?? false) ? 'required' : '' ?>
                                    value="<?= htmlspecialchars($_POST['prenom'] ?? $_SESSION['entreprise_selectionnee']['prenom'] ?? $infos_client['prenom'] ?? '') ?>" />
                            </div>
                        </div>

                        <div class="ligne-triple">
                            <div class="groupe-input">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="Entrez votre adresse e-mail" <?= !($_SESSION['is_admin'] ?? false) ? 'required' : '' ?>
                                    value="<?= htmlspecialchars($_POST['email'] ?? $_SESSION['entreprise_selectionnee']['email'] ?? $infos_client['email'] ?? '') ?>" />
                            </div>
                            <div class="groupe-input">
                                <label for="telephone">Numéro de téléphone</label>
                                <input type="tel" maxlength="50" id="telephone" name="telephone" placeholder="Entrez votre numéro de téléphone" <?= !($_SESSION['is_admin'] ?? false) ? 'required' : '' ?>
                                    value="<?= htmlspecialchars($_POST['telephone'] ?? $_SESSION['entreprise_selectionnee']['telephone'] ?? $infos_client['telephone'] ?? '') ?>" />
                            </div>
                            <div class="groupe-input">
                                <label for="niveau_urgence">Niveau d'urgence
                                    <button type="button" class="btn-help-modal" onclick="ouvrirModalUrgence()">?</button>
                                </label>
                                <select id="niveau_urgence" name="niveau_urgence" required>
                                    <option value="" disabled selected>Choisissez un niveau d'urgence</option>
                                    <option value="1" <?= ($_POST['niveau_urgence'] ?? '') === '1' ? 'selected' : '' ?>>Bloquant / Très urgent</option>
                                    <option value="2" <?= ($_POST['niveau_urgence'] ?? '') === '2' ? 'selected' : '' ?>>Urgent</option>
                                    <option value="3" <?= ($_POST['niveau_urgence'] ?? '') === '3' ? 'selected' : '' ?>>Normal</option>
                                    <option value="4" <?= ($_POST['niveau_urgence'] ?? '') === '4' ? 'selected' : '' ?>>Non urgent / Demande d'évolution</option>
                                </select>
                            </div>
                            <div id="modalUrgence" class="modal-urgence-overlay" onclick="fermerModalUrgence(event)">
                                <div class="modal-urgence-content">
                                    <div class="modal-urgence-header">
                                        <h2>Détails des niveaux d'urgence</h2>
                                        <button type="button" class="modal-urgence-close" onclick="document.getElementById('modalUrgence').style.display='none'">&times;</button>
                                    </div>
                                    <div class="modal-urgence-body">
                                        <ul>
                                            <li><strong>Bloquant / Très urgent :</strong> Je ne peux plus travailler : logiciel inaccessible...</li>
                                            <li><strong>Urgent :</strong> Je peux encore travailler, mais un point important me bloque...</li>
                                            <li><strong>Normal :</strong> Problème gênant mais contournable...</li>
                                            <li><strong>Non urgent :</strong> Idée d’amélioration, modification souhaitée...</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="groupe-input">
                            <label for="titre">Titre</label>
                            <input type="text" id="titre" name="titre" placeholder="Entrez le titre du ticket" required value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>" />
                        </div>

                        <div class="detail-ticket">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" placeholder="Ajoutez toutes informations complémentaires"><?= htmlspecialchars(trim($_POST['description'] ?? '')) ?></textarea>
                        </div>

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

                        <button type="submit" class="btn-submit" name="nouveau-ticket">Envoyer ma demande</button>
                    </form>
                </div>
            </div>

        <?php else : ?>
            <div class="container-nouveau-ticket">
                <div class="en-tete-container">
                    <div class="en-tete-textes">
                        <h2>Suivi client</h2>
                        <p>Enregistrez les détails de votre communication téléphonique.</p>
                    </div>
                    <?php if ($_SESSION['is_admin'] ?? false) : ?>
                        <button type="button" class="btn-modal-liste-entreprises" onclick="ouvrirModalListeEntreprises()">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 21h8V5a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v16Z" />
                                <path d="M11 21h10v-9a1 1 0 0 0-1-1h-8v10Z" />
                                <path d="M6 7h2M6 11h2M6 15h2" />
                                <path d="M15 14h2M15 18h2" />
                            </svg>Liste des entreprises
                        </button>
                    <?php endif; ?>
                </div>

                <div class="formulaire-nouveau-suivi">
                    <form action="index.php?page=nouveau_suivi" method="POST">
                        <input type="hidden" name="action" value="creer_suivi_appel">
                        <div class="ligne-double">
                            <div class="groupe-input">
                                <label for="nom_entreprise_suivi">Nom entreprise</label>
                                <input type="text" id="nom_entreprise_suivi" name="nom_entreprise" list="entreprises_suggestion" placeholder="Entrez le nom de l'entreprise" autocomplete="off" required
                                    value="<?= htmlspecialchars($_POST['nom_entreprise'] ?? $_SESSION['entreprise_selectionnee']['nom_entreprise'] ?? '') ?>">
                                <datalist id="entreprises_suggestion">
                                    <?php foreach ($liste_nom_entreprise ?? [] as $entreprise): ?>
                                        <option value="<?= htmlspecialchars($entreprise['nom_entreprise']) ?>">
                                        <?php endforeach; ?>
                                </datalist>
                            </div>
                            <div class="groupe-input">
                                <label for="date_creation">Date de création</label>
                                <input type="date" id="date_creation" name="date_creation"
                                    value="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="ligne-double">
                            <?php
                            // On détermine le logiciel à sélectionner (soit le POST si formulaire soumis avec erreur, soit la session de l'entreprise)
                            $logiciel_preselectionne = $_POST['logiciel'] ?? $_SESSION['entreprise_selectionnee']['logiciel'] ?? '';
                            ?>

                            <div class="groupe-input">
                                <label for="logiciel">Logiciel concerné</label>
                                <select id="logiciel" name="logiciel" required>
                                    <option value="" disabled <?= empty($logiciel_preselectionne) ? 'selected' : '' ?>>Choisissez un logiciel</option>
                                    <option value="GOA" <?= $logiciel_preselectionne === 'GOA' ? 'selected' : '' ?>>GOA</option>
                                    <option value="IWAN_V3" <?= $logiciel_preselectionne === 'IWAN_V3' ? 'selected' : '' ?>>IWAN V3</option>
                                    <option value="CRM" <?= $logiciel_preselectionne === 'CRM' ? 'selected' : '' ?>>CRM</option>
                                    <option value="RESAVAC" <?= $logiciel_preselectionne === 'RESAVAC' ? 'selected' : '' ?>>RESAVAC</option>
                                    <option value="WINLORE" <?= $logiciel_preselectionne === 'WINLORE' ? 'selected' : '' ?>>WINLORE</option>
                                    <option value="AERORESA" <?= $logiciel_preselectionne === 'AERORESA' ? 'selected' : '' ?>>AERORESA</option>
                                    <option value="PLANNING" <?= $logiciel_preselectionne === 'PLANNING' ? 'selected' : '' ?>>PLANNING</option>
                                    <option value="MATERIEL" <?= $logiciel_preselectionne === 'MATERIEL' ? 'selected' : '' ?>>MATERIEL</option>
                                    <option value="ANAMAG" <?= $logiciel_preselectionne === 'ANAMAG' ? 'selected' : '' ?>>ANAMAG</option>
                                    <option value="IWAN_CAISSE" <?= $logiciel_preselectionne === 'IWAN_CAISSE' ? 'selected' : '' ?>>IWAN CAISSE</option>
                                    <option value="AUTRE" <?= $logiciel_preselectionne === 'AUTRE' ? 'selected' : '' ?>>AUTRE</option>
                                </select>
                            </div>
                            <div class="groupe-input">
                                <label for="type_suivi">Type de suivi</label>
                                <select id="type_suivi" name="type_suivi" required>
                                    <option value="" disabled selected>Choisissez un type de suivi</option>
                                    <option value="DEMANDE_DE_DEV" <?= ($_POST['type_suivi'] ?? '') === 'DEMANDE_DE_DEV' ? 'selected' : '' ?>>DEMANDE DE DEV</option>
                                    <option value="BUG" <?= ($_POST['type_suivi'] ?? '') === 'BUG' ? 'selected' : '' ?>>BUG</option>
                                    <option value="QUESTION_D'UTILISATION" <?= ($_POST['type_suivi'] ?? '') === "QUESTION_D'UTILISATION" ? 'selected' : '' ?>>QUESTION D'UTILISATION</option>
                                    <option value="MAJ" <?= ($_POST['type_suivi'] ?? '') === 'MAJ' ? 'selected' : '' ?>>MAJ</option>
                                    <option value="SUPPORT" <?= ($_POST['type_suivi'] ?? '') === 'SUPPORT' ? 'selected' : '' ?>>SUPPORT</option>
                                    <option value="DEMANDE_DE_DEVIS" <?= ($_POST['type_suivi'] ?? '') === 'DEMANDE_DE_DEVIS' ? 'selected' : '' ?>>DEMANDE DE DEVIS</option>
                                    <option value="QUESTION_ADMINISTRATIVE" <?= ($_POST['type_suivi'] ?? '') === 'QUESTION_ADMINISTRATIVE' ? 'selected' : '' ?>>QUESTION ADMINISTRATIVE</option>
                                    <option value="INSTALL_LOGICIEL" <?= ($_POST['type_suivi'] ?? '') === 'INSTALL_LOGICIEL' ? 'selected' : '' ?>>INSTALL LOGICIEL</option>
                                    <option value="SUPPORT_LOGICIEL" <?= ($_POST['type_suivi'] ?? '') === 'SUPPORT_LOGICIEL' ? 'selected' : '' ?>>SUPPORT_LOGICIEL</option>
                                    <option value="AUTRE" <?= ($_POST['type_suivi'] ?? '') === 'AUTRE' ? 'selected' : '' ?>>AUTRE</option>
                                </select>
                            </div>
                        </div>
                        <div class="ligne-double">
                            <div class="groupe-input">
                                <label for="suivi_nom">Nom de l'interlocuteur</label>
                                <input type="text" id="suivi_nom" name="nom_contact" placeholder="Nom de la personne au téléphone" required value="<?= htmlspecialchars($_SESSION['entreprise_selectionnee']['nom'] ?? '') ?>" />
                            </div>
                            <div class="groupe-input">
                                <label for="suivi_prenom">Prénom de l'interlocuteur</label>
                                <input type="text" id="suivi_prenom" name="prenom_contact" placeholder="Prénom de la personne au téléphone" required value="<?= htmlspecialchars($_SESSION['entreprise_selectionnee']['prenom'] ?? '') ?>" />
                            </div>
                        </div>
                        <div class="ligne-double">
                            <div class="groupe-input">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="Entrez votre adresse e-mail" <?= !($_SESSION['is_admin'] ?? false) ? 'required' : '' ?>
                                    value="<?= htmlspecialchars($_POST['email'] ?? $_SESSION['entreprise_selectionnee']['email'] ?? $infos_client['email'] ?? '') ?>" />
                            </div>
                            <div class="groupe-input">
                                <label for="telephone">Numéro de téléphone</label>
                                <input type="tel" maxlength="50" id="telephone" name="telephone" placeholder="Entrez votre numéro de téléphone" <?= !($_SESSION['is_admin'] ?? false) ? 'required' : '' ?>
                                    value="<?= htmlspecialchars($_POST['telephone'] ?? $_SESSION['entreprise_selectionnee']['telephone'] ?? $infos_client['telephone'] ?? '') ?>" />
                            </div>
                        </div>

                        <div class="ligne-triple">
                            <div class="groupe-input">
                                <label for="suivi_titre">Objet de l'appel</label>
                                <input type="text" id="suivi_titre" name="titre" placeholder="Ex: Demande de tarifs ou Problème réseau" required />
                            </div>

                            <div class="groupe-input">
                                <label for="suivi_statut">Statut du suivi</label>
                                <select id="suivi_statut" name="code_statut" required>
                                    <option value="1" selected>En attente</option>
                                    <option value="2">En cours</option>
                                    <option value="3">Résolu</option>
                                    <option value="4">Archivé</option>
                                </select>
                            </div>
                        </div>

                        <div class="detail-ticket">
                            <label for="suivi_description">Notes</label>
                            <textarea id="suivi_description" name="description" placeholder="Saisissez ici le résumé complet de la conversation, les consignes laissées ou les actions à mener..." required></textarea>
                        </div>

                        <button type="submit" class="btn-submit" name="nouveau-suivi">Enregistrer le suivi d'appel</button>
                    </form>
                </div>
            </div>

        <?php endif; ?>
    </main>
    <script src="public/scripts/Nouveau_ticket.js"></script>
</body>

</html>
<?php require_once __DIR__ . '/Templates/Footer.php'; ?>