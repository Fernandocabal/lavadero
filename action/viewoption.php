<?php
include "../connet/conexion.php";

$vehicleId = $_GET['vehicleId'];
try {
    $sql = "SELECT p.id_precios, p.producto, p.precio, p.id_vehiculo
            FROM precios p
            INNER JOIN vehiculos vp ON vp.id_vehiculos = p.id_vehiculo
            WHERE vp.id_vehiculos = :vehicleId";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':vehicleId', $vehicleId, PDO::PARAM_INT);
    $stmt->execute();
    $options = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $options[] = [
            'id_precios' => $row['id_precios'],
            'producto' => $row['producto'],
            'precio' => $row['precio']
        ];
    }
    if (empty($options)) {
        echo json_encode(['success' => false, 'error' => 'No se encontraron opciones para este vehículo']);
    } else {
        echo json_encode(['success' => true, 'options' => $options]);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Error en la consulta: ' . $e->getMessage()]);
}
