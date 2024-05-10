<?php

session_start();
$cvuelosnum = isset($_SESSION['cvuelosnum']) ? $_SESSION['cvuelosnum'] : 0;
$_SESSION['cvuelosnum'] = $cvuelosnum;

$creservanum = isset($_SESSION['creservanum']) ? $_SESSION['creservanum'] : 0;
$_SESSION['creservanum'] = $creservanum;
// Parámetros de conexión (reemplaza con tus propios valores)
$host = 'localhost'; // Cambia esto
$port = '5432'; // Puerto predeterminado de PostgreSQL
$dbname = 'aerolinea';
$user = 'postgres'; // Cambia esto
$password = 'admin';

// Cadena de conexión a PostgreSQL
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

// Function to update the reservation status
function confirmarReserva($creservanum)
{
    global $dsn;
    try {
        // Connect to the database
        $conn = new PDO($dsn);
        // Set PDO to throw exceptions on error
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL to update the reservation status to 'Confirmada'
        $sql = "UPDATE reservas_personas SET estado_reserva = 'Confirmada' WHERE creserva = :creserva";

        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':creserva', $creservanum, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        // Close the connection
        $conn = null;

        // Return success message
        return "Reserva confirmada exitosamente.";
    } catch (PDOException $e) {
        // Return error message if an exception occurs
        return "Error: " . $e->getMessage();
    }
}

// Check if the Confirmar Reserva button is clicked
if (isset($_POST['confirmar_reserva'])) {
    // Call the function to update the reservation status
    $confirmacion = confirmarReserva($creservanum);
    echo "<script>alert('$confirmacion'); window.location.href = 'index.html';</script>";
}

// Fetch reservation data from the database
try {
    // Connect to the database
    $conn = new PDO($dsn);
    // Set PDO to throw exceptions on error
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL to fetch reservation details
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
                r.creserva = :creserva";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':creserva', $creservanum, PDO::PARAM_INT);

    // Execute the statement
    $stmt->execute();

    // Fetch all rows from the result set
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Display error message if an exception occurs
    echo "Error: " . $e->getMessage();
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
    <link rel="stylesheet" href="styles/style.css"> 

<link rel="stylesheet" type="text/css" href="styles/default.css" />
    <link rel="stylesheet" type="text/css" href="styles/component.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">

<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
    rel="stylesheet">


</head>
<div style="display: flex; align-items: center;margin-right: 10px;background-color:rgba(143, 188, 234, 1);">
    <img src="assets\logoavion.png" alt="Menu Icon" style="width:10%;height:10%;margin-left:10px;margin-top: 10px; margin-bottom: 20px;">
    <button id="showRight" style="margin-left:85%;"><img src="assets\home2.png" alt="Menu Icon" style="width:40px;height:50%;background-color:white;"></button>
        <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="cbp-spmenu-s2">
			<h3 style="font-family: 'Inter', sans-serif;font-size:35px;color:white;" id="menuHeader">Menu</h3>
            <a style="font-family: 'Inter', sans-serif;font-size:20px;color:black;text-algin:center;" href="#">Perfil</a>
			<a style="font-family: 'Inter', sans-serif;font-size:20px;color:black;text-algin:center;" href="#">Vuelos</a>
            <a style="font-family: 'Inter', sans-serif;font-size:20px;color:black;text-algin:center;" href="#">Check-In</a>
            <a style="font-family: 'Inter', sans-serif;font-size:20px;color:black;text-algin:center;" href="#">Premios Millas</a>
            <a style="font-family: 'Inter', sans-serif;font-size:20px;color:black;text-algin:center;" href="#">Log out</a>
            
		</nav>
        
</div>
<body>



<button class="btn btn" style="position: absolute; leftt: 0; top:14%; color:rgba(8, 86, 167, 1);"><a href="index.html">< Cancelar reserva</a></button>
<h1 class="h1rese">Reservar </h1>

<div class="datos">
    <p class="pdatos">
        <?php
        // Establish connection to the database
        $host = 'localhost'; // Change this
        $dbname = 'aerolinea';
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
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
<button type="submit" class="btn btn" name="confirmar_reserva" style="color: rgba(8, 86, 167, 1); background-color: rgba(255, 196, 79, 1); border-radius: 20px; margin-right: 2%; margin-top: 3%; width: 10%; font-size: 20px;">Confirmar</button>
</form>

</center>
<!-- Link to the JavaScript file -->
<script src="scripts\menu.js"></script>
<script>
    var redirectTimeout;

    function redirect() {
        redirectTimeout = setTimeout(function(){
            window.location.href = 'index.html';
        }, 3000); // 3000 milliseconds = 3 seconds
    }

    function confirmarReserva() {
        redirect();
    }
</script>

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
