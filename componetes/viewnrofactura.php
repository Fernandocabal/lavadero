<?php

$queryid = "SELECT COALESCE(MAX(ultimo_numero), 0) + 1 AS proximonumero FROM numeracion_factura";
$result = $connect->query($queryid);
$row = $result->fetch_assoc();
$proximonumero = $row['proximonumero'] ?? 0;
$parte3 = str_pad($proximonumero, 7, '0', STR_PAD_LEFT);

// Formatear el número final
echo $formatproximonumero = $sucursal . '-' . $caja . '-' . $parte3;
