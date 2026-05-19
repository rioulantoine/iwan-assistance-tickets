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
                    <div class="ajouter-fichier">
                        <label for="fichier">Ajouter un fichier (optionnel)</label>
                        <input type="file" id="fichier" name="fichier[]" multiple />
                        <div id="liste-fichiers" class="file-list"></div>
                    </div>
                    <button type="submit" class="btn-submit">Créer le ticket</button>
                </form>
            </div>
        </div>
    </main>
    <!-- Permet d'avoir plusieurs fichiers joints -->
    <script src="public/scripts/upload_fichiers.js"></script>
</body>

</html>
<?php require_once __DIR__ . '/Templates/Footer.php'; ?>