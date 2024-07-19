<?php
include "../connet/conexion.php";
$sql = ("SELECT * FROM `vehiculos`");
if ($result = $connect->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $id_vehiculos = $row["id_vehiculos"];
        $tipo_vehiculos = $row["tipos_vehiculos"];
        echo "<option value='$id_vehiculos'>$tipo_vehiculos</option>";
    }
};
