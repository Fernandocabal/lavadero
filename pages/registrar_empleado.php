<?php
include "../functions/conexion.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    include "../include/head.php";
    ?>
    <title>Registrar Empleado</title>
</head>

<body class="contentdash">
    <header class="ctnheader">
        <?php
        include "../include/header.php";
        ?>
    </header>
    <?php
    $query = "SELECT item FROM permisos_usuarios WHERE usuario = :usuario";
    $stmt = $connect->prepare($query);
    $stmt->bindParam(':usuario', $usernickname, PDO::PARAM_STR);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_COLUMN); // Obtiene solo los valores de 'item'

    if (!in_array('view_registrar_empleado', $resultados)) {
        include "../include/view/no_permission.php";
        exit;
    }

    include "../include/view/registrar_empleado.php";
    ?>
    <footer class="ctnfooter">
        <?php
        include "../include/footer.php"; ?>
    </footer>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/js/crear_usuario.js"></script>
    <script src="../scripts/crear_usuario.js"></script>
</body>

</html>