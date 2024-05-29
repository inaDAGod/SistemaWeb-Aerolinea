$(document).ready(function() {
    $.ajax({
        url: 'http://localhost/SistemaWeb-Aerolinea/backend/cargar_vuelo.php', // Reemplaza 'ruta_al_archivo_php.php' con la ruta correcta a tu archivo PHP
        type: 'GET', // Puedes usar 'GET' o 'POST' según la configuración de tu servidor
        success: function(response) {
            // Inserta el contenido recibido en el elemento con id 'contenido'
            $('#contenido').html(response);
        },
        error: function() {
            // Maneja el caso de error
            $('#contenido').html('<p>Error al cargar el contenido.</p>');
        }
    });
});



document.getElementById('eliminar-reserva-btn').addEventListener('click', function() {
    fetch('http://localhost/SistemaWeb-Aerolinea/backend/eliminar_reserva.php', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert("Error: " + data.error);
        } else {
            alert(data.message);
            window.location.href = 'indexCliente.html';
        }
    })
    .catch(error => {
        console.error('Error eliminando reserva:', error);
    });
});