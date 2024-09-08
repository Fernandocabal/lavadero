<?php
include "../functions/conexion.php";
session_start();
$nombre = $_SESSION["nombre"];
$apellido = $_SESSION["apellido"];
$id_tipo = $_SESSION["id_tipo"];

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
        <div class="ctnfact" id="targetcenter">
            <form action="" method="POST" class="row" id="formfactura">
                <?php
                include "../backend/datosfactura.php";
                ?>
                <div class="col-12 m-0 titlefact">
                    <div class="col-md-6 d-grid mx-auto">
                        <p class="col-12 display-8 d-flex justify-content-center">
                            Datos de factura
                        </p>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-around m-0 p-0 headerfact">
                    <div class="datosfactura">
                        <div class="form-label mb-0 lablefact">N° de Factura</div>
                        <div type="text" class="inputform"><?php echo $formatproximonumero ?></div>
                        <div class="form-label mb-0 lablefact">Timbrado</div>
                        <div type="date" class="inputform"><?php echo $nro_timbrado; ?></div>
                    </div>
                    <div class="datosfactura">
                        <div class="form-label mb-0 lablefact">Fecha</div>
                        <div type="date" id="fechaactual" class="inputform"></div>
                    </div>
                    <div class="datosfactura">
                        <div class="form-label mb-0 lablefact">Nombre Cliente: </div>
                        <div class="inputform">
                            <select id="nombres" name="nombres" class="form-control">
                                <option> </option>
                                <?php
                                include "../backend/selectclient.php";
                                ?>
                            </select>
                        </div>
                        <div class="form-label mb-0 lablefact">Ruc o Ci: </div>
                        <input type="text" class="inputform" id="nroci" readonly>
                    </div>
                    <div class="datosfactura">
                        <div class="form-label mb-0 lablefact">Direccion: </div>
                        <input type="text" class="inputform" id="direccion" readonly>
                        <div class="form-div mb-0 lablefact">Celular: </div>
                        <input type="text" class="inputform" id="phonenumber" readonly>
                    </div>
                    <div class="datosfactura">
                        <div class="form-label mb-0 lablefact">Correo: </div>
                        <input type="text" class="inputform" id="email" readonly>
                    </div>
                    <div class="datosfactura" style="font-size: 10px;">
                        <p class="form-label mb-0 lablefact">Condicion de venta: </p>
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
                <div class="ctnproducto d-flex align-items-center" style="height: 40px;">
                    <select id="selectservice" class="buscadorprecio form-select m-0 form-select-sm w-25">
                        <option value="" selected disabled>Selecciona una opcion</option>
                        <?php
                        include "../backend/obtener_datos_producto.php"
                        ?>
                    </select>
                    <button id="addservice" class="btn btn-sm btn-dark">Agregar</button>

                </div>
                <div class="col-12 p-0 d-flex flex-column justify-content-between body_factura">
                    <div>
                        <table id="table" class="table mb-0 table-sm table-bordered" style="font-size: 10px;">
                            <thead>
                                <tr>
                                    <th style="width: 4%;" scope="col"></th>
                                    <th scope="col">Descripcion</th>
                                    <th style="width: 10%;" scope="col">Cantidad</th>
                                    <th style="width: 10%;" scope="col">Precio Unitario</th>
                                    <th style="width: 10%;" scope="col">Descuentos</th>
                                    <th style="width: 10%;" scope="col">Exentas</th>
                                    <th style="width: 10%;" scope="col">5%</th>
                                    <th style="width: 10%;" scope="col">10%</th>
                                </tr>
                            </thead>
                            <tbody id="bodytable" class="table-group-divider">


                            </tbody>
                        </table>
                    </div>
                    <!-- seccion base de factura -->
                    <div class="d-flex flex-column gap-1  bg-body-secondary">

                        <div class="d-flex justify-content-between">
                            <div class="basederecha d-flex justify-content-center align-items-center">
                                <div>
                                    Sub Total
                                </div>
                            </div>
                            <div class="d-flex justify-content-end baseizquierda">
                                <div class="datostotal" id="subtotaltotal">0</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="basederecha d-flex justify-content-center align-items-center">
                                <div>
                                    Total de la operación
                                </div>
                            </div>
                            <div class="d-flex justify-content-end baseizquierda">
                                <div class="datostotal" id="totaloperacion">0</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="basederecha d-flex justify-content-center align-items-center">
                                <div>
                                    Total en guaraníes
                                </div>
                            </div>
                            <div class="d-flex justify-content-end baseizquierda">
                                <div class="datostotal" id="totalguaranies" name="totaloperacion">0</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="basederecha d-flex justify-content-center align-items-center">
                                <div>
                                    Liquidacion IVA
                                </div>
                            </div>
                            <div class="d-flex justify-content-between baseizquierda">
                                <div class="datosIVA">5%</div>
                                <div class="datosIVA">0</div>
                                <div class="datosIVA">10%</div>
                                <div class="datosIVA" id="iva10"></div>
                                <div class="datosIVA">Total Iva</div>
                                <div class="datostotal" id="totaliva">0</div>
                            </div>
                            <!-- SECCION OCULTA PARA ENVIAR VALORES A LA BASE DE DATOS -->
                            <input type="hidden" value="" name="totalfactura" id="totalfactura">
                            <input type="hidden" value="" name="sendiva" id="sendiva">
                        </div>
                    </div>
                </div>
                <div class="ctnbtns bg-body-secondary pt-2 pb-3">
                    <div class="btns">
                        <button type=" submit" class="btn btn-dark  btn-lg" style="width: 100%;" name="insertfactura" id="insertfactura">Imprimir</button>
                    </div>
                    <div class="btns">
                        <a href="../pages/recepcionvh.php" class="btn btn-secondary btn-lg" style="width: 100%;" name="insertclient" id="insertclient">Cancelar</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <footer class="ctnfooter">
        <?php
        include "../include/footer.php"; ?>
    </footer>
    <script src="../assets/js/factura.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../assets/js/verificarfactura.js"></script>
</body>

</html>