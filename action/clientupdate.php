<?php
include "../connet/conexion.php";

if (isset($_POST["editclient"])) {
    if (!empty($_POST["inputname"]) and !empty($_POST["inputdocumento"]) and !empty($_POST["direccion"]) and !empty($_POST["inputCity"])) {
        $id_cliente = $_POST["id_cliente"];
        $name = $_POST["inputname"];
        $apellido = $_POST["inputlastname"];
        $documento = $_POST["inputdocumento"];
        $email = $_POST["inputemail"];
        $phonenumber = $_POST["inputphone"];
        $direccion = $_POST["direccion"];
        $ciudad = $_POST["inputCity"];
        $sql = "UPDATE `clientes` SET `nombres`='$name',`apellidos`='$apellido',`nroci`='$documento',`email`='$email',`phonenumber`='$phonenumber',`direccion`='$direccion',`ciudad`='$ciudad' WHERE `clientes`.`id_cliente` = '$id_cliente'";
        if ($connect->query($sql) === true) {
            echo '<script>
                    Swal.fire({
                    title: "Cambios guardados",
                    icon: "success",
                    html:"Se ha guardado correctamente",
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
    }

?>
    <script>
        setTimeout(() => {
            window.history.replaceState(null, null, window.location.pathname);
        }, 0);
    </script>
<?php
}
?>