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
                  $("#nombre").val(response.nombre);
                  $("#apellido").val(response.apellido);
                  $("#numeroDocumento").val(carnet);
                  $("#fechaVuelo").val(response.fechaVuelo.split("T")[0]); // ISO format to date
                  $("#horaVuelo").val(response.horaVuelo);
                  $("#origen").val(response.origen);
                  $("#destino").val(response.destino);
                  Swal.fire('Encontrado', 'El boleto ha sido encontrado.', 'success');
              } else {
                  resetFields(); // Llamar a la función que borra los campos
                  Swal.fire('No encontrado', response.message, 'error');
              }
          },
          error: function() {
              Swal.fire('Error', 'Hubo un problema al conectar con el servidor.', 'error');
          }
      });
  });

  function resetFields() {
      $("#nombre").val('');
      $("#apellido").val('');
      $("#numeroDocumento").val('');
      $("#fechaVuelo").val('');
      $("#horaVuelo").val('');
      $("#origen").val('');
      $("#destino").val('');
      // Desmarcar todos los checkboxes
      $("#equipajeMano").prop('checked', false);
      $("#maleta").prop('checked', false);
      $("#equipajeExtra").prop('checked', false);
  }

  // Validación de los campos antes de abrir el modal
  $("#formCheckin").submit(function(event) {
      event.preventDefault(); // Evita que el formulario se envíe automáticamente

      // Validar que todos los campos están completos
      var camposCompletos = $("#nombre").val() && $("#apellido").val() && $("#numeroDocumento").val() &&
          $("#fechaVuelo").val() && $("#horaVuelo").val() && $("#origen").val() && $("#destino").val() &&
          ($("#equipajeMano").is(':checked') || $("#maleta").is(':checked') || $("#equipajeExtra").is(':checked'));

      if (!camposCompletos) {
          Swal.fire('Error', 'Todos los campos deben estar completos y al menos un tipo de equipaje seleccionado.', 'error');
      } else {
          // Si todo está correcto, abrir el modal
          $("#emailModal").modal('show');
      }
  });

  // Manejar el envío del formulario del modal
  $("#emailForm").submit(function(event) {
      event.preventDefault();
      var email = $("#emailInput").val();
      if(email) {
          // Aquí puedes agregar la lógica para enviar el correo electrónico
          console.log("Enviar correo a", email);
          $("#emailModal").modal('hide');
          Swal.fire('Confirmado', 'Su check-in ha sido confirmado y su correo ha sido enviado.', 'success');
      }
  });
});
