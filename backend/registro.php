<?php
// Asumiendo que los datos vienen en formato JSON
$data = json_decode(file_get_contents('php://input'), true);

// Conectar a la base de datos
$conexion = pg_connect("dbname=aerolinea user=postgres password=admin");
if (!$conexion) {
    echo json_encode(['success' => false, 'error' => 'No se pudo conectar a la base de datos']);
    exit;
}
$sql = "SELECT ciudad FROM ciudad";
$resultado = pg_query($conexion, $sql);

$ciudades = [];
while ($fila = pg_fetch_assoc($resultado)) {
    array_push($ciudades, $fila['ciudad']);
}

echo json_encode($ciudades);

// Extraer datos
$origen = $data['origen'];
$destino = $data['destino'];
$avion = $data['avion'];
$fecha_vuelo = $data['fecha_vuelo'];
$hora = $data['hora'];
$costo_vip = $data['costo_vip'];
$costo_business = $data['costo_business'];
$costo_economico = $data['costo_economico'];

// Insertar datos en la base de datos
$sql = "INSERT INTO vuelos (origen, destino, avion, fecha_vuelo, hora, costoVip, costoBusiness, costoEco) VALUES ('$origen', '$destino', $avion, '$fecha_vuelo $hora', $costo_vip, $costo_business, $costo_economico)";
$resultado = pg_query($conexion, $sql);

if ($resultado) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Error al insertar el vuelo']);
}

// Cerrar la conexión
pg_close($conexion);
?>
