$(document).ready(function() {
    // Función para cargar todos los pasajeros al cargar la página
    loadAllPassengers();

    $("#buscarBtn").click(function() {
        var documento = $("#numeroDocumento").val();
        if (!documento) {
            alert('Por favor ingrese un número de documento.');
            return;
        }
  
        // Realizar una solicitud AJAX para buscar el pasajero por documento
        $.ajax({
            url: 'http://localhost/SistemaWeb-Aerolinea/backend/listar_pasajeros.php',
            type: 'POST',
            data: { documento: documento }, // Enviar el documento directamente en el formulario POST
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                } else if (response.length === 0) {
                    alert("No hay reservas con el carnet introducido");
                } else {
                    updateTable(response);
                }
            },
            error: function(xhr, status, error) {
                alert("Error en AJAX: " + error);
            }
        });
    });
  
    // Función para cargar todos los pasajeros
    function loadAllPassengers() {
        $.ajax({
            url: 'http://localhost/SistemaWeb-Aerolinea/backend/listar_pasajeros.php',
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
        tbody.empty(); // Limpia la tabla antes de agregar nuevos datos
        data.forEach(function(item) {
            var row = `<tr>
                <td>${item.tipo_pasajero}</td>
                <td>${item.asiento}</td>
                <td>${item.tipo_asiento}</td>
                <td>${item.nombres}</td>
                <td>${item.apellidos}</td>
                <td>${item.documento}</td>
                <td>${item.estado_checkin}</td>
            </tr>`;
            tbody.append(row);
        });
    }
});
