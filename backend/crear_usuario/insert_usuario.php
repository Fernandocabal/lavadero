<?php
include __DIR__ . '/../../functions/conexion.php';
date_default_timezone_set('America/Asuncion');
session_start();
include __DIR__ . '/../../functions/funciones.php';
$ruta = __DIR__ . '/../../pages/html_correos/correo_bienvenida.html';

try {

    if (!estalogueado()) {
        throw new Exception('No has iniciado sesión');
    }
    try {
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

                throw new Exception('Ya existe un usuario con el número de documento: ' . $documento . ' o con el nombre de usuario: ' . $username);
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
                    }

                    $connect->commit();

                    $sendcorreo = enviarCorreoBienvenida($inputemail, $nombre, $apellido, $username, $password, $ruta);

                    echo json_encode([
                        'session' => ['success' => true],
                        'usuario' => ['success' => true, 'message' => 'Usuario creado', 'userData' => ['username' => $username]],
                        'correo' => json_decode($sendcorreo) // Respuesta de API correo
                    ]);
                } catch (PDOException $e) {
                    echo json_encode([
                        'session' => ['success' => false, 'message' => $e->getMessage()],
                        'usuario' => ['success' => false, 'message' => $e->getMessage()],
                        'correo' => ['success' => false, 'message' => $e->getMessage()]
                    ]);
                    exit();
                }
            };
        }
    } catch (Exception $e) {
        echo json_encode([
            'session' => ['success' => true],
            'usuario' => ['success' => false, 'message' => $e->getMessage()],
            'correo' => ['success' => false]
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'session' => ['success' => false, 'message' => $e->getMessage()],
        'usuario' => ['success' => false],
        'correo' => ['success' => false]
    ]);
}

function enviarCorreoBienvenida($inputemail, $nombre, $apellido, $username, $password, $ruta)
{
    $apiKey = 're_h4BYuMSZ_BqRYwzxXQygEdSgmZzf7ph9T';

    $htmlContent = file_get_contents($ruta);
    // Reemplazar las variables en el contenido del HTML
    $htmlContent = str_replace('{{nombre}}', $nombre, $htmlContent);
    $htmlContent = str_replace('{{apellido}}', $apellido, $htmlContent);
    $htmlContent = str_replace('{{username}}', $username, $htmlContent);
    $htmlContent = str_replace('{{password}}', $password, $htmlContent);

    $data = [
        'from'    => 'automatico@ferchudev.com.py',
        'to'      => [$inputemail],
        'subject' => '¡Nuevo usuario registrado!',
        'html'    => $htmlContent,
    ];

    $ch = curl_init('https://api.resend.com/emails');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    if ($curlError) {
        return json_encode(['success' => false, 'message' => 'Error en cURL: ' . $curlError]);
    }
    $decodedResponse  = json_decode($response, true);
    if ($httpCode === 200) {
        return json_encode(['success' => true, 'message' => 'Se ha enviado un correo con las credenciales de acceso a: ' . $inputemail]);
    } else {
        return json_encode([
            'success' => false,
            'message' => 'Error al enviar correo: ' . json_encode($decodedResponse)
        ]);
    }
}


// var_dump($_POST);
