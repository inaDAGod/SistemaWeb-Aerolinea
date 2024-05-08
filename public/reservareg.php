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
    <form action="procesar_reserva.php" method="POST">
        <label for="ci_persona">Cédula de Identidad:</label>
        <input type="text" id="ci_persona" name="ci_persona" required><br><br>
        
        <label for="nombres">Nombres:</label>
        <input type="text" id="nombres" name="nombres"><br><br>
        
        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos"><br><br>
        
        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"><br><br>
        
        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo">
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
            <option value="Otro">Otro</option>
        </select><br><br>
        
        <!-- Sección de Selección de Asiento de Vuelo -->
        <!-- Sección de Selección de Asiento de Vuelo -->
<!-- Sección de Selección de Asiento de Vuelo -->
<!-- Sección de Selección de Asiento de Vuelo -->
<!-- Sección de Selección de Asiento de Vuelo -->
<h3>Seleccionar Asiento de Vuelo</h3>
<table border="1">
    <tr>
        <th>Avión</th>
        <th>Fila</th>
        <?php
        // Establecer la conexión a la base de datos
        $host = 'localhost'; // Cambia esto según tu configuración
        $dbname = 'aerio';
        $username = 'postgres'; // Cambia esto según tu configuración
        $password = 'admin'; // Cambia esto según tu configuración
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
            echo '<td>' . $cavion . '</td>'; // Mostrar el número de avión
            echo '<td>' . $fila . '</td>'; // Mostrar la fila del asiento
            foreach ($tipos_asiento as $tipo) {
                echo '<td>';
                if (isset($asientos[$tipo])) {
                    echo '<input type="radio" name="asiento" value="' . $asientos[$tipo] . '">';
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




        <br>
        <input type="hidden" id="creserva" name="creserva" value="6">

        <button type="submit">Guardar Reserva</button>
    </form>
</div>

<!-- Botón de Siguiente -->
<button class="btn btn" style="position: absolute; right: 0; color: rgba(8, 86, 167, 1); background-color: rgba(255, 196, 79, 1); border-radius: 20px; margin-right: 2%; margin-top: -15px; width: 10%; font-size: 20px;">Siguiente</button>
<script>
    // Function to update the selected seat value
    function updateSelectedSeat(seat) {
        document.getElementById('casiento_seleccionado').value = seat;
    }
</script>

<!-- Script JavaScript -->
<script>
    // pasajeros
    var adum = 1;
    var adu = 2;
    var nin = 3;
    var masco = 4;
    var totalg = adum + adu + nin + masco;
    
    // Set content for each <p> element
    document.getElementById("adum").textContent = adum;
    document.getElementById("adu").textContent = adu;
    document.getElementById("nin").textContent = nin;
    document.getElementById("masco").textContent = masco;
    document.getElementById("totalg").textContent = totalg;
</script>

<!-- Link to the JavaScript file -->
<script src="scripts\menu.js"></script>
</body>
</html>
