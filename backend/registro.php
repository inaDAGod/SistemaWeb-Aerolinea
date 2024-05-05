<?php
// Obtener los datos enviados desde JavaScript
$json = file_get_contents('php://input');
$data = json_decode($json);

$nombres = $data->nombres;
$apellidos = $data->apellidos;
$username = $data->username;
$password = $data->password;

// Generar un código de verificación único
$codigo_verificacion = generarCodigoVerificacion();

// Tu lógica para enviar el correo de verificación
$enviado = enviarCorreoVerificacion($username, $codigo_verificacion);

if (!$enviado) {
    $response = array('estado' => 'error_correo', 'mensaje' => 'Error al enviar el correo electrónico');
    echo json_encode($response);
    exit(); // Salir del script si no se pudo enviar el correo
}

// Almacenar el código de verificación en la base de datos
$conexion = pg_connect("dbname=aerolinea user=postgres password=admin");
if (!$conexion) {
    die("Error al conectar a la base de datos: " . pg_last_error());
}

// Insertar el código de verificación en la tabla de verificaciones_correo
$sql = "INSERT INTO verificaciones_correo (correo, codigo_verificacion, fecha_expiracion) VALUES ('$username', '$codigo_verificacion', NOW() + INTERVAL '1 DAY')";
$resultado = pg_query($conexion, $sql);

if (!$resultado) {
    $response = array('estado' => 'error_base_datos', 'mensaje' => 'Error al insertar el código de verificación en la base de datos');
    echo json_encode($response);
    exit(); // Salir del script si hubo un error en la base de datos
}

// Insertar el usuario en la tabla de usuarios
$sql = "INSERT INTO usuarios (correo_usuario, contraseña, nombres_usuario, apellidos_usuario, tipo_usuario, millas) VALUES ('$username', '$password', '$nombres', '$apellidos', 'cliente', 0)";
$resultado = pg_query($conexion, $sql);

if ($resultado) {
    $response = array('estado' => 'registro_exitoso');
    echo json_encode($response);
} else {
    $response = array('estado' => 'error_registro', 'mensaje' => 'Error al insertar el usuario en la base de datos');
    echo json_encode($response);
}

// Cerrar la conexión
pg_close($conexion);

// Función para generar un código de verificación único
function generarCodigoVerificacion() {
    return substr(md5(uniqid(rand(), true)), 0, 6); // Generar un hash MD5 único y truncarlo a 6 caracteres
}

// Función para enviar correo de verificación
function enviarCorreoVerificacion($destinatario, $codigo_verificacion) {
    $subject = "Verificación de correo electrónico";
    $message = "Tu código de verificación es: $codigo_verificacion";
    $headers = "From: danialee14@gmail.com" ;

    return mail($destinatario, $subject, $message, $headers);
}
?>
