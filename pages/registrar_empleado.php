<?php
include "../connet/conexion.php";
session_start();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Registrar Empleado</title>
</head>

<body class="contentdash">
    <header class="ctnheader">
        <?php
        include "../componetes/header.php";
        ?>
    </header>

    <div class="ctnpage">
        <div class="ctnform" id="targetcenter">
        </div>
    </div>
    <footer class="ctnfooter">
        <?php
        include "../componetes/footer.php"; ?>
    </footer>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="../js/app2.js"></script>
</body>

</html>