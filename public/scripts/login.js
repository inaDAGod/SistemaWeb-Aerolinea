function loginEncript() {
  let correo = document.getElementById("username").value;
  let contrasenia = document.getElementById("password").value;
  var hash = CryptoJS.MD5(contrasenia);

  fetch("http://localhost/SistemaWeb-Aerolinea/backend/login.php", {
      method: "POST",
      body: JSON.stringify({ username: correo, password: hash.toString() }),
  })
  .then(response => {
      if (!response.ok) {
          throw new Error('Error en la solicitud de inicio de sesión');
      }
      return response.json();
  })
  .then(data => {
      if (data.estado === 'contraseña_correcta') {
          window.location.href= 'http://localhost/SistemaWeb-Aerolinea/public/index.html';
      } else if (data.estado === 'contraseña_incorrecta') {
          alert('La contraseña ingresada es incorrecta');
      } else if (data.estado === 'usuario_no_encontrado') {
          alert('No se encontró ningún usuario con ese correo electrónico');
      } else {
          alert('Ups algo salio mal. Inténtelo de nuevo más tarde.');
      }
  })
  .catch(error => {
      console.error('Error durante la solicitud de inicio de sesión:', error);
      alert('Ocurrió un error durante la solicitud de inicio de sesión. Inténtelo de nuevo más tarde.');
  });
}


function registrarUsuario() {
  let nombres = document.getElementById("nombre").value;
  let apellidos = document.getElementById("apellido").value;
  let correo = document.getElementById("email").value;
  let contrasenia = document.getElementById("contra").value;

  if (contrasenia.length < 6) {
      alert('Contraseña muy corta, mínimo 6 caracteres');
  } else {
      if (nombres && apellidos && correo && contrasenia) {
          var hash = CryptoJS.MD5(contrasenia);
          fetch("http://localhost/SistemaWeb-Aerolinea/backend/registro.php", {
              method: "POST",
              body: JSON.stringify({ nombres: nombres, apellidos: apellidos, username: correo, password: hash.toString() }),
          })
          .then(response => {
              if (response.ok) {
                  return response.json();
              }
              throw new Error('Error en la solicitud');
          })
          .then(data => {
              if (data.estado === "registro_exitoso") {
                  window.location.href= 'http://localhost/SistemaWeb-Aerolinea/public/index.html';
              } else if (data.estado === "error_registro") {
                  alert('Ya existe un usuario con esa contraseña');
              }
          })
          .catch(error => {
              console.error('Error en la solicitud:', error);
              alert('Estas seguro que no tienes una cuenta?');
          });
      } else {
          alert('Llene todos los campos');
      }
  }
}