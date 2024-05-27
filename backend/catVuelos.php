<?php
    header('Content-Type: application/json');

    // Conexión a la base de datos
    $conn = pg_connect("host=localhost dbname=aerolinea user=postgres password=admin");
    if (!$conn) {
        echo json_encode(["error" => "Error en la conexión con la base de datos"]);
        exit;
    }

    // Obtener los datos del formulario
    $origen = $_GET['origen'];
    $destino = $_GET['destino'];

    // Crear la consulta SQL utilizando la vista vuelos_filtrados
    $query = "
        SELECT
            \"Vuelo\",
            \"Origen\",
            \"Destino\",
            \"Duración\",
            \"Económico\",
            \"Normal\",
            \"VIP\"
        FROM
            vuelos_filtrados
        WHERE
            \"Origen\" = $1 AND
            \"Destino\" = $2
    ";

    // Ejecutar la consulta
    $result = pg_query_params($conn, $query, array($origen, $destino));
    if (!$result) {
        echo json_encode(["error" => "Error en la ejecución de la consulta"]);
        exit;
    }

    // Recoger los resultados en un array
    $flights = [];
    while ($row = pg_fetch_assoc($result)) {
        $flights[] = $row;
    }

    // Devolver los resultados como JSON
    echo json_encode($flights);

    // Cerrar la conexión
    pg_close($conn);
?>
