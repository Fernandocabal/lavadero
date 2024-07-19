<?php
include "../connet/conexion.php";
$query = ("SELECT * FROM recepcion 
INNER JOIN vehiculos ON recepcion.id_vehiculos = vehiculos.id_vehiculos 
ORDER BY recepcion.nro_recepcion;");

if ($result = $connect->query($query)) {
    while ($row = $result->fetch_assoc()) {
        $nrorecepcion = $row["nro_recepcion"];
        $id_recepcion = $row["id_recepcion"];
        $fecha = $row["fecha_horas"];
        $tipos_vehiculos = $row["tipos_vehiculos"];
        $nombreclient = $row["nombre_cliente"];
        $total = 0;

        $sqldetalles = "SELECT * FROM `detalles_recepcion` WHERE detalles_recepcion.id_recepcion = '$id_recepcion'";
        $resultdetalles = $connect->query($sqldetalles);
        if ($resultdetalles->num_rows > 0) {
            while ($rowdetalles = $resultdetalles->fetch_assoc()) {
                $descripcion_producto = $rowdetalles["descipcion_producto"];
                $precio_producto = $rowdetalles["precio"];
                $total += $precio_producto;
            }
            $resultdetalles->close();
        }

        echo "
        <tr>
        <td> $nrorecepcion </td>
        <td> $nombreclient </td>
        <td> $tipos_vehiculos </td>
         <td> $total GS  </td>
        <td>
            <a class='dropdown-item' href='../pages/factura.php?id=" . $id_recepcion . "' name='idclient' id='listitem'><i class='bx bx-edit'></i>Facturar</a>
            ";
    }
}
