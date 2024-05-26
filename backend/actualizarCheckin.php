<?php
header('Content-Type: application/json');
$conexion = pg_connect("host=localhost dbname=aerolinea user=postgres password=admin");

if (!$conexion) {
    echo json_encode(['error' => 'Error al conectar a la base de datos']);
    exit;
}

$email = $_POST['email'] ?? '';
$carnet = $_POST['carnet'] ?? '';
$numeroVuelo = $_POST['numeroVuelo'] ?? '';
$equipajeMano = $_POST['equipajeMano'] === 'true' ? 'true' : 'false'; // Asegurarse de que el valor es estrictamente 'true' o 'false'
$maleta = $_POST['maleta'] === 'true' ? 'true' : 'false';
$equipajeExtra = $_POST['equipajeExtra'] === 'true' ? 'true' : 'false';

$query = "UPDATE check_in SET 
            correo_usuario = $1, 
            estado_checkin = 'Realizado', 
            equipaje_mano = $2, 
            maleta = $3, 
            equipaje_extra = $4 
          WHERE ccheck_in = (SELECT ccheck_in FROM boletos WHERE ci_persona = $5 AND cvuelo = $6)";
$result = pg_prepare($conexion, "update_checkin", $query);
$result = pg_execute($conexion, "update_checkin", array($email, $equipajeMano, $maleta, $equipajeExtra, $carnet, $numeroVuelo));

if ($result && pg_affected_rows($result) > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'No se pudo actualizar el check-in.']);
}

pg_close($conexion);
?>
