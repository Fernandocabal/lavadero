<?php
include "../functions/conexion.php";
header('Content-Type: application/json');

$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
$id = isset($_POST['id']) ? $_POST['id'] : '';

if ($tipo === 'sucursal') {
    $query = "SELECT * FROM sucursales WHERE id_empresa = :id";
    $stmt = $connect->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $sucursales = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode([
        'sucursales' => $sucursales
    ]);
} elseif ($tipo === 'caja') {
    $query = "SELECT * FROM cajas WHERE id_sucursal = :id";
    $stmt = $connect->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $cajas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode([
        'cajas' => $cajas
    ]);
} else {
    echo json_encode([
        'error' => 'Tipo de solicitud no válido'
    ]);
}
