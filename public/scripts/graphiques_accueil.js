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