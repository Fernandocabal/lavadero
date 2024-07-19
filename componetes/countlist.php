<?php
include "../connet/conexion.php";
$query = ("SELECT COUNT(*) conteo FROM `recepcion`");

if ($result = $connect->query($query)) {
    while ($row = $result->fetch_assoc()) {
        $conteo = $row["conteo"];
    }
    echo "<h2>Tienes " . $conteo . " vehiculos en la <a href='../pages/recepcionvh.php' style='text-decoration:none'>Lista de espera</a>";
}
