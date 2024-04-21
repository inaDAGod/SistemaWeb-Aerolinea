<?php
// Obtener los datos enviados desde JavaScript
$json = file_get_contents('php://input');
$data = json_decode($json);

// Asignar los valores a variables
$nombres = $data->nombres;
$apellidos = $data->apellidos;
$username = $data->username;
$password = $data->password;

// Establecer la conexión con la base de datos PostgreSQL
$conexion = pg_connect("dbname=aerolinea user=postgres password=admin");
if (!$conexion) {
    die("Error al conectar a la base de datos: " . pg_last_error());
}

// Preparar la consulta SQL para insertar los datos en la tabla 'usuarios'
$sql = "INSERT INTO usuarios (correo_usuario, contraseña, nombres_usuario, apellidos_usuario, tipo_usuario, millas) VALUES ('$username', '$password', '$nombres', '$apellidos', 'cliente', 0)";
$resultado = pg_query($conexion, $sql);

// Verificar si la consulta fue exitosa
if ($resultado) {
    echo "Usuario registrado correctamente.";
} else {
    echo "Error al registrar el usuario: " . pg_last_error($conexion);
}

// Cerrar la conexión
pg_close($conexion);
?>
