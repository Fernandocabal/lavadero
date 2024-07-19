<?php
include "../connet/conexion.php";

$vehicleId = $_GET['vehicleId']; // Obtener ID del vehículo del parámetro de consulta

$options = []; // Inicializar un array vacío para las opciones

// Consulta para obtener opciones basadas en el ID del vehículo
$sql = "SELECT p.id_precios, p.producto, p.precio, p.id_vehiculo  FROM precios p
          INNER JOIN vehiculos vp ON vp.id_vehiculos = p.id_vehiculo
          WHERE vp.id_vehiculos = $vehicleId";

$result = $connect->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = [
            'id_precios' => $row['id_precios'],
            'producto' => $row['producto'],
            'precio' => $row['precio']
        ];
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No se encontraron opciones para este vehículo']);
    exit;
}

echo json_encode(['success' => true, 'options' => $options]);
