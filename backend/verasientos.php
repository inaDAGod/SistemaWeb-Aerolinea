<?php
// Establecer conexión a la base de datos
$conexion = pg_connect("dbname=aerolinea user=postgres password=admin");

if (!$conexion) {
    echo json_encode(['disponible' => false, 'mensaje' => 'Error al conectar a la base de datos.']);
    exit;
}

// Obtener los parámetros de la URL
$vuelo = $_GET['vuelo'];
$adultoMayor = (int)$_GET['adultoMayor'];
$adultos = (int)$_GET['adultos'];
$ninos = (int)$_GET['ninos'];
$mascotas = (int)$_GET['mascotas'];
$totalPersonas = $adultoMayor + $adultos + $ninos + $mascotas;

// Obtener el código del avión para el vuelo dado desde la tabla asientos_vuelo
$query_cavion = "SELECT cavion FROM asientos_vuelo WHERE cvuelo = $1 LIMIT 1";
$result_cavion = pg_query_params($conexion, $query_cavion, [$vuelo]);

if ($result_cavion && pg_num_rows($result_cavion) > 0) {
    $cavion_result = pg_fetch_assoc($result_cavion);
    $cavion = $cavion_result['cavion'];

    // Verificar la disponibilidad de asientos para cada tipo de asiento
    $query_asientos = "SELECT tipo_asiento, COUNT(*) as disponibles FROM asientos WHERE cavion = $1 AND estado = 'disponible' GROUP BY tipo_asiento";
    $result_asientos = pg_query_params($conexion, $query_asientos, [$cavion]);

    $asientos_suficientes = true;
    $asientos_por_tipo = [
        'económico' => 0,
        'normal' => 0,
        'vip' => 0
    ];

    if ($result_asientos) {
        while ($asiento = pg_fetch_assoc($result_asientos)) {
            $tipo = $asiento['tipo_asiento'];
            $disponibles = (int)$asiento['disponibles'];
            if ($disponibles < $totalPersonas) {
                $asientos_suficientes = false;
                break;
            }
            $asientos_por_tipo[$tipo] = $disponibles;
        }

        if ($asientos_suficientes) {
            echo json_encode(['disponible' => true]);
        } else {
            echo json_encode(['disponible' => false]);
        }
    } else {
        echo json_encode(['disponible' => false, 'mensaje' => 'Error al consultar la disponibilidad de asientos.']);
    }
} else {
    echo json_encode(['disponible' => false, 'mensaje' => 'No se encontró el avión para el vuelo dado.']);
}

pg_close($conexion);
?>
