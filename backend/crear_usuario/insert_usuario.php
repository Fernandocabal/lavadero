<?php
include __DIR__ . '/../../functions/conexion.php';
date_default_timezone_set('America/Asuncion');
session_start();
include __DIR__ . '/../../functions/funciones.php';
if (!estalogueado()) {
    echo json_encode(['success' => false, 'message' => 'No has iniciado sesión o la sesión ha expirado']);
    exit();
}
if (isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["usernickname"]) && isset($_POST["documento"]) && isset($_POST["inputemail"]) && isset($_POST["password"]) && isset($_POST["nombre_empresa"]) && isset($_POST["sucursal"]) && isset($_POST["caja"])) {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $username = $_POST["usernickname"];
    $documento = $_POST["documento"];
    $inputemail = $_POST["inputemail"];
    $password = $_POST["password"];
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $id_empresa = $_POST["nombre_empresa"];
    $id_sucursal = $_POST["sucursal"];
    $id_caja = $_POST["caja"];
    $fecha = date('d/m/Y H:i');
    // var_dump($nombre);
    $query = "SELECT `documento`, `nombre_usuario` FROM `usuarios` WHERE documento = :documento OR nombre_usuario = :nombre_usuario";
    $stmt = $connect->prepare($query);
    $stmt->bindParam(':documento', $documento);
    $stmt->bindParam(':nombre_usuario', $username);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Ya existe un usuario con el número de documento: ' . $documento . ' o con el nombre de usuario: ' . $username]);
    } else {
        try {
            $connect->beginTransaction();

            $sql = "INSERT INTO `usuarios`(`nombre_usuario`, `nombre`, `apellido`, `documento`, `email`, `fecha_nacimiento`, `password`) VALUES (:username, :nombre, :apellido, :documento, :email, :fecha_nacimiento, :password)";
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
            $stmt->bindParam(':documento', $documento, PDO::PARAM_STR);
            $stmt->bindParam(':email', $inputemail, PDO::PARAM_STR);
            $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $sqlempresa = "INSERT INTO `empresa_activa`( `usuario`, `id_empresa`, `id_sucursal`, `id_caja`, `ult_fecha_modificacion`) VALUES (:username, :id_empresa, :id_sucursal, :id_caja, :fecha)";
                $stmt = $connect->prepare($sqlempresa);
                $stmt->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt->bindParam(':id_empresa', $id_empresa, PDO::PARAM_STR);
                $stmt->bindParam(':id_sucursal', $id_sucursal, PDO::PARAM_STR);
                $stmt->bindParam(':id_caja', $id_caja, PDO::PARAM_STR);
                $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);

                $stmt->execute();
                echo json_encode([
                    'success' => true,
                    'message' => 'Se ha creado el usuario correctamente.',
                    'userData' => [
                        'username' => $username,
                        'password' => $password,
                        'email' => $inputemail
                    ]
                ]);
            }

            $connect->commit();
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Hubo un error en el proceso: ' . $e->getMessage()]);
        }
    };
} else {
    echo json_encode(['success' => false, 'message' => 'Hay algo mal con los datos proporcionados']);
}


// var_dump($_POST);
