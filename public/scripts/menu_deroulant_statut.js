document.addEventListener('DOMContentLoaded', function () {
    //Récupération des éléments dans la page
    const container = document.querySelector('.status-dropdown-container');
    const btn = document.getElementById('statusDropdownBtn');
    const menu = document.getElementById('statusDropdownMenu');

    // On vérifie que le bouton et le menu existent sur cet écran
    if (btn && container && menu) {
        
        // Clic sur le bouton SVG
        btn.addEventListener('click', function (e) {
            e.stopPropagation(); // Empêche le clic de se propager ailleurs
            
            // Si le menu est caché, on l'affiche, sinon on le masque
            if (menu.style.display === 'none' || menu.style.display === '') {
                menu.style.display = 'block';
                container.classList.add('open');
            } else {
                menu.style.display = 'none';
                container.classList.remove('open');
            }
        });

        //Fermeture si on clique n'importe où ailleurs sur la page
        document.addEventListener('click', function (e) {
            if (!container.contains(e.target)) {
                menu.style.display = 'none';
                container.classList.remove('open');
            }
        });
    }
});
document.addEventListener('DOMContentLoaded', function() {
            //Récupération des éléments dans la page
            const container = document.querySelector('.urgence-dropdown-container');
            const btn = document.getElementById('urgenceDropdownBtn');
            const menu = document.getElementById('urgenceDropdownMenu');
            
            // On vérifie que le bouton et le menu existent sur cet écran
            if (btn && container && menu) {

                // Clic sur le bouton SVG
                btn.addEventListener('click', function(e) {
                e.stopPropagation(); // Empêche le clic de se propager ailleurs

                // Si le menu est caché, on l'affiche, sinon on le masque
                if (menu.style.display === 'none' || menu.style.display === '') {
                        menu.style.display = 'block';
                        container.classList.add('open');
                } else {
                        menu.style.display = 'none';
                        container.classList.remove('open');
                    }
                });

                //Fermeture si on clique n'importe où ailleurs sur la page
                document.addEventListener('click', function(e) {
                if (!container.contains(e.target)) {
                        menu.style.display = 'none';
                        container.classList.remove('open');
                    }
                });
            }
});

document.addEventListener('DOMContentLoaded', function() {
    const btnSuivi = document.getElementById('typeSuiviDropdownBtn');
    const menuSuivi = document.getElementById('typeSuiviDropdownMenu');

    if (!btnSuivi || !menuSuivi) return;

    // Ouverture / Fermeture
    btnSuivi.addEventListener('click', function(e) {
        e.stopPropagation(); 
        const isVisible = menuSuivi.style.display === 'block';
        menuSuivi.style.display = isVisible ? 'none' : 'block';
    });

    // Fermeture si clic à l'extérieur
    document.addEventListener('click', function(e) {
        if (!menuSuivi.contains(e.target) && e.target !== btnSuivi) {
            menuSuivi.style.display = 'none';
        }
    });
});