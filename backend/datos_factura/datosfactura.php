<?php
session_start();
require_once '../../functions/funciones.php';
include "../../functions/conexion.php";
date_default_timezone_set('America/Asuncion');
$usernickname = $_SESSION["nombre_usuario"];
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

    $query = "SELECT * FROM `empresa_activa` ea 
    INNER JOIN sucursales s ON ea.id_sucursal = s.id_sucursal
    INNER JOIN cajas c ON ea.id_caja = c.id_caja
    WHERE ea.usuario =  :usuario";
    $stmt = $connect->prepare($query);
    $stmt->bindParam(':usuario', $usernickname, PDO::PARAM_STR);
    $stmt->execute();
    $empresa_activa = $stmt->fetch(PDO::FETCH_ASSOC);

    $nro_sucursal = $empresa_activa['nro_sucursal'];
    $nro_caja = $empresa_activa['nro_caja'];


    // // Obtener el timbrado vigente
    $sqltimbrado = "SELECT * FROM timbrado WHERE id_empresa = :id_empresa AND id_sucursal = :id_sucursal 
    AND id_caja = :id_caja";
    $stmt = $connect->prepare($sqltimbrado);
    $stmt->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
    $stmt->bindParam(':id_sucursal', $id_sucursal, PDO::PARAM_INT);
    $stmt->bindParam(':id_caja', $id_caja, PDO::PARAM_INT);
    $stmt->execute();
    $timbrado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$timbrado) {
        throw new Exception("No se encontró un timbrado válido para la empresa.");
    }
    $id_timbrado = $timbrado["id_timbrado"];

    // Obtener la numeración de la factura
    $sqlnumeracion = "SELECT * FROM `numeracion_factura` nf
                    INNER JOIN timbrado tr ON nf.id_timbrado=tr.id_timbrado
                      WHERE nf.id_empresa = :id_empresa 
                      AND nf.id_sucursal = :id_sucursal 
                      AND nf.id_caja = :id_caja
                      AND nf.id_timbrado = :id_timbrado";
    $stmt = $connect->prepare($sqlnumeracion);
    $stmt->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
    $stmt->bindParam(':id_sucursal', $id_sucursal, PDO::PARAM_INT);
    $stmt->bindParam(':id_caja', $id_caja, PDO::PARAM_INT);
    $stmt->bindParam(':id_timbrado', $id_timbrado, PDO::PARAM_INT);
    $stmt->execute();
    $datosfactura = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$datosfactura) {
        throw new Exception("No se encontró la numeración de factura para la empresa, sucursal y caja seleccionadas.");
        exit;
    }

    $ultimo_numero = $datosfactura['ultimo_numero'];

    $nro_timbrado = $datosfactura["nro_timbrado"];
    $fecha_vencimiento = $datosfactura["fecha_vencimiento"];

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
        exit;
    }

    $nrosucursal = $resultado['nro_sucursal'];
    $nrocaja = $resultado['nro_caja'];

    // Formatear el número de factura
    $formatproximonumero = $nrosucursal . '-' . $nrocaja . '-' . $parte3;

    // Devolver respuesta JSON
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'nro_factura' => $formatproximonumero,
        'nro_timbrado' => $nro_timbrado,
        'fecha_vencimiento' => $fecha_vencimiento,
        'prefijosucursal' => $nrosucursal,
        'prefijocaja' => $nrocaja
    ]);
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'nro_factura' => 'VACIO',
        'nro_timbrado' => 'VACIO',
        'fecha_vencimiento' => 'VACIO',
        'prefijosucursal' => $nro_sucursal ?? 'VACIO',
        'prefijocaja' => $nro_caja ?? 'VACIO'
    ]);
} finally {
    // Cerrar la conexión
    if (isset($connect)) {
        $connect = null;
    }
}
