<?php
include "../functions/conexion.php";
try {
    $query = "SELECT * FROM `headercompra`INNER JOIN proveedores ON headercompra.id_proveedor = proveedores.id_proveedor";
    $stmt = $connect->prepare($query);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id_proveedor = $row['id_proveedor'];
        $id_headercompra = $row['idheadercompra'];
        $nrocompr = $row['nrocompr'];
        $nombre_proveedor = $row['nombre_proveedor'];
        $ruc_proveedor = $row['ruc_proveedor'];
        $fecha_compra = $row['fecha_compra'];
        echo "
        <tr>
        <td> $id_headercompra </td>
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
            </li>"
?>
        <?php
        if ($id_tipo < 2) {
            echo "<li>
            <a class='dropdown-item' onclick='borrar($id_headercompra);' style='cursor: pointer;' id='listitem'><i class='bx bx-trash'></i>Eliminar</a>
            </li>  
            ";
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