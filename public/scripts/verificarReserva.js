$(document).ready(function() {
    $("#buscarReservaBtn").click(function() {
        var carnet = $("#carnet").val();
        var numeroVuelo = $("#inputNumeroVuelo").val(); // Asegúrate de usar el ID correcto
        if (!carnet || !numeroVuelo) {
            Swal.fire('Error', 'Debe ingresar tanto el carnet como el número de vuelo.', 'error');
            return;
        }
        $.ajax({
            url: 'http://localhost/SistemaWeb-Aerolinea/backend/verificarReserva.php',
            type: 'POST',
            dataType: 'json',
            data: { carnet: carnet, numeroVuelo: numeroVuelo },
            success: function(response) {
                if (response.encontrado) {
                    $("#nombre").val(response.nombre);
                    $("#apellido").val(response.apellido);
                    $("#numeroDocumento").val(response.numeroDocumento);
                    $("#fechaVuelo").val(response.fechaVuelo);
                    $("#horaVuelo").val(response.horaVuelo);
                    $("#origen").val(response.origen);
                    $("#destino").val(response.destino);
                    $("#numeroVuelo").val(numeroVuelo);
                    Swal.fire('Reserva Encontrada', 'La reserva ha sido encontrada y está pagada.', 'success');
                } else {
                    resetFields();
                    Swal.fire('No encontrada', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Hubo un problema al conectar con el servidor.', 'error');
            }
        });
    });

    function resetFields() {
        $("#nombre, #apellido, #numeroDocumento, #fechaVuelo, #horaVuelo, #origen, #destino, #numeroVuelo").val('');
    }

    // Maneja el evento de submit para el botón "Generar Boletos"
    $("#formCheckin").submit(function(event) {
        event.preventDefault(); // Previene el envío automático del formulario

        // Verifica si todos los campos requeridos están llenos
        var isComplete = $("#nombre").val() && $("#apellido").val() && $("#numeroDocumento").val() &&
                         $("#fechaVuelo").val() && $("#horaVuelo").val() && $("#origen").val() && $("#destino").val() &&
                         $("#numeroVuelo").val();

        if (!isComplete) {
            Swal.fire('Error', 'Por favor complete todos los campos antes de generar los boletos.', 'error');
        } else {
            // Si todos los campos están llenos, muestra el modal
            $("#emailModal").modal('show');
        }
    });

    // Maneja el envío del formulario dentro del modal
    $("#emailForm").submit(function(event) {
        event.preventDefault();
        var email = $("#emailInput").val();
        if (email) {
            // Aquí puedes añadir código para manejar la lógica de envío de datos, como una solicitud AJAX
            $("#emailModal").modal('hide'); // Cierra el modal
            Swal.fire('Confirmado', 'El correo ha sido enviado y los boletos generados.', 'success');

            // Aquí podrías incluir el código para enviar el formulario principal, si es necesario
            // Por ejemplo:
            // $("#formCheckin").unbind('submit').submit(); // Desvincula este manejador y envía el formulario
        }
    });
});
