<?php
$dbname = "aerolinea";
$user = "postgres";
$password = "admin";

// Crear la conexión
$conn = pg_connect("dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Conexión fallida: " . pg_last_error());
}

//////////////para ver si está realizando la consulta de vuelos o verificación de asientos dispomibles

if (isset($_GET['check_asientos'])) {
    $cvuelo = $_GET['cvuelo'];
    $adultoMayor = $_GET['adultoMayor'];
    $adultos = $_GET['adultos'];
    $ninos = $_GET['ninos'];
    $total_pasajeros = $adultoMayor + $adultos + $ninos;

    // obtine el avión asignado al vuelo y su capacidad
    $sql_avion = "SELECT a.capacidad
                  FROM vuelos v
                  JOIN aviones a ON v.cavion = a.cavion
                  WHERE v.cvuelo = $1";
    $result_avion = pg_query_params($conn, $sql_avion, array($cvuelo));

    if (!$result_avion) {
        die("Error en la consulta de capacidad de avión: " . pg_last_error());
    }

    $row_avion = pg_fetch_assoc($result_avion);
    $capacidad_avion = $row_avion['capacidad'];

    // cuanta los asientos ya reservados para el vuelo
    $sql_reservados = "SELECT COUNT(*) AS asientos_reservados FROM asientos_vuelo WHERE cvuelo = $1";
    $result_reservados = pg_query_params($conn, $sql_reservados, array($cvuelo));

    if (!$result_reservados) {
        die("Error en la consulta de asientos reservados: " . pg_last_error());
    }

    $row_reservados = pg_fetch_assoc($result_reservados);
    $asientos_reservados = $row_reservados['asientos_reservados'];

    // para calculars asientos disponibles
    $asientos_disponibles = $capacidad_avion - $asientos_reservados;

    // ver si hay suficientes asientos disponibles
    $suficientes = $asientos_disponibles >= $total_pasajeros;

    pg_free_result($result_avion);
    pg_free_result($result_reservados);
    pg_close($conn);

    echo json_encode(array('asientos_disponibles' => $asientos_disponibles, 'suficientes' => $suficientes));
} else {

////========================================================================================================

$sql = "SELECT cvuelo, fecha_vuelo, origen, destino, costovip, costoeco, costobusiness FROM vuelos";
$result = pg_query($conn, $sql);

if (!$result) {
    die("Error en la consulta: " . pg_last_error());
}

$vuelos = array();

while ($row = pg_fetch_assoc($result)) {
    $vuelos[] = $row;
}

pg_free_result($result);
pg_close($conn);

echo json_encode($vuelos);
}
?>
