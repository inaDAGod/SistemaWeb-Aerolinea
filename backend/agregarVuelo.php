<?php
header('Content-Type: application/json');
$conexion = pg_connect("dbname=aerolinea user=postgres password=admin");
if (!$conexion) {
    echo json_encode(['success' => false, 'error' => 'No se pudo conectar a la base de datos']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    // Solicitud GET para cargar ciudades
    $sql = "SELECT ciudad FROM ciudad";
    $resultado = pg_query($conexion, $sql);
    $ciudades = [];
    while ($fila = pg_fetch_assoc($resultado)) {
        array_push($ciudades, $fila['ciudad']);
    }
    echo json_encode($ciudades);
} elseif ($method == 'POST') {
    // Solicitud POST para agregar vuelo
    $data = json_decode(file_get_contents('php://input'), true);
    if ($data['origen'] === $data['destino']) {
        echo json_encode(['success' => false, 'error' => 'El origen y el destino no pueden ser el mismo']);
        exit;
    }

    $origen = pg_escape_string($conexion, $data['origen']);
    $destino = pg_escape_string($conexion, $data['destino']);
    $avion = pg_escape_string($conexion, $data['avion']);
    $fecha_vuelo = pg_escape_string($conexion, $data['fecha_vuelo']) . ' ' . pg_escape_string($conexion, $data['hora']);
    $costo_vip = pg_escape_string($conexion, $data['costo_vip']);
    $costo_business = pg_escape_string($conexion, $data['costo_business']);
    $costo_economico = pg_escape_string($conexion, $data['costo_economico']);

    $sql = "INSERT INTO vuelos (fecha_vuelo, costovip, origen, destino, costobusiness, costoeco) VALUES ('$fecha_vuelo', $costo_vip, '$origen', '$destino', $costo_business, $costo_economico)";
    $resultado = pg_query($conexion, $sql);

    if ($resultado) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al insertar el vuelo']);
    }
}
pg_close($conexion);
?>
