$(document).ready(function() {
  $("#buscarBtn").click(function() {
      var documento = $("#numeroDocumento").val();
      if (!documento) {
          alert('Por favor ingrese un número de documento.');
          return;
      }

      $.ajax({
          url: 'http://localhost/SistemaWeb-Aerolinea/backend/reservasAdmin.php', // Asegúrate de que la ruta es correcta
          type: 'POST',
          contentType: 'application/json', // Especifica que el tipo de contenido enviado es JSON
          dataType: 'json', // Especifica que esperas una respuesta en formato JSON
          data: JSON.stringify({ documento: documento }), // Convierte el objeto de datos a una cadena JSON
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
              <td>${item.estado_reserva}</td>
          </tr>`;
          tbody.append(row);
      });
  }
});
