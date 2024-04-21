function loginEncript(){
    let correo = document.getElementById("username").value;
    let contrasenia= document.getElementById("password").value;
    console.log("correo:", correo);
    console.log("contraseña:", contrasenia);
    var hash = CryptoJS.MD5(contrasenia);
    window.hash = hash;
    fetch("http://localhost/SistemaWeb-Aerolinea/public/login.php",{//promesa de q hay respuesta
        method:"POST",
        body:JSON.stringify({username:correo, password:hash.toString() }),
    }).then(res => {
        console.log(res);
        return res.json(); //promesa pueden retornar promesas
    }).then(res => {
        console.log(res);
    });
    
}