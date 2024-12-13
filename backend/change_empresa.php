<?php
include "../functions/conexion.php";
date_default_timezone_set('America/Asuncion');
session_start();
require_once '../functions/funciones.php';
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION["apellido"];
$usernickname = $_SESSION["nombre_usuario"];

if (!empty($_POST["nombre_empresa"]) and !empty($_POST["sucursal"]) and !empty($_POST["caja"])) {
    $id_empresa = $_POST["nombre_empresa"];
    $sucursal = $_POST["sucursal"];
    $caja = (string) $_POST["caja"];
    try {
        if (!estaSesionIniciada()) {
            throw new Exception("No haz iniciado sesión");
            exit();
        }
        $connect->beginTransaction();
        $stmt = $connect->prepare("SELECT * FROM empresa_activa WHERE usuario= :usuario");
        $stmt->bindParam(':usuario', $usernickname, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $activenow = (int) $row['id_empresa_activa'];
            $stmt = $connect->prepare("UPDATE `empresa_activa` 
                                        SET id_empresa= :new_id_empresa, sucursal= :new_sucursal, caja= :new_caja 
                                        WHERE  id_empresa_activa= :empresa_activa");
            $stmt->bindParam(':empresa_activa', $activenow, PDO::PARAM_INT);
            $stmt->bindParam(':new_id_empresa', $id_empresa, PDO::PARAM_INT);
            $stmt->bindParam(':new_sucursal', $sucursal, PDO::PARAM_INT);
            $stmt->bindParam(':new_caja', $caja, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $connect->commit();
                echo json_encode(['success' => true, 'message' => 'Se ha cambiado de empresa!']);
            } else {
                $connect->rollBack();
                echo json_encode(['success' => false, 'message' => 'No se actualizó ningún registro']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'El usuario no existe']);
        }
    } catch (PDOException $e) {
        $connect->rollBack();
        echo json_encode([
            'success' => false,
            'message' => 'Error al insertar datos: ' . $e->getMessage()
        ]);
    }
    $connect = null;
} else {
    echo json_encode(['success' => false, 'message' => 'COMPLETA LOS DATOS PARA CAMBIAR TU EMPRESA']);
}
