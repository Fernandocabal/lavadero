<?php
include "../functions/conexion.php";
date_default_timezone_set('America/Asuncion');
session_start();
require_once '../functions/funciones.php';
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION["apellido"];
$usernickname = $_SESSION["nombre_usuario"];

if (!empty($_POST["pass-actual"]) and !empty($_POST["new_password"]) and !empty($_POST["confirm_password"])) {
    $pass_actual = $_POST["pass-actual"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];
    try {

        if (!estaSesionIniciada()) {
            throw new Exception("No haz iniciado sesión");
            exit();
        }
        $stmt = $connect->prepare("SELECT * FROM usuarios WHERE nombre_usuario= :usuario");
        $stmt->bindParam(':usuario', $usernickname, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_usuario = $row['id_usuario'];
            $userpass = $row["password"];
            if (password_verify($pass_actual, $userpass)) {
                if ($new_password !== $confirm_password) {
                    echo json_encode(['success' => false, 'message' => '¡Las contraseñas no coinciden!']);
                    exit();
                }
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $stmt = $connect->prepare("UPDATE `usuarios` SET password= :new_password WHERE  nombre_usuario= :usuario");
                $stmt->bindParam(':new_password', $hashed_password, PDO::PARAM_STR);
                $stmt->bindParam(':usuario', $usernickname, PDO::PARAM_STR);
                $stmt->execute();
                echo json_encode(['success' => true, 'message' => 'Contraseña Actualizada correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta']);
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
    echo json_encode(['success' => false, 'message' => 'COMPLETA LOS DATOS PARA CAMBIAR TU CONTRASEÑA']);
}
