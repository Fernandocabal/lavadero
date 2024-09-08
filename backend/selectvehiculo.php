<?php
include "../functions/conexion.php";
try {
    $sql = ("SELECT * FROM `vehiculos`");
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id_vehiculos = $row["id_vehiculos"];
        $tipo_vehiculos = $row["tipos_vehiculos"];
        echo "<option value='$id_vehiculos'>$tipo_vehiculos</option>";
    };
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
