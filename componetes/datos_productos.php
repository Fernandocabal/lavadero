<?php
include "../connet/conexion.php";

$id = $_POST["idproducto"];


$sql = "SELECT * FROM precios WHERE id_precios = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $id);

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if ($row) {
    $data = [
        'id_precios' => $row['id_precios'],
        'producto' => $row['producto'],
        'precio' => $row['precio']
    ];
    echo json_encode($data);
} else {
    // Manejar el caso en que no se encuentre ningún resultado
    echo json_encode(['error' => 'Cliente no encontrado']);
}


$stmt->close();
$connect->close();
