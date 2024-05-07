function loginEncript() {
    let correo = document.getElementById("username").value;
    let contrasenia = document.getElementById("password").value;
    var hash = CryptoJS.MD5(contrasenia);
    if(correo  && contrasenia){
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
            alert('Ups algo salió mal. Inténtelo de nuevo más tarde.');
        }
    })
    .catch(error => {
        console.error('Error durante la solicitud de inicio de sesión:', error);
        alert('Ocurrió un error durante la solicitud de inicio de sesión. Inténtelo de nuevo más tarde.');
    });
    }
    else{
        alert('Llena los campos');
    }
}


function registrarUsuario() {
    let nombres = document.getElementById("nombre").value;
    let apellidos = document.getElementById("apellido").value;
    let correo = document.getElementById("email").value;
    let contrasenia = document.getElementById("contra").value;
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
                    alert('Ya existe un usuario con ese correo electrónico');
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
                alert('Estás seguro que no tienes una cuenta?');
            });
}

function generarCodigoVerificacion() {
    return Math.random().toString(36).substring(2, 8); // Generar un código alfanumérico de 6 caracteres
}

let codigo = null;
function mandarCorreoVerificacion() {
    toggleFormVeri(); 
    codigo = generarCodigoVerificacion();
    console.log("Código generado:", codigo);
    let correoDestinatario = document.getElementById("email").value;
    let correoEnviado = document.getElementById("correoEnviado");
    correoEnviado.textContent = correoDestinatario;

    let parametrosCorreo = {
        to_email: correoDestinatario,
        subject: "Verificación de correo electrónico",
        message: codigo
    };
    emailjs.init("zIi78GtT-tPurllpe");
    
    emailjs.send("service_pks7xqo", "template_kvr02gi", parametrosCorreo)
        .then(function(response) {
            console.log("Correo enviado exitosamente:", response);
        }, function(error) {
            console.error("Error al enviar correo:", error);
        });
}

function verificar(){
    let codIngresado = document.getElementById("codVeri").value;
    console.log(typeof codIngresado);
    console.log(typeof codigo);
    if(codIngresado == codigo){
        registrarUsuario();
    }
    else{
        alert('Revisa el codigo no coincide con el que se mando a tu correo');
    }
}

function verificarCampos(){
    let nombres = document.getElementById("nombre").value;
    let apellidos = document.getElementById("apellido").value;
    let correo = document.getElementById("email").value;
    let contrasenia = document.getElementById("contra").value;

    if(nombres && apellidos && correo && contrasenia){
        fetch("http://localhost/SistemaWeb-Aerolinea/backend/verificarExistencia.php", {
            method: "POST",
            body: JSON.stringify({username: correo }),
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Error en la solicitud');
        })
        .then(data => {
            if (data.estado === "cuenta_nueva") {
                if(contrasenia.length < 6){
                    alert('Contraseña muy corta, mínimo 6 caracteres');
                }
                else{
                    mandarCorreoVerificacion();
                }
            } else if (data.estado === "cuenta_existente") {
                alert('Ya existe una cuenta con ese correo');
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
            alert('Ya existe una cuenta con ese correo');
        });
    }
    else{
        alert('Completa todos los campos');
    }
}
function mandarCorreoRestauracion() {
    let correoDestinatario = document.getElementById("correoRestaurar").value;
    if(correoDestinatario){
        fetch("http://localhost/SistemaWeb-Aerolinea/backend/verificarCuenta.php", {
            method: "POST",
            body: JSON.stringify({username: correoDestinatario }),
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Error en la solicitud');
        })
        .then(data => {
            if (data.estado === "cuenta_inexistente") {
                alert('No hay una cuenta registrada a ese correo');
            } else if (data.estado === "cuenta_existente") {
                toggleFormRes3();
                let correoEnviado = document.getElementById("correoEnviado2");
                correoEnviado.textContent = correoDestinatario;
                codigo = generarCodigoVerificacion();
                console.log("Código generado:", codigo);
                let parametrosCorreo = {
                    to_email: correoDestinatario,
                    message: codigo
                };
                emailjs.init("zIi78GtT-tPurllpe");
                
                emailjs.send("service_pks7xqo", "template_cbqy3ke", parametrosCorreo)
                    .then(function(response) {
                        console.log("Correo enviado exitosamente:", response);
                    }, function(error) {
                        console.error("Error al enviar correo:", error);
                    });
            }
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
            alert('No hay una cuenta registrada a ese correo');
        });
    }
    else{
        alert('Llena el correo');
    }
}

function verificar2(){
    let codIngresado = document.getElementById("codRestauraciom").value;
    if(codIngresado == codigo){
        toggleFormRes2();
        let correoDestinatario = document.getElementById("correoRestaurar").value;
        let correoEnviado = document.getElementById("correoCambiar");
        correoEnviado.textContent = correoDestinatario;

    }
    else{
        alert('Revisa el codigo no coincide con el que se mando a tu correo');
    }
}


function newContra(){
    let contra1 = document.getElementById("passwordRes").value;
    let contra2 = document.getElementById("passwordRes2").value;
    let correo = document.getElementById("correoRestaurar").value;
    if(contra1 && contra2){
        if(contra1 == contra2){
            var hash = CryptoJS.MD5(contra1);
            fetch("http://localhost/SistemaWeb-Aerolinea/backend/updatePassword.php", {
                method: "POST",
                body: JSON.stringify({username: correo, newPassword:  hash.toString() }),
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Error en la solicitud');
            })
            .then(data => {
                if (data.estado === "contraseña_cambiada") {
                    alert('Se restauro tu contraseña');
                    window.location.href= 'http://localhost/SistemaWeb-Aerolinea/public/registro.html';
                } else if (data.estado === "error_actualizacion") {
                    alert('Parece que hubo un error');
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
                alert('Parece que hubo un error');
            });
        }
        else{
            alert('Las contraseña no coinciden');
        }
    }
    else{
        alert('Llena los campos');
    }
}