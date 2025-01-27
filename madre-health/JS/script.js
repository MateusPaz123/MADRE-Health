window.onload = function() {
    // Gráfico de pizza para Pacientes
    const ctx1 = document.getElementById('pieChart1').getContext('2d');
    const pieChart1 = new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: ['Homens', 'Mulheres'],
            datasets: [{
                label: 'Distribuição de Pacientes',
                data: [100, 0],
                backgroundColor: ['#3498db', '#e74c3c'], // Cores das fatias
                borderColor: ['#2980b9', '#c0392b'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });

    // Gráfico de pizza para Tipo de Atendimento
    const ctx2 = document.getElementById('pieChart2').getContext('2d');
    const pieChart2 = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Particular', 'Convênio'],
            datasets: [{
                label: 'Distribuição de Atendimento',
                data: [100, 0],
                backgroundColor: ['#3498db', '#2ecc71'], // Cores das fatias
                borderColor: ['#2980b9', '#27ae60'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top'
                }
            }
        }
    });
};