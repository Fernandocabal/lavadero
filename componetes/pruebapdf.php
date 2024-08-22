<?php

include "../connet/conexion.php";
$id_factura = $_GET['id'];

$sql = ("SELECT * FROM `header_factura`
INNER JOIN clientes ON header_factura.id_cliente = clientes.id_cliente
INNER JOIN ciudades on clientes.ciudad=ciudades.id_ciudad
INNER JOIN condicion on condicion.id_condicion=header_factura.id_condicion
WHERE id_header= $id_factura;");
if ($result = $connect->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $nroci = $row['nroci'];
        $nombres = $row['nombres'];
        $apellidos = $row['apellidos'];
        $direccion = $row['direccion'];
        $phonenumber = $row['phonenumber'];
        $email = $row['email'];
        $fecha_horas = $row["fecha_horas"];
        $condicion = $row["condicion"];
        $timbrado = $row["timbrado"];
        $nro_factura = $row["nro_factura"];
        $totalfactura = $row['total'];
        $iva = $row['iva'];
        $total = 0;
    }
}
$sqltimbrado = "SELECT * FROM `timbrado`";
if ($result = $connect->query($sqltimbrado)) {
    while ($row = $result->fetch_assoc()) {
        $nro_timbrado = $row["nro_timbrado"];
        $sucursal = $row["sucursal"];
        $caja = $row["caja"];
        $fecha_inicio = $row["fecha_inicio"];
        $fecha_vencimiento = $row["fecha_vencimiento"];
    }
}


require('../fpdf/fpdf.php');
class PDF extends FPDF
{
    function Header() {}
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 12);
$pdf->Image('../img/logobw.png', 8, 8, 33);
// Información de la factura
$pdf->Cell(130, 5, 'CarWahs Lavadero', 'T,L', 0, 'R');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(40, 5, 'Timbrado:', 'L, T', 0, 'L');
$pdf->Cell(20, 5, $timbrado, 'R, T', 1, 'R');
$pdf->Cell(130, 5, 'de Christian Benitez', 'L', 0, 'R');
$pdf->Cell(40, 5, 'Fecha de inicio de vigencia:', 'L', 0, 'L');
$pdf->Cell(20, 5, $fecha_inicio, 'R', 1, 'R');
$pdf->Cell(130, 5, 'Factura para Cliente', 'L', 0, 'R');
$pdf->Cell(40, 5, 'Fecha de vencimiento:', 'L', 0, 'L');
$pdf->Cell(20, 5, $fecha_vencimiento, 'R', 1, 'R');
$pdf->Cell(130, 5, 'Factura para Cliente', 'L', 0, 'R');
$pdf->Cell(40, 5, 'RUC:', 'L', 0, 'L');
$pdf->Cell(20, 5, '3215768-9', 'R', 1, 'R');
$pdf->Cell(130, 5, 'Factura para Cliente', 'L', 0, 'R');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 5, 'Factura', 'L,R', 1, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(130, 5, 'Factura para Cliente', 'L,B', 0, 'R');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 5, $nro_factura, 'L,R,B', 0, 'C');
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(100, 5, 'Fecha y hora de emision: ' . $fecha_horas, 'T,L', 0, 'L');
$pdf->Cell(30, 5, 'Condicion de venta: ', 'L,T', 0, 'L');
$pdf->Cell(60, 5, $condicion, 'R,T', 1, 'L');
$pdf->Cell(100, 5, 'Nombre o Razon Social: ' . $nombres . ' ' . $apellidos, 'L', 0, 'L');
$pdf->Cell(30, 5, 'Metodo de pago: ', 'L', 0, 'L');
$pdf->Cell(60, 5, 'Efectivo', 'R', 1, 'L');
$pdf->Cell(100, 5, 'RUC/CI: ' . $nroci, 'L', 0, 'L');
$pdf->Cell(40, 5, '', 'L', 0, 'L');
$pdf->Cell(50, 5, '', 'R', 1, 'R');
$pdf->Cell(100, 5, 'Direccion: ' . $direccion, 'L', 0, 'L');
$pdf->Cell(40, 5, '', 'L', 0, 'L');
$pdf->Cell(50, 5, '', 'R', 1, 'R');
$pdf->Cell(100, 5, 'Tel. o Cel.: ' . $phonenumber, 'L', 0, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 5, '', 'L,R', 1, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(100, 5, 'Correo: ' . $email, 'L,B', 0, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 5, '', 'L,R,B', 0, 'C');
$pdf->Ln(7);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(100, 5, 'Descripcion', 1);
$pdf->Cell(30, 5, 'Cantidad', 1, 0, 'C');
$pdf->Cell(30, 5, 'Precio Unitario', 1, 0, 'C');
$pdf->Cell(30, 5, 'Total', 1, 1, 'C');

$sqldetalles = "SELECT * FROM `detalle_factura` WHERE id_header = '$id_factura'";
$resultdetalles = $connect->query($sqldetalles);
if ($resultdetalles->num_rows > 0) {
    foreach ($resultdetalles as $rowdetalles) {
        $cantidad = $rowdetalles['cantidad'];
        $descripcion_producto = $rowdetalles["detalle"];
        $precio_producto = $rowdetalles["precio"];
        $total_item = $cantidad * $precio_producto;

        $pdf->Cell(100, 5, $descripcion_producto, 'T,L,B');
        $pdf->Cell(30, 5, $cantidad, 'R,L,B', 0, 'C');
        $pdf->Cell(30, 5, number_format($precio_producto, 0, '.', '.'), 1, 0, 'R');
        $pdf->Cell(30, 5, number_format($total_item, 0, '.', '.'), 1, 1, 'R');
    }
};

$pdf->Ln(2);
$pdf->Cell(30, 5, 'SUBTOTAL:', 'L, B, T', 0, 'L');
$pdf->Cell(0, 5, number_format($totalfactura, 0, '.', '.'), 'R,T,B', 1, 'R');
$pdf->Cell(30, 5, 'TOTAL DE LA OPERACION:', 'L, B', 0, 'L');
$pdf->Cell(0, 5, number_format($totalfactura, 0, '.', '.'), 'R,T,B', 1, 'R');
$pdf->Cell(30, 5, 'TOTAL EN GUARANIES:', 'L, B', 0, 'L');
$pdf->Cell(0, 5, number_format($totalfactura, 0, '.', '.'), 'R,T,B', 1, 'R');
$pdf->Cell(40, 5, 'LIQUIDACION DE IVA:', 'L, B', 0, 'L');
$pdf->Cell(25, 5, '(5%)', 'L, B', 0, 'C');
$pdf->Cell(30, 5, '0', 'L, B', 0, 'C');
$pdf->Cell(25, 5, '(10%)', 'L, B', 0, 'C');
$pdf->Cell(30, 5, number_format($iva, 0, '.', '.'), 'L, B', 0, 'C');
$pdf->Cell(30, 5, 'TOTAL IVA: ', 'L, B', 0, 'C');
$pdf->Cell(0, 5, number_format($iva, 0, '.', '.'), 'R,T,B', 1, 'R');

$pdf->Ln(2);
$pdf->Cell(0, 5, 'Original', 0, 1, 'L');

$pdf->SetY(150);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Image('../img/logobw.png', 8, 148, 33);
// Información de la factura
$pdf->Cell(130, 5, 'CarWahs Lavadero', 'T,L', 0, 'R');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(40, 5, 'Timbrado:', 'L, T', 0, 'L');
$pdf->Cell(20, 5, $timbrado, 'R, T', 1, 'R');
$pdf->Cell(130, 5, 'de Christian Benitez', 'L', 0, 'R');
$pdf->Cell(40, 5, 'Fecha de inicio de vigencia:', 'L', 0, 'L');
$pdf->Cell(20, 5, $fecha_inicio, 'R', 1, 'R');
$pdf->Cell(130, 5, 'Factura para Cliente', 'L', 0, 'R');
$pdf->Cell(40, 5, 'Fecha de vencimiento:', 'L', 0, 'L');
$pdf->Cell(20, 5, $fecha_vencimiento, 'R', 1, 'R');
$pdf->Cell(130, 5, 'Factura para Cliente', 'L', 0, 'R');
$pdf->Cell(40, 5, 'RUC:', 'L', 0, 'L');
$pdf->Cell(20, 5, '3215768-9', 'R', 1, 'R');
$pdf->Cell(130, 5, 'Factura para Cliente', 'L', 0, 'R');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 5, 'Factura', 'L,R', 1, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(130, 5, 'Factura para Cliente', 'L,B', 0, 'R');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 5, $nro_factura, 'L,R,B', 0, 'C');
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(100, 5, 'Fecha y hora de emision: ' . $fecha_horas, 'T,L', 0, 'L');
$pdf->Cell(30, 5, 'Condicion de venta: ', 'L,T', 0, 'L');
$pdf->Cell(60, 5, $condicion, 'R,T', 1, 'L');
$pdf->Cell(100, 5, 'Nombre o Razon Social: ' . $nombres . ' ' . $apellidos, 'L', 0, 'L');
$pdf->Cell(30, 5, 'Metodo de pago: ', 'L', 0, 'L');
$pdf->Cell(60, 5, 'Efectivo', 'R', 1, 'L');
$pdf->Cell(100, 5, 'RUC/CI: ' . $nroci, 'L', 0, 'L');
$pdf->Cell(40, 5, '', 'L', 0, 'L');
$pdf->Cell(50, 5, '', 'R', 1, 'R');
$pdf->Cell(100, 5, 'Direccion: ' . $direccion, 'L', 0, 'L');
$pdf->Cell(40, 5, '', 'L', 0, 'L');
$pdf->Cell(50, 5, '', 'R', 1, 'R');
$pdf->Cell(100, 5, 'Tel. o Cel.: ' . $phonenumber, 'L', 0, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 5, '', 'L,R', 1, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(100, 5, 'Correo: ' . $email, 'L,B', 0, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 5, '', 'L,R,B', 0, 'C');
$pdf->Ln(7);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(100, 5, 'Descripcion', 1);
$pdf->Cell(30, 5, 'Cantidad', 1, 0, 'C');
$pdf->Cell(30, 5, 'Precio Unitario', 1, 0, 'C');
$pdf->Cell(30, 5, 'Total', 1, 1, 'C');

$sqldetalles = "SELECT * FROM `detalle_factura` WHERE id_header = '$id_factura'";
$resultdetalles = $connect->query($sqldetalles);
if ($resultdetalles->num_rows > 0) {
    foreach ($resultdetalles as $rowdetalles) {
        $cantidad = $rowdetalles['cantidad'];
        $descripcion_producto = $rowdetalles["detalle"];
        $precio_producto = $rowdetalles["precio"];
        $total_item = $cantidad * $precio_producto;

        $pdf->Cell(100, 5, $descripcion_producto, 'T,L,B');
        $pdf->Cell(30, 5, $cantidad, 'R,L,B', 0, 'C');
        $pdf->Cell(30, 5, number_format($precio_producto, 0, '.', '.'), 1, 0, 'R');
        $pdf->Cell(30, 5, number_format($total_item, 0, '.', '.'), 1, 1, 'R');
    }
};

$pdf->Ln(2);
$pdf->Cell(30, 5, 'SUBTOTAL:', 'L, B, T', 0, 'L');
$pdf->Cell(0, 5, number_format($totalfactura, 0, '.', '.'), 'R,T,B', 1, 'R');
$pdf->Cell(30, 5, 'TOTAL DE LA OPERACION:', 'L, B', 0, 'L');
$pdf->Cell(0, 5, number_format($totalfactura, 0, '.', '.'), 'R,T,B', 1, 'R');
$pdf->Cell(30, 5, 'TOTAL EN GUARANIES:', 'L, B', 0, 'L');
$pdf->Cell(0, 5, number_format($totalfactura, 0, '.', '.'), 'R,T,B', 1, 'R');
$pdf->Cell(40, 5, 'LIQUIDACION DE IVA:', 'L, B', 0, 'L');
$pdf->Cell(25, 5, '(5%)', 'L, B', 0, 'C');
$pdf->Cell(30, 5, '0', 'L, B', 0, 'C');
$pdf->Cell(25, 5, '(10%)', 'L, B', 0, 'C');
$pdf->Cell(30, 5, number_format($iva, 0, '.', '.'), 'L, B', 0, 'C');
$pdf->Cell(30, 5, 'TOTAL IVA: ', 'L, B', 0, 'C');
$pdf->Cell(0, 5, number_format($iva, 0, '.', '.'), 'R,T,B', 1, 'R');

$pdf->Ln(2);
$pdf->Cell(0, 5, 'Duplicado', 0, 1, 'L');


$pdf->Output();
