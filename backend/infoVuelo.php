<?php
header('Content-Type: application/json');

$host = 'localhost';
$db = 'aerolinea';
$user = 'postgres';
$pass = 'admin'; 

$origen = $_GET['origen'];
$destino = $_GET['destino'];
$fecha = $_GET['fecha_partida'];

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$db", $user, $pass);

    $stmt = $pdo->prepare("
        SELECT
            v.cvuelo AS vuelo,
            v.origen AS origen,
            v.destino AS destino,
            EXTRACT(EPOCH FROM (v.fecha_vuelo + interval '1 hour' * (SELECT COUNT(*) FROM asientos_vuelo av WHERE av.cvuelo = v.cvuelo))) / 3600 AS duracion_horas,
            v.costo::numeric::float8 AS costo_economico,
            (v.costo * 1.8)::numeric::float8 AS costo_normal,
            (v.costo * 3)::numeric::float8 AS costo_vip
        FROM
            vuelos v
            JOIN asientos_vuelo av ON v.cvuelo = av.cvuelo
        WHERE
            v.origen = :origen AND
            v.destino = :destino AND
            DATE(v.fecha_vuelo) = :fecha
        GROUP BY
            v.cvuelo, v.origen, v.destino, v.fecha_vuelo, v.costo
    ");
    $stmt->execute(['origen' => $origen, 'destino' => $destino, 'fecha' => $fecha]);

    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($resultados);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
