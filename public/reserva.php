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
$masco = 0;
$totalg = $adum + $adu + $nin + $masco;
$cvuelosnum = 6; // Por ejemplo, puedes cambiar este valor según tus necesidades
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
        $host = 'localhost'; // Cambia esto
        $dbname = 'aerio';
        $username = 'postgres'; // Cambia esto
        $password = 'admin'; // Cambia esto
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
    <table class="tablere">
        <tr class="trre">
            <th class="thre">Tipo Persona</th>
            <th class="thre">Cantidad</th>
            <th class="thre">Total</th>
        </tr>
        <tr class="trre">
            <td class="tdre">Adulto mayor</td>
            <td class="tdre"><p><?php echo isset($_SESSION['adum']) ? $_SESSION['adum'] : 0; ?></p></td>
            <td class="tdre"></td>
        </tr>
        <tr class="trre">
            <td class="tdre">Adultos</td>
            <td class="tdre"><p><?php echo isset($_SESSION['adu']) ? $_SESSION['adu'] : 0; ?></p></td>
            <td class="tdre"></td>
        </tr>
        <tr class="trre">
            <td class="tdre">Niños</td>
            <td class="tdre"><p><?php echo isset($_SESSION['nin']) ? $_SESSION['nin'] : 0; ?></p></td>
            <td class="tdre"></td>
        </tr>
        <tr class="trre">
            <td class="tdre">Mascotas</td>
            <td class="tdre"><p><?php echo isset($_SESSION['masco']) ? $_SESSION['masco'] : 0; ?></p></td>
            <td class="tdre"></td>
        </tr>
        <tr class="trre">
            <td class="tdre"></td>
            <td class="tdre"></td>
            <td class="tdre"><p><?php echo isset($_SESSION['total_people']) ? $_SESSION['total_people'] : 0; ?></p></td>
        </tr>
    </table>
</div>
<br>
<form method="post" action="reservareg.php">
    <input type="hidden" id="total_people_input" name="total_people" value="<?php echo $totalg; ?>">
    <button type="submit" class="btn btn" style="position: absolute; right: 0; color: rgba(8, 86, 167, 1); background-color: rgba(255, 196, 79, 1); border-radius: 20px; margin-right: 2%; margin-top: -15px; width: 10%; font-size: 20px;">Siguiente</button>
</form>

<!-- Link to the JavaScript file -->
<script src="scripts\menu.js"></script>
</body>
</html>
