$(function() {
  $("#datepicker").datepicker({
      dateFormat: 'dd/mm/yy',
      changeMonth: true,
      changeYear: true
  });
});
$(document).ready(function() {
  $.ajax({
      url: 'http://localhost/SistemaWeb-Aerolinea/backend/agregarVuelo.php',
      type: 'GET',
      dataType: 'json',
      success: function(ciudades) {
          ciudades.forEach(function(ciudad) {
              $('#origen').append(new Option(ciudad, ciudad));
              $('#destino').append(new Option(ciudad, ciudad));
          });
      },
      error: function() {
          alert('Error cargando las ciudades');
      }
  });
});
$(document).ready(function() {
  $('#formAgregarVuelo').submit(function(e) {
      e.preventDefault(); // Evitar que el formulario se envíe de manera tradicional
      
      // Obtener valores del formulario
      var origen = $('#origen').val();
      var destino = $('#destino').val();
      var avion = $('#avion').val();
      var fecha_vuelo = $('#datepicker').val();
      var hora = $('#hora').val();
      var costo_vip = $('#costo_vip').val();
      var costo_business = $('#costo_business').val();
      var costo_economico = $('#costo_economico').val();

      // Validar que origen y destino no sean iguales
      if (origen === destino) {
          alert('El origen y el destino no pueden ser el mismo.');
          return; // Detener la ejecución si son iguales
      }

      // Preparar los datos para enviar al servidor
      var datos = {
          origen: origen,
          destino: destino,
          avion: avion,
          fecha_vuelo: fecha_vuelo,
          hora: hora,
          costo_vip: costo_vip,
          costo_business: costo_business,
          costo_economico: costo_economico
      };

      // Enviar datos mediante AJAX
      $.ajax({
          url: 'http://localhost/SistemaWeb-Aerolinea/backend/agregarVuelo.php',
          type: 'POST',
          data: JSON.stringify(datos),
          contentType: 'application/json', // Tipo de datos enviados
          dataType: 'json', // Tipo de datos esperados en la respuesta
          success: function(response) {
              if(response.success) {
                  alert('Vuelo agregado correctamente.');
                  location.reload(); // Recargar la página para ver los cambios
              } else {
                  alert('Error al agregar el vuelo: ' + response.error);
              }
          },
          error: function() {
              alert('Error al realizar la solicitud.');
          }
      });
  });
});
