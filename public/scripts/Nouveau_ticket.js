let allFiles = [];
const fileInput = document.getElementById("fichier");
const listConteneur = document.getElementById("liste-fichiers");

// Définition de la taille maximale par fichier (5 Mo = 5 * 1024 * 1024 octets)
const MAX_FILE_SIZE = 5 * 1024 * 1024; 

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
            <div class="file-icon-pdf">PDF</div>
            <div class="file-item-info">
                <span class="file-item-name">${file.name}</span>
                <span class="file-item-size">${fileSizeKB} KB</span>
            </div>
            <button type="button" class="remove-file" data-index="${index}" aria-label="Supprimer le fichier">✕</button>
        `;

        listConteneur.appendChild(item);
    });
}

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