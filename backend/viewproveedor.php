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
        <a role='button' data-bs-toggle='dropdown' aria-expanded='false'>
        <i class='bx bx-dots-vertical-rounded btnacciones'></i></a>
        <ul class='dropdown-menu'>
            <li>
            <button type='button' class='dropdown-item' onclick='get($id_proveedor);' data-bs-toggle='modal' id='listitem' data-bs-target='#editproveedor'>
            <i class='bx bx-edit'></i>Editar
            </button>
            </li>
            <li>
            <a class='dropdown-item' href='../pages/editclient.php?id=" . $id_proveedor . "' name='idclient' id='listitem'><i class='bx bx-edit'></i>Editar</a>
            </li>"
?>
        <?php
        if ($id_tipo < 2) {
            echo "<li>
            <a class='dropdown-item' onclick='borrar($id_proveedor);' style='cursor: pointer;' id='listitem'><i class='bx bx-trash'></i>Eliminar</a>
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
        <script>
            function borrar(id) {
                Swal.fire({
                    title: "Desea Eliminar los registros?",
                    text: "No los podrá recuperar",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#212529",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Si eliminar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                                type: "POST",
                                url: "../backend/deleteclient.php",
                                data: {
                                    'id': id
                                }
                            })
                            .done(function(response) {
                                Swal.fire({
                                    title: "Borrado!",
                                    text: "El registro se ha borrado correctamente",
                                    icon: 'success',
                                    confirmButtonText: "Aceptar",
                                    timer: "2000"
                                }).then((result) => {
                                    // redireccion con javascript
                                    window.location.href = "../pages/registrar_clientes.php";
                                    //recargar página  jQuery
                                    location.reload();
                                });
                            })

                    }
                });
            }
        </script>
<?php
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
<!--  -->