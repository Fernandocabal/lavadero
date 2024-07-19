<?php
include "../connet/conexion.php";

$id = $_POST["id"];
$sql = "DELETE FROM `clientes` WHERE `clientes`.`id_cliente` = '$id'";
if ($connect->query($sql) === true) {
    echo '<script>
    Swal.fire({
    title: "Se ha eliminado correctamente",
    icon: "success",
    focusConfirm: false,
    reverseButtons: true,
    confirmButtonColor: "#0be881",
    confirmButtonText:`Aceptar`
    }).then((result) => {
    if (result.value) {
    window.location.href =`../pages/registrar_clientes.php`
    }
    }); 
    </script>';
} else {
    echo "Error " . $sql . "<br>" . $connect->error;
}
