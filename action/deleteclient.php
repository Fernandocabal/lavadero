<?php
include "../connet/conexion.php";

$id = $_POST["id"];
$sql = "DELETE FROM `clientes` WHERE `clientes`.`id_cliente` = '$id'";
if ($connect->query($sql) === true) {
} else {
    echo "Error " . $sql . "<br>" . $connect->error;
}
