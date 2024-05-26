$("#buscarReservaBtn").click(function() {
    var carnet = $("#carnet").val();
    var numeroVuelo = $("#inputNumeroVuelo").val(); // Cambiado para usar el nuevo ID
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
                $("#numeroVuelo").val(numeroVuelo); // Asegúrate de que este es el ID del campo que debe ser llenado
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


function resetFields() {
    $("#nombre, #apellido, #numeroDocumento, #fechaVuelo, #horaVuelo, #origen, #destino").val('');
}
});
