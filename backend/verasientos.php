<?php
$cvuelosnum = $_GET['vuelo'];
$adultoMayor = $_GET['adultoMayor'];
$adultos = $_GET['adultos'];
$ninos = $_GET['ninos'];
$mascotas = $_GET['mascotas'];

// Conexión a la base de datos
$conexion = pg_connect("dbname=aerolinea user=postgres password=admin");
if (!$conexion) {
    echo json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos.']);
    exit;
}

// Consultar el código del avión para el vuelo dado
$query_cavion = "SELECT cavion FROM asientos_vuelo WHERE cvuelo = $1 LIMIT 1";
$result_cavion = pg_query_params($conexion, $query_cavion, array($cvuelosnum));

if ($result_cavion && pg_num_rows($result_cavion) > 0) {
    $cavion_result = pg_fetch_assoc($result_cavion);
    $cavion = $cavion_result['cavion'];

    // Verificar la disponibilidad de asientos
    $query_disponibilidad = "SELECT tipo_asiento, COUNT(*) AS disponibles FROM asientos WHERE cavion = $1 AND disponible = true GROUP BY tipo_asiento";
    $result_disponibilidad = pg_query_params($conexion, $query_disponibilidad, array($cavion));
    $disponibilidad = pg_fetch_all($result_disponibilidad);

    $suficiente = true;
    foreach ($disponibilidad as $tipo_asiento) {
        if (($tipo_asiento['tipo_asiento'] === 'economico' && $tipo_asiento['disponibles'] < $adultos) ||
            ($tipo_asiento['tipo_asiento'] === 'normal' && $tipo_asiento['disponibles'] < $adultoMayor) ||
            ($tipo_asiento['tipo_asiento'] === 'vip' && $tipo_asiento['disponibles'] < $ninos)) {
            $suficiente = false;
            break;
        }
    }

    if ($suficiente) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No hay suficientes asientos disponibles.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No se encontró el avión para el vuelo dado.']);
}

pg_close($conexion);
?>
