<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Allow-Headers: Content-Type");

$conexion = pg_connect("host=localhost dbname=aerolinea user=postgres password=admin");
if (!$conexion) {
    echo json_encode(['error' => 'Error al conectar a la base de datos']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$documento = $data['documento'] ?? '';

if (!empty($documento)) {
    // Código para buscar reservas por documento
    $query = "SELECT p.tipo_persona AS tipo_pasajero, rp.casiento AS asiento, a.tipo_asiento, p.nombres, p.apellidos, p.ci_persona as documento, rp.estado_reserva
              FROM reservas_personas rp
              JOIN personas p ON p.ci_persona = rp.ci_persona
              JOIN asientos_vuelo av ON av.casiento = rp.casiento AND av.cvuelo = rp.cvuelo
              JOIN asientos a ON a.casiento = av.casiento AND a.cavion = av.cavion
              WHERE p.ci_persona = $1";
    $result = pg_prepare($conexion, "my_query", $query);
    $result = pg_execute($conexion, "my_query", array($documento));
} else {
    // Código para cargar todas las reservas si no se especifica documento
    $query = "SELECT p.tipo_persona AS tipo_pasajero, rp.casiento AS asiento, a.tipo_asiento, p.nombres, p.apellidos, p.ci_persona as documento, rp.estado_reserva
              FROM reservas_personas rp
              JOIN personas p ON p.ci_persona = rp.ci_persona
              JOIN asientos_vuelo av ON av.casiento = rp.casiento AND av.cvuelo = rp.cvuelo
              JOIN asientos a ON a.casiento = av.casiento AND a.cavion = av.cavion";
    $result = pg_query($conexion, $query);
}

if ($result) {
    $data = pg_fetch_all($result);
    if ($data) {
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'No hay reservas disponibles']);
    }
} else {
    echo json_encode(['error' => 'Error en la consulta de la base de datos']);
}

pg_close($conexion);
?>
