document.addEventListener('DOMContentLoaded', function() {
    const tipoVuelo = document.getElementById('tipoVuelo');
    const fechaVueltaGroup = document.getElementById('fechaVueltaGroup');
    
    tipoVuelo.addEventListener('change', function() {
        if (tipoVuelo.value === 'Ida y Vuelta') {
            fechaVueltaGroup.style.display = 'block';
        } else {
            fechaVueltaGroup.style.display = 'none';
        }
    });
});

function buscarVuelos() {

    const origen = document.getElementById('origen').value;
    const destino = document.getElementById('destino').value;
    const fecha_vuelo = document.getElementById('fecha_vuelo').value;
    const adulto_mayor = document.getElementById('adulto_mayor').value;
    const adultos = document.getElementById('adultos').value;
    const ninos = document.getElementById('ninos').value;

   
}