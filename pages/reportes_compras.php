<?php
include "../functions/conexion.php";
session_start();
$nombre = $_SESSION["nombre"];
$apellido = $_SESSION["apellido"];
$id_tipo = $_SESSION["id_tipo"];
$id_empresa = $_SESSION['id_empresa'];

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <script src="../node_modules/jquery/dist/jquery.min.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../node_modules/select2/css/select2.min.css" rel="stylesheet" />
    <script src="../node_modules/select2/js/select2.min.js"></script>
    <script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/datatables/datatables.min.css">
    <link rel="icon" href="../assets/img/Logo.png">
    <title>Reporte Compras</title>
</head>

<body class="contentdash">
    <header class="ctnheader">
        <?php
        include "../include/header.php";
        ?>
    </header>
    <div class="ctnpage">
        <div class="ctnreport flex-column">
            <div class=" reporte_contenedor_form d-flex flex-column">
                <h1 class="col-12 display-6 d-flex justify-content-center">
                    Obtener Reporte
                </h1>
                <p class="col-12 d-flex flex-column align-items-center">Selecciona un rago de fecha para obtener un reporte de tus facturas de compras</p>
                <form action="../backend/reportecompraspdf.php" class="mb-4 d-flex flex-column justify-content-around" method="post" id="formreport" target="_blank" style="height: 160px;">
                    <div class="d-flex justify-content-center">
                        <div class="reporte_fecha d-flex flex-column align-items-center">
                            <label class="form-label form-label-sm" for="firstdate">Desde</label>
                            <input type="date" class="form-control" name="firstdate" id="firstdate">
                        </div>
                        <div class="reporte_fecha d-flex flex-column align-items-center">
                            <label class="form-label form-label-sm" for="lastdate">Hasta</label>
                            <input type="date" class="form-control" name="lastdate" id="lastdate">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-2">
                        <input type="submit" class="btn btn-success" id="report" value="Obtener reporte">
                    </div>
                </form>
            </div>
            <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                <p>Tabla con el listado de todas las facturas cargadas</p>
                <div class="tablareport">
                    <table id="reporte" class="table table-hover table-bordered table-striped nowrap" style="width:100%; font-size:12px;">
                        <thead>
                            <tr>
                                <th scope="col">Registro</th>
                                <th scope="col">Nro Factura</th>
                                <th scope="col">Proveedor</th>
                                <th scope="col">Fecha de carga</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../backend/viewcompras.php";
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <footer class="ctnfooter">
        <?php
        include "../include/footer.php"; ?>
    </footer>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="../assets/js/datatables/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#reporte').DataTable({
                "language": idioma_espanol,
                "pageLength": 5,
                "lengthMenu": [5, 25, 50],
                "order": [
                    [0, 'desc']
                ],
                layout: {
                    bottomEnd: {
                        paging: {
                            firstLast: false
                        }
                    }
                }
            });
        });
        var idioma_espanol = {
            "processing": "Procesando...",
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Ningún dato disponible en esta tabla",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "loadingRecords": "Cargando...",
            "decimal": ".",
            "emptyTable": "No hay datos disponibles en la tabla",
            "zeroRecords": "No se encontraron coincidencias",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
            "infoFiltered": "(Filtrado de _MAX_ total de entradas)",
            "lengthMenu": "Mostrar _MENU_ entradas",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    </script>
    <script src="../assets/js/reportecompras.js"></script>
    <script src="../scripts/reportescompras.js"></script>
</body>

</html>