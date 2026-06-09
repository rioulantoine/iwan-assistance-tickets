// public/scripts/graphiques_accueil.js

document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('radarChart');
    if (!canvas) return;

    const ctxRadar = canvas.getContext('2d');
    // dégradé de couleurs
    let gradientFill = ctxRadar.createLinearGradient(0, 0, 0, 350);
    gradientFill.addColorStop(0, 'rgba(196, 235, 236, 0.8)');
    gradientFill.addColorStop(1, 'rgba(196, 235, 236, 0.1)');

    new Chart(ctxRadar, {
        type: 'radar',
        data: {
            labels: radarLabels, // lecture des données
            datasets: [{
                label: 'Tickets',
                data: radarValues,   
                backgroundColor: gradientFill,
                borderColor: '#438a8e',
                borderWidth: 2,
                pointBackgroundColor: '#438a8e',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                r: {
                    min: 0, // Force le centre à 0
                    angleLines: { color: '#e2e8f0' },
                    grid: { color: '#e2e8f0' },
                    pointLabels: { 
                        font: { size: 14, weight: 'bold', family: "'Segoe UI', sans-serif" }, 
                        color: '#334155' 
                    },
                    ticks: { display: false }
                }
            }
        }
    });
});

// ==========================================
    // DIAGRAMME EN BARRES (Tickets par semaine)
    // ==========================================
    const canvasBar = document.getElementById('barChart');
    if (canvasBar) {
        const ctxBar = canvasBar.getContext('2d');
        
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: barLabels, // Les jours depuis PHP
                datasets: [{
                    label: 'Tickets résolus',
                    data: barValues, // Les chiffres depuis PHP
                    backgroundColor: '#cde2d8', 
                    borderRadius: 2,            
                    borderWidth: 0,
                    barPercentage: 0.6          // Épaisseur des barres
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false } // Cache la légende
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9',    
                            drawBorder: false    
                        },
                        ticks: {
                                precision: 0,       // Force des nombres entiers uniquement (pas de virgule)
                                stepSize: 1,        // Force un écart de 1 entre chaque graduation (0, 1, 2, 3...)
                                color: '#64748b',
                                font: { family: "'Segoe UI', sans-serif" }
                        }
                    },
                    x: {
                        grid: {
                            display: false,      
                            drawBorder: false    
                        },
                        ticks: {
                            color: '#64748b',
                            font: { family: "'Segoe UI', sans-serif" }
                        }
                    }
                }
            }
        });
    }