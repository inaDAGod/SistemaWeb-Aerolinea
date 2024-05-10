$(document).ready(function() {
    loadAllPassengers();

    $("#buscarBtn").click(function() {
        var documento = $("#numeroDocumento").val();
        if (!documento) {
            alert('Por favor ingrese un número de documento.');
            return;
        }
  
        $.ajax({
            url: 'http://localhost/SistemaWeb-Aerolinea/backend/reservasAdmin.php',
            type: 'POST',
            contentType: 'application/json',
            dataType: 'json',
            data: JSON.stringify({ documento: documento }),
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                } else if (response.length === 0) {
                    alert("No hay reservas con el documento introducido");
                } else {
                    updateTable(response);
                }
            },
            error: function(xhr, status, error) {
                alert("Error en AJAX: " + error);
            }
        });
    });

    function loadAllPassengers() {
        $.ajax({
            url: 'http://localhost/SistemaWeb-Aerolinea/backend/reservasAdmin.php',
            type: 'POST',
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                } else {
                    updateTable(response);
                }
            },
            error: function(xhr, status, error) {
                alert("Error en AJAX: " + error);
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
                    <select class="estado-reserva-dropdown" data-documento="${item.documento}">
                        <option value="Pendiente" ${item.estado_reserva === "Pendiente" ? "selected" : ""}>Pendiente</option>
                        <option value="Pagado" ${item.estado_reserva === "Pagado" ? "selected" : ""}>Pagado</option>
                        <option value="Cancelado" ${item.estado_reserva === "Cancelado" ? "selected" : ""}>Cancelado</option>
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
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                } else {
                    alert('Estado de reserva actualizado correctamente');
                }
            },
            error: function(xhr, status, error) {
                alert("Error en AJAX: " + error);
            }
        });
    }
});
