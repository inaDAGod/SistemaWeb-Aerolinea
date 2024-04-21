function loginEncript(){
    let correo = document.getElementById("username").value;
    let contrasenia= document.getElementById("password").value;
    console.log("correo:", correo);
    console.log("contraseña:", contrasenia);
    var hash = CryptoJS.MD5(contrasenia);
    fetch("http://localhost/SistemaWeb-Aerolinea/backend/login.php",{//promesa de q hay respuesta
        method:"POST",
        body:JSON.stringify({username:correo, password:hash.toString() }),
    });
    
}

function registrarUsuario() {
    let nombres = document.getElementById("nombre").value;
    let apellidos = document.getElementById("apellido").value;
    let correo = document.getElementById("email").value;
    let contrasenia = document.getElementById("contra").value;
    if (nombres && apellidos && correo && contrasenia) {
        var hash = CryptoJS.MD5(contrasenia);
        fetch("http://localhost/SistemaWeb-Aerolinea/backend/registro.php",{//promesa de q hay respuesta
        method:"POST",
        body:JSON.stringify({nombres:nombres, apellidos:apellidos, username:correo, password:hash.toString() }),
    })
    } else {
        alert('Llene todos los campos');
        
    }
}