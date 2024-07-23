<?php ?>
<a class="hambur" data-bs-toggle="offcanvas" href="#sidebar" role="button" aria-controls="sidebar">
    <i class='bx bx-menu' id="hamburicon"></i>
</a>
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header" style="border-bottom: 1px solid black;">
        <a href="../pages/dashboard.php" class="offcanvas-title" id="offcanvasExampleLabel" style="text-decoration: none;font-size: xx-large;">CarWash Lavadero</a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column">
        <a href="../pages/recepcionvh.php" class="sidebarop">Recepción de Vehiculos</a>
        <a href="../pages/factura.php" class="sidebarop">Facturación</a>
        <a href="../pages/registrar_clientes.php" class="sidebarop">Registrar Clientes</a>
        <?php
        if ($id_tipo < 2 and $id_tipo > 0) {
            echo "<a href='../pages/registrar_empleado.php' class='sidebarop'>Registrar Nuevo Empleado</a>";
        }
        ?>
    </div>
</div>
<div class="perfil">
    <i class='bx bxs-user user'></i>
    <p class="perfil-nombre"><?php echo $nombre . " " . $apellido; ?></p>
    <!--Sección dropdown-->
    <div class="btndrop" class="btndrop" onclick="dropmenu()"><i class='bx bx-chevrons-down icondrop' id="icondrop"></i></div>
    <div class="boxdrop" id="boxdrop">
        <div class="dropmenu" id="dropmenu">
            <a class="sign-out" href="../action/cerrar_sesion.php" id="sign-out">
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