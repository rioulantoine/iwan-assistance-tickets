<?php require_once __DIR__ . '/Templates/Header.php'; ?>

<head>
    <meta charset="UTF-8" />
    <title>Détails Ticket</title>
    <link rel="icon" type="image/png" href="img/Logo_Iwan.png" />
    <link rel="stylesheet" href="public/styles/Details_ticket.css" />
    <link rel="stylesheet" href="public/styles/Global.css" />
</head>

<body>
    <main>
        <div class="container-details">
            <h1>Détails du ticket</h1>
            <p>
                Consultez l'historique complet des échanges et l'état d'avancement de votre résolution.
            </p>

            <div class="ticket-actions-bar" style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
                <!--Bouton suppression-->
                <?php if ($_SESSION['is_admin'] ?? false) : ?>
                    <a href="index.php?page=supprimer_ticket&ticket=<?= urlencode($details_ticket['numero_ticket'] ?? '') ?>"
                        class="btn-delete-trigger"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce ticket ? Cette action est irréversible.');"
                        style="display: block; text-decoration: none; border: none; background: none; padding: 0; cursor: pointer;">

                        <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="181" height="35" rx="4" fill="#EF1A1A" />
                            <path d="M69.424 23.196C68.6213 23.196 67.8467 23.098 67.1 22.902C66.3627 22.6967 65.7607 22.4353 65.294 22.118L66.204 20.074C66.6427 20.354 67.1467 20.5873 67.716 20.774C68.2947 20.9513 68.8687 21.04 69.438 21.04C69.8207 21.04 70.1287 21.0073 70.362 20.942C70.5953 20.8673 70.7633 20.774 70.866 20.662C70.978 20.5407 71.034 20.4007 71.034 20.242C71.034 20.018 70.9313 19.8407 70.726 19.71C70.5207 19.5793 70.2547 19.472 69.928 19.388C69.6013 19.304 69.2373 19.22 68.836 19.136C68.444 19.052 68.0473 18.9447 67.646 18.814C67.254 18.6833 66.8947 18.5153 66.568 18.31C66.2413 18.0953 65.9753 17.82 65.77 17.484C65.5647 17.1387 65.462 16.7047 65.462 16.182C65.462 15.594 65.6207 15.062 65.938 14.586C66.2647 14.11 66.75 13.7273 67.394 13.438C68.038 13.1487 68.8407 13.004 69.802 13.004C70.446 13.004 71.076 13.0787 71.692 13.228C72.3173 13.368 72.8727 13.578 73.358 13.858L72.504 15.916C72.0373 15.664 71.5753 15.4773 71.118 15.356C70.6607 15.2253 70.2173 15.16 69.788 15.16C69.4053 15.16 69.0973 15.202 68.864 15.286C68.6307 15.3607 68.4627 15.4633 68.36 15.594C68.2573 15.7247 68.206 15.874 68.206 16.042C68.206 16.2567 68.304 16.4293 68.5 16.56C68.7053 16.6813 68.9713 16.784 69.298 16.868C69.634 16.9427 69.998 17.022 70.39 17.106C70.7913 17.19 71.188 17.2973 71.58 17.428C71.9813 17.5493 72.3453 17.7173 72.672 17.932C72.9987 18.1373 73.26 18.4127 73.456 18.758C73.6613 19.094 73.764 19.5187 73.764 20.032C73.764 20.6013 73.6007 21.1287 73.274 21.614C72.9567 22.09 72.476 22.4727 71.832 22.762C71.1973 23.0513 70.3947 23.196 69.424 23.196ZM77.5505 23.126C76.9345 23.126 76.3791 23.0047 75.8845 22.762C75.3991 22.5193 75.0165 22.1413 74.7365 21.628C74.4658 21.1053 74.3305 20.4473 74.3305 19.654V15.412H76.9905V19.22C76.9905 19.808 77.0978 20.228 77.3125 20.48C77.5365 20.732 77.8491 20.858 78.2505 20.858C78.5118 20.858 78.7498 20.7973 78.9645 20.676C79.1791 20.5547 79.3518 20.3633 79.4825 20.102C79.6131 19.8313 79.6785 19.486 79.6785 19.066V15.412H82.3385V23H79.8045V20.858L80.2945 21.46C80.0331 22.02 79.6551 22.44 79.1605 22.72C78.6658 22.9907 78.1291 23.126 77.5505 23.126ZM88.2658 23.126C87.6218 23.126 87.0711 22.986 86.6138 22.706C86.1565 22.4167 85.8065 21.9873 85.5638 21.418C85.3305 20.8393 85.2138 20.102 85.2138 19.206C85.2138 18.3007 85.3258 17.5633 85.5498 16.994C85.7738 16.4153 86.1098 15.986 86.5578 15.706C87.0151 15.426 87.5845 15.286 88.2658 15.286C88.9565 15.286 89.5818 15.4493 90.1418 15.776C90.7111 16.0933 91.1591 16.546 91.4858 17.134C91.8218 17.7127 91.9898 18.4033 91.9898 19.206C91.9898 20.0087 91.8218 20.704 91.4858 21.292C91.1591 21.88 90.7111 22.3327 90.1418 22.65C89.5818 22.9673 88.9565 23.126 88.2658 23.126ZM83.4918 25.716V15.412H86.0258V16.7L86.0118 19.206L86.1518 21.726V25.716H83.4918ZM87.7058 21.012C88.0045 21.012 88.2705 20.942 88.5038 20.802C88.7465 20.662 88.9378 20.4567 89.0778 20.186C89.2271 19.9153 89.3018 19.5887 89.3018 19.206C89.3018 18.8233 89.2271 18.4967 89.0778 18.226C88.9378 17.9553 88.7465 17.75 88.5038 17.61C88.2705 17.47 88.0045 17.4 87.7058 17.4C87.4071 17.4 87.1365 17.47 86.8938 17.61C86.6605 17.75 86.4691 17.9553 86.3198 18.226C86.1798 18.4967 86.1098 18.8233 86.1098 19.206C86.1098 19.5887 86.1798 19.9153 86.3198 20.186C86.4691 20.4567 86.6605 20.662 86.8938 20.802C87.1365 20.942 87.4071 21.012 87.7058 21.012ZM97.4402 23.126C96.7962 23.126 96.2455 22.986 95.7882 22.706C95.3309 22.4167 94.9809 21.9873 94.7382 21.418C94.5049 20.8393 94.3882 20.102 94.3882 19.206C94.3882 18.3007 94.5002 17.5633 94.7242 16.994C94.9482 16.4153 95.2842 15.986 95.7322 15.706C96.1895 15.426 96.7589 15.286 97.4402 15.286C98.1309 15.286 98.7562 15.4493 99.3162 15.776C99.8855 16.0933 100.334 16.546 100.66 17.134C100.996 17.7127 101.164 18.4033 101.164 19.206C101.164 20.0087 100.996 20.704 100.66 21.292C100.334 21.88 99.8855 22.3327 99.3162 22.65C98.7562 22.9673 98.1309 23.126 97.4402 23.126ZM92.6662 25.716V15.412H95.2002V16.7L95.1862 19.206L95.3262 21.726V25.716H92.6662ZM96.8802 21.012C97.1789 21.012 97.4449 20.942 97.6782 20.802C97.9209 20.662 98.1122 20.4567 98.2522 20.186C98.4015 19.9153 98.4762 19.5887 98.4762 19.206C98.4762 18.8233 98.4015 18.4967 98.2522 18.226C98.1122 17.9553 97.9209 17.75 97.6782 17.61C97.4449 17.47 97.1789 17.4 96.8802 17.4C96.5815 17.4 96.3109 17.47 96.0682 17.61C95.8349 17.75 95.6435 17.9553 95.4942 18.226C95.3542 18.4967 95.2842 18.8233 95.2842 19.206C95.2842 19.5887 95.3542 19.9153 95.4942 20.186C95.6435 20.4567 95.8349 20.662 96.0682 20.802C96.3109 20.942 96.5815 21.012 96.8802 21.012ZM101.841 23V15.412H104.375V17.624L103.997 16.994C104.221 16.4247 104.585 16 105.089 15.72C105.593 15.4307 106.204 15.286 106.923 15.286V17.68C106.801 17.6613 106.694 17.652 106.601 17.652C106.517 17.6427 106.423 17.638 106.321 17.638C105.779 17.638 105.341 17.7873 105.005 18.086C104.669 18.3753 104.501 18.8513 104.501 19.514V23H101.841ZM107.46 23V15.412H110.12V23H107.46ZM108.79 14.572C108.305 14.572 107.913 14.4367 107.614 14.166C107.316 13.8953 107.166 13.5593 107.166 13.158C107.166 12.7567 107.316 12.4207 107.614 12.15C107.913 11.8793 108.305 11.744 108.79 11.744C109.276 11.744 109.668 11.8747 109.966 12.136C110.265 12.388 110.414 12.7147 110.414 13.116C110.414 13.536 110.265 13.886 109.966 14.166C109.677 14.4367 109.285 14.572 108.79 14.572ZM111.289 23V15.412H113.823V17.526L113.319 16.924C113.599 16.3827 113.982 15.9767 114.467 15.706C114.952 15.426 115.494 15.286 116.091 15.286C116.772 15.286 117.37 15.4633 117.883 15.818C118.406 16.1633 118.756 16.7047 118.933 17.442L118.065 17.26C118.336 16.644 118.742 16.1633 119.283 15.818C119.834 15.4633 120.464 15.286 121.173 15.286C121.761 15.286 122.284 15.4073 122.741 15.65C123.208 15.8833 123.572 16.2473 123.833 16.742C124.104 17.2367 124.239 17.876 124.239 18.66V23H121.579V19.094C121.579 18.5527 121.476 18.1607 121.271 17.918C121.066 17.666 120.786 17.54 120.431 17.54C120.179 17.54 119.95 17.6007 119.745 17.722C119.54 17.8433 119.381 18.03 119.269 18.282C119.157 18.5247 119.101 18.842 119.101 19.234V23H116.441V19.094C116.441 18.5527 116.338 18.1607 116.133 17.918C115.937 17.666 115.657 17.54 115.293 17.54C115.032 17.54 114.798 17.6007 114.593 17.722C114.397 17.8433 114.238 18.03 114.117 18.282C114.005 18.5247 113.949 18.842 113.949 19.234V23H111.289ZM129.43 23.126C128.534 23.126 127.75 22.958 127.078 22.622C126.415 22.2767 125.897 21.81 125.524 21.222C125.16 20.6247 124.978 19.948 124.978 19.192C124.978 18.436 125.155 17.764 125.51 17.176C125.874 16.5787 126.373 16.1167 127.008 15.79C127.642 15.454 128.356 15.286 129.15 15.286C129.896 15.286 130.578 15.44 131.194 15.748C131.81 16.0467 132.3 16.49 132.664 17.078C133.028 17.666 133.21 18.38 133.21 19.22C133.21 19.3133 133.205 19.4207 133.196 19.542C133.186 19.6633 133.177 19.7753 133.168 19.878H127.162V18.478H131.754L130.746 18.87C130.755 18.5247 130.69 18.226 130.55 17.974C130.419 17.722 130.232 17.526 129.99 17.386C129.756 17.246 129.481 17.176 129.164 17.176C128.846 17.176 128.566 17.246 128.324 17.386C128.09 17.526 127.908 17.7267 127.778 17.988C127.647 18.24 127.582 18.5387 127.582 18.884V19.29C127.582 19.6633 127.656 19.9853 127.806 20.256C127.964 20.5267 128.188 20.7367 128.478 20.886C128.767 21.026 129.112 21.096 129.514 21.096C129.887 21.096 130.204 21.0447 130.466 20.942C130.736 20.83 131.002 20.662 131.264 20.438L132.664 21.894C132.3 22.2953 131.852 22.6033 131.32 22.818C130.788 23.0233 130.158 23.126 129.43 23.126ZM133.876 23V15.412H136.41V17.624L136.032 16.994C136.256 16.4247 136.62 16 137.124 15.72C137.628 15.4307 138.239 15.286 138.958 15.286V17.68C138.837 17.6613 138.729 17.652 138.636 17.652C138.552 17.6427 138.459 17.638 138.356 17.638C137.815 17.638 137.376 17.7873 137.04 18.086C136.704 18.3753 136.536 18.8513 136.536 19.514V23H133.876Z" fill="white" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M43.3751 9.75H40.6251C40.4428 9.75 40.2679 9.82243 40.139 9.95136C40.01 10.0803 39.9376 10.2552 39.9376 10.4375V11.125H44.0626V10.4375C44.0626 10.2552 43.9902 10.0803 43.8612 9.95136C43.7323 9.82243 43.5574 9.75 43.3751 9.75ZM46.1251 11.125V10.4375C46.1251 9.70815 45.8354 9.00868 45.3196 8.49296C44.8039 7.97723 44.1044 7.6875 43.3751 7.6875H40.6251C39.8957 7.6875 39.1963 7.97723 38.6805 8.49296C38.1648 9.00868 37.8751 9.70815 37.8751 10.4375V11.125H34.0952C33.8217 11.125 33.5594 11.2336 33.366 11.427C33.1726 11.6204 33.064 11.8827 33.064 12.1562C33.064 12.4298 33.1726 12.6921 33.366 12.8855C33.5594 13.0789 33.8217 13.1875 34.0952 13.1875H34.5242L34.9601 23.6719C35.0044 24.7354 35.4582 25.7405 36.2264 26.4772C36.9946 27.214 38.0179 27.6252 39.0823 27.625H44.9192C45.9834 27.6249 47.0063 27.2135 47.7743 26.4768C48.5422 25.7401 48.9957 24.7351 49.0401 23.6719L49.4773 13.1875H49.9063C50.1798 13.1875 50.4421 13.0789 50.6355 12.8855C50.8289 12.6921 50.9376 12.4298 50.9376 12.1562C50.9376 11.8827 50.8289 11.6204 50.6355 11.427C50.4421 11.2336 50.1798 11.125 49.9063 11.125H46.1251ZM47.4121 13.1875H36.5881L37.0212 23.5853C37.0432 24.1171 37.27 24.6199 37.6541 24.9884C38.0383 25.3569 38.55 25.5626 39.0823 25.5625H44.9192C45.4513 25.5622 45.9627 25.3564 46.3465 24.9879C46.7304 24.6194 46.957 24.1169 46.979 23.5853L47.4121 13.1875ZM38.9063 15.9375V22.8125C38.9063 23.086 39.015 23.3483 39.2084 23.5417C39.4018 23.7351 39.6641 23.8438 39.9376 23.8438C40.2111 23.8438 40.4734 23.7351 40.6668 23.5417C40.8602 23.3483 40.9688 23.086 40.9688 22.8125V15.9375C40.9688 15.664 40.8602 15.4017 40.6668 15.2083C40.4734 15.0149 40.2111 14.9062 39.9376 14.9062C39.6641 14.9062 39.4018 15.0149 39.2084 15.2083C39.015 15.4017 38.9063 15.664 38.9063 15.9375ZM44.0626 14.9062C44.3361 14.9062 44.5984 15.0149 44.7918 15.2083C44.9852 15.4017 45.0938 15.664 45.0938 15.9375V22.8125C45.0938 23.086 44.9852 23.3483 44.7918 23.5417C44.5984 23.7351 44.3361 23.8438 44.0626 23.8438C43.7891 23.8438 43.5268 23.7351 43.3334 23.5417C43.14 23.3483 43.0313 23.086 43.0313 22.8125V15.9375C43.0313 15.664 43.14 15.4017 43.3334 15.2083C43.5268 15.0149 43.7891 14.9062 44.0626 14.9062Z" fill="white" />
                        </svg>
                    </a>
                    <!-- Bouton modification niveau d'urgence admin -->
                    <div class="urgence-dropdown-container" style="position : relative; display: inline-block">
                        <button id="urgenceDropdownBtn" class="dropdown-trigger-btn" type="button" style="background : non; border: non; padding: 0; margin: 0; cursor: pointer; display:block; outline: none;">
                            <?php if (($details_ticket['id_urgence'] ?? null) == 1): ?>
                                <svg width="241" height="35" viewBox="0 0 241 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="241" height="35" rx="4" fill="#e53e3e" />
                                    <text x="46%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">Bloquant / Très urgent</text>
                                    <path d="M210 15 L215 20 L220 15" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            <?php elseif (($details_ticket['id_urgence'] ?? null) == 2): ?>
                                <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="181" height="35" rx="4" fill="#dd6b20" />
                                    <text x="46%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">Urgent</text>
                                    <path d="M153 15 L158 20 L163 15" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            <?php elseif (($details_ticket['id_urgence'] ?? null) == 3): ?>
                                <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="181" height="35" rx="4" fill="#3182ce" />
                                    <text x="46%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">Normal</text>
                                    <path d="M153 15 L158 20 L163 15" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            <?php else : ?>
                                <svg width="291" height="35" viewBox="0 0 291 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="291" height="35" rx="4" fill="#38a169" />
                                    <text x="46%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">Non urgent / Demande d'évolution</text>
                                    <path d="M263 15 L268 20 L273 15" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            <?php endif; ?>

                        </button>
                        <div class="urgence-dropdown-menu" id="urgenceDropdownMenu" style="display: none; position: absolute; top: calc(100% + 6px); right: 0; background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 10px 25px rgba(15, 46, 72, 0.12); width: 181px; z-index: 100; padding: 6px 0; box-sizing: border-box;">
                            <div class="dropdown-title" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #94a3b8; padding: 6px 14px 4px 14px; letter-spacing: 0.5px;">Changer le niveau d'urgence :</div>

                            <a href="index.php?page=changer_urgence&ticket=<?= urlencode($details_ticket['numero_ticket'] ?? '') ?>&urgence=1" class="dropdown-item" style="display: flex; align-items: center; gap: 10px; padding: 8px 14px; font-family: -apple-system, BlinkMacSystemFont, sans-serif; font-size: 14px; font-weight: 600; color: #0f2e48; text-decoration: none;">
                                <span class="urgence-dot" style="width: 10px; height: 10px; border-radius: 50%; display: inline-block; background-color: #e53e3e;"></span> Bloquant / Très urgent
                            </a>
                            <a href="index.php?page=changer_urgence&ticket=<?= urlencode($details_ticket['numero_ticket'] ?? '') ?>&urgence=2" class="dropdown-item" style="display: flex; align-items: center; gap: 10px; padding: 8px 14px; font-family: -apple-system, BlinkMacSystemFont, sans-serif; font-size: 14px; font-weight: 600; color: #0f2e48; text-decoration: none;">
                                <span class="urgence-dot" style="width: 10px; height: 10px; border-radius: 50%; display: inline-block; background-color: #dd6b20;"></span> Urgent
                            </a>
                            <a href="index.php?page=changer_urgence&ticket=<?= urlencode($details_ticket['numero_ticket'] ?? '') ?>&urgence=3" class="dropdown-item" style="display: flex; align-items: center; gap: 10px; padding: 8px 14px; font-family: -apple-system, BlinkMacSystemFont, sans-serif; font-size: 14px; font-weight: 600; color: #0f2e48; text-decoration: none;">
                                <span class="urgence-dot" style="width: 10px; height: 10px; border-radius: 50%; display: inline-block; background-color: #3182ce;"></span> Normal
                            </a>
                            <a href="index.php?page=changer_urgence&ticket=<?= urlencode($details_ticket['numero_ticket'] ?? '') ?>&urgence=4" class="dropdown-item" style="display: flex; align-items: center; gap: 10px; padding: 8px 14px; font-family: -apple-system, BlinkMacSystemFont, sans-serif; font-size: 14px; font-weight: 600; color: #0f2e48; text-decoration: none;">
                                <span class="urgence-dot" style="width: 10px; height: 10px; border-radius: 50%; display: inline-block; background-color: #38a169;"></span> Non urgent / Demande d'évolution
                            </a>
                        </div>

                    </div>
                <?php endif; ?>
                <!--Dropdown pour statut ticket admin-->
                <?php if ($_SESSION['is_admin'] ?? false) : ?>
                    <div class="status-dropdown-container" style="position: relative; display: inline-block;">

                        <button id="statusDropdownBtn" class="dropdown-trigger-btn" type="button" style="background: none; border: none; padding: 0; margin: 0; cursor: pointer; display: block; outline: none;">

                            <?php if (($details_ticket['id_statut'] ?? null) == 1) : ?>
                                <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="181" height="35" rx="4" fill="#d97706" />
                                    <text x="46%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">En attente</text>
                                    <path d="M153 15 L158 20 L163 15" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            <?php elseif (($details_ticket['id_statut'] ?? null) == 2) : ?>
                                <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="181" height="35" rx="4" fill="#7faad4" />
                                    <text x="46%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">En cours</text>
                                    <path d="M153 15 L158 20 L163 15" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            <?php elseif (($details_ticket['id_statut'] ?? null) == 3) : ?>
                                <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="181" height="35" rx="4" fill="#38a169" />
                                    <text x="46%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">Résolu</text>
                                    <path d="M153 15 L158 20 L163 15" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            <?php else : ?>
                                <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="181" height="35" rx="4" fill="#94a3b8" />
                                    <text x="46%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">Archivé</text>
                                    <path d="M153 15 L158 20 L163 15" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            <?php endif; ?>

                        </button>

                        <div class="status-dropdown-menu" id="statusDropdownMenu" style="display: none; position: absolute; top: calc(100% + 6px); right: 0; background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 10px 25px rgba(15, 46, 72, 0.12); width: 181px; z-index: 100; padding: 6px 0; box-sizing: border-box;">
                            <div class="dropdown-title" style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #94a3b8; padding: 6px 14px 4px 14px; letter-spacing: 0.5px;">Changer le statut :</div>

                            <a href="index.php?page=changer_statut&ticket=<?= urlencode($details_ticket['numero_ticket'] ?? '') ?>&status=1" class="dropdown-item" style="display: flex; align-items: center; gap: 10px; padding: 8px 14px; font-family: -apple-system, BlinkMacSystemFont, sans-serif; font-size: 14px; font-weight: 600; color: #0f2e48; text-decoration: none;">
                                <span class="status-dot" style="width: 10px; height: 10px; border-radius: 50%; display: inline-block; background-color: #d97706;"></span> En attente
                            </a>
                            <a href="index.php?page=changer_statut&ticket=<?= urlencode($details_ticket['numero_ticket'] ?? '') ?>&status=2" class="dropdown-item" style="display: flex; align-items: center; gap: 10px; padding: 8px 14px; font-family: -apple-system, BlinkMacSystemFont, sans-serif; font-size: 14px; font-weight: 600; color: #0f2e48; text-decoration: none;">
                                <span class="status-dot" style="width: 10px; height: 10px; border-radius: 50%; display: inline-block; background-color: #7faad4;"></span> En cours
                            </a>
                            <a href="index.php?page=changer_statut&ticket=<?= urlencode($details_ticket['numero_ticket'] ?? '') ?>&status=3" class="dropdown-item" style="display: flex; align-items: center; gap: 10px; padding: 8px 14px; font-family: -apple-system, BlinkMacSystemFont, sans-serif; font-size: 14px; font-weight: 600; color: #0f2e48; text-decoration: none;">
                                <span class="status-dot" style="width: 10px; height: 10px; border-radius: 50%; display: inline-block; background-color: #38a169;"></span> Résolu
                            </a>

                            <div class="dropdown-divider" style="height: 1px; background-color: #e2e8f0; margin: 6px 0;"></div>

                            <a href="index.php?page=changer_statut&ticket=<?= urlencode($details_ticket['numero_ticket'] ?? '') ?>&status=4" class="dropdown-item" style="display: flex; align-items: center; gap: 10px; padding: 8px 14px; font-family: -apple-system, BlinkMacSystemFont, sans-serif; font-size: 14px; font-weight: 600; color: #64748b; text-decoration: none;">
                                <span class="status-dot" style="width: 10px; height: 10px; border-radius: 50%; display: inline-block; background-color: #94a3b8;"></span> Archivé
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <?php if (($details_ticket['id_statut'] ?? null) == 1) : ?>
                        <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="181" height="35" rx="4" fill="#d9ad7a" />
                            <text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">En attente</text>
                        </svg>
                    <?php elseif (($details_ticket['id_statut'] ?? null) == 2) : ?>

                        <svg width="181" height="35" viewBox="0 0 181 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="181" height="35" rx="4" fill="#7FAAD4" />
                            <text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="white" font-family="-apple-system, BlinkMacSystemFont, sans-serif" font-weight="700" font-size="14">En cours</text>
                        </svg>
                    <?php elseif (($details_ticket['id_statut'] ?? null) == 3) : ?>

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

                <?php endif; ?>
            </div>
        </div>
        <div class="thread-container">

            <div class="message-card">
                <div class="message-header">
                    <div class="header-left">
                        <?php
                        if (($details_ticket['id_urgence'] ?? null) == 1) {
                            echo '<span class="status-dot red"></span>';
                        } elseif (($details_ticket['id_urgence'] ?? null) == 2) {
                            echo '<span class="status-dot orange"></span>';
                        } elseif (($details_ticket['id_urgence'] ?? null) == 3) {
                            echo '<span class="status-dot blue"></span>';
                        } else {
                            echo '<span class="status-dot green"></span>';
                        }
                        ?>
                        <span class="meta-title"><?= htmlspecialchars($num_ticket ?? 'Numéro de ticket non spécifié') ?></span>
                    </div>
                    <div class="header-right">
                        <span class="message-time"><?= htmlspecialchars($date_ticket ?? 'Date non spécifiée') ?> (<?= $ecart_date_ticket ?? '0' ?>)</span>
                        <div class="action-icons">
                            <svg class="icon-btn" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                <rect x="6" y="14" width="12" height="8"></rect>
                            </svg>
                            <svg class="icon-btn" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 17 4 12 9 7"></polyline>
                                <path d="M20 18v-2a4 4 0 0 0-4-4H4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="message-body">
                    <h3><?= htmlspecialchars($details_ticket['titre'] ?? 'Titre non spécifié') ?></h3>
                    <p class="message-text"><?= htmlspecialchars($details_ticket['description'] ?? 'Description non spécifiée') ?></p>
                    <?php if (!empty($pieces_jointes)): ?>
                        <?php foreach ($pieces_jointes as $pj) :
                            $extension = strtolower(pathinfo($pj['nom_origine'], PATHINFO_EXTENSION));
                            $taille_kb = round($pj['taille_octets'] / 1024);
                        ?>
                            <div class="attachment-card">
                                <div class="file-icon-wrapper file-<?= $extension ?>">
                                    <div class="file-badge"><?= strtoupper($extension) ?></div>
                                </div>
                                <div class="file-info">
                                    <span class="file-title"><?= htmlspecialchars($pj['nom_origine']) ?></span>
                                    <span class="file-size"><?= $taille_kb ?> KB</span>
                                </div>
                                <a href="public/uploads/<?= htmlspecialchars($pj['nom_stockage']) ?>"
                                    download="<?= htmlspecialchars($pj['nom_origine']) ?>"
                                    class="download-btn">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v4"></path>
                                        <polyline points="7 10 12 15 17 10"></polyline>
                                        <line x1="12" y1="15" x2="12" y2="3"></line>
                                    </svg>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="message-card">
                    <div class="message-header">
                        <div class="header-left">
                            <span class="meta-title">Transaction Failed</span>
                        </div>
                        <div class="header-right">
                            <span class="message-time">15:44 (4 plus tot)</span>
                            <div class="action-icons">
                                <svg class="icon-btn" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                    <rect x="6" y="14" width="12" height="8"></rect>
                                </svg>
                                <svg class="icon-btn" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 17 4 12 9 7"></polyline>
                                    <path d="M20 18v-2a4 4 0 0 0-4-4H4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="message-body">
                        <p class="reply-indicator">Réponse à "Le site est inaccessible"</p>
                        <p class="message-text">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>
                    </div>
                </div>

                <div class="reply-section">
                    <div class="reply-header">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="100" height="100" fill="currentColor">
                            <path d="M14 9V5l7 7-7 7v-4.1c-5 0-8.5 1.6-11 5.1 1-5 4-10 11-11z" />
                        </svg>

                        <h3>En réponse à "Transaction Failed"</h3>
                    </div>

                    <form action="#" method="POST" class="reply-form">
                        <div class="input-group">
                            <label for="reply-title">Titre</label>
                            <input type="text" id="reply-title" name="title" placeholder="Entrez le titre de votre réponse" required>
                        </div>

                        <div class="textarea-wrapper">
                            <textarea name="content" placeholder="Entrez votre réponse..." required></textarea>

                            <div class="textarea-actions">

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

                                <button type="submit" class="btn-submit" aria-label="Envoyer">
                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="22" y1="2" x2="11" y2="13"></line>
                                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <script src="public/scripts/upload_fichiers.js"></script>
            <script src="public/scripts/menu_deroulant_statut.js"></script>
    </main>

</body>

<?php require_once __DIR__ . '/Templates/Footer.php'; ?>