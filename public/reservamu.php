<?php

session_start();
$cvuelosnum = isset($_SESSION['cvuelosnum']) ? $_SESSION['cvuelosnum'] : 0;
$_SESSION['cvuelosnum'] = $cvuelosnum;

$creservanum = isset($_SESSION['creservanum']) ? $_SESSION['creservanum'] : 0;
$_SESSION['creservanum'] = $creservanum;
// Parámetros de conexión (reemplaza con tus propios valores)
$host = 'localhost'; // Cambia esto
$port = '5432'; // Puerto predeterminado de PostgreSQL
$dbname = 'aerio';
$user = 'postgres'; // Cambia esto
$password = 'admin';

// Cadena de conexión a PostgreSQL
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

try {
    // Conectar a la base de datos
    $conn = new PDO($dsn);

    // Configurar para que PDO lance excepciones en caso de error
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta SQL
    $sql = "SELECT 
                p.tipo_persona,
                p.nombres AS nombre,
                p.apellidos AS apellido,
                p.ci_persona AS CI,
                p.fecha_nacimiento,
                rp.casiento AS asiento
            FROM 
                personas p
            JOIN 
                reservas_personas rp ON p.ci_persona = rp.ci_persona
            JOIN 
                reservas r ON rp.creserva = r.creserva
            WHERE 
                r.creserva = $creservanum";

    // Preparar consulta
    $stmt = $conn->prepare($sql);

    // Ejecutar consulta
    $stmt->execute();

    // Obtener resultados
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // En caso de error, mostrar mensaje y detener ejecución
    echo "Error: " . $e->getMessage();
    die();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto_NAV</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Your custom CSS -->
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/reserva.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap">

</head>
<body>
<header class="py-3 cliente-header">
    <div class="container d-flex justify-content-between align-items-center" style="padding: 20px; margin-top: 15px; margin-bottom: 5px; color: white;">
        <nav class="navbar navbar-expand-lg navbar" style="position: absolute; left: 0; margin-bottom: 5px;">

            <ul class="navbar-nav" style="display: flex; align-items: center; position: absolute; left: 0; margin-right:10%;">
                <li class="nav-item">
                    <div style="display: flex; align-items: center; margin-right: 10px;">
                        <img src="assets\logoavion.png" alt="Menu Icon" style="width: 150px; height: 50%; margin-left:10px; margin-top: 10px; margin-bottom: 20px;">
                    </div>
                </li>
                
                <div id="nav-links-containercli">
                    <li class="nav-item">
                        <a class="nav-linkcli" href="servicios.php">Vuelos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-linkcli" href="Login.php">Check in</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-linkcli" href="servicios.php">Premios Millas</a>
                    </li>
                </div>

            </ul>
        </nav>
        <button id="menu-toggle" class="btn btn" style="position: absolute; right: 0; top:-1%;">
            <img src="assets\perfil.png" alt="Menu Icon" style="width:40%;">
        </button>
    </div>
</header>

<!-- Mini navigation bar placed outside the header -->
<nav id="mini-nav" class="mini-nav py-200 px-3" style="position: absolute; top: calc(10% + 3px); right: 15%; background-color: rgba(143, 188, 234, 1); width:15%; font-size:25px; border-radius: 10px;">
    <ul class="list-unstyled mb-0">
        <li><a href="#">Perfil</a></li>
        <li><a href="#">Premios Millas</a></li>
        <li><a href="menunologin.php">Log out</a></li>
    </ul>
</nav>

<button class="btn btn" style="position: absolute; leftt: 0; top:14%; color:rgba(8, 86, 167, 1);">Cancelar reserva</button>
<h1 class="h1rese">Reservar </h1>

<div class="datos">
    <p class="pdatos">
        <?php
        // Establish connection to the database
        $host = 'localhost'; // Change this
        $dbname = 'aerio';
        $username = 'postgres'; // Change this
        $password = 'admin'; // Change this
        try {
            $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare SQL query
            $query = "SELECT cvuelo, origen, destino FROM vuelos WHERE cvuelo = $cvuelosnum LIMIT 1";

            $stmt = $conn->prepare($query);

            // Execute query
            $stmt->execute();

            // Fetch the first row as an associative array
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Display result
            if ($row) {
                echo "Vuelo: " . $row['cvuelo'] . "<br>";
                echo "Origen: " . $row['origen'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                echo "Destino: " . $row['destino'] . "<br>";
            } else {
                echo "No data found.";
            }
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        ?>
    </p>
</div>

<div class="centerre">
<table class="tablere" >
    <tr class="trre">
        <th class="thre" style='padding: 8px;'>Tipo Persona</th>
        <th class="thre" style='padding: 8px;'>Nombre</th>
        <th class="thre" style='padding: 8px;'>Apellido</th>
        <th class="thre" style='padding: 8px;'>CI</th>
        <th class="thre" style='padding: 8px;'>Fecha de Nacimiento</th>
        <th class="thre" style='padding: 8px;'>Asiento</th>
    </tr>

    <?php
    // Mostrar resultados de la consulta
    foreach ($result as $row) {
        echo "<tr class='trre'>";
        echo "<td class='tdre' style='padding: 8px;'>" . $row["tipo_persona"] . "</td>";
        echo "<td class='tdre' style='padding: 8px;'>" . $row["nombre"] . "</td>";
        echo "<td class='tdre' style='padding: 8px;'>" . $row["apellido"] . "</td>";
        echo "<td class='tdre' style='padding: 8px;'>" . $row["ci"] . "</td>";
        echo "<td class='tdre' style='padding: 8px;'>" . $row["fecha_nacimiento"] . "</td>";
        echo "<td class='tdre' style='padding: 8px;'>" . $row["asiento"] . "</td>";
        echo "</tr>";
    }
    
    ?>

</table>
</div>
<center>
<button type="submit" class="btn btn" style="color: rgba(8, 86, 167, 1); background-color: rgba(255, 196, 79, 1); border-radius: 20px; margin-right: 2%; margin-top: 3%; width: 10%; font-size: 20px;">Siguiente</button></center>
<!-- Link to the JavaScript file -->
<script src="scripts\menu.js"></script>
</body>
</html>
