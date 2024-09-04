<?php
include "../connet/conexion.php";
date_default_timezone_set('America/Asuncion');
session_start();
try {
    $sqltimbrado = "SELECT * FROM `timbrado`";
    $stmt = $connect->query($sqltimbrado);
    $timbrado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($timbrado) {
        $nro_timbrado = $timbrado["nro_timbrado"];
        $sucursal = $timbrado["sucursal"];
        $caja = $timbrado["caja"];
        $fecha_vencimiento = $timbrado["fecha_vencimiento"];
    }
    $connect->beginTransaction();
    $fecha = date('d/m/Y H:i');
    $precio = $_POST["precio"];
    $descripcion = $_POST["descripcion"];
    $cant_check = count($precio);
    $cantidad = $_POST["cantidad"];
    $nombres = $_POST["nombres"];
    $totalfactura = $_POST['totalfactura'];
    $iva10 = $_POST['sendiva'];
    $sqlcondicion = "SELECT * FROM `condicion` WHERE id_condicion = 1";
    $stmt = $connect->query($sqlcondicion);
    $condicion = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($condicion) {
        $id_condicion = $condicion["id_condicion"];
    }
    function siguientenumero($sucursal, $caja)
    {
        global $connect;
        $stmt = $connect->query("SELECT COUNT(*) FROM numeracion_factura");
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            $query = "INSERT INTO numeracion_factura (ultimo_numero) VALUES (0)";
            $connect->exec($query);
        }

        $stmt = $connect->query("SELECT COALESCE(MAX(ultimo_numero), 0) + 1 AS proximonumero FROM numeracion_factura");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $proximonumero = $row['proximonumero'] ?? 0;
        $parte3 = str_pad($proximonumero, 7, '0', STR_PAD_LEFT);

        // Formatear el número final
        $formatproximonumero = $sucursal . '-' . $caja . '-' . $parte3;
        $stmt = $connect->prepare("UPDATE numeracion_factura SET ultimo_numero = ?");
        $stmt->execute([$proximonumero]);

        if ($stmt->rowCount() > 0) {
            return $formatproximonumero;
        } else {
            throw new Exception("Error al actualizar el último número");
        }
    }
    $numeroFactura = siguientenumero($sucursal, $caja);
    $insertfacturas = "INSERT INTO `header_factura`(`nro_factura`, `timbrado`, `fecha_horas`, `id_cliente`, `cajero`, `id_condicion`, `subtotal`, `iva`, `total`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connect->prepare($insertfacturas);
    $stmt->execute([$numeroFactura, $nro_timbrado, $fecha, $nombres, $_SESSION["nombre"], $id_condicion, $totalfactura, $iva10, $totalfactura]);
    $idinsertado = $connect->lastInsertId();

    $insertdetalle = "INSERT INTO `detalle_factura`(`id_header`, `detalle`, `cantidad`, `precio`) VALUES (?, ?, ?, ?)";
    $stmt = $connect->prepare($insertdetalle);
    for ($i = 0; $i < $cant_check; $i++) {
        $descripcion = $descripcion[$i];
        $precio = $precio[$i];
        $cantidad = $cantidad[$i];

        $stmt->execute([$idinsertado, $descripcion, $cantidad, $precio]);
    }
    $connect->commit();

    echo json_encode([
        'success' => true,
        'id' => $idinsertado,
        'message' => 'La factura se ha generado!'
    ]);
} catch (PDOException $e) {
    $connect->rollBack();
    echo json_encode([
        'success' => false,
        'message' => 'Error al insertar datos: ' . $e->getMessage()
    ]);
}
$connect = null;
