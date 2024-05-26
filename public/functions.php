<?php
function obtener_cvuelo_del_asiento($conn, $casiento_seleccionado) {
    try {
        $query = "SELECT cvuelo FROM asientos_vuelo WHERE casiento = :casiento";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':casiento', $casiento_seleccionado);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['cvuelo'] : false;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}
?>
