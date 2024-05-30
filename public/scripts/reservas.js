document.addEventListener('DOMContentLoaded', function() {
    const cvuelo = localStorage.getItem('cvuelo');
    const adultos = localStorage.getItem('adultos');
    const adultoMayor = localStorage.getItem('adultoMayor');
    const ninos = localStorage.getItem('ninos');
    
    console.log(localStorage);

    // Aquí puedes usar estos datos para mostrar la información en la página o para completar el formulario
    document.getElementById('vueloSeleccionado').innerText = cvuelo;
    document.getElementById('adultosSeleccionados').innerText = adultos;
    document.getElementById('adultoMayorSeleccionados').innerText = adultoMayor;
    document.getElementById('ninosSeleccionados').innerText = ninos;


 // Create the table using the retrieved data
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
         '<td>' + adultoMayor + '</td>' +
         '<td></td>' +
     '</tr>' +
     '<tr>' +
         '<td>Adultos</td>' +
         '<td>' + adultos + '</td>' +
         '<td></td>' +
     '</tr>' +
     '<tr>' +
         '<td>Niños</td>' +
         '<td>' + ninos + '</td>' +
         '<td></td>' +
     '</tr>' +
     '<tr>' +
         '<td></td>' +
         '<td></td>' +
         '<td>' + (parseInt(adultos) + parseInt(adultoMayor) + parseInt(ninos)) + '</td>' +
     '</tr>' +
 '</tbody>' +
'</table>';

// Insert the table into the HTML
document.getElementById('resumenVuelo').innerHTML = tabla;

    // Enviar datos a PHP
    const data = {
        cvuelo: cvuelo,
        adultos: adultos,
        adultoMayor: adultoMayor,
        ninos: ninos
    };

    fetch('http://localhost/SistemaWeb-Aerolinea/backend/test_session.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
});



