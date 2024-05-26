<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'conexion.php';

$correo_usuario = 'andrea.fernandez.l@ucb.edu.bo';
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

$cvuelosnum = 2; // Por ejemplo, puedes cambiar este valor según tus necesidades

$_SESSION['cvuelosnum'] = $cvuelosnum;
$_SESSION['creservanum'] = $creservanum;
$_SESSION['reservation_counter'] = 0;
?>
