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
});
