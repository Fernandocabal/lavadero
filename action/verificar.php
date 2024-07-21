<?php
session_start();
if (!empty($_POST["ingresar"])) {
    if (!empty($_POST["usuario"]) and !empty($_POST["password"])) {
        $usuario = $_POST["usuario"];
        $password = md5($_POST["password"]);
        $consultabd = ("SELECT * FROM usuarios WHERE nombre_usuario='$usuario'");
        $result = $connect->query($consultabd);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $nameuser = $row["nombre_usuario"];
                $userpass = $row["password"];
                $username = $row["nombre"];
                $userlastname = $row["apellido"];
                $usertype = $row["id_tipo"];
            }
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