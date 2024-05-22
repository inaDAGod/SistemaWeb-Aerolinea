function showAlert(message, type = 'danger') {
    var alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `;
    $('#alert-container').html(alertHtml);
}

$(document).ready(function() {
    // Función para cargar todos los pasajeros al cargar la página
    loadAllPassengers();

    $("#buscarBtn").click(function() {
        var documento = $("#numeroDocumento").val();
        var nombre = $("#nombre").val(); // Nuevo: obtener el valor del campo de nombre
        var apellido = $("#apellido").val(); // Nuevo: obtener el valor del campo de apellido

        if (!documento && !nombre && !apellido) {
            showAlert('Por favor ingrese un criterio de búsqueda.');
            return;
        }

        // Realizar una solicitud AJAX para buscar el pasajero por documento, nombre y apellido
        $.ajax({
            url: 'http://localhost/SistemaWeb-Aerolinea/backend/listar_pasajeros.php',
            type: 'POST',
            data: { documento: documento, nombre: nombre, apellido: apellido }, // Nuevo: enviar nombre y apellido
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    showAlert(response.error, 'danger');
                } else if (response.length === 0) {
                    showAlert("No se encontraron pasajeros con los criterios de búsqueda proporcionados.", 'warning');
                } else {
                    updateTable(response);
                }
            },
            error: function(xhr, status, error) {
                showAlert("Error en AJAX: " + xhr.responseText, 'danger');
            }
        });
    });

    // Función para cargar todos los pasajeros
    function loadAllPassengers() {
        $.ajax({
            url: 'http://localhost/SistemaWeb-Aerolinea/backend/listar_pasajeros.php',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    showAlert(response.error, 'danger');
                } else {
                    updateTable(response);
                }
            },
            error: function(xhr, status, error) {
                showAlert("Error en AJAX: " + xhr.responseText, 'danger');
            }
        });
    }

    function updateTable(data) {
        var tbody = $('table tbody');
        tbody.empty(); // Limpia la tabla antes de agregar nuevos datos
        data.forEach(function(item) {
            var row = `<tr>
                <td data-label="Tipo pasajero">${item.tipo_pasajero}</td>
                <td data-label="Asiento">${item.asiento}</td>
                <td data-label="Tipo Asiento">${item.tipo_asiento}</td>
                <td data-label="Nombres">${item.nombres}</td>
                <td data-label="Apellidos">${item.apellidos}</td>
                <td data-label="Documento" class="documento">${item.documento}</td>
                <td data-label="Estado Check-In">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="estadoCheckInDropdown${item.documento}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            ${item.estado_checkin}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="estadoCheckInDropdown${item.documento}">
                            <a class="dropdown-item" href="#" data-value="Pendiente">Pendiente</a>
                            <a class="dropdown-item" href="#" data-value="Realizado">Realizado</a>
                        </div>
                    </div>
                </td>
            </tr>`;
            tbody.append(row);
        });

        // Manejar el cambio de estado del combo box
        $('.dropdown-item').click(function() {
            var newStatus = $(this).attr('data-value');
            var documento = $(this).closest('tr').find('.documento').text(); // Obtener el documento del pasajero

            // Obtener el estado actual del check-in
            var estadoActual = $('#estadoCheckInDropdown' + documento).text().trim();

            // Verificar si el estado actual es "Realizado" y el nuevo estado es "Pendiente"
            if (estadoActual === "Realizado" && newStatus === "Pendiente") {
                showAlert("No se puede cambiar el estado a 'Pendiente' porque ya está 'Realizado'", 'warning');
                return; // Evitar enviar la solicitud AJAX
            }

            // Si no hay problemas con la validación, enviar la solicitud AJAX
            updateCheckInStatus(documento, newStatus);
        });
    }

    function updateCheckInStatus(documento, newStatus) {
        $.ajax({
            url: 'http://localhost/SistemaWeb-Aerolinea/backend/estado_checkin.php',
            type: 'POST',
            data: { documento: documento, estado: newStatus },
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    showAlert(response.error, 'danger');
                } else {
                    // Actualizar el texto del botón del combo box después de cambiar el estado
                    var dropdownButton = $('#estadoCheckInDropdown' + documento);
                    dropdownButton.text(newStatus);
                    showAlert("Estado de Check-In actualizado correctamente", 'success');
                }
            },
            error: function(xhr, status, error) {
                showAlert("Error en AJAX: " + xhr.responseText, 'danger');
            }
        });
    }
});
