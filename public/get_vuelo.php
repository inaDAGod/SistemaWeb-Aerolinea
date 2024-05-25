<?php
$host = 'localhost'; // Cambia esto
$dbname = 'aerolinea';
$username = 'postgres'; // Cambia esto
$password = 'admin';

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $cvuelo = isset($_GET['cvuelo']) ? intval($_GET['cvuelo']) : 1;
    $stmt = $conn->prepare("SELECT cvuelo, origen, destino FROM vuelos WHERE cvuelo = :cvuelo");
    $stmt->bindParam(':cvuelo', $cvuelo);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($result);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
