<?php
include "../functions/conexion.php";
try {
    $sql = "SELECT * FROM `precios`";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nombreproducto = $row["producto"];
        $precioproducto = $row["precio"];
        $id_precios = $row["id_precios"];
        echo "<option value='$id_precios'>$nombreproducto </option>";
    }
} catch (PDOException $e) {
    echo 'Error ' . $e->getMessage();
}
