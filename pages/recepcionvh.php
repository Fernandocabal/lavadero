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
    <link rel="stylesheet" href="../css/datatables/datatables.min.css">
    <title>Recepcion de vehiculos</title>
</head>

<body>
    <header class="ctnheader">
        <?php
        include "../componentes/header.php";
        ?>
    </header>
    <div class="ctnpage">
        <div class="ctnform" id="targetcenter">
            <div class="targetform">
                <form action="" method="post" id="formregis">
                    <?php
                    include "../action/insertrecepcion.php";
                    ?>
                    <div class="col-12">
                        <div class="col-md-6 d-grid mx-auto">
                            <h1 class="col-12 display-6 d-flex justify-content-center">
                                Recepcion de vehiculos
                            </h1>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <div class="col-md-6 factuinput">
                            <label for="inputname" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="inputname" id="inputname" autocomplete="off">
                            <div class="valid-feedback">
                                Correcto!
                            </div>
                            <div class="invalid-feedback">
                                Este campo es obligatorio
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <div class="col-md-6 factuinput">
                            <label for="inputvehiculo" class="form-label">Vehiculo</label>
                            <select class="form-select" id="inputvehiculo" name="inputvehiculo" autocomplete="off">
                                <option selected disabled>Selecciona un tipo de vehículo</option>
                                <?php
                                include "../action/selectvehiculo.php";
                                ?>
                            </select>
                            <div class="valid-feedback">
                                Correcto!
                            </div>
                            <div class="invalid-feedback">
                                Este campo es obligatorio
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-center" style="height: 100px;">
                        <div class="col-md-6 d-flex flex-column factuinput" style="justify-content:start;" id="option-container">

                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <div class="col-md-6 factuinput">
                            <input class="form-control" type="text" name="viewvalor" id="viewvalor" value="" disabled>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="col-md-2 d-grid mx-auto mt-2">
                            <button type="submit" class="btn btn-primary btn-lg" name="insertclient" id="insertclient">Guardar</button>
                        </div>

                    </div>
                </form>
                <div class="col-12">
                    <div class="col-md-6 d-grid mx-auto">
                        <h1 class="col-12 display-6 d-flex justify-content-center">
                            Lista de espera
                        </h1>
                    </div>
                </div>
                <div class="containerta">
                    <table id="myTable" class="table table-hover table-bordered table-striped nowrap" style="width:100%;">
                        <thead>
                            <tr>
                                <th scope="col">Numero de recepcion</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Vehiculo</th>
                                <th scope="col">Total a pagar</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include "../action/viewrecepcion.php";
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <footer class="ctnfooter">
        <?php
        include "../componentes/footer.php"; ?>
    </footer>
    <script src="../node_modules/jquery/dist/jquery.slim.min.js" crossorigin="anonymous"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="../js/datatables/datatables.min.js"></script>
    <script src="../js/registerverif.js">
    </script>

</body>

</html>