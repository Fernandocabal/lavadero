<?php
include "../functions/conexion.php";

$id = $_POST["id"];
try {
    $sql = "SELECT * FROM clientes WHERE id_cliente = :id";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Cliente no encontrado ' . $e->getMessage()]);
}
