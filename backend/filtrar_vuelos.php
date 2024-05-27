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
    $fecha_partida = $_GET['fecha_partida'];
    $tipo_vuelo = $_GET['tipo_vuelo'];
    $fecha_regreso = isset($_GET['fecha_regreso']) ? $_GET['fecha_regreso'] : null;
    $adulto_mayor = intval($_GET['adulto_mayor']);
    $adulto = intval($_GET['adulto']);
    $nino = intval($_GET['nino']);

    // Crear la consulta SQL para vuelo de ida
    $query_ida = "
        SELECT
            v.cvuelo AS vuelo,
            v.origen AS origen,
            v.destino AS destino,
            EXTRACT(EPOCH FROM (v.fecha_vuelo + interval '1 hour' * (SELECT COUNT(*) FROM asientos_vuelo av WHERE av.cvuelo = v.cvuelo))) / 3600 AS duracion_horas,
            v.costo AS costo_economico,
            v.costo * 1.8 AS costo_normal,
            v.costo * 3 AS costo_vip
        FROM
            vuelos v
        WHERE
            v.origen = $1 AND
            v.destino = $2 AND
            v.fecha_vuelo::date = $3
    ";

    // Ejecutar la consulta para vuelo de ida
    $result_ida = pg_query_params($conn, $query_ida, array($origen, $destino, $fecha_partida));
    if (!$result_ida) {
        echo json_encode(["error" => "Error en la ejecución de la consulta de ida"]);
        exit;
    }

    // Recoger los resultados en un array
    $flights = [];
    while ($row = pg_fetch_assoc($result_ida)) {
        $flights[] = $row;
    }

    // Si es ida/vuelta, crear y ejecutar la consulta para vuelo de vuelta
    if ($tipo_vuelo === 'ida_vuelta' && $fecha_regreso) {
        $query_vuelta = "
            SELECT
                v.cvuelo AS vuelo,
                v.origen AS origen,
                v.destino AS destino,
                EXTRACT(EPOCH FROM (v.fecha_vuelo + interval '1 hour' * (SELECT COUNT(*) FROM asientos_vuelo av WHERE av.cvuelo = v.cvuelo))) / 3600 AS duracion_horas,
                v.costo AS costo_economico,
                v.costo * 1.8 AS costo_normal,
                v.costo * 3 AS costo_vip
            FROM
                vuelos v
            WHERE
                v.origen = $2 AND
                v.destino = $1 AND
                v.fecha_vuelo::date = $4
        ";

        $result_vuelta = pg_query_params($conn, $query_vuelta, array($origen, $destino, $fecha_partida, $fecha_regreso));
        if (!$result_vuelta) {
            echo json_encode(["error" => "Error en la ejecución de la consulta de vuelta"]);
            exit;
        }

        while ($row = pg_fetch_assoc($result_vuelta)) {
            $flights[] = $row;
        }
    }

    // Devolver los resultados como JSON
    echo json_encode($flights);

    // Cerrar la conexión
    pg_close($conn);
    ?>