<?php
include "../connet/conexion.php";
session_start();
$nombre = $_SESSION["nombre"];
$apellido = $_SESSION["apellido"];
$id_tipo = $_SESSION["id_tipo"];
if (empty($_SESSION["nombre"]) and empty($_SESSION["apellido"])) {
    header("location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jq-3.6.0/dt-1.11.4/datatables.min.css" />
    <link rel="icon" href="../img/Logo.png">
    <title>Facturación</title>
</head>

<body class="contentdash">
    <header class="ctnheader">
        <?php
        include "../componetes/header.php";
        ?>
    </header>
    <div class="ctnpage">
        <div class="ctnfact" id="targetcenter">
            <form action="" method="post" class="row" id="formfactura">
                <div class="col-12 m-0" style="background-color: rgb(184, 229, 247, 0.5);">
                    <div class="col-md-6 d-grid mx-auto">
                        <p class="col-12 display-10 d-flex justify-content-center">
                            Datos de factura
                        </p>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-around m-0 mb-3 p-0 headerfact">
                    <div class="datosfactura m-0">
                        <label for="" class="form-label">N° de Factura</label>
                        <div type="text" class="form-control">001-002-000001</div>
                        <label for="" class="form-label">Timbrado</label>
                        <div type="date" class="form-control">13345675</div>
                    </div>
                    <div class="datosfactura">
                        <label for="" class="form-label">Fecha de inicio</label>
                        <div type="date" class="form-control">13/05/2024</div>
                        <label for="" class="form-label">Fecha fin de Vigencia</label>
                        <div type="text" class="form-control">13/05/2024</div>
                    </div>
                    <div class="datosfactura">
                        <label for="" class="form-label">Nombre Cliente: </label>
                        <input type="text" class="form-control">
                        <label for="" class="form-label">Ruc o Ci: </label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="datosfactura">
                        <label for="" class="form-label">Direccion: </label>
                        <input type="text" class="form-control">
                        <label for="" class="form-label">Celular: </label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="datosfactura">
                        <label for="" class="form-label">Correo: </label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="datosfactura">
                        <p class="form-label">Condicion de venta: </p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="contado" checked>
                            <label class="form-check-label" for="contado">
                                Contado
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="credito" disabled>
                            <label class="form-check-label" for="credito">
                                Credito
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3" style="border: 1px solid red; height:500px">

                </div>

                <div class="col-md-6 d-grid">
                    <div class="col-md-6 mx-auto ctnbtns">
                        <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;" name="insertclient" id="insertclient">Imprimir</button>
                    </div>
                </div>
                <div class="col-md-6 d-grid">
                    <div class="col-md-6 d-grid mx-auto ctnbtns">
                        <a href="../pages/recepcionvh.php" class="btn btn-secondary btn-lg" style="width: 100%;" name="insertclient" id="insertclient">Cancelar</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <footer class="ctnfooter">
        <?php
        include "../componetes/footer.php"; ?>
    </footer>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../node_modules/jquery/dist/jquery.slim.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.6.0/dt-1.11.4/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "language": idioma_espanol
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
    <script src="../js/clientverif.js"></script>

</body>

</html>