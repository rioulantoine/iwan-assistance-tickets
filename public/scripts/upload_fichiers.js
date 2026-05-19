let allFiles = [];
const fileInput = document.getElementById("fichier");
const listConteneur = document.getElementById("liste-fichiers");

        fileInput.addEventListener("change", function(e) {
            const newFiles = Array.from(e.target.files);

            allFiles = allFiles.concat(newFiles);

            syncInputAndRender();
        });

        function syncInputAndRender() {
            const dataTransfer = new DataTransfer();
            allFiles.forEach((file) => dataTransfer.items.add(file));
            fileInput.files = dataTransfer.files;

            listConteneur.innerHTML = "";

            allFiles.forEach((file, index) => {
                const item = document.createElement("div");
                item.className = "file-item";

                item.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
        <span>${file.name}</span>
        <span class="remove-file" data-index="${index}" style="margin-left: 10px; color: #e15252; cursor: pointer; font-weight: bold;">✕</span>
      `;

                listConteneur.appendChild(item);
            });
        }

        listConteneur.addEventListener("click", function(e) {
            if (e.target.classList.contains("remove-file")) {
                const indexToRemove = parseInt(e.target.getAttribute("data-index"));
                allFiles.splice(indexToRemove, 1);
                syncInputAndRender();
            }
        });
