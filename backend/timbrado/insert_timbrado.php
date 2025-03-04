<?php
include "../../functions/conexion.php";
date_default_timezone_set('America/Asuncion');
session_start();
require_once '../../functions/funciones.php';
$usernickname = $_SESSION["nombre_usuario"];
$sucursal_activa = $_SESSION['id_sucursal_activa'];
$caja_activa = $_SESSION['id_caja_activa'];
$id_empresa = $_SESSION['id_empresa_activa'];
try {
    $connect->beginTransaction();
    if (!estalogueado()) {
        throw new Exception("No haz iniciado sesión");
        exit();
    }
    $query = "SELECT item FROM permisos_usuarios WHERE usuario = :usuario AND empresa= :id_empresa";
    $stmt = $connect->prepare($query);
    $stmt->bindParam(':usuario', $usernickname, PDO::PARAM_STR);
    $stmt->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_COLUMN); // Obtiene solo los valores de 'item'

    if (!in_array('insert_timbrado', $resultados)) {
        throw new Exception("No tienes permisos para insertar nuevos timbrados");
        exit;
    }

    $nrotimbrado = $_POST['nrotimbrado'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];
    $nro_factura = $_POST['nro_factura'];

    $querytimbrado = "SELECT nro_timbrado FROM timbrado WHERE nro_timbrado= :nro_timbrado";
    $stmtquerytimbrado = $connect->prepare($querytimbrado);
    $stmtquerytimbrado->bindParam(':nro_timbrado', $nrotimbrado, PDO::PARAM_STR);
    $stmtquerytimbrado->execute();
    $result = $stmtquerytimbrado->fetchAll(PDO::FETCH_ASSOC);
    if ($result) {
        throw new Exception("Ya existe un timbrado registrado con el numero: " . $nrotimbrado);
        exit;
    }

    if (!preg_match('/^[0-9]{5,9}$/', $nrotimbrado)) {
        throw new Exception("El número de timbrado debe ser un número entre 5 y 9 dígitos.");
        exit;
    }

    // Validación de fecha_inicio (debe ser una fecha válida)
    if (!DateTime::createFromFormat('Y-m-d', $fecha_inicio) || !checkdate(substr($fecha_inicio, 5, 2), substr($fecha_inicio, 8, 2), substr($fecha_inicio, 0, 4))) {
        throw new Exception("La fecha de inicio no es válida.");
        exit;
    }

    // Validación de fecha_vencimiento (debe ser una fecha válida y no puede ser menor que la fecha actual)
    if (!DateTime::createFromFormat('Y-m-d', $fecha_vencimiento) || !checkdate(substr($fecha_vencimiento, 5, 2), substr($fecha_vencimiento, 8, 2), substr($fecha_vencimiento, 0, 4))) {
        throw new Exception("La fecha de vencimiento no es válida.");
        exit;
    }

    $hoy = new DateTime();
    $fecha_vencimiento_obj = new DateTime($fecha_vencimiento);
    if ($fecha_vencimiento_obj < $hoy) {
        throw new Exception("La fecha de vencimiento no puede ser menor a la fecha actual.");
        exit;
    }

    // Validación de nro_factura (debe ser 3 dígitos-3 dígitos-7 dígitos)
    if (!preg_match('/^\d{3}-\d{3}-\d{7}$/', $nro_factura)) {
        throw new Exception("El número de factura debe tener el formato 000-000-0000000.");
        exit;
    }

    // Separar los tres grupos de la factura
    $partes = explode('-', $nro_factura);

    if (count($partes) === 3) {
        // Convertir el último grupo a número entero
        $ultimo_numero_int = (int)$partes[2];

        // Solo restar si el número es mayor a 0
        if ($ultimo_numero_int > 0) {
            $ultimo_numero_int -= 1;
        }

        // Formatear nuevamente con ceros a la izquierda
        $ultimo_numero = str_pad($ultimo_numero_int, 7, '0', STR_PAD_LEFT);
        $nrof = $ultimo_numero + 1;
        $oficial = str_pad($nrof, 7, '0', STR_PAD_LEFT);
        $nueva_factura = "{$partes[0]}-{$partes[1]}-{$oficial}";
    } else {
        throw new Exception("Error al intentar convertir a formate de numero de factura");
        exit;
    }

    $sqlinsert_timbrado = "INSERT INTO `timbrado`( `id_empresa`, `nro_timbrado`, `id_sucursal`, `id_caja`, `fecha_inicio`, `fecha_vencimiento`) VALUES (? ,? ,? ,? ,? ,?)";
    $stmt = $connect->prepare($sqlinsert_timbrado);
    $stmt->execute([$id_empresa, $nrotimbrado, $sucursal_activa, $caja_activa, $fecha_inicio, $fecha_vencimiento]);
    $idinsertado = $connect->lastInsertId();

    $sqlinsertnumeracion = "INSERT INTO `numeracion_factura`(`id_empresa`, `id_sucursal`, `id_caja`, `id_timbrado`, `ultimo_numero`) VALUES (? ,? ,? ,? ,?)";
    $stmt = $connect->prepare($sqlinsertnumeracion);
    $stmt->execute([$id_empresa, $sucursal_activa, $caja_activa, $idinsertado, $ultimo_numero]);

    $connect->commit();
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'message' => 'El timbrado (' . $nrotimbrado . ') se ha insertado con exito, tu numeracion de factura es el: ' . $nueva_factura
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
} catch (Exception $e) {
    $connect->rollBack();
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
$connect = null;
