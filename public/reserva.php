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
$adu = 1;
$nin = 1;

$totalg = $adum + $adu + $nin ;


$correo_usuario = 'example@example.com';
$fecha_reserva = '2024-05-15'; // Puedes cambiar esta fecha según sea necesario
$fecha_lmite  = '2024-06-15'; // Puedes cambiar esta fecha según sea necesario

// Función para generar dinámicamente el número de reserva
function generar_numero_reserva($conn, $correo_usuario, $fecha_reserva, $fecha_lmite) {
    // Preparar la consulta SQL para insertar en la tabla 'reservas'
    $query = "INSERT INTO reservas (correo_usuario, fecha_reserva, fecha_lmite) VALUES (:correo_usuario, :fecha_reserva, :fecha_lmite)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':correo_usuario', $correo_usuario);
    $stmt->bindParam(':fecha_reserva', $fecha_reserva);
    $stmt->bindParam(':fecha_lmite', $fecha_lmite);
    $stmt->execute();

    // Obtener el ID de la reserva creada
    $creservanum = $conn->lastInsertId();

    // Devolver el número de reserva generado
    return $creservanum;
}


// Establish connection to the database
$host = 'localhost'; // Cambia esto
$dbname = 'aerolinea';
$username = 'postgres'; // Cambia esto
$password = 'admin'; // Cambia esto
try {
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insertar reserva con valores predefinidos
    $creservanum = generar_numero_reserva($conn, $correo_usuario, $fecha_reserva, $fecha_lmite );

    $cvuelosnum = 2; // Por ejemplo, puedes cambiar este valor según tus necesidades

    // Guarda $creserva en una variable de sesión
    $_SESSION['cvuelosnum'] = $cvuelosnum;
    $_SESSION['creservanum'] = $creservanum;
    $_SESSION['adum'] = $adum;
    $_SESSION['adu'] = $adu;
    $_SESSION['nin'] = $nin;
    $_SESSION['total_people'] = $totalg;
    // Reset reservation counter to 0
    $_SESSION['reservation_counter'] = 0;
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
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

    <link rel="stylesheet" type="text/css" href="styles/default.css" />
		<link rel="stylesheet" type="text/css" href="styles/component.css" />
    



</head>
<div style="display: flex; align-items: center;margin-right: 10px;background-color:rgba(143, 188, 234, 1);">
    <img src="assets\logoavion.png" alt="Menu Icon" style="width:10%;height:10%;margin-left:10px;margin-top: 10px; margin-bottom: 20px;">
    <button id="showRight" style="margin-left:85%;"><img src="assets/indexAssets/bx-menu-alt-right.svg" alt="" class="hamburger"></button>
        <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
			<h3 style="font-family: 'Inter', sans-serif;font-size:35px;color:white;" id="menuHeader">Menu</h3>
            <a style="font-family: 'Inter', sans-serif;font-size:20px;color:black;text-algin:center;" href="#">Perfil</a>
			<a style="font-family: 'Inter', sans-serif;font-size:20px;color:black;text-algin:center;" href="#">Vuelos</a>
            <a style="font-family: 'Inter', sans-serif;font-size:20px;color:black;text-algin:center;" href="#">Check-In</a>
            <a style="font-family: 'Inter', sans-serif;font-size:20px;color:black;text-algin:center;" href="#">Premios Millas</a>
            <a style="font-family: 'Inter', sans-serif;font-size:20px;color:black;text-algin:center;" href="#">Log out</a>
            
		</nav>  
</div>
<body style="color:black">



<button class="btn btn" style="position: absolute; leftt: 0; top:14%; color:black;"><a href="index.html">< Cancelar reserva</a></button>
<h1 class="h1rese">Reservar </h1>

<div class="datos">
    <p class="pdatos">
        <?php
        // Establish connection to the database
        $host = 'localhost'; // Cambia esto
        $dbname = 'aerolinea';
        $username = 'postgres'; // Cambia esto
        $password = 'admin'; // Cambia esto
        try {
            $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);







// Prepare SQL query
$query = "SELECT cvuelo, origen, destino FROM vuelos WHERE cvuelo = :cvuelo";
$stmt = $conn->prepare($query);
$stmt->bindParam(':cvuelo', $_SESSION['cvuelosnum']); 



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

<div class="centerre1">
    <table class="tablere1">
        <tr class="trre1">
            <th class="thre1">Tipo Persona</th>
            <th class="thre1">Cantidad</th>
            <th class="thre1">Total</th>
        </tr>
        <tr class="trre1">
            <td class="tdre1">Adulto mayor</td>
            <td class="tdre1"><p><?php echo isset($_SESSION['adum']) ? $_SESSION['adum'] : 0; ?></p></td>
            <td class="tdre1"></td>
        </tr>
        <tr class="trre1">
            <td class="tdre1">Adultos</td>
            <td class="tdre1"><p><?php echo isset($_SESSION['adu']) ? $_SESSION['adu'] : 0; ?></p></td>
            <td class="tdre1"></td>
        </tr>
        <tr class="trre1">
            <td class="tdre1">Niños</td>
            <td class="tdre1"><p><?php echo isset($_SESSION['nin']) ? $_SESSION['nin'] : 0; ?></p></td>
            <td class="tdre1"></td>
        </tr>
       
        <tr class="trre1">
            <td class="tdre1"></td>
            <td class="tdre1"></td>
            <td class="tdre1"><p><?php echo isset($_SESSION['total_people']) ? $_SESSION['total_people'] : 0; ?></p></td>
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

<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <script src="scripts/script.js"></script>
    <script src="scripts/classie.js"></script>

    <script src="scripts/classie.js"></script>
    <script>
        var 
            menuRight = document.getElementById('cbp-spmenu-s2'),
            showRight = document.getElementById('showRight'),
            menuHeader = document.getElementById('menuHeader'),
            body = document.body;
    
        showRight.onclick = function() {
            classie.toggle(this, 'active');
            classie.toggle(menuRight, 'cbp-spmenu-open');
            disableOther('showRight');
        };
    
        // Function to disable other elements
        function disableOther(button) {
            if (button !== 'showRight') {
                classie.toggle(showRight, 'disabled');
            }
        }
    
        // Add event listener to close menu when header is clicked
        menuHeader.addEventListener('click', function() {
            classie.remove(menuRight, 'cbp-spmenu-open');
            classie.remove(showRight, 'active');
        });
    
        // Add event listener to close menu when clicked outside of it
        document.addEventListener('click', function(event) {
            var isClickInside = menuRight.contains(event.target) || showRight.contains(event.target);
            if (!isClickInside) {
                classie.remove(menuRight, 'cbp-spmenu-open');
                classie.remove(showRight, 'active');
            }
        });
    </script>




</body>
</html>
