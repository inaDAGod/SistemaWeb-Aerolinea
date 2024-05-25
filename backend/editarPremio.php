<?php
// Verificar si se han recibido datos por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos del formulario
    $premio = $_POST['premio'];
    $millas = $_POST['millas'];
    $destacado = $_POST['producto_destacado'] === 'true' ? 'true' : 'false';
    $tipo_premio = $_POST['tipo_premio'];

    // Verificar si se ha enviado una foto
    if ($_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        // Procesar la foto
        $nombre_archivo = pg_escape_string($_FILES['foto']['name']);
        $ruta_temporal = $_FILES['foto']['tmp_name'];
        $ruta_destino = "../public/assets/" . $nombre_archivo;
        $src_foto = "/SistemaWeb-Aerolinea/public/assets/".$nombre_archivo;

        // Mover la foto a su ubicación final
        if (move_uploaded_file($ruta_temporal, $ruta_destino)) {
            // Conectar a la base de datos
            $conexion = pg_connect("dbname=aerolinea user=postgres password=admin");
            if (!$conexion) {
                die("Error al conectar a la base de datos: " . pg_last_error());
            }

            // Actualizar los datos en la base de datos con la nueva foto
            $sql = "UPDATE premios_millas SET premio = '$premio', millas = $millas, tipo_premio = '$tipo_premio', producto_destacado = $destacado, src_foto = '$src_foto' WHERE premio = '$premio'";
            $resultado = pg_query($conexion, $sql);

            if ($resultado) {
                $response = array('estado' => 'actualizacion_exitosa');
                echo json_encode($response);
            } else {
                $response = array('estado' => 'error_actualizacion', 'mensaje' => 'Error al actualizar los datos en la base de datos.');
                echo json_encode($response);
            }

            // Cerrar la conexión
            pg_close($conexion);
        } else {
            // Error al mover la foto
            $response = array('estado' => 'error_archivo', 'mensaje' => 'Error al mover la foto.');
            echo json_encode($response);
        }
    } else {
        // No se ha enviado una foto, actualizar solo los datos
        // Conectar a la base de datos
        $conexion = pg_connect("dbname=aerolinea user=postgres password=admin");
        if (!$conexion) {
            die("Error al conectar a la base de datos: " . pg_last_error());
        }

        // Actualizar los datos en la base de datos sin cambiar la foto
        $sql = "UPDATE premios_millas SET premio = '$premio', millas = $millas, tipo_premio = '$tipo_premio', producto_destacado = $destacado WHERE premio = '$premio'";
        $resultado = pg_query($conexion, $sql);

        if ($resultado) {
            $response = array('estado' => 'actualizacion_exitosa');
            echo json_encode($response);
        } else {
            $response = array('estado' => 'error_actualizacion', 'mensaje' => 'Error al actualizar los datos en la base de datos.');
            echo json_encode($response);
        }

        // Cerrar la conexión
        pg_close($conexion);
    }
} else {
    // Error: no se han recibido datos por POST
    $response = array('estado' => 'error_no_post', 'mensaje' => 'No se han recibido datos por POST.');
    echo json_encode($response);
}
?>
