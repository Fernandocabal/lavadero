<?php
include "../connet/conexion.php";
$sql = ("SELECT * FROM `clientes`");
if ($result = $connect->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $id_cliente = $row["id_cliente"];
        $nombres = $row["nombres"];
        $apellidos = $row["apellidos"];
        $nroci = $row["nroci"];
        echo "<option value='$id_cliente'>$nombres" . " $apellidos" . " ($nroci)</option>";
    }
}
