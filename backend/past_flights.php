<?php
$host = 'localhost';
$port = '5432';
$dbname = 'aerolinea';
$user = 'postgres';
$password = 'admin';

// Realizar la conexión a la base de datos
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    echo "Error: No se pudo conectar a la base de datos.\n";
    exit;
}

// Consulta para obtener los vuelos pasados del usuario
$email = 'danialee14@gmail.com'; // El correo del usuario que quieres mostrar
$current_date = date('Y-m-d');
$query_past_flights = "SELECT v.* FROM vuelos v 
                       JOIN boletos b ON v.cvuelo = b.cvuelo 
                       JOIN check_in c ON b.ccheck_in = c.ccheck_in
                       WHERE c.correo_usuario='$email' AND v.fecha_vuelo < '$current_date'";
$result_past_flights = pg_query($conn, $query_past_flights);

if (!$result_past_flights) {
    echo "Error en la consulta de vuelos pasados.\n";
    exit;
}

// Mostrar los resultados en una tabla
echo "<table class='table table-striped'>";
echo "<tr><th>cvuelo</th><th>origen</th><th>destino</th><th>fecha_vuelo</th><th>costo</th></tr>";
while ($row_past_flights = pg_fetch_assoc($result_past_flights)) {
    echo "<tr>";
    echo "<td>" . $row_past_flights['cvuelo'] . "</td>";
    echo "<td>" . $row_past_flights['origen'] . "</td>";
    echo "<td>" . $row_past_flights['destino'] . "</td>";
    echo "<td>" . $row_past_flights['fecha_vuelo'] . "</td>";
    echo "<td>" . $row_past_flights['costo'] . "</td>";
    echo "</tr>";
}
echo "</table>";

// Cerrar la conexión a la base de datos
pg_close($conn);
?>
