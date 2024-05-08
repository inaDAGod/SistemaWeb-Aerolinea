<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto_NAV</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Your custom CSS -->
    <link rel="stylesheet" href="styles/style.css"> <!-- Link to the external CSS file -->
</head>

<body>
    <header class="py-3 user-header">
        <div class="container d-flex justify-content-between align-items-center" style=" padding: 20px; margin-top: 15px; margin-bottom: 5px;color:white;">
            <nav class="navbar navbar-expand-lg navbar" style="position: absolute; left: 0; margin-bottom: 5px;">

                <ul class="navbar-nav" style="display: flex; align-items: center;position: absolute; left: 0;margin-right:10%;">
                    <li class="nav-item">
                        <div style="display: flex; align-items: center;margin-right: 10px;">
                            <img src="assets\logoavion.png" alt="Menu Icon" style="width: 150px; height: 50%;margin-left:10px;margin-top: 10px; margin-bottom: 20px;">
                            
                        </div>
                    </li>
                    

                    <div id="nav-links-containernon">
                    <li class="nav-item">
                        <a class="nav-linknon" href="servicios.php" >Vuelos</a> <!-- Removed inline styles -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-linknon" href="Login.php" >Check in</a> <!-- Removed inline styles -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-linknon" href="servicios.php" >Premios Millas</a> <!-- Removed inline styles -->
                    </li></div>
                </ul>
            </nav>


            <ul style="list-style-type: none; margin: 0; padding: 0;">
                <li class="nav-item" style="position: absolute; right: 1%; top:3%;">
                    <a class="nav-linknon" href="Login.php">| Iniciar Sesión</a> <!-- Removed inline styles -->
                </li>
            </ul>


        </div>
    </header>
    <h1 class="h1menu">Bienvenido, vuela con los mejores</h1>


</body>

</html>
