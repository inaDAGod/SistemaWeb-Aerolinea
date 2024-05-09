<?php

function agregarUsuario($datos) {
    // Conectar a la base de datos
    $conexion = pg_connect("dbname=aerolinea user=postgres password=admin");
    if (!$conexion) {
        die("Error al conectar a la base de datos: " . pg_last_error());
    }

    // Obtener datos del formulario
    $nombres = $datos->nombres;
    $apellidos = $datos->apellidos;
    $correo = $datos->correo;
    $contrasena = $datos->contrasena;

    // Consulta SQL para agregar usuario
    $sql = "INSERT INTO usuarios (correo_usuario, contraseña, nombres_usuario, apellidos_usuario, tipo_usuario, millas) VALUES ('$correo', '$contrasena', '$nombres', '$apellidos', 'cliente', 0)";
    $resultado = pg_query($conexion, $sql);

    if ($resultado) {
        $response = array('estado' => 'registro_exitoso');
        echo json_encode($response);
    } else {
        $response = array('estado' => 'error_registro');
        echo json_encode($response);
    }

    // Cerrar la conexión
    pg_close($conexion);
}

// Función para eliminar un usuario
function eliminarUsuario($datos) {
    // Conectar a la base de datos
    $conexion = pg_connect("dbname=aerolinea user=postgres password=admin");
    if (!$conexion) {
        die("Error al conectar a la base de datos: " . pg_last_error());
    }

    // Obtener datos del formulario
    $correoUsuario = $datos->correo_usuario;

    // Consulta SQL para eliminar usuario específico
    $sql = "DELETE FROM usuarios WHERE correo_usuario = '$correoUsuario'";
    $resultado = pg_query($conexion, $sql);

    if ($resultado) {
        $response = array('estado' => 'eliminacion_exitosa');
        echo json_encode($response);
    } else {
        $response = array('estado' => 'error_eliminar');
        echo json_encode($response);
    }

    // Cerrar la conexión
    pg_close($conexion);
}

// Función para modificar un usuario
function modificarUsuario($datos) {
    // Conectar a la base de datos
    $conexion = pg_connect("dbname=aerolinea user=postgres password=admin");
    if (!$conexion) {
        die("Error al conectar a la base de datos: " . pg_last_error());
    }

    // Obtener datos del formulario
    $correoUsuario = $datos->correo_usuario;
    // Aquí deberías obtener los demás datos del usuario que se van a modificar

    // Consulta SQL para modificar usuario
    // Esto es solo un ejemplo, necesitarás ajustarlo según tu estructura de base de datos y qué campos quieres modificar
    $sql = "UPDATE usuarios SET nombres_usuario = '$nuevosNombres', apellidos_usuario = '$nuevosApellidos' WHERE correo_usuario = '$correoUsuario'";
    $resultado = pg_query($conexion, $sql);

    if ($resultado) {
        $response = array('estado' => 'modificacion_exitosa');
        echo json_encode($response);
    } else {
        $response = array('estado' => 'error_modificacion');
        echo json_encode($response);
    }

    // Cerrar la conexión
    pg_close($conexion);
}


// Acción principal
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $datos = json_decode(file_get_contents("php://input"));

    switch ($action) {
        case 'agregar':
            agregarUsuario($datos);
            break;
        case 'eliminar':
            eliminarUsuario($datos);
            break;
        case 'modificar':
            modificarUsuario($datos);
        default:
            // Acción no válida
            break;
    }
}
?>
