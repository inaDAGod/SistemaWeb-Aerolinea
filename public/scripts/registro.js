function toggleForm() {
  var registroForm = document.getElementById('registro');
  var inicioSesionForm = document.getElementById('inicio-sesion');

  // Alternar la visibilidad de los formularios
  registroForm.style.display = (registroForm.style.display === 'none') ? 'block' : 'none';
  inicioSesionForm.style.display = (inicioSesionForm.style.display === 'none') ? 'block' : 'none';
}