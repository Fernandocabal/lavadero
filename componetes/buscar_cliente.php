<?php
include "../connet/conexion.php";


$q = $_GET['q'];

$sql = "SELECT * FROM `clientes` WHERE nombres LIKE ?";
$stmt = $connect->prepare($sql);
$search_value = "%$q%";
$stmt->bind_param("s", $search_value);
if ($stmt->execute()) {
    $result = $stmt->get_result();

    $results = [];
    while ($row = $result->fetch_assoc()) {
        $results[] = [
            'id' => $row['id_cliente'],
            'text' => $row['nombres']
        ];
    }

    echo json_encode(['items' => $results]);
} else {
    echo json_encode(['error' => $stmt->error]);
}
$stmt->close();
$connect->close();
