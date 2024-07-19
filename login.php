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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Inicio</title>
</head>

<body class="contenedor">

    <form action="" method="post" class="tarjeta-login" id="formlogin">
        <img src="./img/Logo.png" class="logo"></img>
        <?php
        include "./action/verificar.php";
        ?>
        <h1>Bienvenido</h1>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="./js/app.js"></script>
</body>

</html>