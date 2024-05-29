<?php
session_start();

$creservanum = isset($_SESSION['creservanum']) ? $_SESSION['creservanum'] : 0;
$correo_usuario = isset($_SESSION['correo_usuario']) ? $_SESSION['correo_usuario'] : '';
// Parámetros de conexión
$host = 'localhost';
$dbname = 'aerolinea';
$username = 'postgres';
$password = 'admin';

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE reservas_personas SET estado_reserva = 'Pagado' WHERE creserva = :creserva";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':creserva', $creservanum, PDO::PARAM_INT);
    $stmt->execute();

    // Assuming creserva is the primary key and you want to return it after updating
    echo json_encode(["message" => "Reserva confirmada exitosamente.", "creserva" => $creservanum,"correo_usuario" => $correo_usuario]);

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>