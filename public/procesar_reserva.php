<?php
// Conexión a la base de datos
$host = 'localhost'; // Cambia esto
$dbname = 'aerio';
$username = 'postgres'; // Cambia esto
$password = 'admin'; // Cambia esto
try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener datos del formulario
    $ci_persona = $_POST['ci_persona'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $sexo = $_POST['sexo'];
    // Obtener el asiento seleccionado
    $casiento_seleccionado = $_POST['casiento_seleccionado'];

    // Obtener el cvuelo del asiento seleccionado
    $cvuelo = obtener_cvuelo_del_asiento($conn, $casiento_seleccionado); // Función hipotética para obtener cvuelo

    // Handle case where cvuelo might be null
    if (!$cvuelo) {
        echo "Error: No se pudo obtener el cvuelo del asiento seleccionado.";
        exit; // Exit script to prevent further execution
    }

    // Insertar datos en la tabla personas
    $stmt = $conn->prepare("INSERT INTO personas (ci_persona, nombres, apellidos, fecha_nacimiento, sexo) 
                            VALUES (:ci_persona, :nombres, :apellidos, :fecha_nacimiento, :sexo)");
    $stmt->bindParam(':ci_persona', $ci_persona);
    $stmt->bindParam(':nombres', $nombres);
    $stmt->bindParam(':apellidos', $apellidos);
    $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
    $stmt->bindParam(':sexo', $sexo);
    $stmt->execute();

    // Insertar datos en la tabla boletos
    $total = obtener_costo_del_vuelo($conn, $cvuelo); // Función hipotética para obtener costo del vuelo
    $stmt = $conn->prepare("INSERT INTO boletos (ci_persona, cvuelo, casiento, total) 
                        VALUES (:ci_persona, :cvuelo, :casiento, :total)");
    $stmt->bindParam(':ci_persona', $ci_persona);
    $stmt->bindParam(':cvuelo', $cvuelo);
    $stmt->bindParam(':casiento', $casiento_seleccionado);
    $stmt->bindParam(':total', $total);
    $stmt->execute();

    // Insertar datos en la tabla reservas_personas
    $creserva = 6; // Establecer manualmente el valor de "creserva"
    $estado_reserva = 'Pendiente';
    $stmt = $conn->prepare("INSERT INTO reservas_personas (creserva, ci_persona, estado_reserva, cvuelo, casiento) 
                            VALUES (:creserva, :ci_persona, :estado_reserva, :cvuelo, :casiento)");
    $stmt->bindParam(':creserva', $creserva);
    $stmt->bindParam(':ci_persona', $ci_persona);
    $stmt->bindParam(':estado_reserva', $estado_reserva);
    $stmt->bindParam(':cvuelo', $cvuelo);
    $stmt->bindParam(':casiento', $casiento_seleccionado);
    $stmt->execute();

    echo "¡Reserva exitosa!";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

function obtener_cvuelo_del_asiento($conn, $casiento_seleccionado) {
    try {
        // Prepare and execute the SQL query to get the cvuelo for the given seat
        $query = "SELECT cvuelo FROM asientos_vuelo WHERE casiento = :casiento";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':casiento', $casiento_seleccionado);
        $stmt->execute();
        
        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if a cvuelo was found
        if ($result && isset($result['cvuelo'])) {
            return $result['cvuelo'];
        } else {
            return false; // Return false if no cvuelo was found
        }
    } catch (PDOException $e) {
        // Handle any errors that occur during the database query
        echo "Error: " . $e->getMessage();
        return false; // Return false if an error occurred
    }
}




function obtener_costo_del_vuelo($conn, $cvuelo) {
    $query = "SELECT costo FROM vuelos WHERE cvuelo = :cvuelo";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':cvuelo', $cvuelo);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['costo'];
}
?>
