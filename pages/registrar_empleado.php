<?php
include "../functions/conexion.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>Registrar Empleado</title>
</head>

<body class="contentdash">
    <header class="ctnheader">
        <?php
        include "../include/header.php";
        ?>
    </header>

    <div class="ctnpage">
        <div class="ctnform" id="targetcenter" style="border: 1px solid red;">
            <form action="" class="card_form d-flex" style="border: 1px solid red;">
                <div class="perfil_box m-2">
                    <p>Datos del Usuario</p>
                    <label class="form-label col-form-label-sm" for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control form-control-sm">
                    <label class="form-label col-form-label-sm" for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="apellido" class="form-control form-control-sm">
                    <label class="form-label col-form-label-sm" for="usernickname">Nombre de Usuario</label>
                    <input type="text" name="usernickname" id="usernickname" class="form-control form-control-sm">
                    <label class="form-label col-form-label-sm" for="pass-actual">Contraseña Actual</label>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control form-control-sm" name="pass-actual" id="pass-actual" value="" autocomplete="off">
                        <div class="input-group-text" style="cursor: pointer;" id="eye_password">
                            <i class='bx bx-show'></i>
                        </div>
                    </div>
                    <label class="form-label col-form-label-sm" for="confirm_password">Confirmar contraseña</label>
                    <div class="input-group">
                        <input type="password" class="form-control form-control-sm" name="confirm_password" id="confirm_password" value="" autocomplete="off">
                        <div class="input-group-text" style="cursor: pointer;" id="eye_confirm_password">
                            <i class='bx bx-show'></i>
                        </div>
                    </div>
                </div>
                <div class="m-2">
                    <p>Empresa Activa</p>
                    <label class="form-label col-form-label-sm" for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control">
                    <label class="form-label col-form-label-sm" for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="apellido" class="form-control">
                    <label class="form-label col-form-label-sm" for="usernickname">Nombre de Usuario</label>
                    <input type="text" name="usernickname" id="usernickname" class="form-control">
                    <label class="form-label col-form-label-sm" for="password">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control">
                    <label class="form-label col-form-label-sm" for="confirm_password">Confirmar Contraseña</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                </div>
                <input type="button" value="Insertar">
            </form>
        </div>
    </div>
    <footer class="ctnfooter">
        <?php
        include "../include/footer.php"; ?>
    </footer>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/js/app2.js"></script>
</body>

</html>