<?php
include "../connet/conexion.php";

$sql = "SELECT * FROM `precios`";
$stmt = $connect->prepare($sql);


$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $nombreproducto = $row["producto"];
    $precioproducto = $row["precio"];
    $id_precios = $row["id_precios"];
    echo "<option value='$id_precios'>$nombreproducto </option>";
}

$stmt->close();
$connect->close();
