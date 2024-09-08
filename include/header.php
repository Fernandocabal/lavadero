<?php
// session_start();
require_once '../functions/funciones.php';

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
        <a href="../pages/dashboard.php" class="offcanvas-title" id="offcanvasExampleLabel" style="text-decoration: none;font-size: xx-large;">CarWash Lavadero</a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Menu Acciones
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <a href="../pages/recepcionvh.php" class="sidebarop">Recepción de Vehiculos</a>
                        <a href="../pages/factura.php" class="sidebarop">Facturación</a>
                        <a href="../pages/registrar_clientes.php" class="sidebarop">Registrar Clientes</a>
                    </div>
                </div>
            </div>

            <?php
            if ($id_tipo < 2 and $id_tipo > 0) {
                echo "
             <div class='accordion-item'>
                <h2 class='accordion-header'>
                    <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapseThree' aria-expanded='false' aria-controls='collapseThree'>
                        Administrativo
                    </button>
                </h2>
                <div id='collapseThree' class='accordion-collapse collapse' data-bs-parent='#accordionExample'>
                    <div class='accordion-body'>
                    <a href='../pages/compras.php' class='sidebarop'>Cargar facturas Compras</a>
                    <a href='../pages/registrar_empleado.php' class='sidebarop'>Cargar facturas Ventas</a>
                        <a href='../pages/registrar_empleado.php' class='sidebarop'>Registrar Nuevo Empleado</a>    
                    </div>
                </div>
            </div>";
            }
            ?>
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
            <a class="sign-out" href="../backend/cerrar_sesion.php" id="sign-out">
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