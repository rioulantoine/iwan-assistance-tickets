<?php

require_once __DIR__ . '/../Controller/ControllerHeader.php'; ?>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Tableau de bord</title>
    <link rel="icon" type="image/png" href="img/Logo_Iwan.png" />
    <link rel="stylesheet" href="public/styles/Accueil.css" />
    <link rel="stylesheet" href="public/styles/Global.css" />
</head>

<body>
    <main>
        <div class="tableau-de-bord">
            <div class="header-text">
                <h1>Tableau de bord</h1>

                <?php if (isset($_SESSION['id_client'])): ?>
                    <p>
                        <?php if (($nb_tickets_actif ?? 0) > 15): ?>
                            Forte activité ce mois-ci : nos équipes sont mobilisées sur vos dossiers (<strong><?= htmlspecialchars($nb_tickets_actif ?? 0) ?></strong> en cours).
                        <?php elseif (($nb_tickets_actif ?? 0) > 0): ?>
                            Activité modérée : vos dossiers sont en cours de traitement par nos techniciens.
                        <?php elseif (($nb_tickets_resolu ?? 0) == 0): ?>
                            Bienvenue sur votre tableau de bord ! Aucun ticket n'a encore été créé.
                        <?php else: ?>
                            Excellente nouvelle ! Tous vos tickets ont été traités, aucun dossier en attente.
                        <?php endif; ?>
                    </p>
                <?php elseif (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
                    <p>
                        <?php if (($total_crees_ce_mois ?? 0) > 50): ?>
                            Forte activité ce mois-ci : <?= htmlspecialchars($total_crees_ce_mois ?? 0) ?> tickets ont été créés ce mois-ci.
                        <?php elseif (($total_crees_ce_mois ?? 0) > 25): ?>
                            Activité modérée : <?= htmlspecialchars($total_crees_ce_mois ?? 0) ?> tickets ont été créés ce mois-ci.
                        <?php elseif (($total_crees_ce_mois ?? 0) === 1): ?>
                            Faible activité : <?= htmlspecialchars($total_crees_ce_mois ?? 0) ?> ticket a été créé ce mois-ci.
                        <?php else: ?>
                            Faible activité : <?= htmlspecialchars($total_crees_ce_mois ?? 0) ?> tickets ont été créés ce mois-ci.
                        <?php endif; ?>
                    </p>
                <?php endif; ?>
            </div>

            <?php if (isset($_SESSION['id_client'])): ?>
                <a href="index.php?page=nouveau_ticket" class="btn-nouveau-ticket">
                    <div class="icon-button">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                    </div>
                    <span>Nouveau ticket</span>
                </a>
            <?php endif; ?>
        </div>
        <div class="container-boxes">
            <div class="box">
                <div class="box-header">
                    <div class="box-badge">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="16" rx="2" />
                            <polyline points="8 12 12 16 16 12" />
                            <line x1="12" y1="8" x2="12" y2="16" />
                        </svg>
                    </div>
                    <h3>Tickets actifs</h3>
                </div>
                <p class="box-desc">
                    <?php if (($ecart_actifs ?? 0) > 0): ?>
                        <span class="text-danger">Augmentation de <strong><?= htmlspecialchars($ecart_actifs ?? 0) ?>% </strong>par rapport au mois dernier</span>

                    <?php elseif (($ecart_actifs ?? 0) < 0): ?>
                        <span class="text-success">Baisse de <strong><?= htmlspecialchars(abs($ecart_actifs ?? 0)) ?>% </strong>par rapport au mois dernier</span>
                    <?php elseif (($actifs_mois_dernier ?? 0) == 0): ?>
                        <span class="text-success">Il n'y a plus aucun ticket actif du mois dernier.</span>
                    <?php else: ?>
                        <span class="text-muted">Stable par rapport au mois dernier</span>

                    <?php endif ?>
                </p>
                <div class="box-value"><?= htmlspecialchars($nb_tickets_actif ?? 0) ?></div>
                <div
                    class="box-watermark"
                    style="transform: rotate(-15deg); right: -10px; bottom: -20px">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="16" rx="2" />
                        <polyline points="8 12 12 16 16 12" />
                        <line x1="12" y1="8" x2="12" y2="16" />
                    </svg>
                </div>
            </div>

            <div class="box active">
                <div class="box-header">
                    <div class="box-badge">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
                            stroke-linecap="round"
                            stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <h3>Tickets résolus</h3>
                </div>

                <p class="box-desc">
                    <?php if (($ecart_resolus ?? 0) > 0): ?>
                        <span class="text-danger">Augmentation de <strong><?= htmlspecialchars($ecart_resolus ?? 0) ?>% </strong> de tickets resolus par rapport au mois dernier</span>

                    <?php elseif (($ecart_resolus ?? 0) < 0): ?>
                        <span class="text-success">Baisse de <strong><?= htmlspecialchars(abs($ecart_resolus ?? 0)) ?>% </strong>par rapport au mois dernier</span>
                    <?php elseif (($resolus_mois_dernier ?? 0) == 0): ?>
                        <span class="text-success">Il n’y a eu aucun ticket résolu le mois dernier.</span>

                    <?php else: ?>
                        <span class="text-muted">Stable par rapport au mois dernier</span>

                    <?php endif ?>
                </p>
                <div class="box-value"><?= htmlspecialchars($nb_tickets_resolu ?? 0) ?></div>
                <div class="box-watermark" style="right: -15px; bottom: -25px">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2.5"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
            </div>

            <div class="box urgent">
                <div class="box-header">
                    <div class="box-badge">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            viewBox="0 0 24 24"
                            fill="currentColor">
                            <circle cx="12" cy="12" r="10" />
                            <line
                                x1="12"
                                y1="8"
                                x2="12"
                                y2="12"
                                stroke="#ffffff"
                                stroke-width="2"
                                stroke-linecap="round" />
                            <circle cx="12" cy="16" r="1" fill="#ffffff" />
                        </svg>
                    </div>
                    <h3>Tickets Urgents</h3>
                </div>

                <p class="box-desc">
                    <?php if (($ecart_urgents ?? 0) > 0): ?>
                        <span class="text-danger">Augmentation de <strong style="color: #C71500;"><?= htmlspecialchars($ecart_urgents ?? 0) ?>% </strong> du nombre de tickets urgent par rapport au mois dernier</span>

                    <?php elseif (($ecart_urgents ?? 0) < 0): ?>
                        <span class="text-success">Baisse de <strong><?= htmlspecialchars(abs($ecart_urgents ?? 0)) ?>% </strong> du nombre de tickets urgent par rapport au mois dernier</span>
                    <?php elseif (($urgents_mois_dernier ?? 0) == 0): ?>
                        <span class="text-success">Il n'y a eu aucun ticket de urgent le mois dernier.</span>

                    <?php else: ?>
                        <span class="text-muted">Stable par rapport au mois dernier</span>

                    <?php endif ?>
                </p>
                <div class="box-value"><?= htmlspecialchars($nb_tickets_urgent ?? 0) ?></div>
                <div
                    class="box-watermark"
                    style="
              transform: rotate(28deg);
              right: -30px;
              bottom: -40px;
              color: rgba(225, 82, 82, 0.18);
              opacity: 1;
            ">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor">
                        <circle cx="12" cy="12" r="11" />
                        <line
                            x1="12"
                            y1="6"
                            x2="12"
                            y2="13"
                            stroke="#ffffff"
                            stroke-width="2.5"
                            stroke-linecap="round" />
                        <circle cx="12" cy="17" r="1.5" fill="#ffffff" />
                    </svg>
                </div>
            </div>
            <?php if ($montrer_taux ?? false): ?>
                <div class="box">
                    <div class="box-header">
                        <div class="box-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="bg-percent-icon">
                                <path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z" />
                                <line x1="8" y1="16" x2="16" y2="8" />
                                <path d="M9 9.5h.01" stroke-width="2.5" />
                                <path d="M15 14.5h.01" stroke-width="2.5" />
                            </svg>
                        </div>
                        <h3>Taux de Résolution global</h3>
                    </div>

                    <p class="box-desc">
                    <p class="box-desc">
                        <?php if (($ecart_taux ?? 0) > 0): ?>
                            <span class="text-muted">Efficacité en hausse de <strong style="color: green;">+<?= htmlspecialchars($ecart_taux ?? 0) ?> points</strong> par rapport au mois dernier</span>

                        <?php elseif (($ecart_taux ?? 0) < 0): ?>
                            <span class="text-muted">Efficacité en baisse de <strong style="color: red;"><?= htmlspecialchars($ecart_taux ?? 0) ?> points</strong> par rapport au mois dernier</span>

                        <?php else: ?>
                            <span class="text-muted">Le taux de résolution est stable par rapport au mois dernier</span>

                        <?php endif ?>
                    </p>
                    </p>
                    <div class="box-value"><?= htmlspecialchars($taux_resolution ?? 0) ?>%</div>
                    <div class="box-watermark" style="right: -15px; bottom: -20px">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="bg-percent-icon">
                            <path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z" />
                            <line x1="8" y1="16" x2="16" y2="8" />
                            <path d="M9 9.5h.01" stroke-width="2.5" />
                            <path d="M15 14.5h.01" stroke-width="2.5" />
                        </svg>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="container-tickets">
            <?php if (isset($_SESSION['id_client'])): ?>
                <p>
                    Espace client :&nbsp;<strong><?= htmlspecialchars($_SESSION['name'] ?? 0) ?></strong> </p>

            <?php endif ?>



            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
                <div class="dashboard-layout">

                    <div class="colonne-principale">
                        <div class="row-graphiques">

                            <div class="panel-graphique">
                                <div class="panel-header">
                                    <div class="panel-titre-bloc">
                                        <h3>Répartition des tickets</h3>
                                        <p>Volume des demandes enregistrées ce mois-ci selon leur niveau de criticité.</p>
                                    </div>
                                </div>

                                <div class="chart-container">
                                    <canvas id="radarChart"></canvas>
                                </div>
                            </div>

                            <div class="panel-graphique">
                                <div class="panel-header">
                                    <div class="panel-titre-bloc">
                                        <h3>Tickets par semaine</h3>
                                        <p>Les tickets résolus sur la période du : <?= $date_debut_semaine ?? '00/00/00' ?> - <?= $date_fin_semaine ?? '00/00/00' ?></p>
                                    </div>
                                </div>

                                <div class="chart-container">
                                    <canvas id="barChart"></canvas>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="colonne-laterale">

                        <div class="panel-sidebar">
                            <svg class="illustration-box" viewBox="0 0 485 461" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20.9066 211.165C23.6142 211.165 25.8092 208.971 25.8092 206.263C25.8092 203.555 23.6142 201.36 20.9066 201.36C18.1991 201.36 16.0041 203.555 16.0041 206.263C16.0041 208.971 18.1991 211.165 20.9066 211.165Z" stroke="#2563EB" stroke-width="2.21515" />
                                <path d="M30.5134 206.763C40.4019 205.745 55.918 206.949 57.7519 214.598C59.5858 222.247 52.5828 225.044 48.8522 225.487C34.6487 227.744 15.8155 226.682 15.8155 214.598" stroke="#2563EB" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M26.9407 218.331C27.5656 218.331 28.0721 217.824 28.0721 217.199C28.0721 216.575 27.5656 216.068 26.9407 216.068C26.3159 216.068 25.8094 216.575 25.8094 217.199C25.8094 217.824 26.3159 218.331 26.9407 218.331Z" stroke="#2563EB" stroke-width="2.21515" />
                                <path d="M37.8769 217.199C37.8769 217.749 37.3648 218.331 36.5569 218.331C35.7491 218.331 35.237 217.749 35.237 217.199C35.237 216.65 35.7491 216.068 36.5569 216.068C37.3648 216.068 37.8769 216.65 37.8769 217.199Z" stroke="#2563EB" stroke-width="2.21515" />
                                <path d="M46.1738 218.331C46.7986 218.331 47.3051 217.824 47.3051 217.199C47.3051 216.575 46.7986 216.068 46.1738 216.068C45.5489 216.068 45.0424 216.575 45.0424 217.199C45.0424 217.824 45.5489 218.331 46.1738 218.331Z" stroke="#2563EB" stroke-width="2.21515" />
                                <path d="M392.932 73.1404C395.432 73.1404 397.458 71.1143 397.458 68.615C397.458 66.1157 395.432 64.0896 392.932 64.0896C390.433 64.0896 388.407 66.1157 388.407 68.615C388.407 71.1143 390.433 73.1404 392.932 73.1404Z" stroke="black" stroke-width="2.21515" />
                                <path d="M401.823 64.6549C405.139 64.6549 414.615 64.6549 419.072 64.6549C422.683 64.6549 424.421 65.4536 424.421 71.044C424.421 76.4756 424.376 83.5115 424.421 86.3512C424.452 88.3476 423.458 90.5572 420.142 90.8766C416.826 91.196 403.517 91.0097 397.277 90.8766C394.959 90.8766 390.858 89.5627 390.858 84.2212V78.2315" stroke="#2563EB" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M399.532 74.0833L407.829 79.7401" stroke="#2563EB" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M407.828 79.7404L422.913 65.7871" stroke="#2563EB" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M411.652 76.3467L415.774 80.495L419.896 84.6433" stroke="#2563EB" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M396.515 84.6433L402.597 76.3467" stroke="#2563EB" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M426.097 355.972C424.844 357.227 423.763 358.309 423.019 359.054C421.078 360.997 419.041 359.863 418.264 359.054L405.885 347.127C404.058 345.427 402.513 343.75 395.605 337.16C394.898 336.452 393.778 334.644 394.952 333.075C396.127 331.507 402.73 323.272 405.885 319.351C406.842 317.965 408.922 316.315 411.574 318.782C413.859 320.906 421.691 328.258 428.381 333.848" stroke="#2563EB" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M405.755 319.774C406.144 326.928 408.769 338.444 422.348 342.778" stroke="#2563EB" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M440.188 343.333C439.566 341.751 434.787 339.909 432.981 343.333C431.12 346.864 432.544 349.839 433.754 350.423C435.3 351.168 437.571 351.557 439.969 347.27" stroke="#2563EB" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M440.308 341.251C440.168 342.077 440.025 342.425 439.912 343.453C439.765 344.792 439.671 346.196 439.693 347.39C439.739 349.486 440.153 350.931 441.33 350.234C443.691 348.834 444.965 347.686 445.305 346.515C445.87 344.546 445.874 340.777 442.691 338.312C438.852 335.337 434.523 335.418 431.118 338.312C427.736 341.185 426.812 345.785 426.997 348.171C427.199 350.781 429.147 356.386 435.504 356.474C441.858 356.561 445.301 353.135 445.829 351.531" stroke="#2563EB" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M105.569 296.231C104.213 290.997 99.7114 281.344 92.5522 284.607C85.3927 287.87 89.5689 293.715 92.5522 296.231C94.5596 297.59 98.8754 299.045 100.078 293.987C101.28 288.93 96.2133 286.85 94.7893 289.094C94.0385 289.977 93.1903 292.193 95.8064 293.987" stroke="#2563EB" stroke-linecap="round" stroke-width="2.21515" />
                                <path d="M145.32 42.2309C145.968 42.5664 146.739 42.5621 147.382 42.2191L155.997 37.6277L154.401 47.258C154.282 47.9773 154.525 48.7091 155.05 49.215L162.078 55.989L152.427 57.4472C151.706 57.5561 151.085 58.0131 150.766 58.6684L146.496 67.4472L142.126 58.7184C141.126 58.7184 142.126 58.7184 142.126 58.7184L130.783 56.1682L137.733 49.3141C138.252 48.8022 138.486 48.0675 138.359 47.3496L136.654 37.7385L145.32 42.2309Z" stroke="#2563EB" stroke-width="2.21515" />
                                <path d="M253.965 211.134V243.189" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M278.1 214.904V245.451" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M222.957 353.111C214.987 354.103 196.33 357.763 192.244 365.205C191.017 367.438 189.595 372.871 193.715 376.741C197.835 380.612 205.363 379.594 208.612 378.602L227.555 370.973" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M328.903 298.14C314.032 298.618 248.353 330.415 217.372 346.254C214.734 363.707 225.867 376.239 231.763 380.322C262.644 371.357 326.024 353.188 332.5 352.231C338.977 351.275 345.392 346.653 347.791 344.461C364.58 324.857 352.188 308.201 343.893 302.324C337.988 298.14 332.891 298.011 328.903 298.14Z" fill="black" />
                                <path d="M190.961 293.106C201.497 293.808 247.46 311.622 269.238 320.958L219.432 345.846C197.142 352.383 183.449 350.229 179.268 348.82C155.13 337.191 164.587 308.501 174.177 297.873C180.358 292.612 187.185 292.854 190.961 293.106Z" fill="black" />
                                <path d="M310.73 357.111C317.315 360.276 320.876 364.422 322.681 367.822C326.55 376.676 319.603 381.999 311.672 379.496C307.289 378.113 306.256 377.186 303.935 375.261C302.757 374.284 297.255 369.172 290.974 363.135" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M182.193 213.61L186.451 290.985C186.774 296.857 191.629 301.452 197.51 301.452H324.346C330.463 301.452 335.422 296.493 335.422 290.376V211.234C335.422 205.058 330.372 200.076 324.197 200.159L193.103 201.926C186.806 202.011 181.847 207.322 182.193 213.61Z" fill="black" />
                                <rect x="186.084" y="302.773" width="149.338" height="7.16522" rx="3.58261" fill="black" />
                                <path d="M278.478 160.223C291.614 160.034 320.526 170.028 332.028 201.517" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M249.628 160.034C219.647 165.879 205.317 178.701 194.003 203.402" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M349.941 189.858L357.295 177.601" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M357.295 193.253L367.288 184.956" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M358.803 198.908C360.752 199.662 365.177 200.379 367.288 197.211" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M165.908 187.563L154.595 175.873" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M177.41 185.678L170.622 168.142" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M163.08 194.163L154.595 190.958" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M306.572 154.52C327.314 109.831 360.877 17.2114 329.2 4.23853C289.602 -11.9775 238.314 34.785 196.454 146.412" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M339.57 222.667C346.547 233.603 354.466 246.614 339.57 271.094" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M278.666 161.165C280.363 156.263 278.817 152.963 277.308 152.335C268.258 160.632 254.53 157.552 249.439 152.524C247.629 154.183 248.685 159.091 249.439 160.599C259.244 171.46 273.198 165.376 278.666 161.165Z" fill="black" />
                                <path d="M238.503 191.334L239.263 190.167C243.533 183.614 251.841 180.998 259.095 183.923C265.607 186.549 273.069 184.727 277.639 179.395L283.568 172.478" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M179.484 229.613C176.656 236.275 173.3 252.428 182.501 263.742" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M304.666 84.0848C300.518 98.981 298.443 100.301 292.409 106.9C292.409 100.378 291.289 89.4306 291.289 84.8721C271.532 84.8721 254.858 76.807 248.991 72.7744C249.201 86.45 236.381 95.3918 236.381 95.3918C236.381 95.3918 238.22 100.915 239.271 113.275C240.111 123.164 237.694 121.253 236.381 119.061C232.597 106.858 226.397 110.119 223.77 113.275C191.531 60.8921 241.109 50.7706 250.567 51.7349C257.713 45.6335 267.679 40.852 274.685 40.1507C299.952 37.6214 311.392 59.9313 304.666 84.0848Z" fill="black" />
                                <path d="M236.822 128.384C240.216 149.104 262.997 164.004 279.436 147.219C295.876 130.434 292.586 99.7091 290.83 85.3718" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M223.397 111.992C221.323 117.083 223.269 128.364 236.822 128.364" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M229.375 114.789C229.075 115.878 229.315 118.459 232.674 120.068" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M290.373 125.724C294.797 123.88 297.915 117.05 296.715 106.114" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M265.483 138.169C269.82 139.301 269.546 136.187 272.837 133.455" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <ellipse cx="278.43" cy="111.827" rx="2.82838" ry="2.82838" fill="black" />
                                <ellipse cx="253.54" cy="112.204" rx="2.82838" ry="2.82838" fill="black" />
                                <path d="M247.381 105.738C247.977 103.985 250.545 100.743 256.055 101.795" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M273.78 102.343C275.094 101.205 278.668 99.6111 282.453 102.343" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M264.656 110.262C264.217 113.985 263.918 121.536 266.237 121.952" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M373.322 281.309C423.667 295.262 514.1 311.289 473.07 263.773C460.122 251.014 441.015 236.055 410.28 222.856" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M427.816 183.819C459.116 163.769 509.537 122.349 460.813 117.07C412.09 111.79 367.603 130.08 351.45 139.885" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M150.325 116.025C103.94 90.6321 9.24606 51.5754 1.55287 98.4887C-6.14031 145.402 87.8498 184.534 135.806 198.236" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <path d="M148.12 222.856C80.4273 257.362 -4.39028 305.084 42.5909 329.957C61.8236 340.139 111.038 333.917 133.665 324.677" stroke="black" stroke-width="2.21515" stroke-linecap="round" />
                                <ellipse cx="258.867" cy="448.749" rx="93.3364" ry="11.3135" fill="#B3C0DD" />
                            </svg>

                            <h4 class="titre-box-action">
                                <?php $nb = $nb_tickets_du_jour ?? 0; ?>

                                <?php if ($nb === 0): ?>
                                    Vous n'avez <span>aucun</span> nouveau ticket aujourd'hui

                                <?php elseif ($nb === 1): ?>
                                    Vous avez <span>1</span> nouveau ticket aujourd'hui

                                <?php else: ?>
                                    Vous avez <span><?= htmlspecialchars($nb) ?></span> nouveaux tickets aujourd'hui

                                <?php endif; ?>
                            </h4>

                            <a href=" /iwan-assistance-tickets/index.php?page=admin_tickets" class="btn-action-dark">Voir tous les tickets</a>
                        </div>

                        <div class="panel-sidebar">
                            <h4 class="titre-box-action">Un ticket manquant ?</h4>

                            <a href="/iwan-assistance-tickets/index.php?page=nouveau_ticket" class="btn-action-dark">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                                Nouveau ticket
                            </a>
                        </div>

                    </div>

                </div>
            <?php endif ?>
            <!-- Affichage des tickets client -->
            <div class="dashboard-content" id="tickets">
                <?php if (!empty($_SESSION['is_admin'])) : ?>
                    <h1>Les derniers tickets</h1>
                    <form action="#tickets" method="GET" class="filtre">
                        <button class="<?= $id_statut == 0 ? 'actif' : '' ?>" type="submit" name="statut" value="0">Tous</button>

                        <button class="<?= $id_statut == 1 ? 'actif' : '' ?>" type="submit" name="statut" value="1">En attente</button>

                        <button class="<?= $id_statut == 2 ? 'actif' : '' ?>" type="submit" name="statut" value="2">En cours</button>

                        <button class="<?= $id_statut == 3 ? 'actif' : '' ?>" type="submit" name="statut" value="3">Résolus</button>
                    </form>
                <?php else : ?>
                    <h1>Mes derniers tickets</h1>
                <?php endif; ?>

                <?php foreach ($ticket_maj_user ?? [] as $ticket): ?>

                    <div class="ticket-list">
                        <div class="ticket-card">
                            <div class="ticket-header">
                                <div class="ticket-title-block">
                                    <?php
                                    if (($ticket['id_urgence'] ?? null) == 1) {
                                        echo '<span class="status-dot red"></span>';
                                    } elseif (($ticket['id_urgence'] ?? null) == 2) {
                                        echo '<span class="status-dot orange"></span>';
                                    } elseif (($ticket['id_urgence'] ?? null) == 3) {
                                        echo '<span class="status-dot blue"></span>';
                                    } else {
                                        echo '<span class="status-dot green"></span>';
                                    }
                                    ?>
                                    <div class="ticket-title-text">
                                        <h3><?= htmlspecialchars($ticket['libelle_urgence']) . " #" . htmlspecialchars($ticket['numero_ticket']) ?></h3>
                                        <h4><?= htmlspecialchars($ticket['titre']) ?></h4>
                                        <div class="nom-entreprise">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 21h8V5a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v16Z" />

                                                <path d="M11 21h10v-9a1 1 0 0 0-1-1h-8v10Z" />

                                                <path d="M6 7h2M6 11h2M6 15h2" />

                                                <path d="M15 14h2M15 18h2" />
                                            </svg>
                                            <p> <?= htmlspecialchars($ticket['nom_entreprise']) ?></p>

                                        </div>
                                    </div>
                                </div>

                                <div class="ticket-header-right">
                                    <div class="ticket-author">
                                        <div class="avatar-placeholder">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="#64748b" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5Z" />
                                                <path d="M12 14c-4.42 0-8 2.58-8 6v2h16v-2c0-3.42-3.58-6-8-6Z" />
                                            </svg>
                                        </div>
                                        <span><?= htmlspecialchars($ticket['declarant_nom']) . " " . htmlspecialchars($ticket['declarant_prenom']) ?></span>
                                    </div>
                                    <div class="statut-badge">
                                        <?php if (($ticket['id_statut'] ?? null) == 1) : ?>
                                            <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="181" height="35" rx="4" fill="#d97706" />
                                                <text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">En attente</text>
                                            </svg>
                                        <?php elseif (($ticket['id_statut'] ?? null) == 2) : ?>
                                            <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="181" height="35" rx="4" fill="#7FAAD4" />
                                                <text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">En cours</text>
                                            </svg>
                                        <?php elseif (($ticket['id_statut'] ?? null) == 3) : ?>
                                            <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="181" height="35" rx="4" fill="#38a169" />
                                                <text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">Résolu</text>
                                            </svg>
                                        <?php else : ?>
                                            <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="181" height="35" rx="4" fill="#718096" />
                                                <text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">Archivé</text>
                                            </svg>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="ticket-body">

                                <p>
                                    <?= htmlspecialchars(
                                        mb_strlen($ticket['description'], 'UTF-8') > 600

                                            ? mb_substr($ticket['description'], 0, 600, 'UTF-8') . '...'

                                            : $ticket['description']

                                    ) ?>
                                </p>
                            </div>
                            <?php $date_creation = (new DateTime($ticket['date_creation']))->format('d/m/y à H:i'); ?>
                            <?php
                            $date_maj = !empty($ticket['date_maj'])
                                ? (new DateTime($ticket['date_maj']))->format('d/m/Y à H:i')
                                : null;
                            ?>
                            <div class="ticket-footer">
                                <?php if ($_SESSION['is_admin'] ?? false): ?>
                                    <span class="ticket-date"><?= $date_creation ?></span>
                                <?php else : ?>

                                    <span class="ticket-date"> Mis a jour le <?= $date_maj ?> : <?= $ticket['derniere_action'] ?? "" ?></span>
                                <?php endif ?>
                                <a href="index.php?page=detail_ticket&ticket=<?= urlencode($ticket['numero_ticket']) ?>" class="btn-ouvrir"> Ouvrir le ticket </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const radarLabels = <?= json_encode($labels_radar ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
        const radarValues = <?= json_encode($valeurs_radar ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;

        const barLabels = <?= json_encode($labels_barres ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
        const barValues = <?= json_encode($valeurs_barres ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
    </script>

    <script src="public/scripts/graphiques_accueil.js"></script>
    <script src="public/scripts/Accueil.js"></script>

</body>

</html>
</body>

</html>


<?php require_once __DIR__ . '/Templates/Footer.php'; ?>