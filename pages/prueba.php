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
    <script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/datatables/datatables.min.css">
    <title>Document</title>
</head>

<body>
    <form action="" class="col-6" method="post">
        <?php
        include "../action/insertfactura.php";
        ?>
        <label for="nombrecliente">Numero del cliente</label>
        <input type="number" class="form-control" name="nombrecliente" id="nombrecliente">
        <label for="descripcion">Nombre del producto</label>
        <input type="text" class="form-control" name="descripcion" id="descripcion">
        <label for="precio">Precio</label>
        <input type="number" class="form-control" name="precio" id="precio">
        <label for="cantidad">cantidad</label>
        <input type="number" class="form-control" name="cantidad" id="cantidad">
        <input type="submit" class="btn btn-primary" name="insertfactura" value="Enviar">
    </form>
</body>

</html>