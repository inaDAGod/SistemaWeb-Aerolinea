<?php
$dbname = "aerolinea";
$user = "postgres";
$password = "admin";

// Crear la conexión
$conn = pg_connect("dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Conexión fallida: " . pg_last_error());
}

$sql = "SELECT copinion, fecha_opinion, correo_usuario, nombres_usuario, apellidos_usuario, comentario, estrellas FROM opiniones";
$result = pg_query($conn, $sql);

if (!$result) {
    die("Error en la consulta: " . pg_last_error());
}

$opiniones = array();

while ($row = pg_fetch_assoc($result)) {
    $opiniones[] = $row;
}

pg_free_result($result);
pg_close($conn);

echo json_encode($opiniones);
?>
