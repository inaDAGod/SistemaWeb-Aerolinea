<?php
// Conexión a la base de datos
$host = 'localhost'; // Change this
        $dbname = 'aerio';
        $username = 'postgres'; // Change this
        $password = 'admin'; // Change this
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
    // Necesitarás obtener el cvuelo y cavion del asiento seleccionado antes de hacer esta inserción
    // Insertar datos en la tabla boletos
// Necesitarás obtener el cvuelo del asiento seleccionado antes de hacer esta inserción
$cavion = obtener_cavion_del_asiento($conn, $casiento_seleccionado);
$cvuelo = obtener_cvuelo_del_asiento($conn, $casiento_seleccionado); // Función hipotética para obtener cvuelo
$total = obtener_costo_del_vuelo($conn, $cvuelo); // Función hipotética para obtener costo del vuelo
$stmt = $conn->prepare("INSERT INTO boletos (ci_persona, cvuelo, casiento, total) 
                        VALUES (:ci_persona, :cvuelo, :casiento, :total)");
$stmt->bindParam(':ci_persona', $ci_persona);
$stmt->bindParam(':cvuelo', $cvuelo);
$stmt->bindParam(':casiento', $casiento_seleccionado);
$stmt->bindParam(':total', $total);
$stmt->execute();


    // Insertar datos en la tabla reservas_personas
    $creserva = generar_numero_de_reserva_unico($conn); // Función hipotética para generar un número de reserva único
    $estado_reserva = 'Activa'; // Por ejemplo
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


function obtener_cavion_del_asiento($conn, $casiento_seleccionado) {
    $query = "SELECT cavion FROM asientos WHERE casiento = :casiento";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':casiento', $casiento_seleccionado);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['cavion'];
}

function obtener_costo_del_vuelo($conn, $cvuelo) {
    $query = "SELECT costo FROM vuelos WHERE cvuelo = :cvuelo";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':cvuelo', $cvuelo);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['costo'];
}

function obtener_cvuelo_del_asiento($conn, $casiento_seleccionado) {
    $query = "SELECT cvuelo FROM asientos_vuelo WHERE casiento = :casiento";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':casiento', $casiento_seleccionado);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['cvuelo'];
}
function generar_numero_de_reserva_unico($conn) {
    // Generate a unique reservation number using current timestamp and a random number
    return time() . rand(1000, 9999);
}

?>
