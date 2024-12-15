<?php
include "../functions/conexion.php";
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION["apellido"];
try {
    $query = "SELECT headercompra.*, proveedores.nombre_proveedor, proveedores.id_proveedor FROM headercompra INNER JOIN proveedores ON headercompra.id_proveedor = proveedores.id_proveedor WHERE headercompra.id_empresa = :id";
    $stmt = $connect->prepare($query);
    $stmt->bindParam(':id', $id_empresa, PDO::PARAM_INT);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id_proveedor = $row['id_proveedor'];
        $id_headercompra = $row['idheadercompra'];
        $registro = $row['registro'];
        $nrocompr = $row['nrocompr'];
        $nombre_proveedor = $row['nombre_proveedor'];
        $fecha_compra = $row['fecha_compra'];
        echo "
        <tr>
        <td> $registro </td>
        <td> $nrocompr </td>
        <td> $nombre_proveedor</td>
        <td> $fecha_compra </td>
        <td class='ctnacciones'>
        <a role='button' data-bs-toggle='dropdown' aria-expanded='false' style='text-decoration: none;';>
        <i class='bx bx-dots-vertical-rounded btnacciones d-flex align-items-center justify-content-center'></i></a>
        <ul class='dropdown-menu'>
            <li>
            <button type='button' class='dropdown-item' onclick='get($id_headercompra);' data-bs-toggle='modal' id='listitem' data-bs-target='#editproveedor'>
            <i class='bx bx-edit'></i>Editar
            </button>
            </li>";
        $querypermisos = "SELECT * FROM `permisos_usuarios` WHERE usuario = :usuario";
        $stmtpermisos = $connect->prepare($querypermisos);
        $stmtpermisos->bindParam(':usuario', $usernickname, PDO::PARAM_STR);
        $stmtpermisos->execute();
        $resultadospermisos = $stmtpermisos->fetchAll(PDO::FETCH_ASSOC);
        if ($resultadospermisos) {
            foreach ($resultadospermisos as $permiso) {
                $item = $permiso['item'];
                if ($item === 'btn_eliminar_compra') {
                    echo "<li>
            <a class='dropdown-item' onclick='borrar($id_proveedor);' style='cursor: pointer;' id='listitem'><i class='bx bx-trash'></i>Eliminar</a>
            </li>  
            ";
                }
            }
        }
        echo
        " 
        </ul>
        </td>
        </tr>";
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
<!--  -->