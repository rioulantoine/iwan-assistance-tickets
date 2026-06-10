<?php require_once __DIR__ . '/../Controller/ControllerHeader.php'; ?>

<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Tableau de bord</title>
    <link rel="icon" type="image/png" href="img/Logo_Iwan.png" />
    <link rel="stylesheet" href="public/styles/Nouveau_client.css" />
    <link rel="stylesheet" href="public/styles/Global.css" />
</head>

<body>
    <main>
        <div class="container-nouveau-client">
            <div class="titre-container">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="34" height="34">
                    <rect width="32" height="32" rx="8" fill="#F0F4FF" />

                    <g transform="translate(4, 4)" fill="none" stroke="#5f6265" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">

                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />

                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />

                    </g>
                </svg>

                <h1>Informations nouveau client</h1>
            </div>
            <div class="separation"></div>

            <!-- Message de session si client bien créé ou erreur -->
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
            <!-- Formulaire de création de client -->
            <div class="formulaire-nouveau-client">
                <form action="" method="POST" class="" auth-form>
                    <div class="ligne-double">
                        <div class="groupe-input">
                            <label for="non_entreprise">Nom entreprise</label>
                            <input
                                type="text"
                                id="nom_entreprise"
                                name="nom_entreprise"
                                list="entreprises_suggestion"
                                placeholder="Entrez le nom de l'entreprise"
                                autocomplete="off"
                                required
                                value="<?= htmlspecialchars($_POST['nom_entreprise'] ?? '') ?>">
                        </div>
                        <div class="groupe-input">
                            <label for="id_client">ID Client</label>
                            <input
                                type="text"
                                id="id_client"
                                name="id_client"
                                list="entreprises_suggestion"
                                placeholder="Entrez l'identifiant du client"
                                autocomplete="off"
                                required
                                value="<?= htmlspecialchars($_POST['id_client'] ?? '') ?>">
                        </div>

                    </div>
                    <div class="ligne-double">
                        <div class="groupe-input">
                            <label for="cp">Code postal</label>
                            <input
                                type="text"
                                id="cp"
                                name="cp"
                                placeholder="Ex : 44110"
                                required
                                value="<?= htmlspecialchars($_POST['cp'] ?? '') ?>" />
                        </div>
                        <div class="groupe-input">
                            <label for="ville">Ville</label>
                            <input
                                type="text"
                                id="ville"
                                name="ville"
                                placeholder="Ex: Paris"
                                required
                                value="<?= htmlspecialchars($_POST['ville'] ?? '') ?>" />
                        </div>
                    </div>
                    <div class="ligne-double">
                        <div class="groupe-input">
                            <label for="nom">Nom</label>
                            <input
                                type="text"
                                id="nom"
                                name="nom"
                                placeholder="Entrez votre nom"
                                required
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
                    <div class="ligne-double">
                        <div class="groupe-input">
                            <label for="email">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="Ex : jean.dupont@exemple.com"
                                required
                                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
                        </div>
                        <div class="groupe-input">
                            <label for="tel">Téléphone</label>
                            <input
                                type="tel"
                                id="telephone"
                                name="telephone"
                                placeholder="Ex: 06 01 01 01 01"
                                required
                                value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>" />
                        </div>
                    </div>
                    <div class="groupe-input">
                        <label for="logiciel">Logiciel concerné</label>
                        <select id="logiciel" name="id_logiciel" required>
                            <option value="" disabled <?= !isset($_POST['id_logiciel']) ? 'selected' : '' ?>>Choisissez un logiciel</option>

                            <?php foreach (($liste_logiciels ?? []) as $log) : ?>
                                <option value="<?= $log['id_logiciel'] ?>" <?= ((int)($_POST['id_logiciel'] ?? 0) === (int)$log['id_logiciel']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($log['logiciel']) ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                    <div class="observation">
                        <label for="observation">Observations</label>
                        <textarea
                            id="observation"
                            name="observation"
                            placeholder="Ajoutez toutes informations complémentaires"><?= htmlspecialchars(trim($_POST['observation'] ?? '')) ?></textarea>
                    </div>
                    <button type="submit" class="btn-submit">Enregistrer le client</button>
            </div>
        </div>
    </main>
    <script src="public/scripts/Nouveau_client.js"></script>
</body>

<?php require_once __DIR__ . '/Templates/Footer.php'; ?>