function guardarProducto(){
    let nombre = document.getElementById("premio").value;
    let millas = document.getElementById("millas").value;
    let destacado = document.querySelector('input[name="destacadosOption"]:checked').value;
    let tipoProducto = document.getElementById("tipo").value;
    let formData = new FormData();
    let nombre_archivo = document.getElementById("foto");
    if(nombre && millas && destacado && tipoProducto && nombre_archivo){
        if(destacado == 'destacado'){
            destacado = "true";
        }
        else{
            destacado = "false";
        }
        formData.append('premio', nombre);
        formData.append('millas', millas);
        formData.append('destacado', destacado);
        formData.append('tipoProducto', tipoProducto);
        formData.append('foto', nombre_archivo.files[0]); // Agregar el archivo al FormData
        fetch("http://localhost/SistemaWeb-Aerolinea/backend/addPremio.php", {
                method: "POST",
                body: formData, // Enviar el FormData en lugar de JSON.stringify()
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error('Error en la solicitud');
            })
            .then(data => {
                if (data.estado === "registro_exitoso") {
                    window.location.href= 'http://localhost/SistemaWeb-Aerolinea/public/addProducto.html';
                } else if (data.estado === "error_registro") {
                    alert('Ya se añadio un producto igual');
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
                alert('Parece que hubo un error en la solicitud vuelve a intentar mas tarde');
            });
    }
    else{
        alert('Llena todos los campos');
    }
}


