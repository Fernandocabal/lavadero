<?php
include "../connet/conexion.php";
if (isset($_POST["insertclient"])) {
    if (!empty($_POST["inputname"]) and !empty($_POST["inputdocumento"]) and !empty($_POST["direccion"]) and !empty($_POST["inputCity"])) {
        $name = $_POST["inputname"];
        $apellido = $_POST["inputlastname"];
        $documento = $_POST["inputdocumento"];
        $email = $_POST["inputemail"];
        $phonenumber = $_POST["inputphone"];
        $direccion = $_POST["direccion"];
        $ciudad = $_POST["inputCity"];
        #Consultamos si ya existe el cliente
        $consulta = $connect->query("SELECT * FROM `clientes` WHERE nroci = '$documento'");
        if ($data = $consulta->fetch_object()) {
            $nombres["nombres"] = $data->nombres;
            $nroci["nroci"] = $data->nroci;
            echo '<script>
                Swal.fire({
                icon: "warning",
                title: "Ya existe el cliente",
                confirmButtonText: "Reintentar",
                text: "El cliente con numero de ci: ' . $nroci["nroci"] . ' ya existe",
                confirmButtonColor: "#3b5998",
                });
                </script>';
        } else { #Si no existe, entonces guardamos el cliente
            $sql = "INSERT INTO `clientes`(`nombres`, `apellidos`, `nroci`,`email`,`phonenumber`,`direccion`, `ciudad`) VALUES ('$name','$apellido','$documento','$email','$phonenumber','$direccion','$ciudad')";
            if ($connect->query($sql) === true) {
                echo '<script>
                    Swal.fire({
                    icon: "success",
                    title: "Se ha registrado el cliente",
                    timer: 2000,
                    confirmButtonColor: "#3b5998",
                    });
                    </script>';
            } else {
                echo "Error " . $sql . "<br>" . $connect->error;
            }
        }
    } else { #Cuando los campos están vacíos, mostramos este mensaje
        echo '<script>
             Swal.fire({
            icon: "warning",
            title: "Campos vacíos",
            confirmButtonText: "Reintentar",
            text: "Todos los campos son obligatorios",
            confirmButtonColor: "#3b5998",
            });
            </script>';
    } ?>
    <script>
        setTimeout(() => {
            window.history.replaceState(null, null, window.location.pathname);
        }, 0);
    </script>
<?php
} ?>