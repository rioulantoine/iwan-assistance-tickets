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

                    <form method="GET" action="index.php" id="formFiltreEntreprises" class="modal-liste-entreprises-filtre" style="display: flex; gap: 10px; align-items: center;">
                        <input type="hidden" name="page" value="nouveau_ticket">
                        <input type="hidden" name="ouvrir_modal" value="1">
                        <input type="hidden" name="tab" value="<?= htmlspecialchars($tab_actif ?? '') ?>">

                        <div class="search-wrapper" style="flex: 1;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" name="recherche" placeholder="Rechercher une entreprise..." value="<?= htmlspecialchars($_GET['recherche'] ?? '') ?>" />
                        </div>

                        <button type="submit" class="btn-filtre">Appliquer le filtre</button>

                        <button type="button" onclick="ouvrirModalCreation()" style="height: 42px; padding: 0 15px; background-color: #0f2e48; color: white; border: none; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px; flex-shrink: 0;" title="Créer un nouveau client">
                            +
                        </button>
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
                                            <button type="button"
                                                class="btn-selectionner-entreprise"
                                                onclick="attribuerEntrepriseAuTicket({
                                                        id_client: '<?= htmlspecialchars($entreprise['id_client'] ?? '') ?>',
                                                        nom_entreprise: '<?= htmlspecialchars(addslashes($entreprise['nom_entreprise'] ?? '')) ?>',
                                                        nom: '<?= htmlspecialchars(addslashes($entreprise['nom'] ?? '')) ?>',
                                                        prenom: '<?= htmlspecialchars(addslashes($entreprise['prenom'] ?? '')) ?>',                                        
                                                        email: '<?= htmlspecialchars($entreprise['email'] ?? '') ?>',
                                                        telephone: '<?= htmlspecialchars($entreprise['telephone'] ?? '') ?>',
                                                        ville: '<?= htmlspecialchars(addslashes($entreprise['ville'] ?? '')) ?>',
                                                        code_postal: '<?= htmlspecialchars($entreprise['cp'] ?? '') ?>',
                                                        id_logiciel: '<?= htmlspecialchars($entreprise['id_logiciel'] ?? '') ?>',
                                                        logiciel: '<?= htmlspecialchars(addslashes($entreprise['logiciel'] ?? '')) ?>'
                                                    })">
                                                Sélectionner
                                            </button>
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
            <div id="modalNouveauClient" class="modal-edition" onclick="fermerModalCreation(event)" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 46, 72, 0.5); z-index: 9999; justify-content: center; align-items: center;">
                <div class="modal-edition-content" style="max-width: 700px; background: white; padding: 30px; border-radius: 8px; width: 90%; box-shadow: 0 4px 24px rgba(0,0,0,0.15);">

                    <div class="modal-edition-top-bar" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e2e8f0; padding-bottom: 15px; margin-bottom: 20px;">
                        <div class="client-badge-groupe" style="display: flex; align-items: center; gap: 16px;">
                            <div style="background-color: #F0F4FF; padding: 6px; border-radius: 8px; display: flex;">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="28" height="28">
                                    <g fill="none" stroke="#0f2e48" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    </g>
                                </svg>
                            </div>
                            <div>
                                <h2 style="margin: 0; font-size: 18px; color: #0f2e48;">Créer un nouveau client rapide</h2>
                                <p style="margin: 0; font-size: 13px; color: #64748b;">Ajouter l'entreprise avant de générer le ticket</p>
                            </div>
                        </div>
                        <button type="button" onclick="fermerModalCreationForce()" style="background: none; border: none; font-size: 24px; color: #64748b; cursor: pointer;">&times;</button>
                    </div>

                    <form id="formNouveauClientRapide" onsubmit="soumettreCreationClient(event)">
                        <input type="hidden" name="action_creation_rapide" value="creer_entreprise_depuis_ticket">

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div class="groupe-input">
                                <label>Nom entreprise <span style="color: #EF1A1A;">*</span></label>
                                <input type="text" name="nom_entreprise" placeholder="Ex : Les Établissements Briandis" required>
                            </div>
                            <div class="groupe-input">
                                <label>ID Client <span style="color: #EF1A1A;">*</span></label>
                                <input type="text" name="id_client" placeholder="Ex : 44110" required>
                            </div>
                            <div class="groupe-input">
                                <label>Code postal</label>
                                <input type="text" name="cp" placeholder="Ex : 44110">
                            </div>
                            <div class="groupe-input">
                                <label>Ville</label>
                                <input type="text" name="ville" placeholder="Ex : Châteaubriant">
                            </div>
                            <div class="groupe-input">
                                <label>Nom du contact</label>
                                <input type="text" name="nom" placeholder="Ex : Dupont">
                            </div>
                            <div class="groupe-input">
                                <label>Prénom du contact</label>
                                <input type="text" name="prenom" placeholder="Ex : Jean">
                            </div>
                            <div class="groupe-input">
                                <label>Email</label>
                                <input type="email" name="email" placeholder="Ex : contact@entreprise.com">
                            </div>
                            <div class="groupe-input">
                                <label>Téléphone</label>
                                <input type="tel" name="telephone" placeholder="Ex : 02 40 00 00 00">
                            </div>
                            <div class="groupe-input" style="grid-column: span 2;">
                                <label>Logiciel concerné</label>
                                <select name="id_logiciel">
                                    <option value="" disabled selected>Choisissez un logiciel</option>
                                    <?php foreach (($liste_logiciels ?? []) as $log) : ?>
                                        <option value="<?= $log['id_logiciel'] ?>"><?= htmlspecialchars($log['logiciel']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div style="margin-top: 24px; display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #e2e8f0; padding-top: 15px;">
                            <button type="button" class="btn-annuler" onclick="fermerModalCreationForce()" style="padding: 10px 20px; background: #e2e8f0; border: none; border-radius: 6px; cursor: pointer; color: #475569; font-weight: 600;">Annuler</button>
                            <button type="submit" style="padding: 10px 20px; background: #0f2e48; border: none; border-radius: 6px; cursor: pointer; color: white; font-weight: 600;">Enregistrer</button>
                        </div>
                    </form>
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
                    <div class="actions-header">
                        <!-- Dropdown urgence custom -->
                        <div class="urgence-dropdown" id="urgenceDropdown">
                            <button type="button" class="urgence-dropdown-btn" onclick="toggleUrgenceDropdown()" style="background:#3b82f6;">
                                <span id="urgenceLabel"><?= htmlspecialchars($_POST['niveau_urgence_label'] ?? 'Normal') ?></span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </button>

                            <div class="urgence-dropdown-menu" id="urgenceMenu">
                                <p class="urgence-dropdown-titre">CHANGER LE NIVEAU D'URGENCE :</p>
                                <ul>
                                    <li onclick="selectUrgence('1', 'Bloquant / Très urgent', '#ef4444', 'Bloquant / Très urgent')">
                                        <span class="urgence-dot" style="background:#ef4444;"></span>
                                        <span>Bloquant / Très urgent</span>
                                    </li>
                                    <li onclick="selectUrgence('2', 'Urgent', '#f97316', 'Urgent')">
                                        <span class="urgence-dot" style="background:#f97316;"></span>
                                        <span>Urgent</span>
                                    </li>
                                    <li onclick="selectUrgence('3', 'Normal', '#3b82f6', 'Normal')">
                                        <span class="urgence-dot" style="background:#3b82f6;"></span>
                                        <span>Normal</span>
                                    </li>
                                    <li onclick="selectUrgence('4', 'Non urgent / Demande d\'évolution', '#22c55e', 'Non urgent / Demande d\'évolution')">
                                        <span class="urgence-dot" style="background:#22c55e;"></span>
                                        <span>Non urgent / Demande d'évolution</span>
                                    </li>
                                </ul>

                            </div>
                            <button type="button" class="btn-help-modal" onclick="ouvrirModalUrgence()">?</button>

                        </div>
                        <?php
                        $id_logiciel_preselectionne = (int)($_POST['id_logiciel'] ?? $_SESSION['entreprise_selectionnee']['id_logiciel'] ?? 0);
                        $logiciel_label = 'Choisissez un logiciel';
                        $logiciel_couleur = '#64748b';

                        foreach (($liste_logiciels ?? []) as $log) {
                            if ((int)$log['id_logiciel'] === $id_logiciel_preselectionne) {
                                $logiciel_label = htmlspecialchars($log['logiciel']);
                                break;
                            }
                        }
                        ?>

                        <div class="urgence-dropdown" id="logicielDropdown">
                            <button type="button"
                                class="urgence-dropdown-btn logiciel-btn"
                                <?= !($_SESSION['is_admin'] ?? false) ? 'disabled' : 'onclick="toggleLogicielDropdown()"' ?>
                                style="background-color: #1a365d; <?= !($_SESSION['is_admin'] ?? false) ? 'opacity:0.75; cursor:not-allowed;' : '' ?>">
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="2" y="3" width="20" height="14" rx="2" />
                                        <path d="M8 21h8M12 17v4" />
                                    </svg>
                                    <?php if (isset($_POST['logiciel']) && $_POST['logiciel'] !== ''): ?>
                                        <span id="logicielLabel"><?= htmlspecialchars($_POST['logiciel']) ?></span>
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                            <polyline points="6 9 12 15 18 9" />
                                        </svg>
                                    <?php elseif ($_SESSION['is_admin'] ?? false): ?>
                                        <span id="logicielLabel"><?= htmlspecialchars($_SESSION['entreprise_selectionnee']['logiciel'] ?? 'logiciel non renseigné') ?></span>
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                            <polyline points="6 9 12 15 18 9" />
                                        </svg>
                                    <?php else: ?>
                                        <span id="logicielLabel"><?= htmlspecialchars($infos_client['logiciel'] ?? 'logiciel non renseigné') ?></span>

                                    <?php endif; ?>

                            </button>

                            <input type="hidden" name="id_logiciel" id="id_logiciel"
                                value="<?= $id_logiciel_preselectionne ?>"
                                <?= !($_SESSION['is_admin'] ?? false) ? '' : 'required' ?>>

                            <?php if ($_SESSION['is_admin'] ?? false) : ?>
                                <div class="urgence-dropdown-menu" id="logicielMenu">
                                    <p class="urgence-dropdown-titre">CHOISIR LE LOGICIEL :</p>
                                    <ul>
                                        <?php foreach (($liste_logiciels ?? []) as $log) : ?>
                                            <li onclick="selectLogiciel(<?= $log['id_logiciel'] ?>, '<?= addslashes(htmlspecialchars($log['logiciel'])) ?>')">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2">
                                                    <rect x="2" y="3" width="20" height="14" rx="2" />
                                                    <path d="M8 21h8M12 17v4" />
                                                </svg>
                                                <span><?= htmlspecialchars($log['logiciel']) ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Modal urgence -->
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
                                        <li><strong>Non urgent :</strong> Idée d'amélioration, modification souhaitée...</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <?php if ($_SESSION['is_admin'] ?? false) : ?>
                            <button type="button" class="btn-modal-liste-entreprises" onclick="ouvrirModalListeEntreprises()">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 21h8V5a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v16Z" />
                                    <path d="M11 21h10v-9a1 1 0 0 0-1-1h-8v10Z" />
                                    <path d="M6 7h2M6 11h2M6 15h2" />
                                    <path d="M15 14h2M15 18h2" />
                                </svg>Liste des clients
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="formulaire-nouveau-ticket">
                    <form action="" method="POST" enctype="multipart/form-data" auth-form>
                        <input type="hidden" name="niveau_urgence" id="niveau_urgence"
                            value="<?= htmlspecialchars($_POST['niveau_urgence'] ?? '3') ?>">
                        <input type="hidden" name="id_logiciel" id="id_logiciel_form"
                            value="<?= htmlspecialchars(
                                        $_POST['id_logiciel']
                                            ?? $_SESSION['entreprise_selectionnee']['id_logiciel']
                                            ?? $infos_client['id_logiciel']
                                            ?? ''
                                    ) ?>">
                        <input type="hidden" name="logiciel" id="logiciel_form"
                            value="<?= htmlspecialchars($_POST['logiciel'] ?? $_SESSION['entreprise_selectionnee']['logiciel'] ?? '') ?>">
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



                        <div class="groupe-input">
                            <label for="titre">Titre</label>
                            <input type="text" id="titre" name="titre" placeholder="Entrez le titre du ticket" maxlength="50" required value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>" />
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
                            <?php
                            // On détermine le logiciel à sélectionner (soit le POST si formulaire soumis avec erreur, soit la session de l'entreprise)
                            ?>
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
                                <label for="logiciel">Logiciel concerné</label>
                                <select id="logiciel" name="id_logiciel">
                                    <?php
                                    $id_logiciel_preselectionne = (int)($_POST['id_logiciel'] ?? $_SESSION['entreprise_selectionnee']['id_logiciel'] ?? 0);
                                    ?>
                                    <option value="" disabled <?= $id_logiciel_preselectionne === 0 ? 'selected' : '' ?>>Choisissez un logiciel</option>

                                    <?php foreach (($liste_logiciels ?? []) as $log) : ?>
                                        <option value="<?= $log['id_logiciel'] ?>" <?= $id_logiciel_preselectionne === (int)$log['id_logiciel'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($log['logiciel']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                        <div class="ligne-double">
                            <div class="groupe-input">
                                <label for="suivi_nom">Nom de l'interlocuteur</label>
                                <input type="text" id="suivi_nom" name="nom_contact" placeholder="Nom de la personne au téléphone" value="<?= htmlspecialchars($_SESSION['entreprise_selectionnee']['nom'] ?? '') ?>" />
                            </div>
                            <div class="groupe-input">
                                <label for="suivi_prenom">Prénom de l'interlocuteur</label>
                                <input type="text" id="suivi_prenom" name="prenom_contact" placeholder="Prénom de la personne au téléphone" value="<?= htmlspecialchars($_SESSION['entreprise_selectionnee']['prenom'] ?? '') ?>" />
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
                                <input type="tel" maxlength="40" id="telephone" name="telephone" placeholder="Entrez votre numéro de téléphone" <?= !($_SESSION['is_admin'] ?? false) ? 'required' : '' ?>
                                    value="<?= htmlspecialchars($_POST['telephone'] ?? $_SESSION['entreprise_selectionnee']['telephone'] ?? $infos_client['telephone'] ?? '') ?>" />
                            </div>
                        </div>
                        <div class="ligne-double">
                            <div class="groupe-input">
                                <label for="date_creation">Date de création</label>
                                <input type="datetime-local"
                                    name="date_suivi"
                                    value="<?= date('Y-m-d\TH:i') ?>"
                                    required>
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
                            <textarea id="suivi_description" name="description" placeholder="Saisissez ici le résumé complet de la conversation, les consignes laissées ou les actions à mener..."></textarea>
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