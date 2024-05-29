
    $(document).ready(function() {
        // Mostrar el spinner al inicio
        $('#loading-spinner').show();
        $('#tablaSesion').hide();

        // Realiza una solicitud AJAX para obtener los datos de sesión
        $.ajax({
            url: 'http://localhost/SistemaWeb-Aerolinea/backend/obtener_datos_sesion.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                // Ocultar el spinner
                $('#loading-spinner').hide();

                // Construye la tabla con los datos recibidos
                var tabla = '<table class="table table-striped">' +
                                '<thead>' +
                                    '<tr>' +
                                        '<th>Tipo Persona</th>' +
                                        '<th>Cantidad</th>' +
                                        '<th>Total</th>' +
                                    '</tr>' +
                                '</thead>' +
                                '<tbody>' +
                                    '<tr>' +
                                        '<td>Adulto mayor</td>' +
                                        '<td>' + data.adum + '</td>' +
                                        '<td></td>' +
                                    '</tr>' +
                                    '<tr>' +
                                        '<td>Adultos</td>' +
                                        '<td>' + data.adu + '</td>' +
                                        '<td></td>' +
                                    '</tr>' +
                                    '<tr>' +
                                        '<td>Niños</td>' +
                                        '<td>' + data.nin + '</td>' +
                                        '<td></td>' +
                                    '</tr>' +
                                    '<tr>' +
                                        '<td></td>' +
                                        '<td></td>' +
                                        '<td>' + data.total_people + '</td>' +
                                    '</tr>' +
                                '</tbody>' +
                            '</table>';

                // Agrega la tabla al contenedor y mostrarla
                $('#tablaSesion').html(tabla).show();
            },
            error: function() {
                // Maneja el caso de error y ocultar el spinner
                $('#loading-spinner').hide();
                $('#tablaSesion').html('<p class="text-danger">Error al cargar los datos de sesión.</p>').show();
            }
        });
    });

