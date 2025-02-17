<?php
include "../functions/conexion.php";
date_default_timezone_set('America/Asuncion');

try {
    if (!isset($_SESSION['id_empresa_activa']) || empty($_SESSION['id_empresa_activa'])) {
        throw new Exception("No se ha seleccionado una empresa activa.");
    }
    $id_empresa = $_SESSION['id_empresa_activa'];

    $sqltimbrado = "SELECT * FROM `timbrado` WHERE id_empresa = :id";
    $stmt = $connect->prepare($sqltimbrado);
    $stmt->bindParam(':id', $id_empresa, PDO::PARAM_INT);
    $stmt->execute();

    // Obtener los datos del timbrado
    $timbrado = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$timbrado) {
        throw new Exception("No se encontró un timbrado válido para la empresa.");
    }

    $nro_timbrado = $timbrado["nro_timbrado"];
    $fecha_vencimiento = $timbrado["fecha_vencimiento"];


    //Numeración de la factura
    $sqlnumeracion = "SELECT * FROM numeracion_factura WHERE id_empresa = :id";
    $stmt = $connect->prepare($sqlnumeracion);
    $stmt->bindParam(':id', $id_empresa, PDO::PARAM_INT);
    $stmt->execute();
    $numeracion = $stmt->fetch(PDO::FETCH_ASSOC);
    $ultimo_numero = $numeracion['ultimo_numero'];
    $proximonumero = $ultimo_numero + 1;
    $parte3 = str_pad($proximonumero, 7, '0', STR_PAD_LEFT);  // 7 dígitos, rellena con ceros a la izquierda
    $formatproximonumero = $_SESSION['sucursal_activa'] . '-' . $_SESSION['caja_activa'] . '-' . $parte3;
} catch (PDOException $e) {
    echo 'Error ' . $e->getMessage();
}
