<?php
include "../connet/conexion.php";
$consulta = ("SELECT * FROM `ciudades`");
if ($result = $connect->query($consulta)) {
    while ($row = $result->fetch_assoc()) {
        $id_ciudad = $row["id_ciudad"];
        $nombre = $row["nombre"];
        echo "<option value='$id_ciudad'>$nombre</option>";
    }
}
