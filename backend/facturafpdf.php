<?php

include "../functions/conexion.php";
$id_factura = $_GET['id'];
try {
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
        $timbrado = $row["timbrado"];
        $nro_factura = $row["nro_factura"];
        $totalfactura = $row['total'];
        $iva = $row['iva'];
        $cajero = $row['cajero'];
        $total = 0;
    }
    $sqltimbrado = "SELECT * FROM `timbrado`";
    $stmtimbrado = $connect->prepare($sqltimbrado);
    $stmtimbrado->execute();

    while ($row = $stmtimbrado->fetch(PDO::FETCH_ASSOC)) {
        $nro_timbrado = $row["nro_timbrado"];
        $sucursal = $row["sucursal"];
        $caja = $row["caja"];
        $fecha_inicio = $row["fecha_inicio"];
        $fecha_vencimiento = $row["fecha_vencimiento"];
    }
} catch (PDOException $e) {
    echo 'Error' . $e->getMessage();
}




require('../assets/fpdf/fpdf.php');
class PDF extends FPDF
{
    function Header() {}
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 12);
$pdf->Image('../assets/img/logosinfondo.png', 8, 5, 33);
// Información de la factura
$pdf->Cell(130, 5, 'CarWahs Lavadero', 'T,L', 0, 'R');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(40, 4, 'Timbrado:', 'L, T', 0, 'L');
$pdf->Cell(20, 4, $timbrado, 'R, T', 1, 'R');
$pdf->Cell(130, 4, 'de Christian Benitez', 'L', 0, 'R');
$pdf->Cell(40, 4, 'Fecha de inicio de vigencia:', 'L', 0, 'L');
$pdf->Cell(20, 4, $fecha_inicio, 'R', 1, 'R');
$pdf->Cell(130, 4, 'Factura para Cliente', 'L', 0, 'R');
$pdf->Cell(40, 4, 'Fecha de vencimiento:', 'L', 0, 'L');
$pdf->Cell(20, 4, $fecha_vencimiento, 'R', 1, 'R');
$pdf->Cell(130, 4, 'Factura para Cliente', 'L', 0, 'R');
$pdf->Cell(40, 4, 'RUC:', 'L', 0, 'L');
$pdf->Cell(20, 4, '3215768-9', 'R', 1, 'R');
$pdf->Cell(130, 4, 'Factura para Cliente', 'L', 0, 'R');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 4, 'Factura', 'L,R', 1, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(130, 4, 'Factura para Cliente', 'L,B', 0, 'R');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 4, $nro_factura, 'L,R,B', 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(100, 4, 'Fecha y hora de emision: ' . $fecha_horas, 'T,L', 0, 'L');
$pdf->Cell(30, 4, 'Condicion de venta: ', 'L,T', 0, 'L');
$pdf->Cell(60, 4, $condicion, 'R,T', 1, 'L');
$pdf->Cell(100, 4, 'Nombre o Razon Social: ' . $nombres . ' ' . $apellidos, 'L', 0, 'L');
$pdf->Cell(30, 4, 'Metodo de pago: ', 'L', 0, 'L');
$pdf->Cell(60, 4, 'Efectivo', 'R', 1, 'L');
$pdf->Cell(100, 4, 'RUC/CI: ' . $nroci, 'L', 0, 'L');
$pdf->Cell(40, 4, '', 'L', 0, 'L');
$pdf->Cell(50, 4, '', 'R', 1, 'R');
$pdf->Cell(100, 4, 'Direccion: ' . $direccion, 'L', 0, 'L');
$pdf->Cell(40, 4, '', 'L', 0, 'L');
$pdf->Cell(50, 4, '', 'R', 1, 'R');
$pdf->Cell(100, 4, 'Tel. o Cel.: ' . $phonenumber, 'L', 0, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 4, '', 'L,R', 1, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(100, 4, 'Correo: ' . $email, 'L,B', 0, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 4, '', 'L,R,B', 0, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 7);
$pdf->Cell(100, 5, 'Descripcion', 1);
$pdf->Cell(30, 5, 'Cantidad', 1, 0, 'C');
$pdf->Cell(30, 5, 'Precio Unitario', 1, 0, 'C');
$pdf->Cell(30, 5, 'Total', 1, 1, 'C');

try {

    $sqldetalles = "SELECT * FROM `detalle_factura` WHERE id_header = :id_factura";
    $stmt = $connect->prepare($sqldetalles);
    $stmt->bindParam(':id_factura', $id_factura, PDO::PARAM_INT);
    $stmt->execute();
    $resultdetalles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($resultdetalles) > 0) {
        foreach ($resultdetalles as $rowdetalles) {
            $cantidad = $rowdetalles['cantidad'];
            $descripcion_producto = $rowdetalles["detalle"];
            $precio_producto = $rowdetalles["precio"];
            $total_item = $cantidad * $precio_producto;

            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(100, 5, $descripcion_producto, 'T,L,B');
            $pdf->Cell(30, 5, $cantidad, 'R,L,B', 0, 'C');
            $pdf->Cell(30, 5, number_format($precio_producto, 0, '.', '.'), 1, 0, 'R');
            $pdf->Cell(30, 5, number_format($total_item, 0, '.', '.'), 1, 1, 'R');
        }
    }
} catch (PDOException $th) {
    echo 'error ' . $th->getMessage();
}

$pdf->Ln(1);
$pdf->Cell(30, 4, 'SUBTOTAL:', 'L, B, T', 0, 'L');
$pdf->Cell(0, 4, number_format($totalfactura, 0, '.', '.'), 'R,T,B', 1, 'R');
$pdf->Cell(30, 4, 'TOTAL DE LA OPERACION:', 'L, B', 0, 'L');
$pdf->Cell(0, 4, number_format($totalfactura, 0, '.', '.'), 'R,T,B', 1, 'R');
$pdf->Cell(30, 4, 'TOTAL EN GUARANIES:', 'L, B', 0, 'L');
$pdf->Cell(0, 4, number_format($totalfactura, 0, '.', '.'), 'R,T,B', 1, 'R');
$pdf->Cell(40, 4, 'LIQUIDACION DE IVA:', 'L, B', 0, 'L');
$pdf->Cell(25, 4, '(5%)', 'L, B', 0, 'C');
$pdf->Cell(30, 4, '0', 'L, B', 0, 'C');
$pdf->Cell(25, 4, '(10%)', 'L, B', 0, 'C');
$pdf->Cell(30, 4, number_format($iva, 0, '.', '.'), 'L, B', 0, 'C');
$pdf->Cell(30, 4, 'TOTAL IVA: ', 'L, B', 0, 'C');
$pdf->Cell(0, 4, number_format($iva, 0, '.', '.'), 'R,T,B', 1, 'R');

$pdf->Ln(1);
$pdf->Cell(0, 1, 'Original', 0, 1, 'L');

$pdf->SetY(152);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Image('../assets/img/logosinfondo.png', 8, 147, 33);
// Información de la factura
$pdf->Cell(130, 5, 'CarWahs Lavadero', 'T,L', 0, 'R');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(40, 4, 'Timbrado:', 'L, T', 0, 'L');
$pdf->Cell(20, 4, $timbrado, 'R, T', 1, 'R');
$pdf->Cell(130, 4, 'de Christian Benitez', 'L', 0, 'R');
$pdf->Cell(40, 4, 'Fecha de inicio de vigencia:', 'L', 0, 'L');
$pdf->Cell(20, 4, $fecha_inicio, 'R', 1, 'R');
$pdf->Cell(130, 4, 'Factura para Cliente', 'L', 0, 'R');
$pdf->Cell(40, 4, 'Fecha de vencimiento:', 'L', 0, 'L');
$pdf->Cell(20, 4, $fecha_vencimiento, 'R', 1, 'R');
$pdf->Cell(130, 4, 'Factura para Cliente', 'L', 0, 'R');
$pdf->Cell(40, 4, 'RUC:', 'L', 0, 'L');
$pdf->Cell(20, 4, '3215768-9', 'R', 1, 'R');
$pdf->Cell(130, 4, 'Factura para Cliente', 'L', 0, 'R');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 4, 'Factura', 'L,R', 1, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(130, 4, 'Factura para Cliente', 'L,B', 0, 'R');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 4, $nro_factura, 'L,R,B', 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(100, 4, 'Fecha y hora de emision: ' . $fecha_horas, 'T,L', 0, 'L');
$pdf->Cell(30, 4, 'Condicion de venta: ', 'L,T', 0, 'L');
$pdf->Cell(60, 4, $condicion, 'R,T', 1, 'L');
$pdf->Cell(100, 4, 'Nombre o Razon Social: ' . $nombres . ' ' . $apellidos, 'L', 0, 'L');
$pdf->Cell(30, 4, 'Metodo de pago: ', 'L', 0, 'L');
$pdf->Cell(60, 4, 'Efectivo', 'R', 1, 'L');
$pdf->Cell(100, 4, 'RUC/CI: ' . $nroci, 'L', 0, 'L');
$pdf->Cell(40, 4, '', 'L', 0, 'L');
$pdf->Cell(50, 4, '', 'R', 1, 'R');
$pdf->Cell(100, 4, 'Direccion: ' . $direccion, 'L', 0, 'L');
$pdf->Cell(40, 4, '', 'L', 0, 'L');
$pdf->Cell(50, 4, '', 'R', 1, 'R');
$pdf->Cell(100, 4, 'Tel. o Cel.: ' . $phonenumber, 'L', 0, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 4, '', 'L,R', 1, 'C');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(100, 4, 'Correo: ' . $email, 'L,B', 0, 'L');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 4, '', 'L,R,B', 0, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 7);
$pdf->Cell(100, 5, 'Descripcion', 1);
$pdf->Cell(30, 5, 'Cantidad', 1, 0, 'C');
$pdf->Cell(30, 5, 'Precio Unitario', 1, 0, 'C');
$pdf->Cell(30, 5, 'Total', 1, 1, 'C');

try {

    $sqldetalles = "SELECT * FROM `detalle_factura` WHERE id_header = :id_factura";
    $stmt = $connect->prepare($sqldetalles);
    $stmt->bindParam(':id_factura', $id_factura, PDO::PARAM_INT);
    $stmt->execute();
    $resultdetalles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($resultdetalles) > 0) {
        foreach ($resultdetalles as $rowdetalles) {
            $cantidad = $rowdetalles['cantidad'];
            $descripcion_producto = $rowdetalles["detalle"];
            $precio_producto = $rowdetalles["precio"];
            $total_item = $cantidad * $precio_producto;

            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(100, 5, $descripcion_producto, 'T,L,B');
            $pdf->Cell(30, 5, $cantidad, 'R,L,B', 0, 'C');
            $pdf->Cell(30, 5, number_format($precio_producto, 0, '.', '.'), 1, 0, 'R');
            $pdf->Cell(30, 5, number_format($total_item, 0, '.', '.'), 1, 1, 'R');
        }
    }
} catch (PDOException $th) {
    echo 'error ' . $th->getMessage();
}

$pdf->Ln(1);
$pdf->Cell(30, 4, 'SUBTOTAL:', 'L, B, T', 0, 'L');
$pdf->Cell(0, 4, number_format($totalfactura, 0, '.', '.'), 'R,T,B', 1, 'R');
$pdf->Cell(30, 4, 'TOTAL DE LA OPERACION:', 'L, B', 0, 'L');
$pdf->Cell(0, 4, number_format($totalfactura, 0, '.', '.'), 'R,T,B', 1, 'R');
$pdf->Cell(30, 4, 'TOTAL EN GUARANIES:', 'L, B', 0, 'L');
$pdf->Cell(0, 4, number_format($totalfactura, 0, '.', '.'), 'R,T,B', 1, 'R');
$pdf->Cell(40, 4, 'LIQUIDACION DE IVA:', 'L, B', 0, 'L');
$pdf->Cell(25, 4, '(5%)', 'L, B', 0, 'C');
$pdf->Cell(30, 4, '0', 'L, B', 0, 'C');
$pdf->Cell(25, 4, '(10%)', 'L, B', 0, 'C');
$pdf->Cell(30, 4, number_format($iva, 0, '.', '.'), 'L, B', 0, 'C');
$pdf->Cell(30, 4, 'TOTAL IVA: ', 'L, B', 0, 'C');
$pdf->Cell(0, 4, number_format($iva, 0, '.', '.'), 'R,T,B', 1, 'R');

$pdf->Ln(1);
$pdf->Cell(0, 1, 'Duplicado', 0, 1, 'L');

$pdf->SetTitle('Factura nro: ' . $nro_factura);

$pdf->SetAuthor('Cajero: ' . $cajero);

$pdf->Output('I', 'FACT' . $nro_factura . '.pdf');
