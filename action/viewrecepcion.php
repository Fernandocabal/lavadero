<?php
include "../connet/conexion.php";
try {
    $query = ("SELECT * FROM recepcion 
    INNER JOIN vehiculos ON recepcion.id_vehiculos = vehiculos.id_vehiculos 
    ORDER BY recepcion.nro_recepcion;");
    $stmt = $connect->prepare($query);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $nrorecepcion = $row["nro_recepcion"];
        $id_recepcion = $row["id_recepcion"];
        $fecha = $row["fecha_horas"];
        $tipos_vehiculos = $row["tipos_vehiculos"];
        $nombreclient = $row["nombre_cliente"];
        $total = 0;

        $sqldetalles = "SELECT * FROM `detalles_recepcion` WHERE detalles_recepcion.id_recepcion = :id_recepcion";
        $stmtDetalles = $connect->prepare($sqldetalles);
        $stmtDetalles->bindParam(':id_recepcion', $id_recepcion,  PDO::PARAM_INT);
        $stmtDetalles->execute();
        while ($rowdetalles = $stmtDetalles->fetch(PDO::FETCH_ASSOC)) {
            $descripcion_producto = $rowdetalles["descipcion_producto"];
            $precio_producto = $rowdetalles["precio"];
            $total += $precio_producto;
        }
        echo "
        <tr>
        <td>$nrorecepcion</td>
        <td>$nombreclient</td>
        <td>$tipos_vehiculos</td>
        <td>$total GS</td>
        <td>
            <a class='dropdown-item' href='../pages/factura.php?id=" . htmlspecialchars($id_recepcion, ENT_QUOTES, 'UTF-8') . "' name='idclient' id='listitem'><i class='bx bx-edit'></i>Facturar</a>
        </td>
        </tr>";
    }
} catch (PDOException $e) {
    echo 'Error ' . $e->getMessage();
}
