<?php ?>
<div class="ctnpage">
    <!--Sección lateral-->
    <div class="lateral" id="left">
        <a href="http://" class="lateral-opciones">Recepcion de Vehiculos</a>
        <a href="http://" class="lateral-opciones">Lista de espera</a>
        <a href="http://" class="lateral-opciones">Facturación</a>
        <a href="../pages/registrar_usuario.php" class="lateral-opciones">Registrar Clientes</a>
        <div class="footer-lateral" id="footerleft">
            <div class="ocultar" id="ocultar">
                <i class='bx bx-chevrons-left' id="iconrow"></i>
            </div>
        </div>
    </div>
    <!--Fin Sección lateral-->
    <!--Sección centro-->
    <div class="centro" id="targetcenter" style="overflow: auto">
        <?php
        if ($id_tipo > 1) {
            include "../componetes/menu_datos.php";
            include "../componetes/menu_datos.php";
            include "../componetes/menu_datos.php";
            include "../componetes/menu_datos.php";
            include "../componetes/menu_datos.php";
            include "../componetes/menu_datos.php";
            include "../componetes/menu_datos.php";
        } else {
            echo "Hola " . $nombre . " eres admin y tienes el nivel " . $id_tipo;
        }
        ?>
    </div>
    <!--Fin Sección centro-->
</div>
<!--Sección contenedor-->