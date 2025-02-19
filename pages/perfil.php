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
        <link href="../node_modules/select2/css/select2-bootstrap-5-theme.css" rel="stylesheet">
        <link rel="icon" href="../assets/img/logo.png">
        <title>Perfil</title>
    </head>

    <body class="contentdash">
        <header class="ctnheader">
            <?php
            include "../include/header.php";
            ?>
        </header>
        <div class="ctnpage">
            <div class="perfil_ctn">
                <div class="perfil_box_group mt-4">
                    <div class="perfil_box d-flex flex-column align-items-center">
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
                        <form action="" class="container container-fluid" id="form_change_empresa">
                            <label class="form-label" for="nombre_empresa">Empresa</label>
                            <select class="form-select form-select-sm" name="nombre_empresa" id="select_nombre_empresa">
                                <?php
                                $query = "SELECT * 
                                        FROM empresas e
                                        LEFT JOIN empresa_activa ea ON e.id_empresa = ea.id_empresa 
                                        WHERE ea.usuario = :usuario";
                                $stmt = $connect->prepare($query);
                                $stmt->bindParam(':usuario', $usernickname, PDO::PARAM_STR);
                                $stmt->execute();
                                $empresa_activa = $stmt->fetch(PDO::FETCH_ASSOC);

                                $query = "SELECT * FROM empresas";
                                $stmt = $connect->prepare($query);
                                $stmt->execute();
                                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                if ($resultados) {
                                    foreach ($resultados as $resultado) {
                                        $item = $resultado['id_empresa'];
                                        if ($empresa_activa && $empresa_activa['id_empresa'] === $item) {
                                            echo "<option value='$item' selected>" . $resultado['nombre_empresa'] . "</option>";
                                        } else {
                                            echo "<option value='$item'>" . $resultado['nombre_empresa'] . "</option>";
                                        }
                                    }
                                } else {
                                    echo "<option value='' selected>No hay empresas disponibles</option>";
                                }
                                ?>

                            </select>
                            <label class="form-label" for="sucursal">Sucursal</label>
                            <select class="form-select form-select-sm" name="sucursal" id="select_sucursal">
                                <?php
                                $query = "SELECT * FROM sucursales s INNER JOIN empresa_activa ea ON ea.sucursal= s.id_sucursal
                                 WHERE ea.usuario = :usuario";
                                $stmt = $connect->prepare($query);
                                $stmt->bindParam(':usuario', $usernickname, PDO::PARAM_STR);
                                $stmt->execute();
                                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if ($resultados && count($resultados) > 0) {
                                    foreach ($resultados as $resultado) {
                                        echo "<option value='" . $resultado['id_sucursal'] . "'>" . $resultado['prefijo'] . " - " . $resultado['nombre'] . "</option>";
                                    }
                                } else {
                                    echo "<option value='' selected>No hay empresas disponibles</option>";
                                }
                                ?>
                            </select>
                            <label class="form-label" for="caja">Caja</label>
                            <select class="form-select form-select-sm" name="caja" id="select_caja">
                                <?php
                                $query = "SELECT caja 
                                            FROM empresa_activa 
                                             WHERE usuario = :usuario";
                                $stmt = $connect->prepare($query);
                                $stmt->bindParam(':usuario', $usernickname, PDO::PARAM_STR);
                                $stmt->execute();
                                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if ($resultados && count($resultados) > 0) {
                                    foreach ($resultados as $resultado) {
                                        echo "<option value='" . htmlspecialchars($resultado['caja']) . "'>" . htmlspecialchars($resultado['caja']) . "</option>";
                                    }
                                } else {
                                    echo "<option value='' selected>No hay empresas disponibles</option>";
                                }

                                ?>
                            </select>
                            <div class="d-flex flex-column">
                                <h7 class="m-0 text-danger mensaje_error_password" id="mensaje_error_password"></h7>
                                <input type="submit" id="btn_change_empresa" value="Guardar" class="col-3 btn btn-dark btn-sm">
                            </div>

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
        <script src="../scripts/perfil.js"></script>
    </body>

    </html>