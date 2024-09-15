<?php
include "../functions/conexion.php";

$proveedor = $_POST["proveedor"];
// $proveedor = $_GET["proveedor"];
$response = [];
try {
    $sql = "SELECT * FROM `proveedores` WHERE ruc_proveedor = :proveedor";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':proveedor', $proveedor, PDO::PARAM_STR);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $response = [
            'id_proveedor' => $row['id_proveedor'],
            'nombre_proveedor' => $row['nombre_proveedor'],
            'ruc_proveedor' => $row['ruc_proveedor']
        ];
    }
    if (count($response) > 0) {
        echo json_encode([
            'success' => true,
            'respuesta' => $response
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se encontraron registros'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Proveedor no encontrado ']);
}
