let allFiles = [];
const fileInput = document.getElementById("fichier");
const listConteneur = document.getElementById("liste-fichiers");

// Définition de la taille maximale par fichier (5 Mo = 5 * 1024 * 1024 octets)
const MAX_FILE_SIZE = 5 * 1024 * 1024; 

/**
 * Génère un SVG épuré adapté au type de fichier
 */
function obtenirSvgParExtension(nomFichier) {
    const extension = nomFichier.split('.').pop().toLowerCase();
    const couleurs = {
        pdf: '#E44D26',    
        image: '#2AA9E0',  
        word: '#2B579A',   
        excel: '#1E7145',  
        zip: '#F39C12',    
        default: '#7F8C8D'  
    };

    if (extension === 'pdf') {
        return `<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="32" height="32" rx="6" fill="${couleurs.pdf}"/><text x="16" y="18" text-anchor="middle" fill="white" font-size="8" font-family="Arial, sans-serif" font-weight="bold">PDF</text></svg>`;
    }
    if (['png', 'jpg', 'jpeg', 'gif', 'svg', 'webp','heic'].includes(extension)) {
        return `<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="32" height="32" rx="6" fill="${couleurs.image}"/><circle cx="12" cy="13" r="2.5" fill="white"/><path d="M24 22H8V19L12 14L16 18L20 13L24 18V22Z" fill="white"/></svg>`;
    }
    if (['doc', 'docx'].includes(extension)) {
        return `<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="32" height="32" rx="6" fill="${couleurs.word}"/><path d="M9 11H12.5L14 17L15.5 11H19L20.5 17L22 11H25.5L23 21H19.5L18 15L16.5 21H13L9 11Z" fill="white"/></svg>`;
    }
    if (['xls', 'xlsx', 'csv'].includes(extension)) {
        return `<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="32" height="32" rx="6" fill="${couleurs.excel}"/><path d="M11 11H14.5L16 14.5L17.5 11H21L18.5 16L21.5 21H18L16 17.5L14 21H10.5L13.5 16L11 11Z" fill="white"/></svg>`;
    }
    if (['zip', 'rar', '7z'].includes(extension)) {
        return `<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="32" height="32" rx="6" fill="${couleurs.zip}"/><path fill-rule="evenodd" clip-rule="evenodd" d="M14 9H18V11H16V13H18V15H16V17H18V19H14V17H16V15H14V13H16V11H14V9ZM14 19H18V23H14V19Z" fill="white"/></svg>`;
    }
    return `<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="32" height="32" rx="6" fill="${couleurs.default}"/><path d="M12 11H17V13H12V11ZM12 15H20V17H12V15ZM12 19H20V21H12V19Z" fill="white"/></svg>`;
}

if (fileInput) {
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
}

function syncInputAndRender() {
    if (!listConteneur || !fileInput) return;
    const dataTransfer = new DataTransfer();
    allFiles.forEach((file) => dataTransfer.items.add(file));
    fileInput.files = dataTransfer.files;

    listConteneur.innerHTML = "";
    allFiles.forEach((file, index) => {
        const item = document.createElement("div");
        item.className = "file-item-card";
        const fileSizeKB = Math.round(file.size / 1024);

        item.innerHTML = `
            <div class="file-icon-wrapper">${obtenirSvgParExtension(file.name)}</div>
            <div class="file-item-info">
                <span class="file-item-name">${file.name}</span>
                <span class="file-item-size">${fileSizeKB} KB</span>
            </div>
            <button type="button" class="remove-file" data-index="${index}" aria-label="Supprimer le fichier">✕</button>
        `;
        listConteneur.appendChild(item);
    });
}

if (listConteneur) {
    listConteneur.addEventListener("click", function(e) {
        const removeBtn = e.target.closest(".remove-file");
        if (removeBtn) {
            const indexToRemove = parseInt(removeBtn.getAttribute("data-index"));
            allFiles.splice(indexToRemove, 1);
            syncInputAndRender();
        }
    });
}

function ouvrirModalUrgence() {
    document.getElementById('modalUrgence').style.display = 'flex';
}

function fermerModalUrgence(event) {
    const modal = document.getElementById('modalUrgence');
    if (event.target === modal) modal.style.display = 'none';
}

function ouvrirModalListeEntreprises(){
    document.getElementById('modalListeEntreprises').style.display = 'flex';
}

function fermerModalListeEntreprises(event){
    const modal = document.getElementById('modalListeEntreprises');
    if (event.target === modal) modal.style.display = 'none';
}


// ==========================================================================
// REDIMENSIONNEMENT DES TEXTAREAS  (TICKET & SUIVI)
// ==========================================================================
function ajusterHauteurTextarea(el) {
    el.style.height = 'auto';
    el.style.height = el.scrollHeight + 'px';
}

// On attend que le DOM soit totalement prêt pour cibler les éléments
document.addEventListener("DOMContentLoaded", function() {
    const zonesTexte = document.querySelectorAll('textarea');

    zonesTexte.forEach(textarea => {
        // Ajustement à la saisie
        textarea.addEventListener('input', function() {
            ajusterHauteurTextarea(this);
        });
        
        // Ajustement immédiat si la zone contient déjà du texte
        ajusterHauteurTextarea(textarea);
    });
});