<?php
include "../functions/conexion.php";
date_default_timezone_set('America/Asuncion');
try {
    $sqltimbrado = "SELECT * FROM `timbrado`";
    $stmt = $connect->prepare($sqltimbrado);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nro_timbrado = $row["nro_timbrado"];
        $sucursal = $row["sucursal"];
        $caja = $row["caja"];
        $fecha_vencimiento = $row["fecha_vencimiento"];
    }
    $queryid = "SELECT COALESCE(MAX(ultimo_numero), 0) + 1 AS proximonumero FROM numeracion_factura";
    $stmtquery = $connect->prepare($queryid);
    $stmtquery->execute();
    $row = $stmtquery->fetch(PDO::FETCH_ASSOC);
    $proximonumero = $row['proximonumero'] ?? 0;
    $parte3 = str_pad($proximonumero, 7, '0', STR_PAD_LEFT);
    $formatproximonumero = $sucursal . '-' . $caja . '-' . $parte3;
} catch (PDOException $e) {
    echo 'Error ' . $e->getMessage();
}
