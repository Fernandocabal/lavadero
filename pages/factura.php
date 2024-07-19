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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jq-3.6.0/dt-1.11.4/datatables.min.css" />
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
            <div class="targetfact">
                <form action="" method="post" class="row g-3" id="forminsertclient">
                    <div class="col-12">
                        <div class="col-md-6 d-grid mx-auto">
                            <p class="col-12 display-10 d-flex justify-content-center">
                                Datos de factura
                            </p>
                        </div>
                    </div>
                    <div class="col-12 d-flex display-10" style="border: 1px solid red; height:180px">
                        <div class="col-md-2" style="border: 1px solid red;">
                            <label for="" class="form-label">N° de Factura</label>
                            <input type="text" class="form-control">
                            <label for="" class="form-label">Timbrado</label>
                            <div type="date" class="form-control">13345675</div>
                        </div>
                        <div class="col-md-2" style="border: 1px solid red;">
                            <label for="" class="form-label">Fecha de inicio</label>
                            <div type="date" class="form-control">13/05/2024</div>
                            <label for="" class="form-label">Fecha fin de Vigencia</label>
                            <div type="text" class="form-control">13/05/2024</div>
                        </div>
                        <div class="col-md-2" style="border: 1px solid red;">
                            <label for="" class="form-label">Nombre Cliente: </label>
                            <input type="text" class="form-control">
                            <label for="" class="form-label">Ruc o Ci: </label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-2" style="border: 1px solid red;">
                            <label for="" class="form-label">Direccion: </label>
                            <input type="text" class="form-control">
                            <label for="" class="form-label">Celular: </label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-2" style="border: 1px solid red;">
                            <label for="" class="form-label">Correo: </label>
                            <input type="text" class="form-control">


                        </div>
                        <div class="col-md-2">
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
                    <div class="col-12" style="border: 1px solid red; height:500px">

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
    </div>
    <footer class="ctnfooter">
        <?php
        include "../componetes/footer.php"; ?>
    </footer>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
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