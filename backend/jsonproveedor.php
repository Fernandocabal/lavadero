<?php
include "../functions/conexion.php";

$action = $_GET['action'] ?? $_POST['action'] ?? '';
// $id = $_GET['id'] ?? $_POST['id'] ?? '';

switch ($action) {
    case 'select':
        $id = $_GET["id"];
        $response = [];
        try {
            $sql = "SELECT * FROM `proveedores` WHERE id_proveedor = :id";
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $response = [
                    'success' => true,
                    'id_proveedor' => $row['id_proveedor'],
                    'nombre_proveedor' => $row['nombre_proveedor'],
                    'direccion_proveedor' => $row['direccion_proveedor'],
                    'id_ciudad' => $row['id_ciudad'],
                    'tel_proveedor' => $row['tel_proveedor'],
                    'email_proveedor' => $row['email_proveedor'],
                    'ruc_proveedor' => $row['ruc_proveedor']
                ];
                echo json_encode($response);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Proveedor no encontrado ']);
        }
        break;
    case 'delete':
        $id = $_GET["id"];
        $response = [];
        try {
            $sql = "DELETE FROM `proveedores` WHERE id_proveedor = :id";
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Proveedor eliminado correctamente']);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Proveedor no encontrado']);
        }
        break;
    case 'update':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_proveedor = $_POST['id_proveedor'] ?? '';
            $nombre = $_POST['nameproveedor'] ?? '';
            $rucproveedor = $_POST['rucproveedor'] ?? '';
            $emailproveedor = $_POST['emailproveedor'] ?? '';
            $telfproveedor = $_POST['telfproveedor'] ?? '';
            $direccion = $_POST['edit_direccion_proveedor'] ?? '';
            $ciudad = $_POST['edit_ciudad_proveedor'] ?? '';
            if ($id_proveedor && $nombre) {
                try {
                    $sql = "UPDATE `proveedores`
                    SET `id_ciudad`=:ciudad,`nombre_proveedor`=:nombre,`ruc_proveedor`=:rucproveedor,`direccion_proveedor`=:direccion,`tel_proveedor`=:telfproveedor,`email_proveedor`=:email WHERE id_proveedor = :id_proveedor";
                    $stmt = $connect->prepare($sql);
                    $stmt->bindParam(':ciudad', $ciudad);
                    $stmt->bindParam(':nombre', $nombre);
                    $stmt->bindParam(':rucproveedor', $rucproveedor);
                    $stmt->bindParam(':direccion', $direccion);
                    $stmt->bindParam(':telfproveedor', $telfproveedor);
                    $stmt->bindParam(':email', $emailproveedor);
                    $stmt->bindParam(':id_proveedor', $id_proveedor, PDO::PARAM_STR);
                    $stmt->execute();
                    echo json_encode(['success' => true, 'message' => 'Proveedor actualizado correctamente']);
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
            $nombre = $_POST['inputname'] ?? '';
            $rucproveedor = $_POST['inputdocumento'] ?? '';
            $emailproveedor = $_POST['inputemail'] ?? '';
            $telfproveedor = $_POST['inputphone'] ?? '';
            $direccion = $_POST['direccion'] ?? '';
            $ciudad = $_POST['inputCity'] ?? '';
            if ($nombre) {
                $query = "SELECT `ruc_proveedor` FROM `proveedores` WHERE ruc_proveedor = :id";
                $stmt = $connect->prepare($query);
                $stmt->bindParam(':id', $rucproveedor);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    echo json_encode(['success' => false, 'message' => 'Ya existe un proveedor con el RUC: ' . $rucproveedor]);
                } else {
                    try {
                        $sql = "INSERT INTO `proveedores`(`id_ciudad`, `nombre_proveedor`, `ruc_proveedor`, `direccion_proveedor`, `tel_proveedor`, `email_proveedor`) VALUES (?, ?, ?, ?, ?, ?)";
                        $stmt = $connect->prepare($sql);
                        $stmt->execute([$ciudad, $nombre, $rucproveedor, $direccion, $telfproveedor, $emailproveedor]);
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
