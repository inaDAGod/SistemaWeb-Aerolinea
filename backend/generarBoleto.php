<?php
header('Content-Type: application/json');
$conexion = pg_connect("host=localhost dbname=aerolinea user=postgres password=admin");

if (!$conexion) {
    echo json_encode(['error' => 'Error al conectar a la base de datos']);
    exit;
}

$carnet = $_POST['carnet'] ?? '';
$cvuelo = $_POST['cvuelo'] ?? '';
$ccheckIn = $_POST['ccheck_in'] ?? '';

// Insertar nuevo boleto directamente sin verificar duplicados
$queryInsertBoleto = "INSERT INTO boletos (ci_persona, ccheck_in, cvuelo, casiento, total)
                      VALUES ($1, $2, $3, (SELECT casiento FROM asientos WHERE cavion = (SELECT cavion FROM vuelos WHERE cvuelo = $3 LIMIT 1)), 
                              (SELECT costoeco FROM vuelos WHERE cvuelo = $3)) RETURNING cboleto";
$resultInsertBoleto = pg_prepare($conexion, "insert_boleto", $queryInsertBoleto);
$resultInsertBoleto = pg_execute($conexion, "insert_boleto", array($carnet, $ccheckIn, $cvuelo));

if ($resultInsertBoleto && pg_num_rows($resultInsertBoleto) > 0) {
    $cboleto = pg_fetch_result($resultInsertBoleto, 0, 'cboleto');
    echo json_encode(['success' => true, 'cboleto' => $cboleto]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al insertar el boleto']);
}

pg_close($conexion);
?>
