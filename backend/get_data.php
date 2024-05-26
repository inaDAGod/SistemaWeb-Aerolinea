<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");  // Permite todos los orígenes
header("Access-Control-Allow-Methods: POST, GET");  // Permite solo métodos POST y GET
header("Access-Control-Allow-Headers: Content-Type");  // Permite solo cabeceras de tipo Content-Type

// Habilitar la visualización de errores (para desarrollo, deshabilitar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Establecer la conexión con la base de datos
$conexion = pg_connect("dbname=aerolinea user=postgres password=admin");
if (!$conexion) {
    echo json_encode(['error' => 'Error al conectar a la base de datos: ' . pg_last_error()]);
    exit;
}

// Consulta SQL para obtener las personas con más millas acumuladas
$query = "SELECT destino AS ciudad, COUNT(*) AS cantidad_vuelos FROM vuelos GROUP BY destino";

// Ejecuta la consulta
$result = pg_query($conexion, $query);

if (!$result) {
    echo json_encode(['error' => 'Error en la ejecución de la consulta: ' . pg_last_error()]);
    exit;
}

// Procesa los resultados y los agrega al array
$data = pg_fetch_all($result);

// Cierra la conexión con la base de datos
pg_close($conexion);

// Devuelve los datos en formato JSON
echo json_encode($data);
?>
