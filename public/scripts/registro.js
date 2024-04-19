function toggleForm() {
  var registroForm = document.getElementById('registro');
  var inicioSesionForm = document.getElementById('inicio-sesion');

  // Verificar si el formulario de registro está visible
  if (registroForm.style.display === 'block') {
    // Si está visible, ocultarlo y mostrar el formulario de inicio de sesión
    registroForm.style.display = 'none';
    inicioSesionForm.style.display = 'block';
  } else {
    // Si no está visible, mostrar el formulario de registro y ocultar el formulario de inicio de sesión
    registroForm.style.display = 'block';
    inicioSesionForm.style.display = 'none';
  }
}