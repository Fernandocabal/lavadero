<?php
include "../functions/conexion.php";
date_default_timezone_set('America/Asuncion');
try {
    // Verificar sesión y empresa activa
    if (!isset($_SESSION['id_empresa_activa']) || empty($_SESSION['id_empresa_activa'])) {
        throw new Exception("No se ha seleccionado una empresa activa.");
    }

    // Validar y obtener datos de sesión
    $id_empresa = filter_var($_SESSION['id_empresa_activa'], FILTER_VALIDATE_INT);
    $id_sucursal = filter_var($_SESSION['id_sucursal_activa'], FILTER_VALIDATE_INT);
    $id_caja = filter_var($_SESSION['id_caja_activa'], FILTER_VALIDATE_INT);

    if ($id_empresa === false || $id_sucursal === false || $id_caja === false) {
        throw new Exception("Datos de sesión no válidos.");
    }

    // Obtener el timbrado vigente
    $sqltimbrado = "SELECT nro_timbrado, fecha_vencimiento FROM timbrado WHERE id_empresa = :id";
    $stmt = $connect->prepare($sqltimbrado);
    $stmt->bindParam(':id', $id_empresa, PDO::PARAM_INT);
    $stmt->execute();
    $timbrado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$timbrado) {
        throw new Exception("No se encontró un timbrado válido para la empresa.");
    }

    $nro_timbrado = $timbrado["nro_timbrado"];
    $fecha_vencimiento = $timbrado["fecha_vencimiento"];

    // Obtener la numeración de la factura
    $sqlnumeracion = "SELECT ultimo_numero FROM numeracion_factura 
                      WHERE id_empresa = :id_empresa 
                      AND id_sucursal = :id_sucursal 
                      AND id_caja = :id_caja";
    $stmt = $connect->prepare($sqlnumeracion);
    $stmt->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
    $stmt->bindParam(':id_sucursal', $id_sucursal, PDO::PARAM_INT);
    $stmt->bindParam(':id_caja', $id_caja, PDO::PARAM_INT);
    $stmt->execute();
    $numeracion = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$numeracion) {
        throw new Exception("No se encontró la numeración de factura para la empresa, sucursal y caja seleccionadas.");
    }

    $ultimo_numero = $numeracion['ultimo_numero'];
    $proximonumero = $ultimo_numero + 1;
    $parte3 = str_pad($proximonumero, 7, '0', STR_PAD_LEFT);  // 7 dígitos, rellena con ceros a la izquierda

    // Obtener número de sucursal y caja
    $sqlnrosucursal = "SELECT s.nro_sucursal, c.nro_caja 
                       FROM sucursales s 
                       JOIN cajas c ON s.id_sucursal = c.id_sucursal 
                       WHERE s.id_sucursal = :id_sucursal AND c.id_caja = :id_caja";
    $stmt = $connect->prepare($sqlnrosucursal);
    $stmt->bindParam(':id_sucursal', $id_sucursal, PDO::PARAM_INT);
    $stmt->bindParam(':id_caja', $id_caja, PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$resultado) {
        throw new Exception("No se encontró la sucursal o caja seleccionada.");
    }

    $nrosucursal = $resultado['nro_sucursal'];
    $nrocaja = $resultado['nro_caja'];

    // Formatear el número de factura
    $formatproximonumero = $nrosucursal . '-' . $nrocaja . '-' . $parte3;

    // Devolver respuesta JSON
    // echo json_encode([
    //     'success' => true,
    //     'nro_factura' => $formatproximonumero,
    //     'nro_timbrado' => $nro_timbrado,
    //     'fecha_vencimiento' => $fecha_vencimiento
    // ]);
} catch (Exception $e) {
    // Devolver error en formato JSON
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    // Cerrar la conexión
    if (isset($connect)) {
        $connect = null;
    }
}
