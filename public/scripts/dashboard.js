// Este script se encargará de obtener los datos de PHP y crear el gráfico con Chart.js

// Obtiene los datos de PHP
fetch('http://localhost/SistemaWeb-Aerolinea/backend/get_data.php')
  .then(response => {
    if (!response.ok) {
      throw new Error('Error al obtener los datos del servidor');
    }
    return response.json();
  })
  .then(data => {
    // Procesa los datos
    const labels = data.map(entry => entry.ciudad);
    const valores = data.map(entry => entry.cantidad_vuelos);

    // Crea el gráfico
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Cantidad de Vuelos',
          data: valores,
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  })
  .catch(error => {
    console.error('Error:', error.message);
    // Aquí puedes manejar el error, como mostrar un mensaje al usuario
  });
