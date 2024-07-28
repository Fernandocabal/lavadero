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
    <script src="../node_modules/jquery/dist/jquery.min.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../node_modules/select2/css/select2.min.css" rel="stylesheet" />
    <script src="../node_modules/select2/js/select2.min.js"></script>
    <script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
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
                <?php
                include "../action/insertfactura.php";
                ?>
                <div class="col-12 m-0 titlefact">
                    <div class="col-md-6 d-grid mx-auto">
                        <p class="col-12 display-10 d-flex justify-content-center">
                            Datos de factura
                        </p>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-around m-0 mb-3 p-0 headerfact">
                    <div class="datosfactura m-0">
                        <div class="form-label">N° de Factura</div>
                        <div type="text" class="form-control"><?php include "../componetes/viewnrofactura.php"; ?></div>
                        <div class="form-label">Timbrado</div>
                        <div type="date" class="form-control"><?php echo $nro_timbrado; ?></div>
                    </div>
                    <div class="datosfactura">
                        <div class="form-label">Fecha de Vencimiento</div>
                        <div type="date" class="form-control"><?php echo $fecha_vencimiento   ?></div>
                    </div>
                    <div class="datosfactura">
                        <label for="nombrecliente" class="form-label">Nombre Cliente: </label>
                        <select type="text" id="nombres" class="form-select mb-3">
                            <option selected disabled>Escribe el nombre o nro de documento</option>
                            <?php
                            include "../action/selectclient.php";
                            ?>
                        </select>
                        <label for="" class="form-label">Ruc o Ci: </label>
                        <input type="text" class="form-control" id="nroci" readonly>
                    </div>
                    <div class="datosfactura">
                        <label for="direccion" class="form-label">Direccion: </label>
                        <input type="text" class="form-control" id="direccion" readonly>
                        <label for="" class="form-label">Celular: </label>
                        <input type="text" class="form-control" id="phonenumber" readonly>
                    </div>
                    <div class="datosfactura">
                        <label for="" class="form-label">Correo: </label>
                        <input type="text" class="form-control" id="email" readonly>
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
                        <button type="submit" class="btn btn-dark  btn-lg" style="width: 100%;" name="insertfactura" id="insertfactura">Imprimir</button>
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
    <script>
        $(document).ready(function() {
            $('#nombres').select2();
            $('#nombres').on('select2:select', function(e) {
                let data = e.params.data;
                $.ajax({
                    type: 'POST',
                    url: '../componetes/obtener_datos_cliente.php',
                    data: {
                        id: data['id']
                    },
                    success: function(response) {
                        if (response) {
                            let responseobjet = JSON.parse(response)
                            $('#nroci').val(responseobjet.nroci);
                            $('#direccion').val(responseobjet.direccion);
                            $('#phonenumber').val(responseobjet.phonenumber);
                            $('#email').val(responseobjet.email);
                        } else {
                            console.error("Respuesta del servidor inválida:", response);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error fetching client data:", textStatus, errorThrown);
                    }
                });
            });
        });
    </script>

</body>

</html>