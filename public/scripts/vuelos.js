document.addEventListener('DOMContentLoaded', function() {
    fetchVuelos(); // Show all 
    document.getElementById('buscar').addEventListener('click', fetchVuelos);
    document.getElementById('restablecer').addEventListener('click', resetFilters);
    const tipoVuelo = document.getElementById('tipoVuelo');
    const fechaVueltaGroup = document.getElementById('fechaVueltaGroup');
    
    tipoVuelo.addEventListener('change', function() {
        if (tipoVuelo.value === 'Ida y Vuelta') {
            fechaVueltaGroup.style.display = 'block';
        } else {
            fechaVueltaGroup.style.display = 'none';
        }
        fetchVuelos(); 
    });
});

function fetchVuelos() {
    const origen = document.getElementById('origen').value.trim();
    const destino = document.getElementById('destino').value.trim();
    const tipoVuelo = document.getElementById('tipoVuelo').value.trim();
    const fechaVueloIda = document.getElementById('fechaVueloIda').value.trim();
    const fechaVueloVuelta = document.getElementById('fechaVueloVuelta').value.trim();

    // validation 
    if (origen === destino && origen !== "") {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'El origen y el destino no pueden ser iguales. Por favor, seleccione un destino diferente.',
            confirmButtonText: 'Aceptar'
        });
        return; 
    }

    fetch('http://localhost/SistemaWeb-Aerolinea/backend/fetch_vuelos.php')
        .then(response => response.json())
        .then(data => {
            let filteredData = data;

            if (tipoVuelo === 'Ida') {
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
            } else if (tipoVuelo === 'Ida y Vuelta') {
                if (origen) {
                    filteredData = filteredData.filter(vuelo =>
                        vuelo.origen.toLowerCase() === origen.toLowerCase() ||
                        vuelo.destino.toLowerCase() === origen.toLowerCase()
                    );
                }
                if (destino) {
                    filteredData = filteredData.filter(vuelo =>
                        vuelo.destino.toLowerCase() === destino.toLowerCase() ||
                        vuelo.origen.toLowerCase() === destino.toLowerCase()
                    );
                }
                let filteredData2 = filteredData;
                if (fechaVueloIda) {
                    filteredData2 = filteredData.filter(vuelo =>
                        vuelo.origen.toLowerCase() === origen.toLowerCase() &&
                        vuelo.fecha_vuelo.split(' ')[0] === fechaVueloIda
                    );
                }
                if (fechaVueloVuelta) {
                    filteredData = filteredData.filter(vuelo =>
                        vuelo.destino.toLowerCase() === origen.toLowerCase() &&
                        vuelo.fecha_vuelo.split(' ')[0] === fechaVueloVuelta
                    );
                }
                filteredData = filteredData.concat(filteredData2);
            }

            renderVuelos(filteredData);
        })
        .catch(error => console.error('Error:', error));
}

function renderVuelos(vuelos) {
    const tableContainer = document.getElementById('resultados');
    tableContainer.innerHTML = ''; // Limpiar

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
            <td><button class="btn btn-primary" onclick="window.location.href = 'registro.html';">Reservar</button></td>
        `;
        tbody.appendChild(row);
    });

    table.appendChild(tbody);
    tableContainer.appendChild(table);
}

function resetFilters() {
    document.getElementById('origen').value = '';
    document.getElementById('destino').value = '';
    document.getElementById('tipoVuelo').value = 'Ida';
    document.getElementById('fechaVueloIda').value = '';
    document.getElementById('fechaVueloVuelta').value = '';
    document.getElementById('adultoMayor').value = '0';
    document.getElementById('adultos').value = '1';
    document.getElementById('ninos').value = '0';
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
                alert('No hay suficientes asientos disponibles para este vuelo.');
            }
        })
        .catch(error => console.error('Error:', error));
}