<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$dbname = 'aerolinea';
$user = 'postgres';
$password = 'admin';

// Verificamos si se han enviado los parámetros 'origen' o 'destino'
if (isset($_GET['origen']) || isset($_GET['destino'])) {
    $origen = $_GET['origen'] ?? '';
    $destino = $_GET['destino'] ?? '';

    try {
        // Configuramos y creamos el objeto PDO para la conexión
        $dsn = "pgsql:host=$host;dbname=$dbname";
        $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        // Preparamos la consulta SQL básica
        $sql = "SELECT codigo_vuelo, origen, destino, duracion, precio_economico, precio_normal, precio_vip FROM Vuelos WHERE 1=1";

        // Agregamos condiciones a la consulta SQL según los parámetros proporcionados
        if (!empty($origen)) {
            $sql .= " AND origen = :origen";
        }
        if (!empty($destino)) {
            $sql .= " AND destino = :destino";
        }

        // Preparamos la consulta SQL
        $stmt = $pdo->prepare($sql);

        // Preparamos el array de parámetros
        $params = [];
        if (!empty($origen)) {
            $params[':origen'] = $origen;
        }
        if (!empty($destino)) {
            $params[':destino'] = $destino;
        }

        // Ejecutamos la consulta
        $stmt->execute($params);

        // Obtenemos los resultados
        $vuelos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Configuramos el encabezado para JSON y enviamos los resultados
        header('Content-Type: application/json');
        echo json_encode($vuelos);
    } catch (PDOException $e) {
        // En caso de error, devolvemos el mensaje de error en formato JSON
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Error en la conexión: ' . $e->getMessage()]);
    }
}
?>