<?php
include "../functions/conexion.php";
try {
    $query = "SELECT * FROM `clientes`";
    $stmt = $connect->prepare($query);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id_cliente = $row["id_cliente"];
        $nombres = $row["nombres"];
        $apellidos = $row["apellidos"];
        $nroci = $row["nroci"];
        $email = $row["email"];
        $phonenumber = $row["phonenumber"];
        $direccion = $row["direccion"];
        $ciudad = $row["ciudad"];
        echo "
        <tr>
        <td> $nombres </td>
        <td> $apellidos </td>
        <td> $nroci </td>
        <td> $email </td>
        <td class='ctnacciones'>
        <a role='button' data-bs-toggle='dropdown' aria-expanded='false' style='text-decoration: none;';>
        <i class='bx bx-dots-vertical-rounded btnacciones d-flex align-items-center justify-content-center'></i></a>
        <ul class='dropdown-menu'>
            <li>
            <button type='button' class='dropdown-item' onclick='get($id_cliente);' data-bs-toggle='modal' id='listitem' data-bs-target='#editproveedor'>
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
                if ($item === 'btn_eliminar_cliente') {
                    echo "<li>
            <a class='dropdown-item' onclick='borrar($id_cliente);' style='cursor: pointer;' id='listitem'><i class='bx bx-trash'></i>Eliminar</a>
            </li>  
            ";
                }
            }
        } else {
            echo "<li>
    Sin permisos
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