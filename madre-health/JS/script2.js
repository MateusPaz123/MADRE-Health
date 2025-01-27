 // Gráfico de colunas para pacientes recorrentes
 const ctxReturn = document.getElementById('barChartReturn').getContext('2d');
 const barChartReturn = new Chart(ctxReturn, {
     type: 'bar',
     data: {
         labels: ['Recorrentes'],
         datasets: [{
             label: 'Pacientes Recorrentes',
             data: [1],
             backgroundColor: '#2ecc71', // Cor da barra para pacientes recorrentes
             borderColor: '#27ae60',
             borderWidth: 1
         }]
     },
     options: {
         responsive: true,
         scales: {
             y: {
                 beginAtZero: true,
                 ticks: {
                     stepSize: 1
                 }
             }
         }
     }
 });