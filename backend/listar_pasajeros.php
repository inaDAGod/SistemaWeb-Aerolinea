<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");  // Permite todos los orígenes
header("Access-Control-Allow-Methods: POST, GET");  // Permite solo métodos POST y GET
header("Access-Control-Allow-Headers: Content-Type");  // Permite solo cabeceras de tipo Content-Type

// Establecer la conexión con la base de datos
$conexion = pg_connect("dbname=aerolinea user=postgres password=admin");
if (!$conexion) {
    die("Error al conectar a la base de datos: " . pg_last_error());
}

// Obtener el valor del documento del POST si está presente
$documento = $_POST['documento'] ?? '';

// Consulta SQL para obtener la lista de todas las personas
$query = "SELECT p.tipo_persona as tipo_pasajero, rp.casiento as asiento, a.tipo_asiento, p.nombres, p.apellidos, p.ci_persona as documento, ci.estado_checkin
            FROM personas p
            JOIN reservas_personas rp ON p.ci_persona = rp.ci_persona
            JOIN asientos_vuelo av ON rp.cvuelo = av.cvuelo AND rp.casiento = av.casiento
            JOIN asientos a ON av.cavion = a.cavion AND av.casiento = a.casiento
            JOIN check_in ci ON p.ci_persona = ci.numero_documento";

// Si se proporciona un número de documento, agregue una cláusula WHERE para filtrar por ese documento
if ($documento) {
    $query .= " WHERE p.ci_persona = $1";
}

// Prepara la consulta
$result = pg_prepare($conexion, "my_query", $query);
if (!$result) {
    die(json_encode(['error' => 'Error en la preparación de la consulta: ' . pg_last_error()]));
}

// Ejecuta la consulta con el valor del documento si está presente
if ($documento) {
    $result = pg_execute($conexion, "my_query", array($documento));
} else {
    $result = pg_execute($conexion, "my_query", array());
}

if (!$result) {
    die(json_encode(['error' => 'Error en la ejecución de la consulta: ' . pg_last_error()]));
}

// Procesa los resultados
$data = pg_fetch_all($result);
if ($data) {
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'No hay reservas para el documento proporcionado']);
}

// Cierra la conexión con la base de datos
pg_close($conexion);
?>
