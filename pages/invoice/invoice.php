<?php
include __DIR__ . '/../../functions/conexion.php';
$id_factura = $_GET['id'];
$sql = ("SELECT * FROM `header_factura`
INNER JOIN clientes ON header_factura.id_cliente = clientes.id_cliente
INNER JOIN ciudades on clientes.ciudad=ciudades.id_ciudad
INNER JOIN condicion on condicion.id_condicion=header_factura.id_condicion
WHERE id_header= $id_factura;");
$stmt = $connect->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $nroci = $row['nroci'];
    $nombres = $row['nombres'];
    $apellidos = $row['apellidos'];
    $direccion = $row['direccion'];
    $phonenumber = $row['phonenumber'];
    $email = $row['email'];
    $fecha_horas = $row["fecha_horas"];
    $condicion = $row["condicion"];
    $nro_factura = $row["nro_factura"];
    $totalfactura = $row['totalfactura'];
    $exentas = $row['exentas'];
    $gravada5 = $row['gravada5'];
    $gravada10 = $row['gravada10'];
    $totaliva = $row['totaliva'];
    $cajero = $row['cajero'];
    $id_empresa = $row['id_empresa'];
    $id_sucursal = $row['id_sucursal'];
    $id_caja = $row['id_caja'];
    $total = 0;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link href='../../node_modules/bootstrap/dist/css/bootstrap.css' rel='stylesheet'>
    <title>Factura #<?php echo htmlspecialchars($nro_factura); ?></title>
</head>

<body>
    <div class="invoice-container d-flex flex-column align-items-center justify-content-center">
        <img src="../../assets/img/empresa_<?php echo $id_empresa ?>.png" alt="" class="">
        <h3>Factura Nro. <?php echo htmlspecialchars($nro_factura); ?></h3>
        <table class="invoice-header">
            <tr>
                <th>Fecha</th>
                <td><?php echo htmlspecialchars($fecha_horas); ?></td>
            </tr>
            <tr>
                <th>Cliente</th>
                <td><?php echo htmlspecialchars($nombres . ' ' . $apellidos); ?></td>
            </tr>
            <tr>
                <th>CI / RUC</th>
                <td><?php echo htmlspecialchars($nroci); ?></td>
            </tr>
            <tr>
                <th>Dirección</th>
                <td><?php echo htmlspecialchars($direccion); ?></td>
            </tr>
            <tr>
                <th>Teléfono</th>
                <td><?php echo htmlspecialchars($phonenumber); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($email); ?></td>
            </tr>
            <tr>
                <th>Condición</th>
                <td><?php echo htmlspecialchars($condicion); ?></td>
            </tr>
        </table>

        <h3>Detalles de la Factura</h3>
        <table class="invoice-details">
            <tr>
                <th>Exentas</th>
                <th>Gravada 5%</th>
                <th>Gravada 10%</th>
                <th>Total IVA</th>
                <th>Total Factura</th>
            </tr>
            <tr>
                <td><?php echo number_format($exentas, 0, '.', '.') . " Gs"; ?></td>
                <td><?php echo number_format($gravada5, 0, '.', '.') . " Gs"; ?></td>
                <td><?php echo number_format($gravada10, 0, '.', '.') . " Gs"; ?></td>
                <td><?php echo number_format($totaliva, 0, '.', '.') . " Gs"; ?></td>
                <td><?php echo number_format($totalfactura, 0, '.', '.') . " Gs"; ?></td>
            </tr>
        </table>
    </div>
</body>

</html>