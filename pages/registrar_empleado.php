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
    <title>Registrar Empleado</title>
</head>

<body class="contentdash">
    <header class="ctnheader">
        <?php
        include "../include/header.php";
        ?>
    </header>

    <div class="ctnpage">
        <form action="" class="card_form row g-3" id="form_create_user">
            <div class="col-12">
                <div class="col d-grid mx-auto">
                    <h2 class="col-12 display-6 d-flex justify-content-center">
                        Registrar Nuevo Usuario
                    </h2>
                </div>
            </div>
            <div class="col-md-6 user_group_input">
                <label class="form-label col-form-label-sm required" for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control form-control-sm">
            </div>
            <div class="col-md-6 user_group_input">
                <label class="form-label col-form-label-sm" for="apellido">Apellido</label>
                <input type="text" name="apellido" id="apellido" class="form-control form-control-sm" autocomplete="off">
            </div>
            <div class="col-md-6 user_group_input">
                <label class="form-label col-form-label-sm" for="usernickname">Nombre de Usuario</label>
                <input type="text" name="usernickname" id="usernickname" class="form-control form-control-sm" autocomplete="off">
            </div>
            <div class="col-md-6 user_group_input">
                <label class="form-label col-form-label-sm" for="documento">Nro de Documento</label>
                <input type="text" name="documento" id="documento" class="form-control form-control-sm">
            </div>
            <div class="col-md-6 user_group_input">
                <label for="inputemail" class="form-label col-form-label-sm">Correo electrónico</label>
                <input type="email" class="form-control form-control-sm" id="inputemail" name="inputemail" autocomplete="off">
                <div class="invalid-feedback">
                    No puede contener espacios y debe incluir un "@"
                </div>
            </div>
            <div class="col-md-6 user_group_input">
                <label class="form-label col-form-label-sm" for="password">Definir contraseña</label>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="password" id="password" value="" autocomplete="off">
                    <div class="input-group-text" style="cursor: pointer;" id="shufle">
                        <i class='bx bx-refresh' aria-label="Generar contraseña alaeatoria" title="Generar contraseña aleatoria" id="iconshufle"></i>
                    </div>
                </div>
            </div>


            <div class="col-md-6 user_group_input">
                <label class="form-label col-form-label-sm" for="nombre_empresa">Empresa</label>
                <select class="form-select form-select-sm" name="nombre_empresa" id="select_nombre_empresa">
                    <option value=""></option>
                    <?php
                    $query =
                        $query = "SELECT * FROM empresas";
                    $stmt = $connect->prepare($query);
                    $stmt->execute();
                    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($resultados) {
                        foreach ($resultados as $resultado) {
                            $item = $resultado['id_empresa'];
                            echo "<option value='$item'>" . $resultado['nombre_empresa'] . "</option>";
                        }
                    } else {
                        echo "<option value='' selected>No hay empresas disponibles</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-6 user_group_input">
                <label class="form-label col-form-label-sm" for="sucursal">Sucursal</label>
                <select class="form-select form-select-sm" name="sucursal" id="select_sucursal">
                    <option value=""></option>
                </select>
            </div>
            <div class="col-md-6 user_group_input">
                <label class="form-label col-form-label-sm" for="caja">Caja</label>
                <select class="form-select form-select-sm" name="caja" id="select_caja">
                </select>
            </div>
            <div class="col-12">
                <div class="col-md-2 d-grid mx-auto">
                    <button type="button" id="btn_create_user" class="btn btn-dark">Registrar</button>
                </div>
            </div>
        </form>
    </div>
    <!-- Seccion Modal -->
    <!-- Modal -->
    <div class="modal fade" id="modal_verificar" tabindex="-1" aria-labelledby="modal_verificar_datos" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-2">
                    <h1 class="modal-title fs-4" id="modal_verificar_datos">Verificar los datos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6 user_group_input">
                        <label class="form-label col-form-label-sm required" for="modalnombre">Nombre</label>
                        <input type="text" name="modalnombre" id="modalnombre" class="form-control form-control-sm" autocomplete="off" disabled>
                    </div>
                    <div class="col-md-6 user_group_input">
                        <label class="form-label col-form-label-sm" for="modalapellido">Apellido</label>
                        <input type="text" name="modalapellido" id="modalapellido" class="form-control form-control-sm" autocomplete="off" disabled>
                    </div>
                    <div class="col-md-6 user_group_input">
                        <label class="form-label col-form-label-sm" for="modalnick">Nombre de Usuario</label>
                        <input type="text" name="modalnick" id="modalnick" class="form-control form-control-sm" autocomplete="off" disabled>
                    </div>
                    <div class="col-md-6 user_group_input">
                        <label class="form-label col-form-label-sm" for="modaldocumento">Nro de Documento</label>
                        <input type="text" name="modaldocumento" id="modaldocumento" class="form-control form-control-sm" autocomplete="off" disabled>
                    </div>
                    <div class="col-md-6 user_group_input">
                        <label for="modalemail" class="form-label col-form-label-sm">Correo electrónico</label>
                        <input type="text" class="form-control form-control-sm" id="modalemail" name="modalemail" autocomplete="off" disabled>
                    </div>
                    <div class="col-md-6 user_group_input">
                        <label class="form-label col-form-label-sm" for="modalpass">Definir contraseña</label>
                        <input type="text" class="form-control form-control-sm" name="modalpass" id="modalpass" value="" autocomplete="off" disabled>
                    </div>
                    <div class="col-md-6 user_group_input">
                        <label class="form-label col-form-label-sm" for="modalempresa">Empresa</label>
                        <input type="text" class="form-control form-control-sm" name="modalempresa" id="select_modalempresa" autocomplete="off" disabled>
                    </div>
                    <div class="col-md-6 user_group_input">
                        <label class="form-label col-form-label-sm" for="modalsucursal">Sucursal</label>
                        <input type="text" class="form-control form-control-sm" name="modalsucursal" id="select_modalsucursal" autocomplete="off" disabled>
                    </div>
                    <div class="col-md-6 user_group_input">
                        <label class="form-label col-form-label-sm" for="modalcaja">Caja</label>
                        <input type="text" class="form-control form-control-sm" name="modalcaja" id="select_modalcaja" autocomplete="off" disabled>
                    </div>
                </div>
                <div class="modal-footer p-1">
                    <button type="button" id="btn_insert_user" class="btn btn-success btn-sm" data-bs-dismiss="modal" aria-label="Close">¡Si!, Registrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin seccio Modal -->
    <footer class="ctnfooter">
        <?php
        include "../include/footer.php"; ?>
    </footer>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/js/crear_usuario.js"></script>
    <script src="../scripts/crear_usuario.js"></script>
</body>

</html>