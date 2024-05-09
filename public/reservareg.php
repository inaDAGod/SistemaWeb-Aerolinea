<?php
session_start();
$adum = isset($_SESSION['adum']) ? $_SESSION['adum'] : 0;
$adu = isset($_SESSION['adu']) ? $_SESSION['adu'] : 0;
$nin = isset($_SESSION['nin']) ? $_SESSION['nin'] : 0;
$masco = isset($_SESSION['masco']) ? $_SESSION['masco'] : 0;
$totalg = isset($_SESSION['total_people']) ? $_SESSION['total_people'] : 0;
$reservation_counter = isset($_SESSION['reservation_counter']) ? $_SESSION['reservation_counter'] : 0;
echo "Total People: " . $totalg . "<br>";

// Store values in the session
$_SESSION['adum'] = $adum;
$_SESSION['adu'] = $adu;
$_SESSION['nin'] = $nin;
$_SESSION['masco'] = $masco;
$_SESSION['total_people'] = $totalg;
$_SESSION['reservation_counter']=$reservation_counter;



// Process form data if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Increment reservation counter
    

    // Connection to the database
    // Move this section to the top to ensure database connection before using it in the rest of the script.
    $host = 'localhost'; // Change this
    $dbname = 'aerio';
    $username = 'postgres'; // Change this
    $password = 'admin'; // Change this
    try {
        $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Obtain form data
        $ci_persona = isset($_POST['ci_persona']) ? $_POST['ci_persona'] : null;
        $nombres = isset($_POST['nombres']) ? $_POST['nombres'] : null;
        $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : null;
        $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null;
        $sexo = isset($_POST['sexo']) ? $_POST['sexo'] : null;
        $casiento_seleccionado = isset($_POST['casiento_seleccionado']) ? $_POST['casiento_seleccionado'] : null;

        // Obtain the cvuelo of the selected seat only if a seat is selected
        $cvuelo = null; // Initialize to null by default
        if ($casiento_seleccionado) {
            $cvuelo = obtener_cvuelo_del_asiento($conn, $casiento_seleccionado);

            // Handle case where cvuelo might be null
            if (!$cvuelo) {
                echo "Error: No se pudo obtener el cvuelo del asiento seleccionado.";
                exit; // Exit script to prevent further execution
            }
        }

        // Insert data into the personas table
        $stmt = $conn->prepare("INSERT INTO personas (ci_persona, nombres, apellidos, fecha_nacimiento, sexo) 
                                VALUES (:ci_persona, :nombres, :apellidos, :fecha_nacimiento, :sexo)");
        $stmt->bindParam(':ci_persona', $ci_persona);
        $stmt->bindParam(':nombres', $nombres);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->execute();

        // Insert data into the boletos table
        if ($cvuelo) {
            $total = obtener_costo_del_vuelo($conn, $cvuelo);
            $stmt = $conn->prepare("INSERT INTO boletos (ci_persona, cvuelo, casiento, total) 
                                    VALUES (:ci_persona, :cvuelo, :casiento, :total)");
            $stmt->bindParam(':ci_persona', $ci_persona);
            $stmt->bindParam(':cvuelo', $cvuelo);
            $stmt->bindParam(':casiento', $casiento_seleccionado);
            $stmt->bindParam(':total', $total);
            $stmt->execute();
        }

        // Insert data into the reservas_personas table
        $creserva = 6; // Set manually the value of "creserva"
        $estado_reserva = 'Pendiente';
        $stmt = $conn->prepare("INSERT INTO reservas_personas (creserva, ci_persona, estado_reserva, cvuelo, casiento) 
                                VALUES (:creserva, :ci_persona, :estado_reserva, :cvuelo, :casiento)");
        $stmt->bindParam(':creserva', $creserva);
        $stmt->bindParam(':ci_persona', $ci_persona);
        $stmt->bindParam(':estado_reserva', $estado_reserva);
        $stmt->bindParam(':cvuelo', $cvuelo);
        $stmt->bindParam(':casiento', $casiento_seleccionado);
        $stmt->execute();

        echo "¡Reserva exitosa!";
$_SESSION['reservation_counter']++;
echo "Total People registrados: " . $_SESSION['reservation_counter'] . "<br>";

// Check if all expected registrations have been made
if ($_SESSION['reservation_counter'] >= $totalg) {
    // All reservations are complete, redirect to success page
    header("Location: reservamu.php");
    exit;
}
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }


    

    // Check if all expected registrations have been made
    
}

function obtener_cvuelo_del_asiento($conn, $casiento_seleccionado) {
    try {
        // Prepare and execute the SQL query to get the cvuelo for the given seat
        $query = "SELECT cvuelo FROM asientos_vuelo WHERE casiento = :casiento";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':casiento', $casiento_seleccionado);
        $stmt->execute();
        
        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if a cvuelo was found
        if ($result && isset($result['cvuelo'])) {
            return $result['cvuelo'];
        } else {
            return false; // Return false if no cvuelo was found
        }
    } catch (PDOException $e) {
        // Handle any errors that occur during the database query
        echo "Error: " . $e->getMessage();
        return false; // Return false if an error occurred
    }
}

function obtener_costo_del_vuelo($conn, $cvuelo) {
    $query = "SELECT costo FROM vuelos WHERE cvuelo = :cvuelo";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':cvuelo', $cvuelo);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['costo'];
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
    <style>
        .centerfor {
            text-align: left;
            width: 100%;
            margin: 0 auto;
            margin-top: 2%;
        }

        .form-group {
            display: inline-block;
            vertical-align: top;
            margin-left: 80%;
            margin-top: -30%;
        }

        .seat-selection-table {
            width: 100%; /* Ensure table takes full width */
        }
        
        .container {
            display: flex;
            justify-content: space-between; /* Distribute items evenly with space between them */
            align-items: flex-start; /* Align items to the start of the container */
            margin-top: 20px; /* Adjust margin as needed */
        }

        .mejora {
            flex: 1; /* Allow the container to grow and fill available space */
            margin-right: 20px; /* Add space between .mejora and .seat-selection */
            margin-left: 20%;
        }

        .seat-selection {
            flex: 1; /* Allow the container to grow and fill available space */
        }

        .input-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px; /* Add margin between input groups */
        }

        .input-group label {
            margin-right: 10px;
            width: 200px;
        }

        .input-group input,
        .input-group select {
            width: 50%; /* Set input width to fill the remaining space */
        }
    </style>
</head>
<body>
<header class="py-3 cliente-header">
    <div class="container d-flex justify-content-between align-items-center" style="padding: 20px; margin-top: 15px; margin-bottom: 5px; color: white;">
        <nav class="navbar navbar-expand-lg navbar" style="position: absolute; left: 0; margin-bottom: 5px;">
            <ul class="navbar-nav" style="display: flex; align-items: center; position: absolute; left: 0; margin-right: 10%;">
                <li class="nav-item">
                    <div style="display: flex; align-items: center; margin-right: 10px;">
                        <img src="assets\logoavion.png" alt="Menu Icon" style="width: 150px; height: 50%; margin-left: 10px; margin-top: 10px; margin-bottom: 20px;">
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
        <button id="menu-toggle" class="btn btn" style="position: absolute; right: 0; top: -1%;">
            <img src="assets\perfil.png" alt="Menu Icon" style="width: 40%;">
        </button>
    </div>
</header>

<!-- Mini navigation bar placed outside the header -->
<nav id="mini-nav" class="mini-nav  py-200 px-3" style="position: absolute; top: calc(10% + 3px); right: 15%; background-color: rgba(143, 188, 234, 1); width: 15%; font-size: 25px; border-radius: 10px;">
    <ul class="list-unstyled mb-0">
        <li><a href="#">Perfil</a></li>
        <li><a href="#">Premios Millas</a></li>
        <li><a href="menunologin.php">Log out</a></li>
    </ul>
</nav>

<!-- Botón de Cancelar Reserva -->
<button class="btn btn" style="position: absolute; left: 0; top: 14%; color: rgba(8, 86, 167, 1);">Cancelar reserva</button>

<!-- Título -->
<h1 class="h1rese">Reservar </h1>

<!-- Datos del Vuelo -->
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
            $query = "SELECT cvuelo, origen, destino FROM vuelos LIMIT 1";
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
        Adulto mayor 1:
    </p>
</div>

<!-- Formulario de Reserva -->
<div class="centerfor">
<form method="POST">

        <div class="container">
            <div class="mejora">
                <div class="input-group">
                    <label for="ci_persona">Cédula de Identidad:</label>
                    <input type="text" id="ci_persona" name="ci_persona" required>
                </div>
                <div class="input-group">
                    <label for="nombres">Nombres:</label>
                    <input type="text" id="nombres" name="nombres">
                </div>
                <div class="input-group">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos">
                </div>
                <div class="input-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento">
                </div>
                <div class="input-group">
                    <label for="sexo">Sexo:</label>
                    <select id="sexo" name="sexo">
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
            </div>
            <div class="seat-selection">
            <h3 class="vuelos">Seleccionar Asiento de Vuelo</h3>
<table border="1">
    <tr>
        <?php
        // Establish connection to the database
        $host = 'localhost'; // Change this
        $dbname = 'aerio';
        $username = 'postgres'; // Change this
        $password = 'admin'; // Change this
        try {
            $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Consultar los tipos de asientos disponibles para el avión seleccionado
            $query = "SELECT DISTINCT tipo_asiento FROM asientos WHERE cavion = :cavion ORDER BY tipo_asiento";
            $stmt = $conn->prepare($query);
            $cavion = 11; // Esto debería ser dinámico según el avión seleccionado
            $stmt->bindParam(':cavion', $cavion);
            $stmt->execute();
            $tipos_asiento = $stmt->fetchAll(PDO::FETCH_COLUMN);

            // Mostrar los tipos de asientos como columnas en la tabla
            foreach ($tipos_asiento as $tipo) {
                echo '<th>' . $tipo . '</th>';
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </tr>
    <?php
    try {
        // Consultar los asientos disponibles para el avión seleccionado, ordenados por fila y número de asiento
        $query = "SELECT cavion, casiento, tipo_asiento FROM asientos WHERE cavion = :cavion ORDER BY SUBSTRING(casiento, 1, 1), casiento";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':cavion', $cavion);
        $stmt->execute();
        $asientos_disponibles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Inicializar la matriz para almacenar los asientos por fila
        $asientos_por_fila = array();
        foreach ($asientos_disponibles as $asiento) {
            $fila = substr($asiento['casiento'], 0, -1);
            $asientos_por_fila[$fila][$asiento['tipo_asiento']] = $asiento['casiento'];
        }

        // Iterar sobre las filas y mostrar los asientos por tipo como columnas
        foreach ($asientos_por_fila as $fila => $asientos) {
            echo '<tr>';
            foreach ($tipos_asiento as $tipo) {
                echo '<td>';
                if (isset($asientos[$tipo])) {
                    // Updated radio button with onchange event
                    echo '<input type="radio" name="casiento_seleccionado" value="' . $asientos[$tipo] . '" onchange="updateSelectedSeat(this.value)">';
                }
                echo '</td>';
            }
            echo '</tr>';
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
</table>

            </div>
        </div>
        <button type="submit" class="btn btn-success" style="margin-top: 20px;">Reservar</button>
    </form>
</div>
<script>
    // Total number of people
    var total_people = <?php echo $totalg; ?>;
    
    // Set the value of the hidden input field
    document.getElementById("total_people_input").value = total_people;
</script>

</body>
</html>
