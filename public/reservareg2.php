<?php
session_start();
$adum = isset($_SESSION['adum']) ? $_SESSION['adum'] : 0;
$adu = isset($_SESSION['adu']) ? $_SESSION['adu'] : 0;
$nin = isset($_SESSION['nin']) ? $_SESSION['nin'] : 0;
$totalg = isset($_SESSION['total_people']) ? $_SESSION['total_people'] : 0;
$reservation_counter = isset($_SESSION['reservation_counter']) ? $_SESSION['reservation_counter'] : 0;


$cvuelosnum = isset($_SESSION['cvuelosnum']) ? $_SESSION['cvuelosnum'] : 0;
$_SESSION['cvuelosnum'] = $cvuelosnum;

$creservanum = isset($_SESSION['creservanum']) ? $_SESSION['creservanum'] : 0;
$_SESSION['creservanum'] = $creservanum;

// Store values in the session
$_SESSION['adum'] = $adum;
$_SESSION['adu'] = $adu;
$_SESSION['nin'] = $nin;

$_SESSION['total_people'] = $totalg;
$_SESSION['reservation_counter'] = $reservation_counter;



// Process form data if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
        if (!empty($ci_persona)) {
            try {
                // Insert data into the personas table
                $stmt = $conn->prepare("INSERT INTO personas (ci_persona, nombres, apellidos, fecha_nacimiento, sexo, tipo_persona) 
                    VALUES (:ci_persona, :nombres, :apellidos, :fecha_nacimiento, :sexo, :tipo_persona)");

                // Determine the tipo_persona based on the number of each type of person
                if ($adum > 0) {
                    $tipo_persona = 'Adulto mayor';
                    $adum--; // Decrement the count of Adulto mayor after assigning it
                } elseif ($adu > 0) {
                    $tipo_persona = 'Adulto';
                    $adu--; // Decrement the count of Adulto after assigning it
                } elseif ($nin > 0) {
                    $tipo_persona = 'Niño';
                    $nin--; // Decrement the count of Niño after assigning it
                } else {
                    $tipo_persona = 'No especificado';
                }

                // Bind parameters and execute the statement
                $stmt->bindParam(':ci_persona', $ci_persona);
                $stmt->bindParam(':nombres', $nombres);
                $stmt->bindParam(':apellidos', $apellidos);
                $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
                $stmt->bindParam(':sexo', $sexo);
                $stmt->bindParam(':tipo_persona', $tipo_persona);
                $stmt->execute();

            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
                // Handle the error as needed
            }
        }

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

        if (!empty($ci_persona)) {
            try {
                // Insert data into the reservas_personas table
                $creserva = $creservanum; // Set manually the value of "creserva"
                $estado_reserva = 'Pendiente';
                $stmt = $conn->prepare("INSERT INTO reservas_personas (creserva, ci_persona, estado_reserva, cvuelo, casiento) 
                    VALUES (:creserva, :ci_persona, :estado_reserva, :cvuelo, :casiento)");
                $stmt->bindParam(':creserva', $creserva);
                $stmt->bindParam(':ci_persona', $ci_persona);
                $stmt->bindParam(':estado_reserva', $estado_reserva);
                $stmt->bindParam(':cvuelo', $cvuelo);
                $stmt->bindParam(':casiento', $casiento_seleccionado);
                $stmt->execute();
                
                // Increment reservation counter only after successful reservation
                $_SESSION['reservation_counter']++;

                echo "<span id='reserva_success'>¡Reserva exitosa!</span>";
                $_SESSION['adum'] = $adum;
                $_SESSION['adu'] = $adu;
                $_SESSION['nin'] = $nin;

                // Check if all expected registrations have been made
                if ($_SESSION['reservation_counter'] >= $totalg) {
                    // All reservations are complete, redirect to success page
                    header("Location: reservamu.php");
                    exit;
                }
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
                // Handle the error as needed
            }
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
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


<script>
// JavaScript code to hide the successful reservation message after 6 seconds
setTimeout(function() {
    var reservaSuccess = document.getElementById('reserva_success');
    if (reservaSuccess) {
        reservaSuccess.style.display = 'none';
    }
}, 6000); // 6 seconds
</script>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
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

<body style="color:black">
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


<!-- Botón de Cancelar Reserva -->
<button class="btn btn" style=" left: 0;  color: rgba(8, 86, 167, 1);"><a href="index.html">< Cancelar reserva</a></button>

<!-- Título -->
<h2 class="h1rese2">Reservar </h2>

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

<!-- Formulario de Reserva -->
<div class="centerfor">
<form method="POST">
<p style="text-align: center; margin-left: -34.5%;margin-top:-3%;margin-bottom:2%;font-size: 25px;">
    <?php
    // Define the type of person based on available counts
    if ($adum > 0) {
        $tipo_persona = 'Adulto mayor';
        $adum--; // Decrement the count of Adulto mayor after assigning it
    } elseif ($adu > 0) {
        $tipo_persona = 'Adulto';
        $adu--; // Decrement the count of Adulto after assigning it
    } elseif ($nin > 0) {
        $tipo_persona = 'Niño';
        $nin--; // Decrement the count of Niño after assigning it
    } elseif ($masco > 0) {
        $tipo_persona = 'Mascota';
        $masco--; // Decrement the count of Mascota after assigning it
    } else {
        $tipo_persona = 'No especificado';
    }

    // Display the type of person
    echo $tipo_persona;
    ?>
</p>


        <div class="container">
        <input  type="hidden" id="tipo_persona_hidden" name="tipo_persona" value="<?php echo $tipo_persona; ?>">
    
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
            <h3 class="vuelos" style="margin-left:20%;margin-top:-23%;color:black">Seleccionar Asiento de Vuelo</h3>
           <br><br><br>
            <table border="1" style="margin-left:40%">
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

            // Fetch the cavion for the given flight from the asientos_vuelo table
            $query_cavion = "SELECT cavion FROM asientos_vuelo WHERE cvuelo = :cvuelo LIMIT 1";
            $stmt_cavion = $conn->prepare($query_cavion);
            $stmt_cavion->bindParam(':cvuelo', $cvuelosnum);
            $stmt_cavion->execute();
            $cavion_result = $stmt_cavion->fetch(PDO::FETCH_ASSOC);

            if ($cavion_result) {
                $cavion = $cavion_result['cavion'];

                // Consultar los tipos de asientos disponibles para el avión seleccionado
                $query_tipos_asiento = "SELECT DISTINCT tipo_asiento FROM asientos WHERE cavion = :cavion ORDER BY tipo_asiento";
                $stmt_tipos_asiento = $conn->prepare($query_tipos_asiento);
                $stmt_tipos_asiento->bindParam(':cavion', $cavion);
                $stmt_tipos_asiento->execute();
                $tipos_asiento = $stmt_tipos_asiento->fetchAll(PDO::FETCH_COLUMN);

                // Mostrar los tipos de asientos como columnas en la tabla
                foreach ($tipos_asiento as $tipo) {
                    echo '<th>' . $tipo . '</th>';
                }
            } else {
                echo "No se encontró el avión para el vuelo dado.";
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </tr>
    <?php
try {
    // Consultar los asientos disponibles para el avión seleccionado, excluyendo los asientos reservados
    $query_asientos = "SELECT a.casiento, a.tipo_asiento FROM asientos a LEFT JOIN reservas_personas r ON a.casiento = r.casiento WHERE a.cavion = :cavion AND r.cvuelo IS NULL ORDER BY SUBSTRING(a.casiento, 1, 1), a.casiento";
    $stmt_asientos = $conn->prepare($query_asientos);
    $stmt_asientos->bindParam(':cavion', $cavion);
    $stmt_asientos->execute();
    $asientos_disponibles = $stmt_asientos->fetchAll(PDO::FETCH_ASSOC);

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
                // Display the seat number along with the radio button
                echo '<label><input type="radio" name="casiento_seleccionado" value="' . $asientos[$tipo] . '" onchange="updateSelectedSeat(this.value)"> ' . $asientos[$tipo] . '</label>';
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
        </div><br><br>
        <button type="submit" class="btn btn-success" style="position: absolute; right: 0; color: rgba(8, 86, 167, 1); background-color: rgba(255, 196, 79, 1); border-radius: 20px; margin-right: 2%; margin-top: 3%; width: 10%; font-size: 20px;">Siguiente</button>
    </form>
</div>
<script>
    // Total number of people
    var total_people = <?php echo $totalg; ?>;
    
    // Set the value of the hidden input field
    document.getElementById("total_people_input").value = total_people;

    // Function to update the hidden input field with the current tipo_persona value
    function updateTipoPersona() {
        var tipo_persona = '<?php echo $tipo_persona; ?>';
        document.getElementById('tipo_persona_hidden').value = tipo_persona;
    }

    // Call the function initially to set the tipo_persona value
    updateTipoPersona();
</script>




</body>
</html>
