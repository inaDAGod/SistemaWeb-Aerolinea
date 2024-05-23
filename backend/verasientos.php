<?php
// Establecer conexión a la base de datos
$host = 'localhost';
$dbname = 'aerolinea';
$username = 'postgres';
$password = 'admin';

try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener los parámetros de la solicitud
$vuelo = $_GET['vuelo'];
$adultoMayor = intval($_GET['adultoMayor']);
$adultos = intval($_GET['adultos']);
$ninos = intval($_GET['ninos']);
$mascotas = intval($_GET['mascotas']);

// Total de asientos necesarios
$totalPersonas = $adultoMayor + $adultos + $ninos + $mascotas;

// Conectar a la base de datos
// Aquí debes incluir tu lógica para conectar a la base de datos
$conn = new mysqli('localhost', 'usuario', 'contraseña', 'base_de_datos');

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar disponibilidad de asientos para el vuelo
$sql = "SELECT asientos_disponibles FROM vuelos WHERE codigo_vuelo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $vuelo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $asientosDisponibles = intval($row['asientos_disponibles']);
    
    if ($asientosDisponibles >= $totalPersonas) {
        echo json_encode(['disponible' => true]);
    } else {
        echo json_encode(['disponible' => false]);
    }
} else {
    echo json_encode(['error' => 'Vuelo no encontrado']);
}

$stmt->close();
$conn->close();
}
?>