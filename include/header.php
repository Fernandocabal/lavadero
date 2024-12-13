<?php
session_start();
require_once '../functions/funciones.php';
$nombre = $_SESSION["nombre"];
$apellido = $_SESSION["apellido"];
$usernickname = $_SESSION["nombre_usuario"];
$query = "SELECT * FROM empresa_activa ea
    INNER JOIN empresas e ON ea.id_empresa = e.id_empresa 
    WHERE ea.usuario = :usuario";
$stmt = $connect->prepare($query);
$stmt->bindParam(':usuario', $usernickname, PDO::PARAM_STR);
$stmt->execute();
$empresa_activa = $stmt->fetch(PDO::FETCH_ASSOC);
if ($empresa_activa) {
    $id_empresa = $empresa_activa['id_empresa_activa'];
    $nombre_empresa = $empresa_activa['nombre_empresa'];
    $ruc_empresa = $empresa_activa['ruc_empresa'];
}
if (!estalogueado()) {
    session_unset();
    session_destroy();
    header("location:../index.php");
    exit();
}
?>
<a class="hambur" data-bs-toggle="offcanvas" href="#sidebar" role="button" aria-controls="sidebar">
    <i class='bx bx-menu' id="hamburicon"></i>
</a>
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header" style="border-bottom: 1px solid black;">
        <a href="../pages/dashboard.php" class="offcanvas-title" id="offcanvasExampleLabel" style="text-decoration: none;font-size: xx-large;">
            <?php
            echo $nombre_empresa;
            ?>
        </a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#item1" aria-expanded="false" aria-controls="item1">
                        Menu Acciones
                    </button>
                </h2>
                <div id="item1" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <a href="../pages/recepcionvh.php" class="sidebarop">1 - Recepción de Vehiculos</a>
                        <a href="../pages/factura.php" class="sidebarop">2 - Facturación</a>
                        <a href="../pages/registrar_clientes.php" class="sidebarop">3 - Registrar Clientes</a>
                    </div>
                </div>
            </div>
            <div class='accordion-item'>
                <h2 class='accordion-header'>
                    <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#item2' aria-expanded='false' aria-controls='item2'>
                        Administrativo
                    </button>
                </h2>
                <div id='item2' class='accordion-collapse collapse' data-bs-parent='#accordionExample'>
                    <div class='accordion-body'>
                        <?php
                        $query = "SELECT * FROM `permisos_usuarios` WHERE usuario = :usuario";
                        $stmt = $connect->prepare($query);
                        $stmt->bindParam(':usuario', $usernickname, PDO::PARAM_STR);
                        $stmt->execute();
                        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        if ($resultados) {
                            foreach ($resultados as $resultado) {
                                $item = $resultado['item'];
                                if ($item === 'menu_administrativo') {
                                    echo "
                    <a href='../pages/compras.php' class='sidebarop'>1 - Cargar facturas Compras</a>
                    <a href='../pages/registrar_empleado.php' class='sidebarop'>2 - Cargar facturas Ventas</a>
                    <a href='../pages/registrar_proveedor.php' class='sidebarop'>3 - Registrar Proveedor</a> 
                    <a href='../pages/registrar_empleado.php' class='sidebarop'>4 - Registrar Nuevo Empleado</a>";
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#item3" aria-expanded="false" aria-controls="item3">
                        Reportes
                    </button>
                </h2>
                <div id="item3" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <a href="../pages/reportes_compras.php" class="sidebarop">1 - Compras Registradas</a>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<div class="perfil">

    <i class='bx bxs-user user'></i>
    <p class="perfil-nombre"><?php echo $nombre . " " . $apellido; ?></p>
    <!--Sección dropdown-->
    <div class="btndrop" class="btndrop" onclick="dropmenu()"><i class='bx bx-chevrons-down icondrop' id="icondrop"></i></div>
    <div class="boxdrop" id="boxdrop">
        <div class="dropmenu" id="dropmenu">
            <a class="drop_menu_option" href="../pages/perfil.php" id="sign-out">
                <i class="bx bx-user" id="iconout"></i>
                <div class="">Perfil</div>
            </a>
            <a class="drop_menu_option" href="../backend/cerrar_sesion.php" id="sign-out">
                <i class="bx bx-exit" id="iconout"></i>
                <div class="">Cerrar Sesión</div>
            </a>
        </div>
    </div>
    <script>
        let
            btndrop = document.getElementById('btndrop'),
            icondrop = document.getElementById('icondrop'),
            boxdrop = document.getElementById('boxdrop');

        function dropmenu() {
            boxdrop.classList.toggle('active');
            icondrop.classList.toggle('active');
        }
    </script>
    <!--Fin Sección dropdown-->
</div>