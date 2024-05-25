// mostrar_datos.js
function mostrarDatosVueloEnPagina() {
    const datosVuelo = JSON.parse(localStorage.getItem('datosVuelo'));
    if (datosVuelo) {
        getVuelo(datosVuelo.cvuelo, function(datosDetalleVuelo) {
            document.getElementById('cvuelo').textContent = datosVuelo.cvuelo;
            document.getElementById('adum').textContent = datosVuelo.adum;
            document.getElementById('adu').textContent = datosVuelo.adu;
            document.getElementById('nin').textContent = datosVuelo.nin;
            document.getElementById('correo_usuario').textContent = datosVuelo.correo_usuario;
            document.getElementById('fecha_reserva').textContent = datosVuelo.fecha_reserva;
            document.getElementById('fecha_limite').textContent = datosVuelo.fecha_limite;
            document.getElementById('origen').textContent = datosDetalleVuelo.origen;
            document.getElementById('destino').textContent = datosDetalleVuelo.destino;
        });
    } else {
        alert("No se han ingresado datos de vuelo.");
    }
}
