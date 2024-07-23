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
    <title>Editar clientes</title>
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
                <form action="" method="post" class="row g-2" id="form_edit_client">
                    <?php
                    include "../action/clientupdate.php";
                    ?>
                    <div class="col-12">
                        <div class="col-md-6 d-grid mx-auto">
                            <h1 class="col-12 display-6 d-flex justify-content-center">
                                Editar Clientes
                            </h1>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?php
                        $idclient = $_GET["id"];
                        $consulta = $consulta = ("SELECT * FROM `clientes` WHERE id_cliente='$idclient'");
                        if ($result = $connect->query($consulta)) {
                            while ($row = $result->fetch_assoc()) {
                                $id_cliente = $row["id_cliente"];
                                $nombres = $row["nombres"];
                                $apellidos = $row["apellidos"];
                                $nroci = $row["nroci"];
                                $email = $row["email"];
                                $phonenumber = $row["phonenumber"];
                                $direccion = $row["direccion"];
                                $ciudad = $row["ciudad"];
                            }
                        }
                        ?>
                        <input type="text" class="form-control" id="" name="id_cliente" value="<?php echo $id_cliente ?>" autocomplete="off" style="display: none;">
                        <label for="inputname" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="inputname" name="inputname" value="<?php echo $nombres ?>" autocomplete="off">
                        <div class="valid-feedback">
                            Correcto!
                        </div>
                        <div class="invalid-feedback">
                            El nombre no puede contener números y debe al menos tener 3 letras
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputlastname" class="form-label">Apellido</label>
                        <input type="text" class="form-control" name="inputlastname" id="inputlastname" value="<?php echo $apellidos ?>" autocomplete="off">
                        <div class="valid-feedback">
                            Correcto!
                        </div>
                        <div class="invalid-feedback">
                            El apellido no puede contener números y debe al menos tener 3 letras
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputdocumento" class="form-label">C.I o RUC</label>
                        <input type="text" class="form-control" id="inputdocumento" name="inputdocumento" value="<?php echo $nroci ?>" autocomplete="off">
                    </div>
                    <div class="col-md-6">
                        <label for="inputemail" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="inputemail" name="inputemail" value="<?php echo $email ?>" autocomplete="off">
                    </div>
                    <div class="col-md-6">
                        <label for="inputphone" class="form-label">Celular</label>
                        <input type="text" class="form-control" id="inputphone" name="inputphone" value="<?php echo $phonenumber ?>" autocomplete="off">
                    </div>
                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Direccion</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion ?>" autocomplete="off">
                    </div>
                    <div class="col-md-6">
                        <label for="inputCity" class="form-label">Ciudad</label>
                        <select class="form-select" id="inputCity" name="inputCity" autocomplete="off">
                            <?php
                            $query = ("SELECT * FROM `ciudades` WHERE id_ciudad = $ciudad;");
                            if ($data = $connect->query($query)) {
                                while ($row = $data->fetch_assoc()) {
                                    $id_ciudad = $row["id_ciudad"];
                                    $nombre = $row["nombre"];
                                    echo "<option selected value='$id_ciudad'>$nombre</option>";
                                }
                            }
                            ?>
                            <?php
                            $consulta = ("SELECT * FROM `ciudades`");
                            if ($result = $connect->query($consulta)) {
                                while ($row = $result->fetch_assoc()) {
                                    $id_ciudad = $row["id_ciudad"];
                                    $nombre = $row["nombre"];
                                    echo "<option value='$id_ciudad'>$nombre</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <div class="col-md-2 d-grid mx-auto">
                            <button type="submit" class="btn btn-primary btn-lg" name="editclient">Guardar cambios</button>
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
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script src="../js/editclientverif.js"></script>
</body>

</html>