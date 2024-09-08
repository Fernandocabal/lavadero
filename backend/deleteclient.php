<?php
include "../functions/conexion.php";

$id = $_POST["id"];

try {
    $sql = "DELETE FROM `clientes` WHERE `id_cliente` = :id";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    if ($stmt->execute()) {
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "Error al eliminar el cliente: " . $errorInfo[2];
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
