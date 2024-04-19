<?php
// Aquí puedes agregar cualquier lógica o procesamiento de PHP necesario
// Por ejemplo, procesar los datos del formulario cuando se envíe

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesar los datos del formulario aquí
    $origen = $_POST["origen"];
    $destino = $_POST["destino"];
    $avion = $_POST["avion"];
    $fecha_vuelo = $_POST["fecha_vuelo"];
    $hora = $_POST["hora"];
    $costo_vip = $_POST["costo_vip"];
    $costo_business = $_POST["costo_business"];
    $costo_economico = $_POST["costo_economico"];

    // Realizar acciones necesarias con los datos, como guardarlos en una base de datos
    // ...
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Vuelo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="styles/agregarVuelo.css">
</head>
<body>
    <div class="container">
    <h2 class="mt-4 mb-3" style="text-align: center;">AGREGAR VUELO</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class="form-group">
                <label for="origen">Origen:</label>
                <select class="form-control" name="origen" id="origen">
                    <option value="1">La Paz</option>
                    <option value="2">Cochabamba</option>
                    <option value="2">Santa Cruz</option>
                </select>
            </div>
            <div class="form-group">
                <label for="destino">Destino:</label>
                <select class="form-control" name="destino" id="destino">
                    <option value="1">La Paz</option>
                    <option value="2">Cochabamba</option>
                    <option value="2">Santa Cruz</option>
                </select>
            </div>
            <div class="form-group">
                <label for="avion">Avión:</label>
                <select class="form-control" name="avion" id="avion">
                    <option value="1">Avión 1</option>
                    <option value="2">Avión 2</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_vuelo">Fecha de Vuelo:</label>
                <input type="text" class="form-control" id="datepicker" name="fecha_vuelo">
            </div>
            <div class="form-group">
                <label for="hora">Hora:</label>
                <input type="time" class="form-control" id="hora" name="hora">
            </div>
            <div id="reloj" class="form-group text-center mt-3"></div>
            <div class="form-group">
                <label for="costo_vip">Costo Asiento VIP:</label>
                <input type="text" class="form-control" id="costo_vip" name="costo_vip">
            </div>
            <div class="form-group">
                <label for="costo_business">Costo Asiento Business:</label>
                <input type="text" class="form-control" id="costo_business" name="costo_business">
            </div>
            <div class="form-group">
                <label for="costo_economico">Costo Asiento Económico:</label>
                <input type="text" class="form-control" id="costo_economico" name="costo_economico">
            </div>
            <button type="submit" class="btn btn-primary">Agregar Vuelo</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="scripts/agregarVuelo.js"></script>
</body>
</html>