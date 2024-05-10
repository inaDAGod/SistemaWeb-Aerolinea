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
</head>
<body>
<header class="py-3">
    <div class="container d-flex justify-content-between align-items-center"style=" padding: 20px; margin-top: 15px; margin-bottom: 5px;color:white;">
    <nav class="navbar navbar-expand-lg navbar" style="position: absolute; left: 0; margin-bottom: 5px;">

                <ul class="navbar-nav" style="display: flex; align-items: center;position: absolute; left: 0;margin-right:10%;">
                    <li class="nav-item">
                        <div style="display: flex; align-items: center;margin-right: 10px;">
                            <img src="assets\avion.png" alt="Menu Icon" style="width:70%;">
                            <h3>VuelaBodo</h3>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php" style="font-size: 25px;color:white;margin-left: 100%;top: 2%;">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="servicios.php" style="font-size: 25px;color:white;margin-left: 100%;">Vuelos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Login.php" style="font-size: 25px;color:white;width:150%;margin-left: 100%;">Reserva</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Login.php" style="font-size: 25px;color:white;width:150%;margin-left: 100%;">Dashboard</a>
                    </li>
                </ul>
            </nav>
    
    

        <button id="menu-toggle" class="btn btn"  style="position: absolute; right: 0;top:-1%;">
            <img src="assets\perfil.png" alt="Menu Icon" style="width:40%;">
        </button>
    </div>
</header>

<!-- Mini navigation bar placed outside the header -->
<nav id="mini-nav" class="mini-nav  py-200 px-3" style="position: absolute; top: calc(10% + 3px); right: 15%;background-color: rgba(143, 188, 234, 1);width:15%;font-size:25px; border-radius: 10px;">
    <ul class="list-unstyled mb-0">
        
        <li><a href="#">Agregar vuelo</a></li>
        <li><a href="#">Agregar producto millas</a></li>
        <li><a href="#">Registrar admin</a></li>
        <li><a href="menunologin.php">Log out</a></li>
    </ul>
</nav>

<h1>Bienvenido, vuela con los mejores</h1>

<!-- Link to the JavaScript file -->
<script src="scripts\menu.js"></script>
</body>
</html>
