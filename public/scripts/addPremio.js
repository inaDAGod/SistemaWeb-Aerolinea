function guardarProducto() {
    let nombre = document.getElementById("premio");
    let millas = document.getElementById("millas");
    let destacado = document.querySelector('input[name="destacadosOption"]:checked');
    let tipoProducto = document.getElementById("tipo");
    let foto = document.getElementById("foto");

    if (nombre.checkValidity() && millas.checkValidity() && destacado && tipoProducto.checkValidity() && foto.checkValidity()) {
        let formData = new FormData();
        let nombre_archivo = document.getElementById("foto");

        if (destacado.value == 'destacado') {
            destacado = "true";
        } else {
            destacado = "false";
        }
        formData.append('premio', nombre.value);
        formData.append('millas', millas.value);
        formData.append('destacado', destacado);
        formData.append('tipoProducto', tipoProducto.value);
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
                    window.location.href = 'http://localhost/SistemaWeb-Aerolinea/public/addProducto.html';
                } else if (data.estado === "error_registro") {
                    alert('Ya se añadió un producto igual');
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
                alert('Parece que hubo un error en la solicitud. Vuelve a intentar más tarde.');
            });
    } else {
        // Agregar clases de Bootstrap para mostrar los estilos de validación incorrecta
        if (!nombre.checkValidity()) {
            nombre.classList.add('is-invalid');
        } else {
            nombre.classList.remove('is-invalid');
            nombre.classList.add('is-valid');
        }

        if (!millas.checkValidity()) {
            millas.classList.add('is-invalid');
        } else {
            millas.classList.remove('is-invalid');
            millas.classList.add('is-valid');
        }

        if (!destacado) {
            document.querySelector('.radio-group').classList.add('is-invalid');
        } else {
            document.querySelector('.radio-group').classList.remove('is-invalid');
        }

        if (!tipoProducto.checkValidity()) {
            tipoProducto.classList.add('is-invalid');
        } else {
            tipoProducto.classList.remove('is-invalid');
            tipoProducto.classList.add('is-valid');
        }

        if (!foto.checkValidity()) {
            foto.classList.add('is-invalid');
        } else {
            foto.classList.remove('is-invalid');
            foto.classList.add('is-valid');
        }
    }
}