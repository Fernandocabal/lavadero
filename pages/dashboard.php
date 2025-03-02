<?php
include "../functions/conexion.php";
// session_start();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    include "../include/head.php";
    ?>
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