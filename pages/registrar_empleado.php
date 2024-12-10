<?php
include "../functions/conexion.php";
session_start();
$nombre = $_SESSION["nombre"];
$apellido = $_SESSION["apellido"];


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>Registrar Empleado</title>
</head>

<body class="contentdash">
    <header class="ctnheader">
        <?php
        include "../include/header.php";
        ?>
    </header>

    <div class="ctnpage">
        <div class="ctnform" id="targetcenter">
        </div>
    </div>
    <footer class="ctnfooter">
        <?php
        include "../include/footer.php"; ?>
    </footer>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/js/app2.js"></script>
</body>

</html>