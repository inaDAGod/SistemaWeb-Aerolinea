<?php
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $username = $data->username;
    $password = $data->password;
    
    // Establecer la conexión con la base de datos
    $conexion = pg_connect("dbname=aerolinea user=postgres password=admin");
    if (!$conexion) {
        die("Error al conectar a la base de datos: " . pg_last_error());
    }
    
    // Consulta SQL para obtener la contraseña del usuario
    $sql = "SELECT contraseña FROM usuarios WHERE correo_usuario = '$username'";
    $resultado = pg_query($conexion, $sql);
    
    if ($resultado) {
        // Verificar si se encontró algún resultado
        if (pg_num_rows($resultado) > 0) {
            // Obtener la contraseña almacenada en la base de datos
            $fila = pg_fetch_assoc($resultado);
            $contraseñaBD = $fila['contraseña'];
            
            // Verificar si la contraseña coincide
            if ($password === $contraseñaBD) {
                // La contraseña coincide
                echo json_encode(["estado" => "contraseña_correcta"]);
            } else {
                // La contraseña no coincide
                echo json_encode(["estado" => "contraseña_incorrecta"]);
            }
        } else {
            // No se encontró ningún usuario con el correo electrónico proporcionado
            echo json_encode(["estado" => "usuario_no_encontrado"]);
        }
    } else {
        // Error en la consulta SQL
        echo json_encode(["estado" => "error_consulta"]);
    }
    
    // Cerrar la conexión con la base de datos
    pg_close($conexion);
?>