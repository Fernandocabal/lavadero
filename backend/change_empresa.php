<?php
include "../functions/conexion.php";
date_default_timezone_set('America/Asuncion');
session_start();
require_once '../functions/funciones.php';

try {
    if (!estalogueado()) {
        throw new Exception("No has iniciado sesión o la sesión ha expirado");
    }

    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION["apellido"];
    $usernickname = $_SESSION["nombre_usuario"];
    $fecha = date('d/m/Y H:i');

    // Validar datos del formulario
    if (empty($_POST["nombre_empresa"]) || empty($_POST["sucursal"]) || empty($_POST["caja"])) {
        throw new Exception("Completa los datos para cambiar tu empresa");
    }

    $id_empresa = filter_var($_POST["nombre_empresa"], FILTER_VALIDATE_INT);
    $id_sucursal = filter_var($_POST["sucursal"], FILTER_VALIDATE_INT);
    $id_caja = filter_var($_POST["caja"], FILTER_SANITIZE_STRING);

    if ($id_empresa === false || $id_sucursal === false || $id_caja === false) {
        throw new Exception("Datos del formulario no válidos");
    }

    // Iniciar transacción
    $connect->beginTransaction();

    // Verificar si el usuario tiene una empresa activa
    $stmt = $connect->prepare("SELECT id_empresa_activa FROM empresa_activa WHERE usuario = :usuario");
    $stmt->bindParam(':usuario', $usernickname, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        throw new Exception("El usuario no tiene una empresa activa");
    }

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $activenow = (int) $row['id_empresa_activa'];

    // Actualizar empresa activa
    $stmt = $connect->prepare("UPDATE empresa_activa 
                               SET id_empresa = :new_id_empresa, 
                                   id_sucursal = :new_sucursal, 
                                   id_caja = :new_caja,
                                   ult_fecha_modificacion = :fecha 
                               WHERE id_empresa_activa = :empresa_activa");
    $stmt->bindParam(':empresa_activa', $activenow, PDO::PARAM_INT);
    $stmt->bindParam(':new_id_empresa', $id_empresa, PDO::PARAM_INT);
    $stmt->bindParam(':new_sucursal', $id_sucursal, PDO::PARAM_INT);
    $stmt->bindParam(':new_caja', $id_caja, PDO::PARAM_STR);
    $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        throw new Exception("No se actualizó ningún registro");
    }

    // Actualizar variables de sesión
    $_SESSION['id_empresa_activa'] = $id_empresa;
    $_SESSION['id_sucursal_activa'] = $id_sucursal;
    $_SESSION['id_caja_activa'] = $id_caja;
    $_SESSION['last_activity'] = time();

    // Confirmar transacción
    $connect->commit();
    echo json_encode(['success' => true, 'message' => 'Se ha cambiado de empresa!']);
} catch (Exception $e) {
    // Revertir transacción en caso de error
    if ($connect->inTransaction()) {
        $connect->rollBack();
    }
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} finally {
    // Cerrar conexión
    if (isset($connect)) {
        $connect = null;
    }
}
