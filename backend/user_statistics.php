<?php
$host = 'localhost';
$port = '5432';
$dbname = 'aerolinea';
$user = 'postgres';
$password = 'admin';

// Establish database connection
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    echo json_encode(["error" => "Error: No se pudo conectar a la base de datos."]);
    exit;
}

// Calculate total days of travel
$query_total_days_travelled = "SELECT COUNT(DISTINCT fecha_vuelo) AS total_days_travelled 
                               FROM boletos b 
                               JOIN vuelos v ON b.cvuelo = v.cvuelo";
$result_total_days_travelled = pg_query($conn, $query_total_days_travelled);
$row_total_days_travelled = pg_fetch_assoc($result_total_days_travelled);
$total_days_travelled = $row_total_days_travelled['total_days_travelled'];

// Calculate total cities visited
$query_total_cities_visited = "SELECT COUNT(DISTINCT destino) AS total_cities_visited 
                               FROM boletos b 
                               JOIN vuelos v ON b.cvuelo = v.cvuelo";
$result_total_cities_visited = pg_query($conn, $query_total_cities_visited);
$row_total_cities_visited = pg_fetch_assoc($result_total_cities_visited);
$total_cities_visited = $row_total_cities_visited['total_cities_visited'];

// Retrieve total miles earned
$email = 'danialee14@gmail.com';
$query_total_miles_earned = "SELECT millas FROM usuarios WHERE correo_usuario = '$email'";
$result_total_miles_earned = pg_query($conn, $query_total_miles_earned);

if (!$result_total_miles_earned) {
    echo json_encode(["error" => "Error al obtener las millas ganadas."]);
    exit;
}

$row_total_miles_earned = pg_fetch_assoc($result_total_miles_earned);
$total_miles_earned = $row_total_miles_earned['millas'];

// Prepare statistics data
$statistics_data = [
    "total_days_travelled" => $total_days_travelled,
    "total_cities_visited" => $total_cities_visited,
    "total_miles_earned" => $total_miles_earned
];

// Output statistics data as JSON
echo json_encode($statistics_data);

// Close database connection
pg_close($conn);
?>
