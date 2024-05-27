<?php
session_start();

// Verificar si la sesión correo_usuario está establecida
if (isset($_SESSION['correo_usuario'])) {
    // Obtener el correo del usuario desde la sesión
    $correo_usuario = $_SESSION['correo_usuario'];
    
    // Enviar el correo del usuario como respuesta
    echo json_encode(["correo_usuario" => $correo_usuario]);
} else {
    // Si el correo del usuario no está definido en la sesión, enviar un mensaje de error
    echo json_encode(["error" => "El correo del usuario no está definido en la sesión."]);
}
?>
