<?php
include "../functions/conexion.php";

if (isset($_POST["insertclient"])) {
    if (!empty($_POST["inputname"]) && !empty($_POST["inputdocumento"]) && !empty($_POST["direccion"]) && !empty($_POST["inputCity"])) {
        $name = $_POST["inputname"];
        $apellido = $_POST["inputlastname"];
        $documento = $_POST["inputdocumento"];
        $email = $_POST["inputemail"];
        $phonenumber = $_POST["inputphone"];
        $direccion = $_POST["direccion"];
        $ciudad = $_POST["inputCity"];

        try {
            $stmt = $connect->prepare("SELECT * FROM `clientes` WHERE nroci = :documento");
            $stmt->bindParam(':documento', $documento, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                $nroci = $data["nroci"];
                echo '<script>
                    Swal.fire({
                    icon: "warning",
                    title: "Ya existe el cliente",
                    confirmButtonText: "Reintentar",
                    text: "El cliente con numero de ci: ' . $nroci . ' ya existe",
                    confirmButtonColor: "#212529",
                    });
                    </script>';
            } else {

                $sql = "INSERT INTO `clientes` (`nombres`, `apellidos`, `nroci`, `email`, `phonenumber`, `direccion`, `ciudad`) 
                        VALUES (:name, :apellido, :documento, :email, :phonenumber, :direccion, :ciudad)";
                $stmt = $connect->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
                $stmt->bindParam(':documento', $documento, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
                $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
                $stmt->bindParam(':ciudad', $ciudad, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    echo '<script>
                        Swal.fire({
                        icon: "success",
                        title: "Se ha registrado el cliente",
                        timer: 2000,
                        confirmButtonColor: "#212529",
                        confirmButtonText:`Aceptar`
                        });
                        </script>';
                } else {
                    echo "Error al insertar datos: " . $stmt->errorInfo()[2];
                }
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo '<script>
            Swal.fire({
            icon: "warning",
            title: "Campos vacíos",
            confirmButtonText: "Reintentar",
            text: "Todos los campos son obligatorios",
            confirmButtonColor: "#212529",
            });
            </script>';
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