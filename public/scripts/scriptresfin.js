document.addEventListener('DOMContentLoaded', function() {
    // Fetch and display vuelo info
    fetch('http://localhost/SistemaWeb-Aerolinea/backend/get_vuelo.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const vueloInfo = document.getElementById('vuelo-info');
            if (data.error) {
                vueloInfo.innerText = "Error: " + data.error;
            } else {
                vueloInfo.innerHTML = `Vuelo: ${data.cvuelo}<br>Origen: ${data.origen}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Destino: ${data.destino}<br>`;
            }
        })
        .catch(error => {
            console.error('Error fetching vuelo data:', error);
        });

    // Fetch and display reservas info
    fetch('http://localhost/SistemaWeb-Aerolinea/backend/get_reserva.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const tableBody = document.querySelector('#reservas-table tbody');
            if (data.error) {
                tableBody.innerHTML = `<tr><td colspan="6">Error: ${data.error}</td></tr>`;
            } else {
                data.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.classList.add('trre');
                    tr.innerHTML = `
                        <td class='tdre' style='padding: 8px;'>${row.tipo_persona}</td>
                        <td class='tdre' style='padding: 8px;'>${row.nombre}</td>
                        <td class='tdre' style='padding: 8px;'>${row.apellido}</td>
                        <td class='tdre' style='padding: 8px;'>${row.ci_persona}</td>
                        <td class='tdre' style='padding: 8px;'>${row.fecha_nacimiento}</td>
                        <td class='tdre' style='padding: 8px;'>${row.asiento}</td>
                    `;
                    tableBody.appendChild(tr);
                });
            }
        })
        .catch(error => {
            console.error('Error fetching reserva data:', error);
        });

    // Confirm reservation
   // Confirm reservation
document.getElementById('confirmar-reserva-form').addEventListener('submit', function(event) {
    event.preventDefault();
    
    fetch('http://localhost/SistemaWeb-Aerolinea/backend/confirmar_reserva.php', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            console.error('Error confirming reserva:', data.error);
        } else {
            Swal.fire({
                title: '¡Reserva confirmada!',
                text: `Reserva confirmada exitosamente. Código de reserva: ${data.creserva}`, // Displaying the creserva value
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    programaMillas(data.correo_usuario);
                    window.location.href = 'indexCliente.html';
                    
                }
            });
        }
    })
    .catch(error => {
        console.error('Error confirming reserva:', error);
    });
});


    // Delete reservation
    document.getElementById('eliminar-reserva-btn').addEventListener('click', function() {
        fetch('http://localhost/SistemaWeb-Aerolinea/backend/eliminar_reserva2.php', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert("Error: " + data.error);
            } else {
                Swal.fire({
                    title: '¡Reserva eliminada!',
                    text: data.message,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.html';
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error eliminando reserva:', error);
        });
    });
});
