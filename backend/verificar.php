<?php
session_start();

include_once '../functions/conexion.php';
header('Content-Type: application/json');

if (!empty($_POST["usuario"]) and !empty($_POST["password"])) {
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];
    try {
        $stmt = $connect->prepare("SELECT * FROM usuarios WHERE nombre_usuario = :usuario");
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_usuario = $row['id_usuario'];
            $userpass = $row["password"];
            $username = $row["nombre"];
            $userlastname = $row["apellido"];
            $usertype = $row["id_tipo"];
            $id_empresa = $row['id_empresa'];
            $usernickname = $row["nombre_usuario"];
            if (password_verify($password, $userpass)) {
                $_SESSION['id_usuario'] = $id_usuario;
                $_SESSION["nombre"] = $username;
                $_SESSION["apellido"] = $userlastname;
                $_SESSION["id_tipo"] = $usertype;
                $_SESSION["nombre_usuario"] = $usernickname;
                $_SESSION['id_empresa'] = $id_empresa;
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
