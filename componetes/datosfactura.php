<?php
include "../connet/conexion.php";
date_default_timezone_set('America/Asuncion');
//Seleccionamos el timbrado
$sqltimbrado = "SELECT * FROM `timbrado`";
if ($result = $connect->query($sqltimbrado)) {
    while ($row = $result->fetch_assoc()) {
        $nro_timbrado = $row["nro_timbrado"];
        $sucursal = $row["sucursal"];
        $caja = $row["caja"];
        $fecha_vencimiento = $row["fecha_vencimiento"];
    }
}
$queryid = "SELECT COALESCE(MAX(ultimo_numero), 0) + 1 AS proximonumero FROM numeracion_factura";
$result = $connect->query($queryid);
$row = $result->fetch_assoc();
$proximonumero = $row['proximonumero'] ?? 0;
$parte3 = str_pad($proximonumero, 7, '0', STR_PAD_LEFT);
$formatproximonumero = $sucursal . '-' . $caja . '-' . $parte3;
