<?php
include "../functions/conexion.php";

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'select':
        $id = $_GET["id"];
        $response = [];
        try {
            $sql = "SELECT * FROM `clientes` WHERE id_cliente = :id";
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $response = [
                    'success' => true,
                    'id_cliente' => $row['id_cliente'],
                    'nombres' => $row['nombres'],
                    'apellidos' => $row['apellidos'],
                    'nroci' => $row['nroci'],
                    'email' => $row['email'],
                    'phonenumber' => $row['phonenumber'],
                    'direccion' => $row['direccion'],
                    'ciudad' => $row['ciudad']
                ];
                echo json_encode($response);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Cliente no encontrado ']);
        }
        break;
    case 'delete':
        $id = $_GET["id"];
        $response = [];
        try {
            $sql = "DELETE FROM `clientes` WHERE id_cliente = :id";
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'El cliente ha sido eliminado correctamente']);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Cliente no encontrado']);
        }
        break;
    case 'update':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_cliente = $_POST['id_cliente'] ?? '';
            $nombre = $_POST['name_client_edit'] ?? '';
            $apellido = $_POST["lastname_client_edit"] ?? '';
            $documento = $_POST['nro_docu_edit'] ?? '';
            $email = $_POST['edit_email_client'] ?? '';
            $phonenumber = $_POST['edit_telf_client'] ?? '';
            $direccion = $_POST['edit_direccion_client'] ?? '';
            $ciudad = $_POST['edit_ciudad_client'] ?? '';
            if ($id_cliente && $nombre) {

                try {
                    $sql = "UPDATE `clientes` SET `nombres` = :name, `apellidos` = :apellido, `nroci` = :documento, `email` = :email, `phonenumber` = :phonenumber, `direccion` = :direccion, `ciudad` = :ciudad WHERE `id_cliente` = :id_cliente";
                    $stmt = $connect->prepare($sql);
                    $stmt->bindParam(':name', $nombre);
                    $stmt->bindParam(':apellido', $apellido);
                    $stmt->bindParam(':documento', $documento);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':phonenumber', $phonenumber);
                    $stmt->bindParam(':direccion', $direccion);
                    $stmt->bindParam(':ciudad', $ciudad);
                    $stmt->bindParam(':id_cliente', $id_cliente);
                    $stmt->execute();
                    echo json_encode(['success' => true, 'message' => 'Cliente actualizado correctamente']);
                } catch (PDOException $e) {
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
            }
        };
        break;
    case 'insert':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST["inputname"] ?? '';
            $apellido = $_POST["inputlastname"] ?? '';
            $documento = $_POST["inputdocumento"] ?? '';
            $email = $_POST["inputemail"] ?? '';
            $phonenumber = $_POST["inputphone"] ?? '';
            $direccion = $_POST["direccion"] ?? '';
            $ciudad = $_POST["inputCity"] ?? '';
            if ($nombre) {
                $query = "SELECT `nroci` FROM `clientes` WHERE nroci = :id";
                $stmt = $connect->prepare($query);
                $stmt->bindParam(':id', $documento);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    echo json_encode(['success' => false, 'message' => 'Ya existe un proveedor con el RUC: ' . $documento]);
                } else {
                    try {
                        $sql = "INSERT INTO `clientes` (`nombres`, `apellidos`, `nroci`, `email`, `phonenumber`, `direccion`, `ciudad`) 
                        VALUES (:nombre, :apellido, :documento, :email, :phonenumber, :direccion, :ciudad)";
                        $stmt = $connect->prepare($sql);
                        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                        $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
                        $stmt->bindParam(':documento', $documento, PDO::PARAM_STR);
                        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                        $stmt->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
                        $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
                        $stmt->bindParam(':ciudad', $ciudad, PDO::PARAM_STR);
                        $stmt->execute();
                        echo json_encode(['success' => true, 'message' => 'Se ha guardado correctamente!']);
                    } catch (PDOException $e) {
                        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                    }
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
            }
        };
        break;
    default:
        echo json_encode(['success' => false, 'message' => 'Accion no válida']);
        break;
}
