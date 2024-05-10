<?php
// Start session
session_start();

// Initialize reservation counter to 0 if not already set


// Check if form submitted from registro.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process data from registro.php and store in database
    // Redirect to the index page after all registrations are complete
    header("Location: index.php");
    exit;
}

// Store total number of people in session
$adum = 1;
$adu = 0;
$nin = 0;
$masco = 1;
$totalg = $adum + $adu + $nin + $masco;
$cvuelosnum = 7; // Por ejemplo, puedes cambiar este valor según tus necesidades
$creservanum = 7; // Por ejemplo, puedes cambiar este valor según tus necesidades

// Guarda $creserva en una variable de sesión
$_SESSION['cvuelosnum'] = $cvuelosnum;
$_SESSION['creservanum'] = $creservanum;
$_SESSION['adum'] = $adum;
$_SESSION['adu'] = $adu;
$_SESSION['nin'] = $nin;
$_SESSION['masco'] = $masco;
$_SESSION['total_people'] = $totalg;
// Reset reservation counter to 0
$_SESSION['reservation_counter'] = 0;
?>
