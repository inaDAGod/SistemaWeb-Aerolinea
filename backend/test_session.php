<?php
include 'conexion.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$adum = 0;
$adu = 1;
$nin = 0;
$totalg = $adum + $adu + $nin;

$cvuelosnum = 2;
$correo_usuario = isset($_SESSION['correo_usuario']) ? $_SESSION['correo_usuario'] : '';
$fecha_reserva = '2024-05-25';
$fecha_lmite = '2024-05-30';

function generar_numero_reserva($conn, $correo_usuario, $fecha_reserva, $fecha_lmite) {
    $query = "INSERT INTO reservas (correo_usuario, fecha_reserva, fecha_lmite) VALUES (:correo_usuario, :fecha_reserva, :fecha_lmite)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':correo_usuario', $correo_usuario);
    $stmt->bindParam(':fecha_reserva', $fecha_reserva);
    $stmt->bindParam(':fecha_lmite', $fecha_lmite);
    $stmt->execute();

    return $conn->lastInsertId();
}

$creservanum = generar_numero_reserva($conn, $correo_usuario, $fecha_reserva, $fecha_lmite);
$reservation_counter = 0;



$_SESSION['adum'] = $adum;
$_SESSION['adu'] = $adu;
$_SESSION['nin'] = $nin;
$_SESSION['total_people'] = $totalg;
$_SESSION['cvuelosnum'] = $cvuelosnum;
$_SESSION['creservanum'] = $creservanum;
$_SESSION['reservation_counter'] = $reservation_counter;
$_SESSION['correo_usuario'] = $correo_usuario;

?>
