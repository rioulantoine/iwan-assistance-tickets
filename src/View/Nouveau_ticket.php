<?php require_once __DIR__ . '/Templates/Header.php'; ?>

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
            <p>
                Aidez-nous à vous aider: détaillez votre demande pour une prise en
                charge prioritaire.
            </p>
        </div>
        <div class="container-nouveau-ticket">
            <h1>Créez votre ticket rapidement !</h1>
            <p>
                Rédiger et traiter les nouvelles demandes et les nouveaux problèmes
            </p>
            <div class="formulaire-nouveau-ticket">
                <form action="" method="POST" class="" auth-form>
                    <div class="ligne-double">
                        <div class="groupe-input">

                            <label for="nom">Nom</label>
                            <input
                                type="text"
                                id="nom"
                                placeholder="Entrez votre nom"
                                required />
                        </div>
                        <div class="groupe-input">
                            <label for="prenom">Prénom</label>
                            <input
                                type="text"
                                id="prenom"
                                placeholder="Entrez votre prénom"
                                required />
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
                                required />
                        </div>
                        <div class="groupe-input">
                            <label for="Titre">Titre</label>
                            <input
                                type="text"
                                id="Titre"
                                name="Titre"
                                placeholder="Entrez le titre du ticket" />
                        </div>
                        <div class="groupe-input">
                            <label for="Niveau-urgence">Niveau d'urgence</label>
                            <select id="Niveau-urgence" name="Niveau-urgence" required>
                                <option value="" disabled selected>
                                    Choisissez un niveau d'urgence
                                </option>
                                <option value="basse">Critique</option>
                                <option value="moyenne">Majeur</option>
                                <option value="haute">Standart</option>
                            </select>
                        </div>
                    </div>
                    <div class="detail-ticket">
                        <label for="description">Description</label>
                        <textarea
                            id="description"
                            name="description"
                            placeholder="Décrivez votre problème en détail"
                            required></textarea>
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
    <script src="public/scripts/upload_fichiers.js"></script>
</body>

</html>
<?php require_once __DIR__ . '/Templates/Footer.php'; ?>