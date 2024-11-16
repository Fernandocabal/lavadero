<?php
include "../functions/conexion.php";
try {
    $query = ("SELECT * FROM `tipo_factura`");
    $stmt = $connect->prepare($query);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id_tipofactura = $row["id_tipofactura"];
        $nombre = $row["nombre"];
        echo "<option value='$id_tipofactura'>$nombre</option>";
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
