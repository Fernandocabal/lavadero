<?php
include "../functions/conexion.php";
date_default_timezone_set('America/Asuncion');
session_start();
require_once '../functions/funciones.php';

if (!empty($_POST["pass-actual"]) and !empty($_POST["new_password"]) and !empty($_POST["confirm_password"])) {
    $pass_actual = $_POST["pass-actual"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    try {
        if (!estalogueado()) {
            throw new Exception("No has iniciado sesión");
            exit();
        }

        $stmt = $connect->prepare("SELECT * FROM usuarios WHERE nombre_usuario= :usuario");
        $stmt->bindParam(':usuario', $_SESSION["nombre_usuario"], PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $userpass = $row["password"];

            if (password_verify($pass_actual, $userpass)) {

                if ($new_password !== $confirm_password) {
                    echo json_encode(['success' => false, 'message' => '¡Las contraseñas no coinciden!']);
                    exit();
                }

                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

                $stmt = $connect->prepare("UPDATE usuarios SET password = :new_password WHERE nombre_usuario = :usuario");
                $stmt->bindParam(':new_password', $hashed_password, PDO::PARAM_STR);
                $stmt->bindParam(':usuario', $_SESSION["nombre_usuario"], PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    echo json_encode(['success' => true, 'message' => 'Contraseña actualizada correctamente']);
                } else {

                    echo json_encode(['success' => false, 'message' => 'No se realizó ninguna actualización']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Contraseña actual incorrecta']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'El usuario no existe']);
        }
    } catch (PDOException $e) {

        $connect->rollBack();
        echo json_encode(['success' => false, 'message' => 'Error al insertar datos: ' . $e->getMessage()]);
    }

    $connect = null;
} else {
    echo json_encode(['success' => false, 'message' => 'Completa todos los datos para cambiar tu contraseña']);
}
