<?php
session_start();

include_once './connet/conexion.php';


if (!empty($_POST["ingresar"])) {
    if (!empty($_POST["usuario"]) and !empty($_POST["password"])) {
        $usuario = $_POST["usuario"];
        $password = md5($_POST["password"]);
        try {
            $stmt = $connect->prepare("SELECT * FROM usuarios WHERE nombre_usuario = :usuario");
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $userpass = $row["password"];
                $username = $row["nombre"];
                $userlastname = $row["apellido"];
                $usertype = $row["id_tipo"];
                if ($userpass != $password) {
                    echo '<script>
                         Swal.fire({
                         icon: "error",
                         title: "Oops...",
                         confirmButtonText: "Reintentar",
                         text: "Contraseña incorrecta",
                         confirmButtonColor: "#3b5998",
                         });
                         </script>';
                } else {
                    $_SESSION["nombre"] = $username;
                    $_SESSION["apellido"] = $userlastname;
                    $_SESSION["password"] = $userpass;
                    $_SESSION["id_tipo"] = $usertype;
                    $_SESSION['last_activity'] = time();
                    header("location:./pages/dashboard.php");
                    exit();
                }
            } else {
                echo '<script>
                 Swal.fire({
                 icon: "error",
                 title: "Oops...",
                 confirmButtonText: "Reintentar",
                 text: "No existe el usuario",
                 confirmButtonColor: "#3b5998",
                 });
                 </script>';
            }
        } catch (PDOException $e) {
            echo '<script>
                    Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    confirmButtonText: "Reintentar",
                    text: "Error en la consulta: ' . addslashes($e->getMessage()) . '",
                    confirmButtonColor: "#3b5998",
                    });
                    </script>';
        }
    } else {
        echo '<script>
                Swal.fire({
                icon: "warning",
                title: "Oops...",
                confirmButtonText: "Reintentar",
                text: "Completa los campos para iniciar sessión",
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