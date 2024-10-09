<?php
include "../functions/conexion.php";
try {
    $query = ("SELECT * FROM `condicion`");
    $stmt = $connect->prepare($query);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id_condicion = $row["id_condicion"];
        $condicion = $row["condicion"];
        echo "<option value='$id_condicion'>$condicion</option>";
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
