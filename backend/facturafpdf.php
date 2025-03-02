<?php
ob_start();
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

    $sqltimbrado = "SELECT * FROM `timbrado` WHERE id_empresa= :id_empresa AND id_sucursal= :id_sucursal AND id_caja= :id_caja";
    $stmtimbrado = $connect->prepare($sqltimbrado);
    $stmtimbrado->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
    $stmtimbrado->bindParam(':id_sucursal', $id_sucursal, PDO::PARAM_INT);
    $stmtimbrado->bindParam(':id_caja', $id_caja, PDO::PARAM_INT);
    $stmtimbrado->execute();
    while ($row = $stmtimbrado->fetch(PDO::FETCH_ASSOC)) {
        $nro_timbrado = $row["nro_timbrado"];
        $fecha_inicio = $row["fecha_inicio"];
        $fecha_vencimiento = $row["fecha_vencimiento"];
    }

    $sqlempresa = "SELECT * FROM `empresas` e INNER JOIN ciudades c ON e.id_ciudad = c.id_ciudad WHERE e.id_empresa= :id_empresa";
    $stmrempresa = $connect->prepare($sqlempresa);
    $stmrempresa->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
    $stmrempresa->execute();
    while ($empresa = $stmrempresa->fetch(PDO::FETCH_ASSOC)) {
        $nombre_empresa = $empresa['nombre_empresa'];
        $ruc_empresa = $empresa['ruc_empresa'];
        $direccion_empresa = $empresa['direccion_empresa'];
        $tel_empresa = $empresa['tel_empresa'];
        $email_empresa = $empresa['email_empresa'];
        $nombre_ciudad = $empresa['nombre_ciudad'];
    }
} catch (PDOException $e) {
    echo 'Error' . $e->getMessage();
}
require('../assets/tcpdf/tcpdf.php');
class PDF extends TCPDF
{
    function Header() {}
}
$pdf = new TCPDF();
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();
function cabecera($pdf,  $nombre_empresa, $ruc_empresa, $direccion_empresa, $tel_empresa, $nombre_ciudad, $email_empresa, $nro_timbrado, $fecha_inicio, $fecha_vencimiento, $nro_factura, $fecha_horas, $condicion, $nombres, $apellidos, $nroci, $direccion, $phonenumber, $email)
{
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(130, 5, $nombre_empresa, 'L,T', 0, 'C');
    $pdf->SetFont('helvetica', '', 7);
    $pdf->Cell(40, 4, 'Timbrado:', 'L,T', 0, 'L');
    $pdf->Cell(20, 4,  $nro_timbrado, 'R,T', 1, 'R');
    $pdf->Cell(130, 5, '', 'L', 0, 'C');
    $pdf->Cell(40, 4, 'Fecha de inicio de vigencia:', 'L', 0, 'L');
    $pdf->Cell(20, 4, $fecha_inicio, 'R', 1, 'R');
    $pdf->Cell(130, 4, $direccion_empresa, 'L', 0, 'C');
    $pdf->Cell(40, 4, 'Fecha de vencimiento:', 'L', 0, 'L');
    $pdf->Cell(20, 4, $fecha_vencimiento, 'R', 1, 'R');
    $pdf->Cell(130, 4, 'Cel: ' . $tel_empresa, 'L', 0, 'C');
    $pdf->Cell(40, 4, 'RUC:', 'L', 0, 'L');
    $pdf->Cell(20, 4, $ruc_empresa, 'R', 1, 'R');
    $pdf->Cell(130, 5, $email_empresa, 'L', 0, 'C');
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->Cell(60, 5, 'Factura', 'L,R', 1, 'C');
    $pdf->SetFont('helvetica', '', 7);
    $pdf->Cell(130, 5, $nombre_ciudad, 'L,B', 0, 'C');
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->Cell(60, 5, $nro_factura, 'L,R,B', 0, 'C');
    $pdf->Ln(6);
    //Seccion datos del cliente
    $pdf->SetFont('helvetica', '', 7);
    $pdf->Cell(100, 4, 'Fecha y hora de emision: ' . $fecha_horas, 'T,L', 0, 'L');
    $pdf->Cell(30, 4, 'Condicion de venta: ', 'T', 0, 'L');
    $pdf->Cell(60, 4, $condicion, 'R,T', 1, 'L');
    $pdf->Cell(100, 4, 'Nombre o Razon Social: ' . $nombres . ' ' . $apellidos, 'L', 0, 'L');
    $pdf->Cell(30, 4, 'Metodo de pago: ', '', 0, 'L');
    $pdf->Cell(60, 4, 'Efectivo', 'R', 1, 'L');
    $pdf->Cell(100, 4, 'RUC/CI: ' . $nroci, 'L', 0, 'L');
    $pdf->Cell(40, 4, '', '', 0, 'L');
    $pdf->Cell(50, 4, '', 'R', 1, 'R');
    $pdf->Cell(100, 4, 'Direccion: ' . $direccion, 'L', 0, 'L');
    $pdf->Cell(40, 4, '', '', 0, 'L');
    $pdf->Cell(50, 4, '', 'R', 1, 'R');
    $pdf->Cell(100, 4, 'Tel. o Cel.: ' . $phonenumber, 'L', 0, 'L');
    $pdf->Cell(90, 4, '', 'R', 1, 'C');
    $pdf->SetFont('helvetica', '', 7);
    $pdf->Cell(100, 4, 'Correo: ' . $email, 'L,B', 0, 'L');
    $pdf->Cell(90, 4, '', 'R,B', 0, 'C');
};
cabecera($pdf, $nombre_empresa, $ruc_empresa, $direccion_empresa, $tel_empresa, $nombre_ciudad, $email_empresa, $nro_timbrado, $fecha_inicio, $fecha_vencimiento, $nro_factura, $fecha_horas, $condicion, $nombres, $apellidos, $nroci, $direccion, $phonenumber, $email);
$pdf->Image('../assets/img/empresa_' . $id_empresa . '.png', 11, 10, 25);
$pdf->Ln(5);
function agregarDetallesFactura($pdf, $connect, $id_factura)
{
    $pdf->SetFont('helvetica', '', 7);
    $pdf->Cell(100, 5, 'Descripcion', 'T,B,L', 0, 'C');
    $pdf->Cell(30, 5, 'Cantidad', 'T,R,B,L', 0, 'C');
    $pdf->Cell(30, 5, 'Precio Unitario', 'R,T,B', 0, 'C');
    $pdf->Cell(30, 5, 'Total', 'T,B,R', 1, 'C');
    try {
        $sqldetalles = "SELECT * FROM `detalle_factura` WHERE id_header = :id_factura";
        $stmt = $connect->prepare($sqldetalles);
        $stmt->bindParam(':id_factura', $id_factura, PDO::PARAM_INT);
        $stmt->execute();
        $resultdetalles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $num_detalles = count($resultdetalles);
        $max_detalles = 10;  // Máximo de detalles a mostrar
        if (count($resultdetalles) > 0) {
            foreach ($resultdetalles as $rowdetalles) {
                $cantidad = $rowdetalles['cantidad'];
                $descripcion_producto = $rowdetalles["detalle"];
                $precio_producto = $rowdetalles["precio"];
                $total_item = $cantidad * $precio_producto;

                $pdf->SetFont('helvetica', '', 7);
                $pdf->Cell(100, 4, $descripcion_producto, 'L,B');
                $pdf->Cell(30, 4, $cantidad, 'R,L,B', 0, 'C');
                $pdf->Cell(30, 4, number_format($precio_producto, 0, '.', '.'), 'B', 0, 'R');
                $pdf->Cell(30, 4, number_format($total_item, 0, '.', '.'), 'B,L,R', 1, 'R');
            }
        }
        for ($i = $num_detalles; $i < $max_detalles; $i++) {
            $pdf->Cell(100, 4, '', 'L');
            $pdf->Cell(30, 4, '', '', 0, 'C');
            $pdf->Cell(30, 4, '', '', 0, 'R');
            $pdf->Cell(30, 4, '', 'R', 1, 'R');
        }
    } catch (PDOException $th) {
        echo 'error ' . $th->getMessage();
    }
}
agregarDetallesFactura($pdf, $connect, $id_factura);
function piefactura($pdf, $totalfactura, $gravada5, $gravada10, $totaliva)
{
    $pdf->Cell(30, 4, 'SUBTOTAL:', 'L,T', 0, 'L');
    $pdf->Cell(0, 4, number_format($totalfactura, 0, '.', '.'), 'R,T', 1, 'R');
    $pdf->Cell(40, 4, 'TOTAL DE LA OPERACION:', 'L,T', 0, 'L');
    $pdf->Cell(0, 4, number_format($totalfactura, 0, '.', '.'), 'R,T', 1, 'R');
    $pdf->Cell(40, 4, 'TOTAL EN GUARANIES:', 'L,T', 0, 'L');
    $pdf->Cell(0, 4, number_format($totalfactura, 0, '.', '.'), 'R,T', 1, 'R');
    $pdf->Cell(40, 4, 'LIQUIDACION DE IVA:', 'L,B,T', 0, 'L');
    $pdf->Cell(25, 4, '(5%)', 'B,T', 0, 'L');
    $pdf->Cell(30, 4, number_format($gravada5, 0, '.', '.'), 'B,T', 0, 'L');
    $pdf->Cell(25, 4, '(10%)', 'B,T', 0, 'L');
    $pdf->Cell(30, 4, number_format($gravada10, 0, '.', '.'), 'B,T', 0, 'L');
    $pdf->Cell(30, 4, 'TOTAL IVA: ', 'B,T', 0, 'L');
    $pdf->Cell(0, 4, number_format($totaliva, 0, '.', '.'), 'R,T,B', 1, 'R');
};
piefactura($pdf, $totalfactura, $gravada5, $gravada10, $totaliva);
$pdf->Cell(0, 1, 'Original', 0, 1, 'L');
//Sección duplicado
$pdf->SetY(152);
$pdf->Image('../assets/img/empresa_' . $id_empresa . '.png', 11, 152, 25);

cabecera($pdf, $nombre_empresa, $ruc_empresa, $direccion_empresa, $tel_empresa, $nombre_ciudad, $email_empresa, $nro_timbrado, $fecha_inicio, $fecha_vencimiento, $nro_factura, $fecha_horas, $condicion, $nombres, $apellidos, $nroci, $direccion, $phonenumber, $email);
$pdf->Ln(5);
agregarDetallesFactura($pdf, $connect, $id_factura);
piefactura($pdf, $totalfactura, $gravada5, $gravada10, $totaliva);
$pdf->Cell(0, 1, 'Duplicado', 0, 1, 'L');
$pdf->SetTitle('Factura nro: ' . $nro_factura);
$pdf->SetAuthor('Cajero: ' . $cajero);
ob_end_clean();
$pdf->Output('FACT' . $nro_factura . '.pdf', 'I');
