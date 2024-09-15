<?php
include "../functions/conexion.php";

date_default_timezone_set('America/Asuncion');

if (isset($_POST["insertclient"])) {
    try {
        $connect->beginTransaction();

        $fecha = date('d-m-Y H:i');
        $checkboxes = $_POST["opcion"];
        $decriptioncheck = $_POST["nombre"];
        $cant_check = count($checkboxes);
        $nombre = $_POST["inputname"];
        $tipo_vehiculo = $_POST["inputvehiculo"];
        $totalvalor = 0;
        $queryid = "SELECT COALESCE(MAX(id_recepcion), 0) + 1 AS proximonumero FROM recepcion";
        $stmt = $connect->query($queryid);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $proximonumero = $row['proximonumero'];

        $formatproximonumero = str_pad($proximonumero, 6, '0', STR_PAD_LEFT);

        $insertrecepcion = "INSERT INTO `recepcion`(`nro_recepcion`, `fecha_horas`, `id_vehiculos`, `nombre_cliente`) VALUES (:nro_recepcion, :fecha_horas, :id_vehiculos, :nombre_cliente)";
        $stminsertrecepcion = $connect->prepare($insertrecepcion);
        $stminsertrecepcion->bindParam(':nro_recepcion', $formatproximonumero);
        $stminsertrecepcion->bindParam(':fecha_horas', $fecha);
        $stminsertrecepcion->bindParam(':id_vehiculos', $tipo_vehiculo, PDO::PARAM_INT);
        $stminsertrecepcion->bindParam(':nombre_cliente', $nombre);
        $stminsertrecepcion->execute();

        $idinsertado = $connect->lastInsertId();

        $insertdetalle = "INSERT INTO `detalles_recepcion`(`id_recepcion`, `descipcion_producto`, `precio`, `cantidad`) VALUES (:id_recepcion, :descipcion_producto, :precio, :cantidad)";
        $stminsertdetalle = $connect->prepare($insertdetalle);

        foreach ($decriptioncheck as $index => $descripcion) {
            $precio = $checkboxes[$index];

            $cantidad = $totalvalor;

            $stminsertdetalle->bindParam(':id_recepcion', $idinsertado, PDO::PARAM_INT);
            $stminsertdetalle->bindParam(':descipcion_producto', $descripcion);
            $stminsertdetalle->bindParam(':precio', $precio, PDO::PARAM_INT);
            $stminsertdetalle->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);

            $stminsertdetalle->execute();
        }

        $connect->commit();

        echo '<script>
                Swal.fire({
                icon: "success",
                title: "Recepcionado!",
                timer: 2000,
                confirmButtonColor: "#212529",
                confirmButtonText:`Aceptar`,
                });
                </script>';
    } catch (Exception $e) {

        $connect->rollBack();
        echo "Error al insertar datos: " . $e->getMessage();
    }
}
?>
<script>
    setTimeout(() => {
        window.history.replaceState(null, null, window.location.pathname);
    }, 0);
</script>