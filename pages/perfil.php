<?php
include "../functions/conexion.php";

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
    <link rel="icon" href="../assets/img/Logo.png">
    <title>Facturación</title>
</head>

<body class="contentdash">
    <header class="ctnheader">
        <?php
        include "../include/header.php";
        ?>
    </header>
    <div class="ctnpage">
        <div class="perfil_ctn">
            <div class="perfil_box_group">
                <div class="perfil_box d-flex flex-column align-items-center mt-4">
                    <p class="m-0">Datos Personales</p>
                    <form action="" class="container container-fluid">
                        <label class="form-label" for="nombre">Nombre</label>
                        <input type="text" class="form-control form-control-sm" name="nombre" id="nombre" value="<?php echo $nombre; ?>" readonly>
                        <label class="form-label" for="apellido">Apellido</label>
                        <input type="text" class="form-control form-control-sm" name="apellido" id="apellido" value="<?php echo $apellido; ?>" readonly>
                    </form>
                </div>
                <div class="perfil_box d-flex flex-column align-items-center">
                    <p class="m-0">Cambiar Contraseña</p>
                    <form action="" id="change_password" class="container container-fluid " autocomplete="off">
                        <label class="form-label" for="pass-actual">Contraseña Actual</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control form-control-sm" name="pass-actual" id="pass-actual" value="" autocomplete="off">
                            <div class="input-group-text" style="cursor: pointer;" id="eye_password">
                                <i class='bx bx-show'></i>
                            </div>
                        </div>
                        <label class="form-label" for="new_password">Nueva contraseña</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control form-control-sm" name="new_password" id="new_password" value="" autocomplete="off">
                            <div class="input-group-text" style="cursor: pointer;" id="eye_new_password">
                                <i class='bx bx-show'></i>
                            </div>
                        </div>
                        <label class="form-label" for="confirm_password">Confirmar nueva contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control form-control-sm" name="confirm_password" id="confirm_password" value="" autocomplete="off">
                            <div class="input-group-text" style="cursor: pointer;" id="eye_confirm_password">
                                <i class='bx bx-show'></i>
                            </div>
                        </div>
                        <div class="d-flex flex-column">
                            <h7 class="m-0 text-danger mensaje_error_password" id="mensaje_error_password"></h7>
                            <input type="button" id="btn_change_password" value="Guardar" class="col-3 btn btn-dark btn-sm">
                        </div>

                    </form>
                </div>
                <div class="perfil_box d-flex flex-column align-items-center">
                    <p class="m-0">Parametros de la empresa</p>
                    <form action="" class="container container-fluid">
                        <label class="form-label" for="nombre_empresa">Empresa</label>
                        <select class="form-select form-select-sm" name="nombre_empresa" id="nombre_empresa">
                            <option value="<?php echo $nombre_empresa; ?>" selected><?php echo $nombre_empresa; ?></option>
                        </select>
                        <label class="form-label" for="Sucursal">Sucursal</label>
                        <input type="text" class="form-control form-control-sm" name="Sucursal" id="Sucursal" value="<?php echo $apellido; ?>" readonly>
                        <input type="submit" id="btn_change_empresa" value="Guardar" class="col-3 btn btn-dark btn-sm">
                    </form>
                </div>
            </div>
            <div class="perfil_box_group">
                <!-- <div class="perfil_box"></div>
                <div class="perfil_box"></div>
                <div class="perfil_box"></div> -->
            </div>
        </div>
    </div>
    <footer class="ctnfooter">
        <?php
        include "../include/footer.php"; ?>
    </footer>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/js/perfil.js"></script>
</body>

</html>