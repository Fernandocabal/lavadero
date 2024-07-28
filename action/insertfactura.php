<?php
include "../connet/conexion.php";
date_default_timezone_set('America/Asuncion');
//Seleccionamos el timbrado
$sqltimbrado = "SELECT * FROM `timbrado`";
if ($result = $connect->query($sqltimbrado)) {
    while ($row = $result->fetch_assoc()) {
        $nro_timbrado = $row["nro_timbrado"];
        $sucursal = $row["sucursal"];
        $caja = $row["caja"];
        $fecha_vencimiento = $row["fecha_vencimiento"];
    }
}
if (isset($_POST["insertfactura"])) {
    $connect->begin_transaction();
    $fecha = date('d-m-Y H:i');
    $precio = $_POST["precio"];
    $descripcion = $_POST["descripcion"];
    // $cant_check = count($precio);
    $cantidad = $_POST["cantidad"];
    $nombrecliente = $_POST["nombrecliente"];
    $totalvalor = 0;
    //Seleccionamos los datos de la condición
    $sqlcondicion = "SELECT * FROM `condicion` WHERE id_condicion = 1 ";
    if ($result = $connect->query($sqlcondicion)) {
        while ($row = $result->fetch_assoc()) {
            $id_condicion = $row["id_condicion"];
        }
    }

    function siguientenumero($sucursal, $caja)
    {
        global $connect;
        $respuesta = $connect->query("SELECT COUNT(*) FROM numeracion_factura");
        $row = $respuesta->fetch_row();
        $count = $row[0];

        if ($count == 0) {
            // Si la tabla está vacía, insertar el primer registro
            $query = "INSERT INTO numeracion_factura (ultimo_numero) VALUES (0)";
            $connect->query($query);
        }
        $queryid = "SELECT COALESCE(MAX(ultimo_numero), 0) + 1 AS proximonumero FROM numeracion_factura";
        $result = $connect->query($queryid);
        $row = $result->fetch_assoc();
        $proximonumero = $row['proximonumero'] ?? 0;
        $parte3 = str_pad($proximonumero, 7, '0', STR_PAD_LEFT);

        // Formatear el número final
        $formatproximonumero = $sucursal . '-' . $caja . '-' . $parte3;


        // Preparar la consulta para prevenir inyecciones SQL
        $stmt = $connect->prepare("UPDATE numeracion_factura SET ultimo_numero=?");
        $stmt->bind_param("i", $proximonumero);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return $formatproximonumero;
        } else {
            // Manejo de error, por ejemplo, lanzar una excepción
            throw new Exception("Error al actualizar el último número");
        }
    }
    $numeroFactura = siguientenumero($sucursal, $caja);

    $insertfacturas = "INSERT INTO `header_factura`(`nro_factura`, `timbrado`,`fecha_horas`, `id_cliente`,`cajero`, `id_condicion`) VALUES (?,?,?,?,?,?)";
    $stminsertfacturas = $connect->prepare($insertfacturas);
    $stminsertfacturas->bind_param("sisisi", $numeroFactura, $nro_timbrado, $fecha, $nombrecliente, $_SESSION["nombre"], $id_condicion);
    $stminsertfacturas->execute();

    $idinsertado = $stminsertfacturas->insert_id;

    // foreach ($descripcion as $name) {
    //     $valordescription[] = $name;
    // }
    // foreach ($precio as $valor) {
    //     $valoreselect[] = $valor;
    // }

    // for ($i = 0; $i < $cant_check; $i++) {
    //     $precio = $valoreselect[$i];
    //     $descripcion = $valordescription[$i];

    $insertdetalle = "INSERT INTO `detalle_factura`(`id_header`, `nombre`, `cantidad`,`precio`) VALUES (?,?,?,?)";
    $stminsertdetalle = $connect->prepare($insertdetalle);
    $stminsertdetalle->bind_param("isii", $idinsertado, $descripcion, $cantidad, $precio);

    $stminsertdetalle->execute();
    // }
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