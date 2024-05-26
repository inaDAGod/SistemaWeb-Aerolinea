<?php
session_start();

$creservanum = isset($_SESSION['creservanum']) ? $_SESSION['creservanum'] : 0;

// Parámetros de conexión
$host = 'localhost';
$dbname = 'aerolinea';
$username = 'postgres';
$password = 'admin';

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE reservas_personas SET estado_reserva = 'Confirmada' WHERE creserva = :creserva";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':creserva', $creservanum, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode(["message" => "Reserva confirmada exitosamente."]);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
