document.addEventListener('DOMContentLoaded', function() {
    fetchVuelos(); // Mostrar todos los vuelos al cargar la página
    document.getElementById('buscar').addEventListener('click', fetchVuelos);
    document.getElementById('restablecer').addEventListener('click', resetFilters);

});
function fetchVuelos() {
    const origen = document.getElementById('origen').value.trim();
    const destino = document.getElementById('destino').value.trim();
    const fechaVueloIda = document.getElementById('fechaVueloIda').value.trim();

    fetch('http://localhost/SistemaWeb-Aerolinea/backend/fetch_vuelos.php')
        .then(response => response.json())
        .then(data => {
            let filteredData = data;
                if (origen) {
                    filteredData = filteredData.filter(vuelo =>
                        vuelo.origen.toLowerCase() === origen.toLowerCase()
                    );
                }
                if (destino) {
                    filteredData = filteredData.filter(vuelo =>
                        vuelo.destino.toLowerCase() === destino.toLowerCase()
                    );
                }
                if (fechaVueloIda) {
                    filteredData = filteredData.filter(vuelo =>
                        vuelo.fecha_vuelo.split(' ')[0] === fechaVueloIda
                    );
                }
           

            renderVuelos(filteredData);
        })
        .catch(error => console.error('Error:', error));
}




function renderVuelos(vuelos) {
    const tableContainer = document.getElementById('resultados');
    tableContainer.innerHTML = ''; // Limpiar cualquier contenido previo

    const table = document.createElement('table');
    table.className = 'table table-striped';

    const thead = document.createElement('thead');
    thead.innerHTML = `
        <tr>
            <th>Número de Vuelo</th>
            <th>Fecha de Vuelo</th>
            <th>Origen</th>
            <th>Destino</th>
            <th>Costo VIP</th>
            <th>Costo Económico</th>
            <th>Costo Business</th>
            <th>Acciones</th>
        </tr>
    `;
    table.appendChild(thead);

    const tbody = document.createElement('tbody');
    vuelos.forEach(vuelo => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${vuelo.cvuelo}</td>
            <td>${vuelo.fecha_vuelo}</td>
            <td>${vuelo.origen}</td>
            <td>${vuelo.destino}</td>
            <td>${vuelo.costovip}</td>
            <td>${vuelo.costoeco}</td>
            <td>${vuelo.costobusiness}</td>
            <td>
                <div class="btn-group" role="group">
                    <button class="btn btn-primary" onclick="window.location.href = 'admin_pasajeros.html';">Pasajeros</button>

                    <button class="btn btn-info" onclick="window.location.href = 'reservasAdmin.html';">Reservas</button>
                </div>
             </td>
        `;
        tbody.appendChild(row);
    });

    table.appendChild(tbody);
    tableContainer.appendChild(table);
}

function resetFilters() {
    document.getElementById('origen').value = '';
    document.getElementById('destino').value = '';
    document.getElementById('fechaVueloIda').value = '';

    fetchVuelos();
}

///////////////////para la disponibilidad de asientosa/////////////////////////////////////////////////////

function checkAvailability(cvuelo) {
    const adultoMayor = parseInt(document.getElementById('adultoMayor').value, 10);
    const adultos = parseInt(document.getElementById('adultos').value, 10);
    const ninos = parseInt(document.getElementById('ninos').value, 10);

    fetch(`http://localhost/SistemaWeb-Aerolinea/backend/fetch_vuelos.php?cvuelo=${cvuelo}&adultoMayor=${adultoMayor}&adultos=${adultos}&ninos=${ninos}`)
        .then(response => response.json())
        .then(data => {
            if (data.suficientes) {
                window.location.href = 'registro.html';
            } else {
                // Mostrar una alerta personalizada con SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...Lo sentimos',
                    text: 'No hay suficientes asientos disponibles para este vuelo.',
                });
            }
        })
        .catch(error => console.error('Error:', error));
}
