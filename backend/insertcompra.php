<?php
include "../functions/conexion.php";
date_default_timezone_set('America/Asuncion');
session_start();
require_once '../functions/funciones.php';
// var_dump($_POST);
try {
    $connect->beginTransaction();
    if (!estaSesionIniciada()) {
        throw new Exception("No haz iniciado sesión");
        exit();
    }
    $fecha = date('d/m/Y H:i');
    $fechafactura = $_POST['fechafactura'];
    $fechaObj = DateTime::createFromFormat('d/m/Y', $fechafactura);
    if ($fechaObj && $fechaObj->format('d/m/Y') === $fechafactura) {
        $fechafactura = $fechaObj->format('Y-m-d');
    } else {
        echo "Fecha no válida.";
        exit;
    }

    $id_proveedor = $_POST['idproveedor'];
    if (empty($id_proveedor)) {
        throw new Exception("El proveedor no puede estar vacio");
    }

    $timbrado = $_POST['timbrado'];
    if (empty($timbrado)) {
        throw new Exception("El timbrado es obligatorio");
    };

    $nrofactura = $_POST['nrofactura'];
    $regexnrofactura = '/^\d{3}-\d{3}-\d{7}$/';
    if (!preg_match($regexnrofactura, $nrofactura)) {
        throw new Exception("Número de factura no válido. Debe seguir el patrón 001-001-0000001.");
    }
    //Verificar si ya existe el registro en la base de datos
    $sqlnrofactura = "SELECT * FROM `headercompra`INNER JOIN proveedores ON headercompra.id_proveedor = proveedores.id_proveedor WHERE headercompra.nrocompr= :nrocomprobante AND headercompra.id_proveedor = :idproveedor";
    $stmt = $connect->prepare($sqlnrofactura);
    $stmt->bindParam('nrocomprobante', $nrofactura, PDO::PARAM_STR);
    $stmt->bindParam('idproveedor', $id_proveedor, PDO::PARAM_INT);
    $stmt->execute();
    $nrocomprobanteresult = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($nrocomprobanteresult) {
        throw new Exception("Ya existe un registro cargado con el proveedor: " .
            $nrocomprobanteresult['nombre_proveedor'] .
            " y este número de factura: " .
            $nrocomprobanteresult['nrocompr'] . "\n" .
            "Vea el registro nro: " .
            $nrocomprobanteresult['registro']);
    }
    $tipo_factura = $_POST['tipo_factura'];
    $typemodena = $_POST['typemodena'];
    $typeorigen = $_POST['typeorigen'];
    $exentas = $_POST['exenta'];
    $gravada5 = $_POST['gravada5'];
    $gravada10 = $_POST['gravada10'];
    $precio = $_POST["precio_unit"];
    $cantidad = $_POST["cantidad"];
    $descripcion = $_POST["descripcion"];
    $cant_check = count($descripcion);
    if (
        !is_array($descripcion) || count($descripcion) === 0 ||
        !is_array($cantidad) || count($cantidad) === 0
    ) {
        throw new Exception("Debes de cargar el detalle de la factura");
    }
    foreach ($descripcion as $desc) {
        if (trim($desc) === '') {
            throw new Exception("La descripción no puede estar vacía.");
        }
    }
    foreach ($cantidad as $cant) {
        if (trim($cant) === '') {
            throw new Exception("La cantidad no puede estar vacía.");
        }
    }
    foreach ($precio as $pre) {
        if (trim($pre) === '') {
            throw new Exception("El precio es obligatorio");
        }
    }
    if (count($precio) !== $cant_check || count($cantidad) !== $cant_check) {
        throw new Exception("El número de ítems no coincide en descripción, precio y cantidad.");
    }

    $concepto = $_POST['conceptodecompra'];
    if (empty($concepto)) {
        throw new Exception("El concepto de compra es obligatorio");
    } elseif (is_array($concepto)) {
        $concepto_string = implode(", ", $concepto);
    } else {
        $concepto_string = (string) $concepto;
    }

    $typedoc = $_POST['typedoc'];
    if (empty($typedoc)) {
        throw new Exception("Selecciona el tipo de documento");
    } else {
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
    }

    function totalexentas($exentas)
    {
        $total = 0;
        if (is_array($exentas)) {
            for ($i = 0; $i < count($exentas); $i++) {
                if (is_numeric($exentas[$i])) {
                    $total += floatval($exentas[$i]);
                }
            }
        }
        return $total;
    }
    function totalgravada5($gravada5)
    {
        $total = 0;
        if (is_array($gravada5)) {
            for ($i = 0; $i < count($gravada5); $i++) {
                if (is_numeric($gravada5[$i])) {
                    $total += floatval($gravada5[$i]);
                }
            }
        }
        return $total / 21;
    }
    function totalgravada10($gravada10)
    {
        $total = 0;
        if (is_array($gravada10)) {
            for ($i = 0; $i < count($gravada10); $i++) {
                if (is_numeric($gravada10[$i])) {
                    $total += floatval($gravada10[$i]);
                }
            }
        }
        return $total / 11;
    }
    function totaliva($totalgravada5, $totalgravada10)
    {
        return ($totalgravada5 + $totalgravada10);
    }
    function totalfactura($totalexentas, $gravada5, $gravada10)
    {
        $totalgr10 = 0;
        $totalgr5 = 0;
        if (is_array($gravada10)) {
            for ($i = 0; $i < count($gravada10); $i++) {
                if (is_numeric($gravada10[$i])) {
                    $totalgr10 += floatval($gravada10[$i]);
                }
            }
        }
        if (is_array($gravada5)) {
            for ($i = 0; $i < count($gravada5); $i++) {
                if (is_numeric($gravada5[$i])) {
                    $totalgr5 += floatval($gravada5[$i]);
                }
            }
        }
        return ($totalexentas + $totalgr5 + $totalgr10);
    };
    $totalexentas = totalexentas($exentas);
    $totalgravada5 = totalgravada5($gravada5);
    $totalgravada10 = totalgravada10($gravada10);
    $totaliva = totaliva($totalgravada5, $totalgravada10);
    $totalfactura = totalfactura($totalexentas, $gravada5, $gravada10);
    // var_dump($totalfactura);
    //funtion para crear el número de registro de acuerdo a la empresa del usuario
    function crearnroregistro()
    {
        global $connect;
        $slqnroregistro = "SELECT MAX(registro) AS max_registro FROM headercompra WHERE id_usuario = :id";
        $stmt = $connect->prepare($slqnroregistro);
        $stmt->bindParam('id', $_SESSION['id_usuario'], PDO::PARAM_INT);
        $stmt->execute();
        $nroregistro = $stmt->fetch(PDO::FETCH_ASSOC);
        $ultimoreg = $nroregistro['max_registro'] ? $nroregistro['max_registro'] : 0;
        $proximoreg = $ultimoreg + 1;
        return $proximoreg;
    };
    $proximoreg = crearnroregistro();
    $insertcompra = "INSERT INTO `headercompra`( `registro`, `nrocompr`, `timbrado`, `id_condicion`, `id_proveedor`, `concepto`, `fecha_compra`, `fecha_carga`, `exentas`, `gravada5`, `gravada10`, `totaliva`, `totalfactura`, `tipo_factura`, `moneda`, `typeorigen`, `id_usuario`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connect->prepare($insertcompra);
    $stmt->execute([$proximoreg, $nrofactura, $timbrado, $id_condicion, $id_proveedor, $concepto_string, $fechafactura, $fecha, $totalexentas, $totalgravada5, $totalgravada10, $totaliva, $totalfactura, $tipo_factura, $typemodena, $typeorigen, $_SESSION['id_usuario']]);
    $idinsertado = $connect->lastInsertId();

    $insertdetalle = "INSERT INTO `detalles_compra`(`idheadercompra`, `descripcion`, `cantidad`, `precio`, `exenta`, `gravada5`, `gravada10`) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connect->prepare($insertdetalle);
    for ($i = 0; $i < $cant_check; $i++) {
        $descripcion_item = $descripcion[$i];
        $precio_item = $precio[$i];
        $cantidad_item = $cantidad[$i];
        $exenta_item = $exentas[$i];
        $gravada5_item = floatval($gravada5[$i]) / 1.05;
        $gravada10_item = floatval($gravada10[$i]) / 11;

        $stmt->execute([$idinsertado, $descripcion_item, $cantidad_item, $precio_item, $exenta_item, $gravada5_item, $gravada10_item]);
    }
    $connect->commit();

    echo json_encode([
        'success' => true,
        'id' => $proximoreg,
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
        'message' => $e->getMessage()
    ]);
}
$connect = null;
