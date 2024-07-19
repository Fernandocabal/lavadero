<?php
include "../connet/conexion.php";
date_default_timezone_set('America/Asuncion');
if (isset($_POST["insertclient"])) {
    $connect->begin_transaction();
    $fecha = date('d-m-Y H:i');
    $checkboxes = $_POST["opcion"];
    $decriptioncheck = $_POST["nombre"];
    $cant_check = count($checkboxes);
    $nombre = $_POST["inputname"];
    $tipo_vehiculo = $_POST["inputvehiculo"];
    $totalvalor = 0;
    $queryid = "SELECT MAX(nro_recepcion) + 1 AS proximonumero FROM recepcion;";
    $result = $connect->query($queryid);
    $row = $result->fetch_assoc();
    $proximonumero = $row['proximonumero'];

    $formatproximonumero = str_pad($proximonumero, 6, '0', STR_PAD_LEFT);

    $insertrecepcion = "INSERT INTO `recepcion`(`nro_recepcion`, `fecha_horas`, `id_vehiculos`, `nombre_cliente`) VALUES (?,?,?,?)";
    $stminsertrecepcion = $connect->prepare($insertrecepcion);
    $stminsertrecepcion->bind_param("ssis", $formatproximonumero, $fecha, $tipo_vehiculo, $nombre);
    $stminsertrecepcion->execute();

    $idinsertado = $stminsertrecepcion->insert_id;

    foreach ($decriptioncheck as $name) {
        $valordescription[] = $name;
    }
    foreach ($checkboxes as $valor) {
        $valoreselect[] = $valor;
    }

    for ($i = 0; $i < $cant_check; $i++) {
        $precio = $valoreselect[$i];
        $descripcion = $valordescription[$i];

        $insertdetalle = "INSERT INTO `detalles_recepcion`(`id_recepcion`, `descipcion_producto`, `precio`, `cantidad`) VALUES (?,?,?,?)";
        $stminsertdetalle = $connect->prepare($insertdetalle);
        $stminsertdetalle->bind_param("isii", $idinsertado, $descripcion, $precio, $totalvalor);

        $stminsertdetalle->execute();
    }
    if ($connect->error) {
        $connect->rollback(); // Revertir la transacción si ocurre algún error
        echo "Error al insertar datos: " . $db->error;
        exit();
    }

    $connect->commit();
    echo '<script>
            Swal.fire({
            icon: "success",
            title: "Recepcionado!",
            timer: 2000,
            confirmButtonColor: "#0be881",
            confirmButtonText:`Aceptar`,
            });
            </script>';
} ?>
<script>
    setTimeout(() => {
        window.history.replaceState(null, null, window.location.pathname);
    }, 0);
</script>
<?php
?>