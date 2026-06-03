// public/scripts/Details_ticket.js

/**
 * Génère un SVG épuré adapté au type de fichier
 */
function obtenirSvgParExtension(nomFichier) {
    const extension = nomFichier.split('.').pop().toLowerCase();

    // Palette de couleurs 
    const couleurs = {
        pdf: '#E44D26', image: '#2AA9E0', word: '#2B579A',   
        excel: '#1E7145', zip: '#F39C12', default: '#7F8C8D'  
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

document.addEventListener('DOMContentLoaded', () => {

    /* ICÔNES SVG POUR LES FICHIERS EXISTANTS */
    const existingIcons = document.querySelectorAll('.existing-file-icon');
    existingIcons.forEach(container => {
        const filename = container.getAttribute('data-filename');
        if (filename) {
            container.innerHTML = obtenirSvgParExtension(filename);
        }
    });

    /* GESTION DES RÉPONSES AUX TICKETS */
    const replyButtons = document.querySelectorAll('.btn-reply-to'); 
    const idParentInput = document.getElementById('id_parent_input');
    const replyContextBox = document.getElementById('reply-context'); 
    const replyContextText = document.getElementById('reply-context-text'); 
    const cancelReplyBtn = document.getElementById('cancel-reply');
    const formSection = document.getElementById('formulaire-reponse');

    if (replyButtons.length > 0) {
        replyButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const idReponse = this.getAttribute('data-id');
                const titreReponse = this.getAttribute('data-titre');

                if (idParentInput && replyContextBox && replyContextText && formSection) {
                    idParentInput.value = idReponse;
                    replyContextText.textContent = `En réponse à "${titreReponse}"`;
                    replyContextBox.style.display = 'flex';
                    formSection.scrollIntoView({ behavior: 'smooth' });
                    
                    const titleInput = document.querySelector('.reply-form input[name="titre"]'); 
                    if(titleInput) titleInput.focus();
                }
            });
        });
    }

    if(cancelReplyBtn) {
        cancelReplyBtn.addEventListener('click', () => {
            if (idParentInput && replyContextBox) {
                idParentInput.value = ''; 
                replyContextBox.style.display = 'none'; 
            }
        });
    }

    /* GESTION DE L'UPLOAD DE NOUVEAUX FICHIERS  */
    let allFiles = [];
    const fileInput = document.getElementById("fichier");
    const listConteneur = document.getElementById("liste-fichiers");

    if (fileInput && listConteneur) {

        fileInput.addEventListener('change', (event) => {
            const files = Array.from(event.target.files);
            allFiles = allFiles.concat(files);
            syncInputAndRender();
        });


        listConteneur.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-file')) {
                const index = parseInt(e.target.getAttribute('data-index'), 10);
                allFiles.splice(index, 1);
                syncInputAndRender();
            }
        });


        function syncInputAndRender() {
            const dataTransfer = new DataTransfer();
            allFiles.forEach((file) => dataTransfer.items.add(file));
            fileInput.files = dataTransfer.files; 

            listConteneur.innerHTML = "";

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
                    <button type="button" class="remove-file remove-file-btn" data-index="${index}" aria-label="Supprimer le fichier">✕</button>
                `;

                listConteneur.appendChild(item);
            });
            const textarea = document.querySelector('.textarea-wrapper textarea');
    const actionsBox = document.querySelector('.textarea-actions');
    
    if (textarea && actionsBox) {
        // 1. On mesure la hauteur réelle de la zone contenant les fichiers et le bouton
        const actionsHeight = actionsBox.offsetHeight;
        
        // 2. On pousse le "fond" (padding) du textarea vers le bas pour ne pas cacher le texte
        // (actionsHeight + 15 pixels de marge de sécurité)
        textarea.style.paddingBottom = (actionsHeight + 15) + 'px';
        
        // 3. On "simule" une frappe au clavier pour forcer l'auto-resize qu'on a codé tout à l'heure !
        textarea.dispatchEvent(new Event('input'));
    }
        }
    }
});


// resize du textarea de réponse pour s'adapter au contenu
const textareas = document.querySelectorAll('.textarea-wrapper textarea');

    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto'; 
            this.style.height = (this.scrollHeight + 20) + 'px'; 
        });
    });