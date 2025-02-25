<?php
ob_start();  // Inicia el buffer de salida
include "../functions/conexion.php";
date_default_timezone_set('America/Asuncion');
session_start();
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION["apellido"];
$id_empresa = $_SESSION['id_empresa_activa'];
$id_sucursal = $_SESSION['id_sucursal_activa'];
$horagenerado = date('d-m-Y_H-i-s');
$usernickname = $_SESSION["nombre_usuario"];

$query = "SELECT * FROM empresa_activa  ea 
INNER JOIN empresas empr ON ea.id_empresa=empr.id_empresa
INNER JOIN sucursales suc ON ea.id_sucursal=suc.id_sucursal
INNER JOIN cajas cj ON ea.id_caja=cj.id_caja
    WHERE usuario = :usuario";
$stmt = $connect->prepare($query);
$stmt->bindParam(':usuario', $usernickname, PDO::PARAM_STR);
$stmt->execute();
$empresa_activa = $stmt->fetch(PDO::FETCH_ASSOC);
if ($empresa_activa) {
    $id_empresa = $empresa_activa['id_empresa'];
    $nombre_sucursal = $empresa_activa['nombre'];
    $nro_sucursal = $empresa_activa['nro_sucursal'];
    $nombre_empresa = $empresa_activa['nombre_empresa'];
}

try {
    $firstdate = $_POST['firstdate'];
    $lastdate = $_POST['lastdate'];
    $sql = "SELECT * FROM `headercompra` 
            INNER JOIN proveedores pr ON headercompra.id_proveedor = pr.id_proveedor
            INNER JOIN usuarios user ON headercompra.id_usuario = user.id_usuario 
            WHERE headercompra.fecha_compra BETWEEN :firstdate AND :lastdate AND headercompra.id_empresa = :id_empresa AND headercompra.id_sucursal= :id_sucursal";
    $stmt = $connect->prepare($sql);
    $stmt->bindParam(':firstdate', $firstdate, PDO::PARAM_STR);
    $stmt->bindParam(':lastdate', $lastdate, PDO::PARAM_STR);
    $stmt->bindParam(':id_empresa', $id_empresa, PDO::PARAM_INT);
    $stmt->bindParam(':id_sucursal', $id_sucursal, PDO::PARAM_INT);
    $stmt->execute();
    $data = [];
    $total = 0;
    $totalgravada5 = 0;
    $totalgravada10 = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
        $total += $row['totalfactura'];
        $totalgravada5 += $row['gravada5'];
        $totalgravada10 += $row['gravada10'];
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    exit;
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
$pdf->SetFont('helvetica', 'B', 9);
$pdf->Cell(195, 8, 'Reporte De Compras Registradas', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 7);
$pdf->Cell(100, 5, 'Desde: ' . $firstdate . " hasta: " . $lastdate, 0, 0, 'L');
$pdf->Cell(93, 5, 'Informe generado por: ' . $_SESSION["nombre"] . " " . $_SESSION["apellido"] . " en fecha: " . date('d/m/Y') . " a las "  . date('H:i:s') . "hs", 0, 1, 'L');
$pdf->Cell(195, 8, 'Empresa: ' . $nombre_empresa . " Sucursal: " . $nro_sucursal . " - " . $nombre_sucursal, 0, 1, 'L');
$pdf->SetFont('helvetica', 'B', 7);
$pdf->Cell(12, 8, 'Registro', 1, 0, 'C');
$pdf->Cell(38, 8, 'Proveedor', 1, 0, 'C');
$pdf->Cell(15, 8, 'Timbrado', 1, 0, 'C');
$pdf->Cell(25, 8, 'Nro Factura', 1, 0, 'C');
$pdf->Cell(23, 8, 'Fecha de Compra', 1, 0, 'C');
$pdf->Cell(30, 8, 'Concepto', 1, 0, 'C');
$pdf->Cell(18, 8, 'Total Compra', 1, 0, 'C');
$pdf->Cell(16, 8, 'IVA 5%', 1, 0, 'C');
$pdf->Cell(16, 8, 'IVA 10%', 1, 1, 'C');
foreach ($data as $row) {
    $pdf->SetFont('helvetica', '', 6);
    $pdf->Cell(12, 4, $row['registro'], 'B', 0, 'C');
    $nombre_proveedor = $row['nombre_proveedor'];
    $max_length = 28;
    if (strlen($nombre_proveedor) > $max_length) {
        $nombre_proveedor = substr($nombre_proveedor, 0, $max_length) . '...';
    }
    $pdf->Cell(38, 4, $nombre_proveedor, 'B', 0, 'L');
    $pdf->Cell(15, 4,  $row['timbrado'], 'B', 0, 'R');
    $pdf->Cell(25, 4,  $row['nrocompr'], 'B', 0, 'C');
    $pdf->Cell(23, 4,  $row['fecha_compra'], 'B', 0, 'C');
    $pdf->Cell(30, 4,  $row['concepto'], 'B', 0, 'L');
    $pdf->Cell(18, 4,  number_format($row['totalfactura'], 0, '.', '.') . " Gs", 'B', 0, 'R');
    $pdf->Cell(16, 4,  number_format($row['gravada5'], 0, '.', '.') . " Gs", 'B', 0, 'R');
    $pdf->Cell(16, 4,  number_format($row['gravada10'], 0, '.', '.') . " Gs", 'B', 1, 'R');
}
$pdf->Cell(143, 4, 'Total', 'B L R', 0, 'L');
$pdf->Cell(18, 4,  number_format($total, 0, '.', '.') . " Gs", 'B R', 0, 'R');
$pdf->Cell(16, 4,  number_format($totalgravada5, 0, '.', '.') . " Gs", 'B R', 0, 'R');
$pdf->Cell(16, 4,  number_format($totalgravada10, 0, '.', '.') . " Gs", 'B R', 1, 'R');

$pdf->SetTitle('Compras registradas hasta: ' . $lastdate);
$pdf->SetAuthor($_SESSION["nombre"] . " " . $_SESSION["apellido"]);
ob_end_clean();

// Enviar el PDF al navegador
$pdf->Output('Reporte compras ' . $horagenerado . '.pdf', 'I');
