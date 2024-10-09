<?php
include "../functions/conexion.php";
date_default_timezone_set('America/Asuncion');
session_start();
var_dump($_POST);
try {
    $connect->beginTransaction();
    $fecha = date('d/m/Y H:i');
    $fechafactura = $_POST['fechafactura'];
    $timbrado = $_POST['timbrado'];
    $nrofactura = $_POST['nrofactura'];
    $typedoc = $_POST['typedoc'];
    $concepto = $_POST['conceptodecompra'];
    $typemodena = $_POST['typemodena'];
    $id_proveedor = $_POST['id_proveedor'];
    $typeorigen = $_POST['typeorigen'];
    $exentas = $_POST['exenta_unit'];
    $grabada5 = $_POST['grabada5_unit'];
    $grabada10 = $_POST['grabada10_unit'];
    $precio = $_POST["precio_unit"];
    $cantidad = $_POST["cantidad"];
    $descripcion = $_POST["descripcion"];
    $cant_check = count($descripcion);
    if (count($precio) !== $cant_check || count($cantidad) !== $cant_check) {
        throw new Exception("El número de ítems no coincide en descripción, precio y cantidad.");
    }
    if (is_array($concepto)) {
        $concepto_string = implode(", ", $concepto);
    } else {
        $concepto_string = (string) $concepto;
    }
    $totalfactura = $_POST['totalfactura'];
    $sqlcondicion = "SELECT * FROM `condicion` WHERE id_condicion = :condicion";
    $stmt = $connect->prepare($sqlcondicion);
    $stmt->bindParam(':condicion', $typedoc, PDO::PARAM_INT);
    $stmt->execute();
    $condicion = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$condicion) {
        throw new Exception("Condición no encontrada.");
    } else {
        $id_condicion = $condicion["id_condicion"];
    };
    function totalexentas($exentas)
    {
        $total = 0;

        for ($i = 0; $i < count($exentas); $i++) {
            if (is_numeric($exentas[$i])) {
                $total += floatval($exentas[$i]);
            }
        }
        return $total;
    }
    function totalgrabada5($grabada5)
    {
        $total = 0;

        for ($i = 0; $i < count($grabada5); $i++) {
            if (is_numeric($grabada5[$i])) {
                $total += floatval($grabada5[$i]);
            }
        }
        return $total / 1.05;
    }
    function totalgrabada10($grabada10)
    {
        $total = 0;

        for ($i = 0; $i < count($grabada10); $i++) {
            if (is_numeric($grabada10[$i])) {
                $total += floatval($grabada10[$i]);
            }
        }
        return $total / 11;
    }
    $totalexentas = totalexentas($exentas);
    $totalgrabada5 = totalgrabada5($grabada5);
    $totalgrabada10 = totalgrabada10($grabada10);

    $insertcompra = "INSERT INTO `headercompra`(`nrocompr`, `timbrado`, `id_condicion`, `id_proveedor`, `concepto`, `fecha_compra`, `fecha_carga`, `exentas`, `grabada5`, `grabada10`, `totalcompra`, `moneda`, `typeorigen`, `user`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connect->prepare($insertcompra);
    $stmt->execute([$nrofactura, $timbrado, $id_condicion, $id_proveedor, $concepto_string, $fechafactura, $fecha, $totalexentas, $totalgrabada5, $totalgrabada10, $totalfactura, $typemodena, $typeorigen, $_SESSION['nombre']]);
    $idinsertado = $connect->lastInsertId();

    $insertdetalle = "INSERT INTO `detalles_compra`(`idheadercompra`, `descripcion`, `cantidad`, `precio`, `exenta`, `grabada5`, `grabada10`) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connect->prepare($insertdetalle);
    for ($i = 0; $i < $cant_check; $i++) {
        $descripcion_item = $descripcion[$i];
        $precio_item = $precio[$i];
        $cantidad_item = $cantidad[$i];
        $exenta_item = $exentas[$i];
        $grabada5_item = floatval($grabada5[$i]) / 1.05;
        $grabada10_item = floatval($grabada10[$i]) / 11;

        $stmt->execute([$idinsertado, $descripcion_item, $cantidad_item, $precio_item, $exenta_item, $grabada5_item, $grabada10_item]);
    }
    $connect->commit();

    echo json_encode([
        'success' => true,
        'id' => $idinsertado,
        'message' => 'Id de registro: '
    ]);
} catch (PDOException $e) {
    $connect->rollBack();
    echo json_encode([
        'success' => false,
        'message' => 'Error al insertar datos: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    $connect->rollBack();
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
$connect = null;