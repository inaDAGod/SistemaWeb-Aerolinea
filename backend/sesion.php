<?php
include 'registrores.php';
include 'generar_reserva.php';
// Inicia la sesión solo si no ha sido iniciada previamente
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$correo_usuario = isset($_SESSION['correo_usuario']);

// Verificar si la sesión adum está establecida, de lo contrario, establecerla en 0
$adum = isset($_SESSION['adum']) ? $_SESSION['adum'] : 0;

// Verificar si la sesión adu está establecida, de lo contrario, establecerla en 0
$adu = isset($_SESSION['adu']) ? $_SESSION['adu'] : 0;

// Verificar si la sesión nin está establecida, de lo contrario, establecerla en 0
$nin = isset($_SESSION['nin']) ? $_SESSION['nin'] : 0;

// Verificar si la sesión total_people está establecida, de lo contrario, establecerla en 0
$totalg = isset($_SESSION['total_people']) ? $_SESSION['total_people'] : 0;

// Verificar si la sesión reservation_counter está establecida, de lo contrario, establecerla en 0
$reservation_counter = isset($_SESSION['reservation_counter']) ? $_SESSION['reservation_counter'] : 0;

// Verificar si la sesión cvuelosnum está establecida, de lo contrario, establecerla en 0
$cvuelosnum = isset($_SESSION['cvuelosnum']) ? $_SESSION['cvuelosnum'] : 0;

// Verificar si la sesión creservanum está establecida, de lo contrario, establecerla en 0
$creservanum = isset($_SESSION['creservanum']) ? $_SESSION['creservanum'] : 0;

// Establecer las sesiones con los valores obtenidos o 0 si no están establecidos
$_SESSION['cvuelosnum'] = $cvuelosnum;
$_SESSION['creservanum'] = $creservanum;
$_SESSION['adum'] = $adum;
$_SESSION['adu'] = $adu;
$_SESSION['nin'] = $nin;
$_SESSION['total_people'] = $totalg;
$_SESSION['reservation_counter'] = $reservation_counter;
$_SESSION['correo_usuario'] =$correo_usuario;
?>
