<?php
include "../connet/conexion.php";

$id = $_POST["idproducto"];

try {
    $sql = "SELECT * FROM precios WHERE id_precios = :id";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $data[] = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data = [
            'id_productos' => $row['id_precios'],
            'producto' => $row['producto'],
            'precio' => $row['precio']
        ];
        echo json_encode($data);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Error en la consulta: ' . $e->getMessage()]);
}
