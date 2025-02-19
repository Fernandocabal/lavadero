<?php
session_start();
include "./functions/conexion.php";
include "./functions/funciones.php";
if (estalogueado()) {
    header('location:./pages/dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="./node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="./node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="icon" href="./assets/img/logo.png">
    <title>Inicio</title>
</head>

<body class="contenedor">
    <div class="bgvideo">
        <video autoplay loop muted>
            <source src="https://persistent.oaistatic.com/sonic/landing/bg_v2.mp4" type="video/mp4">
            Tu navegador no soporta el video.
        </video>
    </div>
    <form action="" method="post" class="tarjeta-login" id="formlogin">
        <img src="./assets/img/logo.png" class="logo"></img>
        <h2>Bienvenidos</h2>
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
            <input type="submit" value="Ingresar" class="btn btn-dark btn-lg" name="ingresar" id="boton">
        </div>
    </form>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    </script>
    <script src="./scripts/app.js"></script>
</body>

</html>