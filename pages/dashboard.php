<?php
include "../functions/conexion.php";
// session_start();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="icon" href="../assets/img/logo.png">
    <title>Dashboard</title>
</head>

<body class="contentdash">
    <!--Sección spinner-->
    <div class="spinner" id="spinner"></div>

    <header class="ctnheader">
        <?php
        include "../include/header.php";
        ?>
    </header>
    <!--Sección contenedor-->
    <div class="ctnpage">
        <!--Sección centro-->
        <div class="centro" id="targetcenter">
            <div class="targetdash">
                <p id="time"></p>
                <?php
                echo "<p>Hola " . htmlspecialchars($nombre) . "</p> 
                 <p>Empresa: " . htmlspecialchars($nombre_empresa) . "</p> 
                 <p>Sucursal: " . htmlspecialchars($sucursal_activa) . "</p>
                 <p>Caja: " . htmlspecialchars($caja_activa) . "</p>";
                ?>
            </div>
            <div class="targetdash" style="justify-content: start;">
                <!-- <div class="targettitle">
                    <h2>Lista de espera</h2>
                </div> -->
                <div class="targetcontenido">
                    <?php
                    // include "../backend/countlist.php";
                    ?>
                </div>

            </div>
            <div class="targetdash">

            </div>
            <div class="targetdash">

            </div>
        </div>
    </div>
    <footer class="ctnfooter">
        <?php
        include "../include/footer.php";
        ?>
    </footer>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script src="../assets/js/app2.js"></script>
</body>

</html>