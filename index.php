<?php
session_start();
error_reporting(0);
include "./connet/conexion.php";
if (isset($_SESSION['nombre'])) {
    header('location:./pages/dashboard.php');
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="./node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="./node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="icon" href="./img/Logo.png">
    <title>Inicio</title>
</head>

<body class="contenedor">
    <form action="" method="post" class="tarjeta-login" id="formlogin">
        <img src="./img/Logo.png" class="logo"></img>
        <?php
        include "./action/verificar.php";
        ?>
        <h1>Bienvenidos</h1>
        <h4>Iniciar Sesion</h4>
        <div class="contenedor-input">
            <div class="ctninput">
                <i class='bx bxs-user icon'></i>
                <input type="text" name="usuario" id="usuario" class="input" placeholder="Usuario" autocomplete="off">
            </div>
            <div class="ctninput">
                <i class='bx bxs-lock-alt icon'></i>
                <input type="password" name="password" id="password" class="input" placeholder="Contraseña" autocomplete="off">
                <i class='bx bx-show eyed' id="eyes"></i>
            </div>
        </div>
        <div class="col-12 d-flex align-items-center justify-content-center ctnboton">
            <input type="submit" value="Ingresar" class="btn btn-primary boton" name="ingresar" id="boton">
        </div>
    </form>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    </script>
    <script src="./js/app.js"></script>
</body>

</html>