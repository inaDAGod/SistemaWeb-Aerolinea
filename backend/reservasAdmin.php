<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");  // Permite todos los orígenes
header("Access-Control-Allow-Methods: POST, GET");  // Permite solo métodos POST y GET
header("Access-Control-Allow-Headers: Content-Type");  // Permite solo cabeceras de tipo Content-Type

// Establecer la conexión con la base de datos
$conexion = pg_connect("host=localhost dbname=aerolinea user=postgres password=admin");
if (!$conexion) {
    echo json_encode(['error' => 'Error al conectar a la base de datos']);
    exit;
}

// Leer el cuerpo de la solicitud como JSON
$data = json_decode(file_get_contents('php://input'), true);
$documento = $data['documento'] ?? '';

// Preparar y ejecutar la consulta
$query = "SELECT p.tipo_persona AS tipo_pasajero, rp.casiento AS asiento, a.tipo_asiento, p.nombres, p.apellidos, p.ci_persona as documento, rp.estado_reserva
          FROM reservas_personas rp
          JOIN personas p ON p.ci_persona = rp.ci_persona
          JOIN asientos_vuelo av ON av.casiento = rp.casiento AND av.cvuelo = rp.cvuelo
          JOIN asientos a ON a.casiento = av.casiento AND a.cavion = av.cavion
          WHERE p.ci_persona = $1";
$result = pg_prepare($conexion, "my_query", $query);
$result = pg_execute($conexion, "my_query", array($documento));

if ($result) {
    $data = pg_fetch_all($result);
    if ($data) {
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'No hay reservas con el carnet introducido']);
    }
} else {
    echo json_encode(['error' => 'Error en la consulta de la base de datos']);
}

// Cerrar la conexión
pg_close($conexion);
?>
