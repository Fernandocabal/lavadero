<?php
include "../functions/conexion.php";
try {
    $query = "SELECT COUNT(*) AS conteo FROM `recepcion`";
    $stmt = $connect->prepare($query);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $conteo = $row["conteo"];
    echo "<h2>Tienes " . $conteo . " vehículos en la <a href='../pages/recepcionvh.php' style='text-decoration:none'>Lista de espera</a></h2>";
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
