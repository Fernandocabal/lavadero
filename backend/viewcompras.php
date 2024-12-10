<?php
include "../functions/conexion.php";
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION["apellido"];

$id_empresa = $_SESSION['id_empresa_activa'];
try {
    $query = "SELECT 
    headercompra.*,
    proveedores.*,
    usuarios.id_empresa
FROM 
    headercompra
INNER JOIN 
    proveedores ON headercompra.id_proveedor = proveedores.id_proveedor
INNER JOIN 
    usuarios ON headercompra.id_usuario = usuarios.id_usuario
WHERE 
    usuarios.id_empresa = :id";
    $stmt = $connect->prepare($query);
    $stmt->bindParam(':id', $id_empresa, PDO::PARAM_INT);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id_proveedor = $row['id_proveedor'];
        $id_headercompra = $row['idheadercompra'];
        $registro = $row['registro'];
        $nrocompr = $row['nrocompr'];
        $nombre_proveedor = $row['nombre_proveedor'];
        $ruc_proveedor = $row['ruc_proveedor'];
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