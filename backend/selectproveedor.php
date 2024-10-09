<?php
include "../functions/conexion.php";
try {
    $sql = ("SELECT * FROM `proveedores`");
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id_proveedor = $row["id_proveedor"];
        $nombre_proveedor = $row["nombre_proveedor"];
        $ruc_proveedor = $row["ruc_proveedor"];
        echo "<option value='$id_proveedor'>$nombre_proveedor" . " ($ruc_proveedor)</option>";
    }
} catch (PDOException $e) {
    echo 'Error ' . $e->getMessage();
}
