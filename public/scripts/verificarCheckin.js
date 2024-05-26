$(document).ready(function() {
    $("#buscarBoletoBtn").click(function() {
        var carnet = $("#carnet").val();
        var numeroVuelo = $("#numeroVuelo").val();
        if (!carnet || !numeroVuelo) {
            Swal.fire('Error', 'Debe ingresar tanto el carnet como el número de vuelo.', 'error');
            return;
        }
        $.ajax({
            url: 'http://localhost/SistemaWeb-Aerolinea/backend/verificarCheckin.php',
            type: 'POST',
            dataType: 'json',
            data: { carnet: carnet, numeroVuelo: numeroVuelo },
            success: function(response) {
                if (response.encontrado) {
                    // Actualizar los campos con los datos encontrados
                    $("#nombre").val(response.nombre);
                    $("#apellido").val(response.apellido);
                    $("#numeroDocumento").val(carnet);
                    $("#fechaVuelo").val(response.fechaVuelo);
                    $("#horaVuelo").val(response.horaVuelo);
                    $("#origen").val(response.origen);
                    $("#destino").val(response.destino);
                    Swal.fire('Encontrado', 'El boleto ha sido encontrado.', 'success');
                } else {
                    resetFields(); // Limpiar campos si no se encuentra el boleto
                    Swal.fire('No encontrado', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Hubo un problema al conectar con el servidor.', 'error');
            }
        });
    });

    // Función para limpiar los campos
    function resetFields() {
        $("#nombre, #apellido, #numeroDocumento, #fechaVuelo, #horaVuelo, #origen, #destino").val('');
        $("#equipajeMano, #maleta, #equipajeExtra").prop('checked', false);
    }

    // Validar y abrir modal para confirmar correo electrónico
    $("#formCheckin").submit(function(event) {
        event.preventDefault(); // Prevenir el envío normal del formulario
        // Validar que todos los campos y al menos un checkbox estén completos
        var isComplete = $("#nombre").val() && $("#apellido").val() && $("#numeroDocumento").val() &&
            $("#fechaVuelo").val() && $("#horaVuelo").val() && $("#origen").val() && $("#destino").val() &&
            ($("#equipajeMano").is(':checked') || $("#maleta").is(':checked') || $("#equipajeExtra").is(':checked'));

        if (!isComplete) {
            Swal.fire('Error', 'Por favor complete todos los campos y seleccione al menos una opción de equipaje.', 'error');
        } else {
            $("#emailModal").modal('show'); // Mostrar modal para confirmar correo electrónico
        }
    });

    // Manejar la confirmación del correo electrónico y enviar datos de check-in
    $("#emailForm").submit(function(event) {
        event.preventDefault(); // Prevenir el envío normal del formulario
        var email = $("#emailInput").val();
        if (email) {
            // Aquí se agregaría la lógica para realizar la llamada AJAX y actualizar la base de datos
            // Ejemplo de llamada AJAX para actualizar el check-in
            $.ajax({
                url: 'http://localhost/SistemaWeb-Aerolinea/backend/actualizarCheckin.php', // URL del PHP que maneja la actualización
                type: 'POST',
                data: {
                    email: email,
                    carnet: $("#carnet").val(),
                    numeroVuelo: $("#numeroVuelo").val(),
                    equipajeMano: $("#equipajeMano").is(':checked') ? true : false,
                    maleta: $("#maleta").is(':checked') ? true : false,
                    equipajeExtra: $("#equipajeExtra").is(':checked') ? true : false
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Check-in Confirmado', 'Su check-in ha sido realizado con éxito.', 'success');
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Hubo un problema al realizar el check-in.', 'error');
                }
            });
            $("#emailModal").modal('hide'); // Ocultar modal después de la operación
        }
    });
});
