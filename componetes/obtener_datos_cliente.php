<?php
include "../connet/conexion.php";

$id = $_POST["id"];


$sql = "SELECT * FROM clientes WHERE id_cliente = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $id);

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if ($row) {
    $data = [
        'id_cliente' => $row['id_cliente'],
        'nombres' => $row['nombres'],
        'apellidos' => $row['apellidos'],
        'nroci' => $row['nroci'],
        'email' => $row['email'],
        'direccion' => $row['direccion'],
        'phonenumber' => $row['phonenumber'],

    ];
    echo json_encode($data);
} else {
    // Manejar el caso en que no se encuentre ningún resultado
    echo json_encode(['error' => 'Cliente no encontrado']);
}


$stmt->close();
$connect->close();
