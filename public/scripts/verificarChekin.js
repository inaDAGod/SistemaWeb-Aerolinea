$(document).ready(function() {
  $("#buscarBoletoBtn").click(function() {
      var carnet = $("#carnet").val();
      var numeroVuelo = $("#numeroVuelo").val();

      if (!carnet || !numeroVuelo) {
          Swal.fire('Error', 'Debe ingresar tanto el carnet como el número de vuelo.', 'error');
          return;
      }

      $.ajax({
          url:  'http://localhost/SistemaWeb-Aerolinea/backend/verificarCheckin.php',
          type: 'POST',
          dataType: 'json',
          data: { carnet: carnet, numeroVuelo: numeroVuelo },
          success: function(response) {
              if (response.encontrado) {
                  $("#nombre").val(response.nombre);
                  $("#apellido").val(response.apellido);
                  $("#numeroDocumento").val(carnet);
                  $("#fechaVuelo").val(response.fechaVuelo.split("T")[0]); // ISO format to date
                  $("#horaVuelo").val(response.horaVuelo);
                  $("#origen").val(response.origen);
                  $("#destino").val(response.destino);
                  Swal.fire('Encontrado', 'El boleto ha sido encontrado.', 'success');
              } else {
                  Swal.fire('No encontrado', response.message, 'error');
              }
          },
          error: function() {
              Swal.fire('Error', 'Hubo un problema al conectar con el servidor.', 'error');
          }
      });
  });
});
