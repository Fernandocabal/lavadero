<?php
include "../functions/conexion.php";
date_default_timezone_set('America/Asuncion');
if (!isset($_SESSION['id_empresa_activa'])) {
    echo "No se ha asignado id_empresa en la sesión.";
} else {
    $id_empresa = $_SESSION['id_empresa_activa'];
}
try {
    $sqltimbrado = "SELECT * FROM `timbrado` WHERE id_empresa = :id";
    $stmt = $connect->prepare($sqltimbrado);
    $stmt->bindParam(':id', $id_empresa, PDO::PARAM_INT);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nro_timbrado = $row["nro_timbrado"];
        $sucursal = $row["sucursal"];
        $caja = $row["caja"];
        $fecha_vencimiento = $row["fecha_vencimiento"];
    }
    $sqlnumeracion = "SELECT * FROM numeracion_factura WHERE id_empresa = :id";
    $stmt = $connect->prepare($sqlnumeracion);
    $stmt->bindParam(':id', $_SESSION['id_empresa_activa'], PDO::PARAM_INT);
    $stmt->execute();
    $numeracion = $stmt->fetch(PDO::FETCH_ASSOC);
    $ultimo_numero = $numeracion['ultimo_numero'];
    $proximonumero = $ultimo_numero + 1;
    $parte3 = str_pad($proximonumero, 7, '0', STR_PAD_LEFT);  // 7 dígitos, rellena con ceros a la izquierda
    $formatproximonumero = $sucursal . '-' . $caja . '-' . $parte3;
} catch (PDOException $e) {
    echo 'Error ' . $e->getMessage();
}
