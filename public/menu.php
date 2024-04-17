<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto_NAV</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Your custom CSS -->
    <link rel="stylesheet" href="styles/menu.css">
</head>
<body>
<header class="py-3">
    <div class="container d-flex justify-content-between align-items-center"style=" padding: 20px; margin-top: 15px; margin-bottom: 5px;">
    <nav class="navbar navbar-expand-lg navbar" style="position: absolute; left: 3%; padding: 20px;  margin-bottom: 5px;">

            <ul class="navbar-nav" style="font-size: 20px;">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="servicios.php">Vuelos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Login.php">Check in</a>
                </li>
                
            </ul>
        </nav>
        <button id="menu-toggle" class="btn btn"  style="position: absolute; right: -3%;top:-1%;">
            <img src="styles\imagen\perfil.png" alt="Menu Icon" style="width:40%;">
        </button>
    </div>
</header>

<!-- Mini navigation bar placed outside the header -->
<nav id="mini-nav" class="mini-nav  py-200 px-3" style="position: absolute; top: calc(10% + 10px); right: 10%;background-color: rgba(143, 188, 234, 1);width:10%; ">
    <ul class="list-unstyled mb-0">
        <li><a href="#">Perfil</a></li>
        <li><a href="#">Millas</a></li>
        <li><a href="#">Log out</a></li>
    </ul>
</nav>


<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Your custom JavaScript -->
<script>
    document.getElementById('menu-toggle').addEventListener('click', function() {
        document.getElementById('mini-nav').classList.toggle('show');
    });
</script>
</body>
</html>
