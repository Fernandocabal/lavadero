<?php
session_start();

include_once '../functions/conexion.php';
header('Content-Type: application/json');

if (!empty($_POST["usuario"]) and !empty($_POST["password"])) {
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];
    try {
        $stmt = $connect->prepare("SELECT * FROM usuarios WHERE nombre_usuario= :usuario");
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_usuario = $row['id_usuario'];
            $userpass = $row["password"];
            $username = $row["nombre"];
            $userlastname = $row["apellido"];
            $usernickname = $row["nombre_usuario"];

            if (password_verify($password, $userpass)) {
                // Obtener la empresa activa del usuario
                $stmt_empresa = $connect->prepare("SELECT 
                    empresa_activa.id_empresa AS id_empresa_activa,
                    empresa_activa.usuario,
                    empresa_activa.id_empresa,
                    empresa_activa.id_sucursal,
                    empresa_activa.id_caja,
                    empresa_activa.ult_fecha_modificacion,
                    sucursales.id_sucursal,
                    sucursales.nombre,
                    sucursales.nro_sucursal FROM empresa_activa INNER JOIN sucursales 
                ON empresa_activa.id_sucursal=sucursales.id_sucursal
                WHERE empresa_activa.usuario= :usernickname");
                $stmt_empresa->bindParam(':usernickname', $usernickname, PDO::PARAM_INT);
                $stmt_empresa->execute();
                $empresa_activa = $stmt_empresa->fetch(PDO::FETCH_ASSOC);

                if ($empresa_activa) {
                    $id_empresa = $empresa_activa['id_empresa'];
                    $id_sucursal_activa = $empresa_activa['id_sucursal'];
                    $id_caja_activa = $empresa_activa['id_caja'];
                } else {
                    $id_sucursal_activa = null;
                    $id_caja_activa = null; // O algún valor por defecto si no hay empresa activa
                }

                $_SESSION['id_usuario'] = $id_usuario;
                $_SESSION["nombre"] = $username;
                $_SESSION["apellido"] = $userlastname;
                $_SESSION["nombre_usuario"] = $usernickname;
                $_SESSION['id_empresa_activa'] = $id_empresa;
                $_SESSION['id_sucursal_activa'] = $id_sucursal_activa;
                $_SESSION['id_caja_activa'] = $id_caja_activa;
                $_SESSION['last_activity'] = time();
                echo json_encode(['success' => true, 'redirect' => './pages/dashboard.php']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'El usuario no existe']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'COMPLETA LOS DATOS PARA INICIAR SESSION']);
}
