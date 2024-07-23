<?php
include "../connet/conexion.php";
include "../connet/sessionstart.php";
$nombre = $_SESSION["nombre"];
$apellido = $_SESSION["apellido"];
$id_tipo = $_SESSION["id_tipo"];
if (empty($_SESSION["nombre"]) and empty($_SESSION["apellido"])) {
    header("location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="icon" href="../img/Logo.png">
    <title>Dashboard</title>
</head>

<body class="contentdash">
    <!--Sección spinner-->
    <div class="spinner" id="spinner"></div>

    <header class="ctnheader">
        <?php
        include "../componetes/header.php";
        ?>
    </header>
    <!--Sección contenedor-->
    <div class="ctnpage">
        <!--Sección centro-->
        <div class="centro" id="targetcenter">
            <div class="targetdash">
                <p id="time"></p>
                <?php
                if ($id_tipo > 1) {
                    include "../componetes/menu_datos.php";
                } else {
                    echo "Hola " . $nombre . " eres admin y tienes el nivel " . $id_tipo;
                }
                ?>
            </div>
            <div class="targetdash" style="justify-content: start;">
                <div class="targettitle">
                    <h2>Lista de espera</h2>
                </div>
                <div class="targetcontenido">
                    <?php
                    include "../componetes/countlist.php";
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
        include "../componetes/footer.php";
        ?>
    </footer>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script src="../js/app2.js"></script>
</body>

</html>