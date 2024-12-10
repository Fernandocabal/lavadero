<?php
include "../functions/conexion.php";
try {
    $query = "SELECT * FROM `proveedores`";
    $stmt = $connect->prepare($query);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id_proveedor = $row['id_proveedor'];
        $nombre_proveedor = $row['nombre_proveedor'];
        $ruc_proveedor = $row['ruc_proveedor'];
        $email = $row['email_proveedor'];
        echo "
        <tr>
        <td> $nombre_proveedor </td>
        <td> $ruc_proveedor</td>
        <td> $email </td>
        <td class='ctnacciones'>
        <a role='button' data-bs-toggle='dropdown' aria-expanded='false' style='text-decoration: none;';>
        <i class='bx bx-dots-vertical-rounded btnacciones d-flex align-items-center justify-content-center'></i></a>
        <ul class='dropdown-menu'>
            <li>
            <button type='button' class='dropdown-item' onclick='get($id_proveedor);' data-bs-toggle='modal' id='listitem' data-bs-target='#editproveedor'>
            <i class='bx bx-edit'></i>Editar
            </button>
            </li>"
?>
        <?php
        $query = "SELECT * FROM `permisos_usuarios` WHERE usuario = :usuario";
        $stmt = $connect->prepare($query);
        $stmt->bindParam(':usuario', $usernickname, PDO::PARAM_STR);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($resultados) {
            foreach ($resultados as $resultado) {
                $item = $resultado['item'];
                if ($item === 'btn_eliminar_proveedor') {
                    echo "<li>
            <a class='dropdown-item' onclick='borrar($id_proveedor);' style='cursor: pointer;' id='listitem'><i class='bx bx-trash'></i>Eliminar</a>
            </li>  
            ";
                }
            }
        }
        ?>
        <?php
        " 
        </ul>
        </td>
        </tr>"
        ?>
<?php
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
<!--  -->