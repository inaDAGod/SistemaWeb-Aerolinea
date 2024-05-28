<?php
include 'conexion.php';

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Print session data before setting new variables

// Define new session variables
$cvuelosnum = 2;
$correo_usuario = isset($_SESSION['correo_usuario']) ? $_SESSION['correo_usuario'] : '';
$fecha_reserva = '2024-06-25'; // Puedes cambiar esta fecha según sea necesario
$fecha_lmite = '2024-06-27'; // Puedes cambiar esta fecha según sea necesario

function generar_numero_reserva($conn, $correo_usuario, $fecha_reserva, $fecha_lmite) {
    // Preparar la consulta SQL para insertar en la tabla 'reservas'
    $query = "INSERT INTO reservas (correo_usuario, fecha_reserva, fecha_lmite) VALUES (:correo_usuario, :fecha_reserva, :fecha_lmite)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':correo_usuario', $correo_usuario);
    $stmt->bindParam(':fecha_reserva', $fecha_reserva);
    $stmt->bindParam(':fecha_lmite', $fecha_lmite);
    $stmt->execute();

    // Obtener el ID de la reserva creada
    return $conn->lastInsertId();
}

$creservanum = generar_numero_reserva($conn, $correo_usuario, $fecha_reserva, $fecha_lmite);
$reservation_counter = 0;

// Define and set additional session variables
$adum = 1;
$adu = 1;
$nin = 0;
$totalg = $adum + $adu + $nin;

$_SESSION['adum'] = $adum;
$_SESSION['adu'] = $adu;
$_SESSION['nin'] = $nin;
$_SESSION['total_people'] = $totalg;
$_SESSION['cvuelosnum'] = $cvuelosnum;
$_SESSION['creservanum'] = $creservanum;
$_SESSION['reservation_counter'] = $reservation_counter;
$_SESSION['correo_usuario'] = $correo_usuario;


?>
