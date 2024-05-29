$(document).ready(function() {
    loadAllPassengers();

    $("#buscarBtn").click(function() {
        var documento = $("#numeroDocumento").val();
        var nombre = $("#nombre").val(); // Nuevo: obtener el valor del campo de nombre
        var apellido = $("#apellido").val(); // Nuevo: obtener el valor del campo de apellido
        if (!documento && !nombre && !apellido) {
            Swal.fire('Por favor ingrese un criterio de búsqueda.', 'error');
            return;
        }
  
        $.ajax({
            url: 'http://localhost/SistemaWeb-Aerolinea/backend/reservasAdmin.php',
            type: 'POST',
            data: { documento: documento, nombre: nombre, apellido: apellido }, // Nuevo: enviar nombre y apellido
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    Swal.fire('Por favor ingrese un criterio de búsqueda.', response.error, 'error');
                } else if (response.length === 0) {
                    Swal.fire('No se encontraron pasajeros con los criterios de búsqueda proporcionados.', 'error');
                } else {
                    updateTable(response);
                }
            },
            error: function(xhr, status, error) {
                Swal.fire('Error en ajax', xhr.responseText, 'error');
            }
        });
    });

    function loadAllPassengers() {
        $.ajax({
            url: 'http://localhost/SistemaWeb-Aerolinea/backend/reservasAdmin.php',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    Swal.fire('No se pudo cargar la lista de pasjeros correctamente', response.error, 'error');
                } else {
                    updateTable(response);
                }
            },
            error: function(xhr, status, error) {
                Swal.fire('Error en ajax', xhr.responseText, 'error');
            }
        });
    }

    function updateTable(data) {
        var tbody = $('table tbody');
        tbody.empty();
        data.forEach(function(item) {
            var row = `<tr>
                <td>${item.tipo_pasajero}</td>
                <td>${item.asiento}</td>
                <td>${item.tipo_asiento}</td>
                <td>${item.nombres}</td>
                <td>${item.apellidos}</td>
                <td>${item.documento}</td>
                <td>
                    <select class="btn btn-secondary dropdown-toggle" data-documento="${item.documento}">
                        <option class="dropdown-item" value="Pendiente" ${item.estado_reserva === "Pendiente" ? "selected" : ""}>Pendiente</option>
                        <option class="dropdown-item" value="Pagado" ${item.estado_reserva === "Pagado" ? "selected" : ""}>Pagado</option>
                        <option class="dropdown-item" value="Cancelado" ${item.estado_reserva === "Cancelado" ? "selected" : ""}>Cancelado</option>
                    </select>
                </td>
            </tr>`;
            tbody.append(row);
        });

        $('.estado-reserva-dropdown').change(function() {
            var documento = $(this).data('documento');
            var nuevoEstado = $(this).val();
            updateReservaStatus(documento, nuevoEstado);
        });
    }

    function updateReservaStatus(documento, nuevoEstado) {
        $.ajax({
            url: 'http://localhost/SistemaWeb-Aerolinea/backend/estado_reserva.php',
            type: 'POST',
            data: { documento: documento, estado: nuevoEstado },
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    Swal.fire('No se puede cambiar el estado', response.error, 'error');
                } else {
                    alert('Estado de reserva actualizado correctamente');
                }
            },
            error: function(xhr, status, error) {
                alert("Error en AJAX: " + error);
            }
        });
    }
    $("#mostrarTodosBtn").click(function() {
        // Limpiar los campos de búsqueda
        $("#numeroDocumento").val('');
        $("#nombre").val('');
        $("#apellido").val('');
    
        // Cargar todos los pasajeros
        loadAllPassengers();
    });
    
});
