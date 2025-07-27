// Sidebar toggle functionality
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('open');
}

// Chart data
const participationData = {
    labels: ['Complété', 'En cours', 'Non commencé'],
    datasets: [{
        data: [20, 3, 1],
        backgroundColor: ['#8b44ff', '#3b82f6', '#06d6a0'],
        borderWidth: 0
    }]
};

const riskData = {
    labels: ['Faible', 'Moyen', 'Élevé', 'Critique'],
    datasets: [{
        data: [12, 8, 6, 2],
        backgroundColor: ['#06d6a0', '#ffd166', '#ef476f', '#8b44ff'],
        borderWidth: 0
    }]
};

const criticalityData = {
    labels: ['Bureau', 'Production', 'Maintenance', 'Logistique'],
    datasets: [{
        label: 'Criticité moyenne',
        data: [5.2, 8.7, 9.1, 6.8],
        backgroundColor: 'rgba(139, 68, 255, 0.6)',
        borderColor: '#8b44ff',
        borderWidth: 2,
        borderRadius: 4
    }]
};

// Chart options
const pieOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false
        },
        tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            titleColor: 'white',
            bodyColor: 'white',
            borderColor: 'rgba(139, 68, 255, 0.3)',
            borderWidth: 1
        }
    },
    animation: {
        duration: 800
    }
};

const barOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false
        },
        tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            titleColor: 'white',
            bodyColor: 'white',
            borderColor: 'rgba(139, 68, 255, 0.3)',
            borderWidth: 1
        }
    },
    scales: {
        x: {
            grid: {
                color: 'rgba(255, 255, 255, 0.1)'
            },
            ticks: {
                color: 'rgba(255, 255, 255, 0.6)'
            }
        },
        y: {
            grid: {
                color: 'rgba(255, 255, 255, 0.1)'
            },
            ticks: {
                color: 'rgba(255, 255, 255, 0.6)'
            }
        }
    },
    animation: {
        duration: 800
    }
};

// Initialize charts when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Wait a bit for layout to settle
    setTimeout(() => {
        initializeCharts();
    }, 100);
});

function initializeCharts() {
    try {
        // Participation Chart
        const participationCtx = document.getElementById('participationChart');
        if (participationCtx) {
            const ctx = participationCtx.getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: participationData,
                options: {
                    ...pieOptions,
                    cutout: '50%'
                }
            });
        }

        // Risk Chart
        const riskCtx = document.getElementById('riskChart');
        if (riskCtx) {
            const ctx = riskCtx.getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: riskData,
                options: {
                    ...pieOptions,
                    cutout: '50%'
                }
            });
        }

        // Criticality Chart
        const criticalityCtx = document.getElementById('criticalityChart');
        if (criticalityCtx) {
            const ctx = criticalityCtx.getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: criticalityData,
                options: barOptions
            });
        }

        // Create custom legends
        createLegend('participationLegend', participationData);
        createLegend('riskLegend', riskData);
    } catch (error) {
        console.error('Error initializing charts:', error);
    }
}

function createLegend(containerId, data) {
    const container = document.getElementById(containerId);
    if (!container) return;
    
    const legend = data.labels.map((label, index) => {
        const color = data.datasets[0].backgroundColor[index];
        const value = data.datasets[0].data[index];
        
        return `
            <div class="legend-item">
                <div class="legend-color" style="background-color: ${color}"></div>
                <span style="color: rgba(255, 255, 255, 0.8);">${label}</span>
                <span style="color: white; font-weight: 500;">${value}</span>
            </div>
        `;
    }).join('');
    
    container.innerHTML = legend;
}

// Add smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});
