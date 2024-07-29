<?php
include "../connet/conexion.php";
$id_factura = $_GET['id'];

$sql = ("SELECT * FROM `header_factura`
        INNER JOIN clientes ON header_factura.id_cliente = clientes.id_cliente
        INNER JOIN ciudades on clientes.ciudad=ciudades.id_ciudad
        WHERE id_header= $id_factura;");
if ($result = $connect->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $nroci = $row['nroci'];
        $nombres = $row['nombres'];
        $apellidos = $row['apellidos'];
        $fecha_horas = $row["fecha_horas"];
        $timbrado = $row["timbrado"];
        $nro_factura = $row["nro_factura"];
        $total = 0;

        // $sqldetalles = "SELECT * FROM `detalle_factura` WHERE id_header = '$id_factura'";
        // $resultdetalles = $connect->query($sqldetalles);
        // if ($resultdetalles->num_rows > 0) {
        //     while ($rowdetalles = $resultdetalles->fetch_assoc()) {
        //         $descripcion_producto = $rowdetalles["detalle"];
        //         $precio_producto = $rowdetalles["precio"];
        //         echo "Nombre del producto: " . $descripcion_producto; // Suponiendo que la columna se llama "nombre"
        //         echo "<br>";
        //     }
        // }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <script src="../node_modules/jquery/dist/jquery.min.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../node_modules/select2/css/select2.min.css" rel="stylesheet" />
    <script src="../node_modules/select2/js/select2.min.js"></script>
    <script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="icon" href="../img/Logo.png">
    <title>Factura Nro: <?php echo $nro_factura ?></title>
</head>

<body>
    <div class="form-control"><?php
                                echo "

    <b>Factura Número: </b>" . $nro_factura . "</br>
    <b>Fecha y hora: </b>.$fecha_horas.</br>
    <b>Cliente: </b>" . $nombres . "<b> RUC: </b> " . $nroci . "</br> " ?>
    </div>
    <div class="col-12 mb-3 d-flex flex-column justify-content-between" style="border: 1px solid red; height:500px; font-size:10px;">
        <div>
            <table class="table">
                <thead>

                    <tr>
                        <th style="width: 10%;" scope="col">Cantidad</th>
                        <th scope="col">Descripcion</th>
                        <th style="width: 10%;" scope="col">Precio Unitario</th>
                        <th style="width: 10%;" scope="col">Descuentos</th>
                        <th style="width: 10%;" scope="col">Exentas</th>
                        <th style="width: 10%;" scope="col">5%</th>
                        <th style="width: 10%;" scope="col">10%</th>
                    </tr>

                </thead>
                <tbody id="bodytable" class="table-group-divider">

                    <?php
                    $sqldetalles = "SELECT * FROM `detalle_factura` WHERE id_header = '$id_factura'";
                    $resultdetalles = $connect->query($sqldetalles);
                    if ($resultdetalles->num_rows > 0) {
                        while ($rowdetalles = $resultdetalles->fetch_assoc()) {
                            $cantidad = $rowdetalles['cantidad'];
                            $descripcion_producto = $rowdetalles["detalle"];
                            $precio_producto = $rowdetalles["precio"];
                            echo "<tr>
                            <td><div class='inputform'> " . $cantidad . " </div></td>
                            <td><div class='inputform'> " . $descripcion_producto . " </div></td>
                            <td><div class='inputform'> " . $precio_producto . " </div></td>
                            <td><div class='inputform'>0</div></td>
                            <td><div class='inputform'>0</div></td>
                            <td><div class='inputform'>0</div></td>
                            <td><div class='inputform' id='precio_total'>" . $precio_producto . "</div></td>
                            </tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>
        </div>
        <!-- seccion base de factura -->
        <div class="d-flex flex-column gap-1  bg-body-secondary">

            <div class="d-flex justify-content-between">
                <div class="basederecha d-flex justify-content-center align-items-center">
                    <div>
                        Sub Total
                    </div>
                </div>
                <div class="d-flex justify-content-end baseizquierda">
                    <div class="datostotal" id="subtotal">El total Obvio</div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="basederecha d-flex justify-content-center align-items-center">
                    <div>
                        Total de la operación
                    </div>
                </div>
                <div class="d-flex justify-content-end baseizquierda">
                    <div class="datostotal">El total Obvio</div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="basederecha d-flex justify-content-center align-items-center">
                    <div>
                        Total en guaraníes
                    </div>
                </div>
                <div class="d-flex justify-content-end baseizquierda">
                    <div class="datostotal">El total Obvio</div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="basederecha d-flex justify-content-center align-items-center">
                    <div>
                        Liquidacion IVA
                    </div>
                </div>
                <div class="d-flex justify-content-between baseizquierda">
                    <div class="datosIVA">5%</div>
                    <div class="datosIVA">0</div>
                    <div class="datosIVA">10%</div>
                    <div class="datosIVA">0</div>
                    <div class="datosIVA">Total Iva</div>
                    <div class="datostotal">El total Obvio</div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>