<?php
// Establecer conexión a la base de datos
$conexion = pg_connect("dbname=aerolinea user=postgres password=admin");

if (!$conexion) {
    echo "Error al conectar a la base de datos.";
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
$query_cavion = "SELECT cavion FROM asientos_vuelo WHERE cvuelo = '$vuelo' LIMIT 1";
$result_cavion = pg_query($conexion, $query_cavion);

if ($result_cavion && pg_num_rows($result_cavion) > 0) {
    $cavion_result = pg_fetch_assoc($result_cavion);
    $cavion = $cavion_result['cavion'];

    // Verificar la disponibilidad de asientos para cada tipo de asiento
    $query_asientos = "SELECT tipo_asiento, COUNT(*) as disponibles FROM asientos WHERE cavion = '$cavion' AND estado = 'disponible' GROUP BY tipo_asiento";
    $result_asientos = pg_query($conexion, $query_asientos);

    $asientos_suficientes = true;
    $asientos_por_tipo = [
        'económico' => 0,
        'normal' => 0,
        'vip' => 0
    ];

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
        // Redirigir a la página de reserva si hay asientos disponibles
        header("Location: reserva_vuelo.php?vuelo=$vuelo&adultoMayor=$adultoMayor&adultos=$adultos&ninos=$ninos&mascotas=$mascotas");
        exit;
    } else {
        echo "No hay suficientes asientos disponibles para el vuelo seleccionado.";
    }
} else {
    echo "No se encontró el avión para el vuelo dado.";
}

pg_close($conexion);
?>