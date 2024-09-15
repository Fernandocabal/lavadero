<?php
include "../functions/conexion.php";

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

        try {
            $sql = "UPDATE `clientes` SET `nombres` = :name, `apellidos` = :apellido, `nroci` = :documento, `email` = :email, `phonenumber` = :phonenumber, `direccion` = :direccion, `ciudad` = :ciudad WHERE `id_cliente` = :id_cliente";
            $stmt = $connect->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':documento', $documento);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phonenumber', $phonenumber);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':ciudad', $ciudad);
            $stmt->bindParam(':id_cliente', $id_cliente);
            if ($stmt->execute()) {
                echo '<script>
                        Swal.fire({
                        title: "Cambios guardados",
                        icon: "success",
                        html:"Se ha guardado correctamente",
                        focusConfirm: false,
                        reverseButtons: true,
                        confirmButtonColor: "#212529",
                        confirmButtonText:`Aceptar`
                        }).then((result) => {
                        if (result.value) {
                        window.location.href =`../pages/registrar_clientes.php`
                        }
                        }); 
                        </script>';
            } else {
                echo "Error al ejecutar la consulta.";
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
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