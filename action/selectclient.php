<?php
include "../connet/conexion.php";
try {
    $sql = ("SELECT * FROM `clientes`");
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id_cliente = $row["id_cliente"];
        $nombres = $row["nombres"];
        $apellidos = $row["apellidos"];
        $nroci = $row["nroci"];
        echo "<option value='$id_cliente'>$nombres" . " $apellidos" . " ($nroci)</option>";
    }
} catch (PDOException $e) {
    echo 'Error ' . $e->getMessage();
}
