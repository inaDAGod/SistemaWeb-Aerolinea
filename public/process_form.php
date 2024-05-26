<?php
echo "El script se está ejecutando correctamente.";
session_start();
include 'conexion.php';
include 'functions.php';

// Obtener valores de la sesión o inicializarlos en caso de que no existan
$adum = isset($_SESSION['adum']) ? $_SESSION['adum'] : 0;
$adu = isset($_SESSION['adu']) ? $_SESSION['adu'] : 0;
$nin = isset($_SESSION['nin']) ? $_SESSION['nin'] : 0;
$totalg = isset($_SESSION['total_people']) ? $_SESSION['total_people'] : 0;
$reservation_counter = isset($_SESSION['reservation_counter']) ? $_SESSION['reservation_counter'] : 0;
$cvuelosnum = isset($_SESSION['cvuelosnum']) ? $_SESSION['cvuelosnum'] : 0;
$creservanum = isset($_SESSION['creservanum']) ? $_SESSION['creservanum'] : 0;

// Mostrar todos los datos antes de procesar el formulario
echo "Datos antes de procesar el formulario:<br>";
echo "Adum: $adum<br>";
echo "Adu: $adu<br>";
echo "Nin: $nin<br>";
echo "Total de personas: $totalg<br>";
echo "Contador de reservas: $reservation_counter<br>";
echo "CVuelosNum: $cvuelosnum<br>";
echo "CReservaNum: $creservanum<br>";

$_SESSION['cvuelosnum'] = $cvuelosnum;
$_SESSION['creservanum'] = $creservanum;
$_SESSION['adum'] = $adum;
$_SESSION['adu'] = $adu;
$_SESSION['nin'] = $nin;
$_SESSION['total_people'] = $totalg;
$_SESSION['reservation_counter'] = $reservation_counter;

// Procesar datos del formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Resto del código...

    
    // Obtener datos del formulario
    $ci_persona = isset($_POST['ci_persona']) ? $_POST['ci_persona'] : null;
    $nombres = isset($_POST['nombres']) ? $_POST['nombres'] : null;
    $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : null;
    $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null;
    $sexo = isset($_POST['sexo']) ? $_POST['sexo'] : null;
    $casiento_seleccionado = isset($_POST['casiento_seleccionado']) ? $_POST['casiento_seleccionado'] : null;

    // Debugging: Registrar datos de entrada
    error_log("CI: $ci_persona, Nombres: $nombres, Apellidos: $apellidos, Fecha de Nacimiento: $fecha_nacimiento, Sexo: $sexo, Asiento: $casiento_seleccionado");

    // Obtener el cvuelo solo si se ha seleccionado un asiento
    $cvuelo = $casiento_seleccionado ? obtener_cvuelo_del_asiento($conn, $casiento_seleccionado) : null;
    if (!$cvuelo) {
        echo "Error: No se pudo obtener el cvuelo del asiento seleccionado.";
        exit;
    }
    
    // Debugging: Mostrar información del cvuelo
    echo "CVuelo: $cvuelo<br>";
    echo "CReservaNum: $creservanum<br>";

    // Verificar si la persona ya existe en la base de datos
    $stmt_check_person = $conn->prepare("SELECT COUNT(*) AS count FROM personas WHERE ci_persona = :ci_persona");
    $stmt_check_person->bindParam(':ci_persona', $ci_persona);
    $stmt_check_person->execute();
    $person_exists = $stmt_check_person->fetch(PDO::FETCH_ASSOC)['count'] > 0;

    if (!$person_exists && !empty($ci_persona)) {
        // Si la persona no existe, insertarla en la tabla personas
        $stmt = $conn->prepare("INSERT INTO personas (ci_persona, nombres, apellidos, fecha_nacimiento, sexo, tipo_persona) VALUES (:ci_persona, :nombres, :apellidos, :fecha_nacimiento, :sexo, :tipo_persona)");

        // Debugging: Verificar variables de sesión
        $adum = isset($_SESSION['adum']) ? $_SESSION['adum'] : 0;
        $adu = isset($_SESSION['adu']) ? $_SESSION['adu'] : 0;
        $nin = isset($_SESSION['nin']) ? $_SESSION['nin'] : 0;
        error_log("Adum: $adum, Adu: $adu, Nin: $nin");

        // Determinar el tipo de persona en función de la cantidad de cada tipo
        // Determinar el tipo de persona en función de la cantidad de cada tipo
if ($adum > 0) {
    $tipo_persona = 'Adulto mayor';
    $adum--; // Decrement adum here
} elseif ($adu > 0) {
    $tipo_persona = 'Adulto';
    $adu--; // Decrement adu here
} elseif ($nin > 0) {
    $tipo_persona = 'Niño';
    $nin--; // Decrement nin here
} else {
    $tipo_persona = 'No especificado';
}


        // Asignar parámetros y ejecutar la consulta
        $stmt->bindParam(':ci_persona', $ci_persona);
        $stmt->bindParam(':nombres', $nombres);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':tipo_persona', $tipo_persona);
        $stmt->execute();
    }

    // Debugging: Mostrar los datos a insertar en la tabla reservas_personas
    echo "Datos a insertar en reservas_personas:<br>";
    echo "CReserva: $creserva<br>";
    echo "CIPersona: $ci_persona<br>";
    echo "EstadoReserva: Pendiente<br>";
    echo "CVuelo: $cvuelo<br>";
    echo "Casiento: $casiento_seleccionado<br>";
    if (!empty($ci_persona)) {
        $creserva = isset($_SESSION['creservanum']) ? $_SESSION['creservanum'] : null;
        $estado_reserva = 'Pendiente';
        $stmt = $conn->prepare("INSERT INTO reservas_personas (creserva, ci_persona, estado_reserva, cvuelo, casiento) VALUES (:creserva, :ci_persona, :estado_reserva, :cvuelo, :casiento)");
        $stmt->bindParam(':creserva', $creserva);
        $stmt->bindParam(':ci_persona', $ci_persona);
        $stmt->bindParam(':estado_reserva', $estado_reserva);
        $stmt->bindParam(':cvuelo', $cvuelo);
        $stmt->bindParam(':casiento', $casiento_seleccionado);
        $stmt->execute();
        $_SESSION['reservation_counter']++;

       
        $_SESSION['adum'] = $adum; // Update adum session variable
        $_SESSION['adu'] = $adu; // Update adu session variable
        $_SESSION['nin'] = $nin; // Update nin session variable
        
// Debugging: Echo updated totalg
echo "Total de personas actualizado: {$_SESSION['total_people']}<br>";

        echo "Variables de sesión actualizadas:<br>";
echo "Adum: {$_SESSION['adum']}<br>";
echo "Adu: {$_SESSION['adu']}<br>";
echo "Nin: {$_SESSION['nin']}<br>";
        // Redireccionar si se han completado todas las reservas
        if ($_SESSION['reservation_counter'] >= $totalg) {
            echo "<span id='reserva_success'>¡Reserva exitosa! Todas las reservas se han completado.</span>";
            echo "<script>window.location.href = 'reservamu.php';</script>";
            exit;
        } else {
            echo "<span id='reserva_success'>¡Reserva exitosa! Por favor, continua con las siguientes reservas.</span>";
            
            
        }
    }
}
?>
