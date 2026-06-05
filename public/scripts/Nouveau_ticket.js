let allFiles = [];
const fileInput = document.getElementById("fichier");
const listConteneur = document.getElementById("liste-fichiers");

// Définition de la taille maximale par fichier (5 Mo = 5 * 1024 * 1024 octets)
const MAX_FILE_SIZE = 5 * 1024 * 1024; 

/**
 * Génère un SVG épuré adapté au type de fichier
 * @param {string} nomFichier - Le nom complet du fichier
 * @return {string} Le code HTML du SVG
 */
function obtenirSvgParExtension(nomFichier) {
    const extension = nomFichier.split('.').pop().toLowerCase();

    // Palette de couleurs 
    const couleurs = {
        pdf: '#E44D26',    
        image: '#2AA9E0',  
        word: '#2B579A',   
        excel: '#1E7145',  
        zip: '#F39C12',    
        default: '#7F8C8D'  
    };

    // PDF
    if (extension === 'pdf') {
        return `
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="32" height="32" rx="6" fill="${couleurs.pdf}"/>
            <text x="16" y="18" text-anchor="middle" fill="white" font-size="8" font-family="Arial, sans-serif" font-weight="bold">PDF</text>
        </svg>`;
    }

    // IMAGES
    if (['png', 'jpg', 'jpeg', 'gif', 'svg', 'webp','heic'].includes(extension)) {
        return `
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="32" height="32" rx="6" fill="${couleurs.image}"/>
            <circle cx="12" cy="13" r="2.5" fill="white"/>
            <path d="M24 22H8V19L12 14L16 18L20 13L24 18V22Z" fill="white"/>
        </svg>`;
    }

    // DOCUMENTS WORD
    if (['doc', 'docx'].includes(extension)) {
        return `
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="32" height="32" rx="6" fill="${couleurs.word}"/>
            <path d="M9 11H12.5L14 17L15.5 11H19L20.5 17L22 11H25.5L23 21H19.5L18 15L16.5 21H13L9 11Z" fill="white"/>
        </svg>`;
    }

    // FEUILLES EXCEL / SPREADSHEETS
    if (['xls', 'xlsx', 'csv'].includes(extension)) {
        return `
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="32" height="32" rx="6" fill="${couleurs.excel}"/>
            <path d="M11 11H14.5L16 14.5L17.5 11H21L18.5 16L21.5 21H18L16 17.5L14 21H10.5L13.5 16L11 11Z" fill="white"/>
        </svg>`;
    }

    // ARCHIVES COMPRESSÉES
    if (['zip', 'rar', '7z'].includes(extension)) {
        return `
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="32" height="32" rx="6" fill="${couleurs.zip}"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M14 9H18V11H16V13H18V15H16V17H18V19H14V17H16V15H14V13H16V11H14V9ZM14 19H18V23H14V19Z" fill="white"/>
        </svg>`;
    }

    // SQUELETTE PAR DÉFAUT
    return `
    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="32" height="32" rx="6" fill="${couleurs.default}"/>
        <path d="M12 11H17V13H12V11ZM12 15H20V17H12V15ZM12 19H20V21H12V19Z" fill="white"/>
    </svg>`;
}

// Écouteur pour gérer l'ajout de fichiers
fileInput.addEventListener("change", function(e) {
    const newFiles = Array.from(e.target.files);
    
    newFiles.forEach(file => {
        if (file.size > MAX_FILE_SIZE) {
            alert(`Le fichier "${file.name}" est trop gros ! La taille maximale autorisée est de 5 Mo.`);
        } else {
            allFiles.push(file);
        }
    });

    syncInputAndRender();
});

// Fonction pour synchroniser le tableau allFiles avec l'input et mettre à jour l'affichage
function syncInputAndRender() {
    const dataTransfer = new DataTransfer();
    allFiles.forEach((file) => dataTransfer.items.add(file));
    fileInput.files = dataTransfer.files;

    listConteneur.innerHTML = "";

    allFiles.forEach((file, index) => {
        const item = document.createElement("div");
        item.className = "file-item-card";

        const fileSizeKB = Math.round(file.size / 1024);

        // Intégration du module obtenirSvgParExtension à la place du texte statique PDF
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

// Écouteur pour gérer la suppression d'un fichier
listConteneur.addEventListener("click", function(e) {
    const removeBtn = e.target.closest(".remove-file");
    
    if (removeBtn) {
        const indexToRemove = parseInt(removeBtn.getAttribute("data-index"));
        
        allFiles.splice(indexToRemove, 1);
        
        syncInputAndRender();
    }
});

   // Fonction pour ouvrir la fenêtre pop-up information niveau d'urgence
function ouvrirModalUrgence() {
    const modal = document.getElementById('modalUrgence');
    modal.style.display = 'flex';
}

// Fonction pour fermer la fenêtre si on clique à l'extérieur de la boîte blanche
function fermerModalUrgence(event) {
    const modal = document.getElementById('modalUrgence');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
}

// Fonction pour ouvrir la fenêtre pop-up liste des entreprises
function ouvrirModalListeEntreprises(){
    const modal = document.getElementById('modalListeEntreprises');
            modal.style.display = 'flex';
}

// Fonction pour fermer la fenêtre si on clique à l'extérieur de la boite blanche
function fermerModalListeEntreprises(event){
    const modal = document.getElementById('modalListeEntreprises');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
}



// resize automatique des textarea
const textareas = document.querySelectorAll('.textarea-wrapper textarea, #description');

textareas.forEach(textarea => {
    const resizeTextarea = function() {
        this.style.height = 'auto'; 
        this.style.height = (this.scrollHeight + 20) + 'px'; 
    };
    textarea.addEventListener('input', resizeTextarea);
        resizeTextarea.call(textarea);
    });