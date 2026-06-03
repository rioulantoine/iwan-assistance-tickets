<?php require_once __DIR__ . '/../Controller/ControllerHeader.php'; ?>


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
            <h1>Nouveau ticket</h1>
            <p>Aidez-nous à vous aider : détaillez votre demande pour une prise en charge prioritaire.</p>
        </div>
        <div class="container-nouveau-ticket">
            <h1>Créez votre ticket rapidement !</h1>
            <p>Rédiger et traiter les nouvelles demandes et les nouveaux problèmes.</p>
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
            <div class="formulaire-nouveau-ticket">
                <form action="" method="POST" enctype="multipart/form-data" class="" auth-form>
                    <?php if ($_SESSION['is_admin'] ?? false): ?>
                        <label for="nom_entreprise">Nom entreprise</label>
                        <input
                            type="text"
                            id="nom_entreprise"
                            name="nom_entreprise"
                            list="entreprises_suggestion"
                            placeholder="Entrez le nom de l'entreprise"
                            autocomplete="off"
                            required
                            value="<?= htmlspecialchars($_POST['nom_entreprise'] ?? '') ?>">
                        <datalist id="entreprises_suggestion">
                            <?php foreach ($liste_nom_entreprise ?? [] as $entreprise): ?>
                                <option value="<?= htmlspecialchars($entreprise['nom_entreprise']) ?>">
                                <?php endforeach; ?>
                        </datalist>
                    <?php endif; ?>
                    <div class="ligne-double">
                        <div class="groupe-input">

                            <label for="nom">Nom</label>
                            <input
                                type="text"
                                id="nom"
                                name="nom"
                                placeholder="Entrez votre nom"
                                <?= !($_SESSION['is_admin'] ?? false) ? 'required' : '' ?>
                                value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" />
                        </div>
                        <div class="groupe-input">
                            <label for="prenom">Prénom</label>
                            <input
                                type="text"
                                id="prenom"
                                name="prenom"
                                placeholder="Entrez votre prénom"
                                <?= !($_SESSION['is_admin'] ?? false) ? 'required' : '' ?>
                                value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>" />
                        </div>

                    </div>
                    <div class="ligne-triple">
                        <div class="groupe-input">
                            <label for="email">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="Entrez votre adresse e-mail"
                                <?= !($_SESSION['is_admin'] ?? false) ? 'required' : '' ?>
                                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />

                        </div>
                        <div class="groupe-input">
                            <label for="telephone">Numéro de téléphone</label>
                            <input
                                type="tel"
                                id="telephone"
                                name="telephone"
                                placeholder="Entrez votre numéro de téléphone"
                                <?= !($_SESSION['is_admin'] ?? false) ? 'required' : '' ?>
                                value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>" />
                        </div>
                        <div class="groupe-input">
                            <label for="niveau_urgence">Niveau d'urgence
                                <button type="button" class="btn-help-modal" onclick="ouvrirModalUrgence()">?</button>
                            </label>
                            <select id="niveau_urgence" name="niveau_urgence" required>
                                <option value="" disabled selected>
                                    Choisissez un niveau d'urgence
                                </option>
                                <option value="1" <?= ($_POST['niveau_urgence'] ?? '') === '1' ? 'selected' : '' ?>>
                                    Bloquant / Très urgent
                                </option>
                                <option value="2" <?= ($_POST['niveau_urgence'] ?? '') === '2' ? 'selected' : '' ?>>
                                    Urgent
                                </option>
                                <option value="3" <?= ($_POST['niveau_urgence'] ?? '') === '3' ? 'selected' : '' ?>>
                                    Normal
                                </option>
                                <option value="4" <?= ($_POST['niveau_urgence'] ?? '') === '4' ? 'selected' : '' ?>>
                                    Non urgent / Demande d'évolution
                                </option>

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
                                        <li><strong>Bloquant / Très urgent :</strong> Je ne peux plus travailler : logiciel inaccessible, caisse inutilisable, facturation impossible, plusieurs utilisateurs bloqués.</li>
                                        <li><strong>Urgent :</strong> Je peux encore travailler, mais un point important me bloque fortement : erreur sur un dossier, impression impossible, envoi de mails bloqué, problème avec une échéance proche.</li>
                                        <li><strong>Normal :</strong> Problème gênant mais contournable : anomalie sur un écran, question de fonctionnement, petit bug sans blocage immédiat.</li>
                                        <li><strong>Non urgent / Demande d'évolution :</strong> Idée d’amélioration, modification souhaitée, demande de paramétrage, confort d’utilisation.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="groupe-input">
                        <label for="titre">Titre</label>
                        <input
                            type="text"
                            id="titre"
                            name="titre"
                            placeholder="Entrez le titre du ticket"
                            required
                            value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>" />

                    </div>
                    <div class="detail-ticket">
                        <label for="description">Description</label>
                        <textarea
                            id="description"
                            name="description"
                            placeholder="Décrivez votre problème en détail"><?= htmlspecialchars(trim($_POST['description'] ?? '')) ?></textarea>
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

                    <button type="submit" class="btn-submit">Envoyer ma demande</button>
                </form>
            </div>
        </div>
    </main>
    <!-- Permet d'avoir plusieurs fichiers joints -->
    <script src="public/scripts/Nouveau_ticket.js"></script>
</body>

</html>
<?php require_once __DIR__ . '/Templates/Footer.php'; ?>