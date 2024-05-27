<?php
if (isset($_GET['origen']) || isset($_GET['destino']) || isset($_GET['partida'])) {
    $origen = $_GET['origen'] ?? '';
    $destino = $_GET['destino'] ?? '';
    $partida = $_GET['partida'] ?? '';
    $regreso = $_GET['regreso'] ?? '';
    $ida_vuelta = $_GET['ida_vuelta'] ?? '';
    $adulto_mayor = $_GET['adulto_mayor'] ?? 0;
    $adultos = $_GET['adultos'] ?? 1;
    $ninos = $_GET['ninos'] ?? 0;
    $clase = $_GET['clase'] ?? '';

    // Ajustar los valores para que coincidan con los de la base de datos
    $origen = preg_replace('/ \(.+\)/', '', $origen);
    $destino = preg_replace('/ \(.+\)/', '', $destino);

    // Configuración de la conexión a la base de datos
    $host = 'localhost';
    $dbname = 'aerolinea';
    $user = 'postgres';
    $password = 'admin';

    try {
        // Conexión a la base de datos
        $dsn = "pgsql:host=$host;dbname=$dbname";
        $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        // Filtrado de vuelos según los criterios especificados
        $sql = "SELECT DISTINCT codigo_vuelo, origen, destino, fecha_partida, fecha_llegada, precio_economico, precio_normal, precio_vip FROM Vuelos WHERE 1=1";

        if (!empty($origen)) {
            $sql .= " AND origen = :origen";
        }
        if (!empty($destino)) {
            $sql .= " AND destino = :destino";
        }
        if (!empty($partida)) {
            $sql .= " AND DATE(fecha_partida) = :partida";
        }
        if ($ida_vuelta === 'ida_vuelta' && !empty($regreso)) {
            $sql .= " AND DATE(fecha_llegada) = :regreso";
        }
        if (!empty($ida_vuelta)) {
            $sql .= " AND tipo_vuelo = :ida_vuelta";
        }

        $sql .= " ORDER BY fecha_partida ASC";

        $stmt = $pdo->prepare($sql);
        $params = [];

        if (!empty($origen)) {
            $params['origen'] = $origen;
        }
        if (!empty($destino)) {
            $params['destino'] = $destino;
        }
        if (!empty($partida)) {
            $params['partida'] = $partida;
        }
        if ($ida_vuelta === 'ida_vuelta' && !empty($regreso)) {
            $params['regreso'] = $regreso;
        }
        if (!empty($ida_vuelta)) {
            $params['ida_vuelta'] = $ida_vuelta;
        }

        $stmt->execute($params);

        $vuelos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Transformar los resultados según la clase seleccionada
        foreach ($vuelos as &$vuelo) {
            if ($clase == 'economico') {
                $vuelo['precio'] = $vuelo['precio_economico'];
            } elseif ($clase == 'normal') {
                $vuelo['precio'] = $vuelo['precio_normal'];
            } elseif ($clase == 'vip') {
                $vuelo['precio'] = $vuelo['precio_vip'];
            } else {
                $vuelo['precio'] = '';
            }
            unset($vuelo['precio_economico']);
            unset($vuelo['precio_normal']);
            unset($vuelo['precio_vip']);
        }

        // Devolver los resultados como JSON
        header('Content-Type: application/json');
        echo json_encode($vuelos);

    } catch (PDOException $e) {
        // Manejo de errores de la conexión
        echo json_encode(['error' => 'Error en la conexión: ' . $e->getMessage()]);
    }
}
?>
