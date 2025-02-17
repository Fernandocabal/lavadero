<?php
include "../functions/conexion.php";
date_default_timezone_set('America/Asuncion');
session_start();
require_once '../functions/funciones.php';

if (!estaSesionIniciada()) {
    throw new Exception("No haz iniciado sesión");
    exit();
}
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION["apellido"];
$usernickname = $_SESSION["nombre_usuario"];

if (!empty($_POST["nombre_empresa"]) and !empty($_POST["sucursal"]) and !empty($_POST["caja"])) {
    $id_empresa = $_POST["nombre_empresa"];
    $sucursal = (string)$_POST["sucursal"];
    $caja = (string) $_POST["caja"];
    try {
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
                $stmt_empresa = $connect->prepare("SELECT 
                empresa_activa.id_empresa AS id_empresa_activa,
                empresa_activa.usuario,
                empresa_activa.id_empresa,
                empresa_activa.sucursal,
                empresa_activa.caja,
                empresa_activa.ult_fecha_modificacion,
                sucursales.id_sucursal,
                sucursales.nombre,
                sucursales.prefijo FROM empresa_activa INNER JOIN sucursales 
            ON empresa_activa.sucursal=sucursales.id_sucursal
            WHERE empresa_activa.usuario= :usernickname");
                $stmt_empresa->bindParam(':usernickname', $usernickname, PDO::PARAM_INT);
                $stmt_empresa->execute();
                $empresa_activa = $stmt_empresa->fetch(PDO::FETCH_ASSOC);
                if ($empresa_activa) {
                    $id_empresa = $empresa_activa['id_empresa'];
                    $sucursal_activa = strval($empresa_activa['prefijo']);
                    $caja_activa = strval($empresa_activa['caja']);
                } else {
                    $sucursal_activa = null;
                    $caja_activa = null; // O algún valor por defecto si no hay empresa activa
                }
                $_SESSION['id_empresa_activa'] = $id_empresa;
                $_SESSION['sucursal_activa'] = $sucursal_activa;
                $_SESSION['caja_activa'] = $caja_activa;
                $_SESSION['last_activity'] = time();

                $connect->commit();
                echo json_encode(['success' => true, 'message' => 'Se ha cambiado de empresa!']);
            } else {
                // Si no se actualizó ningún registro, hacer rollback
                $connect->rollBack();
                echo json_encode(['success' => false, 'message' => 'No se actualizó ningún registro']);
            }
        } else {
            // Si el usuario no tiene una empresa activa
            echo json_encode(['success' => false, 'message' => 'El usuario no tiene una empresa activa']);
        }
    } catch (PDOException $e) {
        // En caso de error, hacer rollback y mostrar el mensaje de error
        $connect->rollBack();
        echo json_encode([
            'success' => false,
            'message' => 'Error al insertar datos: ' . $e->getMessage()
        ]);
    } finally {
        // Cerrar la conexión a la base de datos
        $connect = null;
    }
} else {
    // Si los datos del formulario están incompletos
    echo json_encode(['success' => false, 'message' => 'COMPLETA LOS DATOS PARA CAMBIAR TU EMPRESA']);
}
