/**
 * ==========================================================================
 * IWAN ASSISTANCE TICKETS - CONFIGURATION & VARIABLES GLOBALES
 * ==========================================================================
 */

// Tableau stockant temporairement les instances d'objets File téléversés
let allFiles = [];

// Taille maximale par fichier (5 Mo = 5 * 1024 * 1024 octets)
const MAX_FILE_SIZE = 5 * 1024 * 1024; 

/**
 * Génère un bloc SVG vectoriel coloré adapté selon l'extension du fichier joint.
 * @param {string} nomFichier - Nom complet du fichier (ex: document.pdf)
 * @return {string} Chaîne de caractères contenant le balisage HTML du SVG
 */
function obtenirSvgParExtension(nomFichier) {
    const extension = nomFichier.split('.').pop().toLowerCase();

    // Palette de couleurs unifiée pour l'identité visuelle des types de documents
    const couleurs = {
        pdf: '#E44D26',    
        image: '#2AA9E0',  
        word: '#2B579A',   
        excel: '#1E7145',  
        zip: '#F39C12',    
        default: '#7F8C8D'  
    };

    // Format PDF
    if (extension === 'pdf') {
        return `
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="32" height="32" rx="6" fill="${couleurs.pdf}"/>
            <text x="16" y="18" text-anchor="middle" fill="white" font-size="8" font-family="Arial, sans-serif" font-weight="bold">PDF</text>
        </svg>`;
    }

    // Formats Images standards
    if (['png', 'jpg', 'jpeg', 'gif', 'svg', 'webp', 'heic'].includes(extension)) {
        return `
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="32" height="32" rx="6" fill="${couleurs.image}"/>
            <circle cx="12" cy="13" r="2.5" fill="white"/>
            <path d="M24 22H8V19L12 14L16 18L20 13L24 18V22Z" fill="white"/>
        </svg>`;
    }

    // Traitements de texte (Microsoft Word)
    if (['doc', 'docx'].includes(extension)) {
        return `
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="32" height="32" rx="6" fill="${couleurs.word}"/>
            <path d="M9 11H12.5L14 17L15.5 11H19L20.5 17L22 11H25.5L23 21H19.5L18 15L16.5 21H13L9 11Z" fill="white"/>
        </svg>`;
    }

    // Tableurs (Microsoft Excel / Données CSV)
    if (['xls', 'xlsx', 'csv'].includes(extension)) {
        return `
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="32" height="32" rx="6" fill="${couleurs.excel}"/>
            <path d="M11 11H14.5L16 14.5L17.5 11H21L18.5 16L21.5 21H18L16 17.5L14 21H10.5L13.5 16L11 11Z" fill="white"/>
        </svg>`;
    }

    // Archives et paquets compressés
    if (['zip', 'rar', '7z'].includes(extension)) {
        return `
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="32" height="32" rx="6" fill="${couleurs.zip}"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M14 9H18V11H16V13H18V15H16V17H18V19H14V17H16V15H14V13H16V11H14V9ZM14 19H18V23H14V19Z" fill="white"/>
        </svg>`;
    }

    // Icône générique de secours
    return `
    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="32" height="32" rx="6" fill="${couleurs.default}"/>
        <path d="M12 11H17V13H12V11ZM12 15H20V17H12V15ZM12 19H20V21H12V19Z" fill="white"/>
    </svg>`;
}

/**
 * ==========================================================================
 * GESTION DYNAMIQUE DES FICHIERS JOINTS (UPLOAD DRAG/DROP & INPUT)
 * ==========================================================================
 */

document.addEventListener("DOMContentLoaded", function() {
    const fileInput = document.getElementById("fichier");
    if (fileInput) {
        fileInput.addEventListener("change", function(e) {
            const newFiles = Array.from(e.target.files);
            
            newFiles.forEach(file => {
                // Validation de sécurité sur la taille maximale par fichier
                if (file.size > MAX_FILE_SIZE) {
                    alert(`Le fichier "${file.name}" est trop gros ! La taille maximale autorisée est de 5 Mo.`);
                } else {
                    allFiles.push(file);
                }
            });

            syncInputAndRender();
        });
    }

    // Délégation d'événement pour le bouton de suppression adaptatif des aperçus
    const listConteneur = document.getElementById("liste-fichiers");
    if (listConteneur) {
        listConteneur.addEventListener("click", function(e) {
            const removeBtn = e.target.closest(".remove-file");
            if (removeBtn) {
                const indexToRemove = parseInt(removeBtn.getAttribute("data-index"));
                allFiles.splice(indexToRemove, 1); // Retrait de l'élément du tableau global
                syncInputAndRender();
            }
        });
    }
});

/**
 * Synchronise l'état du tableau JS vers l'élément natif input de type file 
 * et génère dynamiquement les composants visuels d'aperçus.
 */
function syncInputAndRender() {
    const listConteneur = document.getElementById("liste-fichiers");
    const fileInput = document.getElementById("fichier");
    if (!listConteneur || !fileInput) return;

    // Utilisation de l'API DataTransfer pour réinjecter la collection de fichiers filtrée
    const dataTransfer = new DataTransfer();
    allFiles.forEach((file) => dataTransfer.items.add(file));
    fileInput.files = dataTransfer.files;

    listConteneur.innerHTML = "";

    // Injection dynamique des cartes de prévisualisation dans le DOM
    allFiles.forEach((file, index) => {
        const item = document.createElement("div");
        item.className = "file-item-card";

        const fileSizeKB = Math.round(file.size / 1024);

        item.innerHTML = `
            <div class="file-icon-wrapper">
                ${obtenirSvgParExtension(file.name)}
            </div>
            <div class="file-item-info">
                <span class="file-item-name">${file.name}</span>
                <span class="file-item-size">${fileSizeKB} KB</span>
            </div>
            <button type="button" class="remove-file" data-index="${index}" aria-label="Supprimer le fichier">✕</button>
        `;
        listConteneur.appendChild(item);
    });
}

/**
 * ==========================================================================
 * GESTION DES AFFICHAGES DES FENÊTRES MODALES (INTERFACE ADMINISTRATEUR)
 * ==========================================================================
 */

/* --- Modale Légendes / Niveaux d'urgence --- */
function ouvrirModalUrgence() {
    const modal = document.getElementById('modalUrgence');
    if (modal) modal.style.display = 'flex';
}

function fermerModalUrgence(event) {
    const modal = document.getElementById('modalUrgence');
    if (modal && event.target === modal) {
        modal.style.display = 'none';
    }
}

/* --- Modale Liste globale des Entreprises enregistrées --- */
function ouvrirModalListeEntreprises(){
    const modal = document.getElementById('modalListeEntreprises');
    if (!modal) return;
    
    modal.style.display = 'flex';

    // Focus automatique adaptatif sur la recherche avec positionnement du curseur à la fin
    const inputRecherche = modal.querySelector('.search-wrapper input[name="recherche"]');
    if (inputRecherche) {
        setTimeout(() => {
            inputRecherche.focus();
            const valeur = inputRecherche.value;
            inputRecherche.value = '';
            inputRecherche.value = valeur;
        }, 50);
    }
}

function fermerModalListeEntreprises(event){
    const modal = document.getElementById('modalListeEntreprises');
    if (modal && event.target === modal) {
        modal.style.display = 'none';
    }
}

/* --- Modale Création rapide d'une nouvelle entreprise --- */
function ouvrirModalCreation() {
    const modal = document.getElementById('modalNouveauClient');
    if (modal) modal.style.display = 'flex';
}

function fermerModalCreationForce() {
    const modal = document.getElementById('modalNouveauClient');
    if (modal) modal.style.display = 'none';
}

function fermerModalCreation(event) {
    const modal = document.getElementById('modalNouveauClient');
    if (event.target === modal) modal.style.display = 'none';
}

/**
 * ==========================================================================
 * INTERACTIONS AVANCÉES DE RECHERCHE ET AUTO-COMPLÉTION SANS RECHARGEMENT
 * ==========================================================================
 */

/**
 * Distribue l'intégralité des attributs d'une entreprise sélectionnée vers les 
 * différents inputs correspondants du formulaire principal (Ticket ou Suivi)
 * afin d'éviter les rechargements de pages et les pertes de données utilisateur.
 * @param {Object} entreprise - Instance contenant les attributs de la ligne SQL
 */
function attribuerEntrepriseAuTicket(entreprise) {
    // Matrice de mappage [ID du champ HTML : Valeur de l'objet entreprise injectée]
    const correspondances = {
        'id_client': entreprise.id_client,
        'nom_entreprise': entreprise.nom_entreprise,
        'nom_entreprise_suivi': entreprise.nom_entreprise,
        'nom': entreprise.nom,
        'suivi_nom': entreprise.nom,
        'prenom': entreprise.prenom,
        'suivi_prenom': entreprise.prenom,
        'email': entreprise.email,
        'telephone': entreprise.telephone,
        'ville': entreprise.ville,
        'cp': entreprise.code_postal
    };

    // Parcours de la structure et hydratation dynamique des inputs
    Object.keys(correspondances).forEach(idInput => {
        const input = document.getElementById(idInput);
        if (input) {
            input.value = correspondances[idInput] || '';
            // Déclenchement manuel de l'événement 'input' pour alerter les scripts tiers (redimensionnements, etc.)
            input.dispatchEvent(new Event('input', { bubbles: true }));
        }
    });

    // Liaison automatique avec le dropdown logiciel custom si configuré
    if (entreprise.id_logiciel && typeof selectLogiciel === "function") {
        selectLogiciel(entreprise.id_logiciel, entreprise.logiciel);
    }

    // Sélection standard par <select> classique du formulaire de Suivi des appels
    const selectLogicielStandard = document.getElementById('logiciel');
    if (selectLogicielStandard && entreprise.id_logiciel) {
        selectLogicielStandard.value = entreprise.id_logiciel;
    }

    // Fermeture de sécurité de la modale de sélection de premier plan
    const modalEntreprises = document.getElementById('modalListeEntreprises');
    if (modalEntreprises) {
        modalEntreprises.style.display = 'none';
    }
}

/**
 * Traitement intercepté de validation asynchrone (AJAX) pour la création d'entreprise.
 * Crée la ligne en BDD, ferme la modale rapide et applique immédiatement le filtre.
 */
function soumettreCreationClient(event) {
    event.preventDefault();

    const formCreation = document.getElementById('formNouveauClientRapide');
    const formData = new FormData(formCreation);

    fetch('index.php?page=nouveau_ticket', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        if (result.trim() === "success") {
            fermerModalCreationForce();

            const formFiltre = document.getElementById('formFiltreEntreprises');
            if (formFiltre) {
                const inputRecherche = formFiltre.querySelector('input[name="recherche"]');
                const nomEntrepriseCreee = formData.get('nom_entreprise');
                if (inputRecherche && nomEntrepriseCreee) {
                    inputRecherche.value = nomEntrepriseCreee;
                }
                formFiltre.submit(); // Soumission automatique pour mise à jour instantanée du tableau
            }
        } else {
            alert("Une erreur est survenue lors de la création en base de données.");
        }
    })
    .catch(error => {
        console.error("Erreur AJAX :", error);
    });
}

/**
 * Écouteur d'événement sur la touche Entrée.
 * Si le filtre de recherche n'affiche qu'un seul résultat unique, la touche Entrée valide
 * et attribue le client automatiquement.
 */
document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById('modalListeEntreprises');
    if (!modal) return;

    const inputRecherche = modal.querySelector('.search-wrapper input[name="recherche"]');
    
    if (inputRecherche) {
        inputRecherche.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                const lignes = modal.querySelectorAll('.table-liste-entreprises tbody tr');
                
                // Vérifie s'il y a une unique correspondance réelle de ligne dans le tableau
                if (lignes.length === 1 && !lignes[0].querySelector('.pas-entreprise')) {
                    const btnSelectionner = lignes[0].querySelector('.btn-selectionner-entreprise');
                    
                    if (btnSelectionner) {
                        event.preventDefault(); 
                        modal.style.display = 'none'; 
                        btnSelectionner.click(); // Simulation du clic d'attribution
                    }
                }
            }
        });
    }
    
    // Réouverture automatique de la modale si l'indicateur de pagination GET est transmis
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('ouvrir_modal') === '1') {
        ouvrirModalListeEntreprises();
    }
});

/**
 * ==========================================================================
 * ACCESSIBILITÉ CLAVIER & COMPORTEMENTS ERGONOMIQUES DE L'INTERFACE
 * ==========================================================================
 */

/**
 * Intercepteur global sur la touche Échap (Escape).
 * Gère une fermeture en cascade : ferme la modale de création si elle est active,
 * sinon ferme les modales de listes de second plan.
 */
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' || event.key === 'Esc') {
        const modalNouveauClient = document.getElementById('modalNouveauClient');
        const modalEntreprises = document.getElementById('modalListeEntreprises');
        const modalUrgence = document.getElementById('modalUrgence');
        
        // Priorité 1 : Fermer uniquement le formulaire de création s'il est au-dessus
        if (modalNouveauClient && modalNouveauClient.style.display === 'flex') {
            event.preventDefault();
            modalNouveauClient.style.display = 'none';
            return; 
        }
        
        // Priorité 2 : Traitement des autres fenêtres modales
        if (modalEntreprises && modalEntreprises.style.display === 'flex') {
            event.preventDefault();
            modalEntreprises.style.display = 'none';
        }
        
        if (modalUrgence && modalUrgence.style.display === 'flex') {
            event.preventDefault();
            modalUrgence.style.display = 'none';
        }
    }
});

/**
 * Redimensionnement automatique dynamique de la hauteur des zones d'édition de texte (Textareas).
 * Calcule l'espace occupé au fur et à mesure de la saisie (évite les ascenseurs verticaux).
 */
function ajusterHauteurTextarea(el) {
    el.style.height = 'auto';
    el.style.height = el.scrollHeight + 'px';
}

document.addEventListener("DOMContentLoaded", function() {
    const zonesTexte = document.querySelectorAll('textarea');

    zonesTexte.forEach(textarea => {
        textarea.addEventListener('input', function() {
            ajusterHauteurTextarea(this);
        });
        ajusterHauteurTextarea(textarea); // Initialisation à froid au chargement du DOM
    });
});

/**
 * Gestion de la réinitialisation intelligente des formulaires ou du repositionnement 
 * de la vue lors d'un retour ou changement d'onglet (Ticket ou Suivi).
 */
window.addEventListener('pageshow', function(event) {
    const formTicket = document.querySelector('.formulaire-nouveau-ticket form');
    const formSuivi = document.querySelector('.formulaire-nouveau-suivi form');
    const urlParams = new URLSearchParams(window.location.search);

    // Blocage de la remise à zéro si on conserve le contexte d'une sélection en cours
    if (urlParams.get('selection') === '1' || urlParams.get('ouvrir_modal') === '1') {
        
        if (urlParams.get('selection') === '1' && urlParams.get('tab') === 'suivi') {
            setTimeout(() => {
                const btnSubmitSuivi = document.querySelector('.formulaire-nouveau-suivi .btn-submit');
                
                if (btnSubmitSuivi) {
                    btnSubmitSuivi.scrollIntoView({ behavior: 'smooth', block: 'end' });
                } else if (formSuivi) {
                    formSuivi.scrollIntoView({ behavior: 'smooth', block: 'end' });
                }
            }, 50); 
        }
        return; 
    }

    // Remise à zéro saine par défaut si l'utilisateur accède à la page pour la première fois
    if (formTicket) formTicket.reset();
    if (formSuivi) formSuivi.reset();
});

/**
 * ==========================================================================
 * GESTION DES MENUS DÉROULANTS GRAPHIQUES CUSTOMISÉS (DROPDOWNS)
 * ==========================================================================
 */

/* --- Dropdown sélecteur de Niveau d'urgence --- */
function toggleUrgenceDropdown() {
    document.getElementById('urgenceMenu').classList.toggle('open');
}

function selectUrgence(valeur, label, couleur, labelBouton) {
    document.getElementById('niveau_urgence').value = valeur;
    document.getElementById('urgenceLabel').textContent = labelBouton;
    document.querySelector('#urgenceDropdown .urgence-dropdown-btn').style.backgroundColor = couleur;
    document.getElementById('urgenceMenu').classList.remove('open');
}

/* --- Dropdown sélecteur de Logiciel --- */
function toggleLogicielDropdown() {
    document.getElementById('logicielMenu').classList.toggle('open');
}

function selectLogiciel(id, nom) {
    const inputFormId = document.getElementById('id_logiciel_form');
    const inputFormName = document.getElementById('logiciel_form');
    
    if (inputFormId) inputFormId.value = id;
    if (inputFormName) inputFormName.value = nom;

    const label = document.getElementById('logicielLabel');
    if (label) label.innerText = nom;
    
    const menu = document.getElementById('logicielMenu');
    if (menu) menu.classList.remove('open');
}

// Fermeture globale automatique de tous les dropdowns actifs lors d'un clic en zone neutre
document.addEventListener('click', function(e) {
    const urgenceDropdown = document.getElementById('urgenceDropdown');
    if (urgenceDropdown && !urgenceDropdown.contains(e.target)) {
        document.getElementById('urgenceMenu').classList.remove('open');
    }

    const logicielDropdown = document.getElementById('logicielDropdown');
    if (logicielDropdown && !logicielDropdown.contains(e.target)) {
        const menu = document.getElementById('logicielMenu');
        if (menu) menu.classList.remove('open');
    }
});