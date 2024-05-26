<?php
session_start();
include 'conexion.php';

// Datos de prueba
$correo_usuario = 'andrea.fernandez.l@ucb.edu.bo';
$fecha_reserva = '2024-06-25'; // Puedes cambiar esta fecha según sea necesario
$fecha_lmite = '2024-06-27'; // Puedes cambiar esta fecha según sea necesario

function generar_numero_reserva($conn, $correo_usuario, $fecha_reserva, $fecha_lmite) {
    // Preparar la consulta SQL para insertar en la tabla 'reservas'
    $query = "INSERT INTO reservas (correo_usuario, fecha_reserva, fecha_lmite) VALUES (:correo_usuario, :fecha_reserva, :fecha_lmite)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':correo_usuario', $correo_usuario);
    $stmt->bindParam(':fecha_reserva', $fecha_reserva);
    $stmt->bindParam(':fecha_lmite', $fecha_lmite);
    $stmt->execute();

    // Obtener el ID de la reserva creada
    return $conn->lastInsertId();
}

$creservanum = generar_numero_reserva($conn, $correo_usuario, $fecha_reserva, $fecha_lmite);

$cvuelosnum = 2; // Por ejemplo, puedes cambiar este valor según tus necesidades

$_SESSION['cvuelosnum'] = $cvuelosnum;
$_SESSION['creservanum'] = $creservanum;
$_SESSION['reservation_counter'] = 0;

// Obtén el número de vuelo de la sesión
$cvuelosnum = isset($_SESSION['cvuelosnum']) ? $_SESSION['cvuelosnum'] : null;

if ($cvuelosnum) {
    // Consulta el avión para el vuelo dado
    $query_cavion = "SELECT cavion FROM asientos_vuelo WHERE cvuelo = :cvuelo LIMIT 1";
    $stmt_cavion = $conn->prepare($query_cavion);
    $stmt_cavion->bindParam(':cvuelo', $cvuelosnum);
    $stmt_cavion->execute();
    $cavion_result = $stmt_cavion->fetch(PDO::FETCH_ASSOC);

    // Agrega mensajes de depuración
    echo "<pre>";
    print_r($cavion_result);
    echo "</pre>";

    if ($cavion_result) {
        $cavion = $cavion_result['cavion'];

        // Consulta los tipos de asientos disponibles para el avión seleccionado
        $query_tipos_asiento = "SELECT DISTINCT tipo_asiento FROM asientos WHERE cavion = :cavion ORDER BY tipo_asiento";
        $stmt_tipos_asiento = $conn->prepare($query_tipos_asiento);
        $stmt_tipos_asiento->bindParam(':cavion', $cavion);
        $stmt_tipos_asiento->execute();
        $tipos_asiento = $stmt_tipos_asiento->fetchAll(PDO::FETCH_COLUMN);

        // Consulta los asientos disponibles para el avión seleccionado, excluyendo los asientos reservados
        $query_asientos = "SELECT a.casiento, a.tipo_asiento FROM asientos a LEFT JOIN reservas_personas r ON a.casiento = r.casiento WHERE a.cavion = :cavion AND r.cvuelo IS NULL ORDER BY SUBSTRING(a.casiento, 1, 1), a.casiento";
        $stmt_asientos = $conn->prepare($query_asientos);
        $stmt_asientos->bindParam(':cavion', $cavion);
        $stmt_asientos->execute();
        $asientos_disponibles = $stmt_asientos->fetchAll(PDO::FETCH_ASSOC);

        // Inicializa la matriz para almacenar los asientos por fila
        $asientos_por_fila = array();
        foreach ($asientos_disponibles as $asiento) {
            $fila = substr($asiento['casiento'], 0, -1);
            $asientos_por_fila[$fila][$asiento['tipo_asiento']] = $asiento['casiento'];
        }

        // Genera la tabla de asientos
        echo '<table border="1" style="margin-left:40%">';
        echo '<tr>';
        foreach ($tipos_asiento as $tipo) {
            echo '<th>' . $tipo . '</th>';
        }
        echo '</tr>';

        foreach ($asientos_por_fila as $fila => $asientos) {
            echo '<tr>';
            foreach ($tipos_asiento as $tipo) {
                echo '<td>';
                if (isset($asientos[$tipo])) {
                    // Muestra el número de asiento junto con el botón de radio
                    echo '<label><input type="radio" name="casiento_seleccionado" value="' . $asientos[$tipo] . '"> ' . $asientos[$tipo] . '</label>';
                }
                echo '</td>';
            }
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo "No se encontró el avión para el vuelo dado.";
    }
} else {
    echo "No se ha especificado un número de vuelo.";
}
?>
