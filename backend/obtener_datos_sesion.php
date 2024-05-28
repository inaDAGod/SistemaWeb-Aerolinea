<?php
session_start();


// Crea un array asociativo con los datos de sesión
$data = array(
    'adum' => $_SESSION['adum'],
    'adu' => $_SESSION['adu'],
    'nin' => $_SESSION['nin'],
    'total_people' => $_SESSION['total_people']
);

// Devuelve los datos en formato JSON
echo json_encode($data);
?>
