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
    <title>Registrar Clientes</title>
</head>

<body class="contentdash">
    <header class="ctnheader">
        <?php
        include "../componetes/header.php";
        ?>
    </header>
    <div class="ctnpage">
        <div class="ctnform" id="targetcenter">
            <div class="targetform">
                <form action="" method="post" class="row g-3" id="forminsertclient">
                    <div class="col-12">
                        <div class="col-md-6 d-grid mx-auto">
                            <h1 class="col-12 display-6 d-flex justify-content-center">
                                Registrar Clientes
                            </h1>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?php
                        include "../action/insertcliente.php";
                        ?>
                        <label for="inputname" class="form-label required">Nombre *</label>
                        <input type="text" class="form-control" id="inputname" name="inputname" placeholder="Juan" autocomplete="off">
                        <div class="valid-feedback">
                            Correcto!
                        </div>
                        <div class="invalid-feedback">
                            El nombre es obligatorio y no puede contener números y debe al menos tener 3 letras
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputlastname" class="form-label">Apellido</label>
                        <input type="text" class="form-control" name="inputlastname" id="inputlastname" autocomplete="off">
                        <div class="valid-feedback">
                            Correcto!
                        </div>
                        <div class="invalid-feedback">
                            El apellido no puede contener números y debe al menos tener 3 letras
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputdocumento" class="form-label">C.I o RUC *</label>
                        <input type="text" class="form-control" id="inputdocumento" name="inputdocumento" autocomplete="off">
                        <div class="valid-feedback">
                            Correcto!
                        </div>
                        <div class="invalid-feedback">
                            No puede contener "." ni letras, debe ser mayor a 5 digitos
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputemail" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="inputemail" name="inputemail" autocomplete="off">
                        <div class="valid-feedback">
                            Correcto!
                        </div>
                        <div class="invalid-feedback">
                            No puede contener espacios y debe incluir un "@"
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputphone" class="form-label">Celular</label>
                        <input type="text" class="form-control" id="inputphone" name="inputphone" autocomplete="off">
                        <div class="valid-feedback">
                            Correcto!
                        </div>
                        <div class="invalid-feedback">
                            Debe de ser de 10 digitos y no puede contener espacios ni puntos "."
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Direccion *</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Av. Pratt Gill Ñemby" autocomplete="off">
                        <div class="valid-feedback">
                            Correcto!
                        </div>
                        <div class="invalid-feedback">
                            Este campo es obligatorio
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputCity" class="form-label">Ciudad *</label>
                        <select class="form-select" id="inputCity" name="inputCity" autocomplete="off">
                            <option selected disabled>Selecciones una ciudad</option>
                            <?php
                            include "../action/selectcontry.php";
                            ?>
                        </select>
                        <div class="valid-feedback">
                            Correcto!
                        </div>
                        <div class="invalid-feedback">
                            Este campo es obligatorio
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="col-md-2 d-grid mx-auto">
                            <button type="submit" class="btn btn-primary btn-lg" name="insertclient" id="insertclient">Registrar</button>
                        </div>
                    </div>
                </form>
                <div class="containerta">
                    <table id="myTable" class="table table-hover table-bordered table-striped nowrap" style="width:100%;">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Ci / Ruc</th>
                                <th scope="col">Email</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../action/viewclient.php";
                            ?>
                        </tbody>
                    </table>
                </div>
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