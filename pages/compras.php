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
    <title>Carga factura</title>
</head>
<style>
    .select2-container .select2-selection--single {
        height: 18px;
    }

    .form-select-sm~.select2-container--bootstrap-5 .select2-selection {
        font-size: 10px;
    }
</style>

<body class="contentdash">
    <header class="ctnheader">
        <?php
        include "../include/header.php";
        ?>
    </header>
    <div class="ctnpage">
        <div class="ctnfact" id="targetcenter">
            <form id="formcompras" class="row" style="width: 99%;">
                <div class="col-12 m-0 titlefact">
                    <div class="col-md-6 d-grid mx-auto">
                        <p class="col-12 display-8 d-flex justify-content-center">
                            Registrar Factura Compra
                        </p>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-around m-0 p-0 headerfact">
                    <div class="datosfactura">
                        <label class="form-label mb-0 lablefact" for="fechafactura">Fecha factura</label>
                        <input type="text" class="form-control form-control-sm inputform" name="fechafactura" id="fechafactura">
                        <script>
                            function formatDateToDDMMYY(date) {
                                const day = String(date.getDate()).padStart(2, '0');
                                const month = String(date.getMonth() + 1).padStart(2, '0');
                                const year = String(date.getFullYear());

                                return `${day}/${month}/${year}`;
                            }

                            function setTodayDate() {
                                const today = new Date();
                                const formattedDate = formatDateToDDMMYY(today);
                                document.getElementById('fechafactura').value = formattedDate;
                            }

                            setTodayDate();
                        </script>

                        <div class="inputform">
                            <label class="form-label mb-0 lablefact" for="idproveedor">Proveedor</label>
                            <select class="form-select form-select-sm" name="idproveedor" id="idproveedor">
                                <option> </option>
                                <?php
                                include "../backend/selectproveedor.php";
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="datosfactura">
                        <label class="form-label mb-0 lablefact" for="timbrado">Timbrado</label>
                        <input type="text" id="timbrado" name="timbrado" class="form-control form-control-sm inputform">
                        <label class="form-label mb-0 lablefact" for="rucproveedor">R.U.C Proveedor</label>
                        <input type="text" class="form-control form-control-sm inputform" name="rucproveedor" id="rucproveedor" readonly>
                    </div>
                    <div class="datosfactura">
                        <label class="form-label mb-0 lablefact" for="nrofactura">Numero de factura</label>
                        <input type="text" class="form-control form-control-sm inputform" name="nrofactura" id="nrofactura" maxlength="15" value="001-001-0000001">
                        <label class="form-label mb-0 lablefact" for="typedoc">Tipo de documento</label>
                        <select class="form-select form-select-sm inputform" name="typedoc" id="typedoc">

                            <?php
                            include "../backend/selectcondicion.php";
                            ?>
                        </select>
                    </div>
                    <div class="datosfactura">
                        <label class="form-label mb-0 lablefact" for="conceptodecompra">Concepto de compra</label>
                        <input type="text" class="form-control form-control-sm inputform" name="conceptodecompra" id="conceptodecompra">

                        <label class="form-label mb-0 lablefact" for="typedoc">Tipo de factura</label>
                        <select class="form-select form-select-sm inputform" name="tipo_factura" id="tipo_factura">

                            <?php
                            include "../backend/selectypefactura.php";
                            ?>
                        </select>
                    </div>
                    <div class="datosfactura">
                        <label class="form-label mb-0 lablefact" for="origen">Origen de fondos</label>
                        <select class="form-select form-select-sm inputform" name="typeorigen" id="origen">
                            <option value="1">Caja chica</option>
                            <option value="2">Transferencia Bancaria</option>
                        </select>
                    </div>
                    <div class="datosfactura">
                        <label class="form-label mb-0 lablefact" for="moneda">Moneda</label>
                        <select class="form-select form-select-sm inputform" name="typemodena" id="moneda">
                            <option value="1">Guaraníes</option>
                        </select>
                    </div>
                </div>
                <div class="ctnproducto d-flex align-items-center" style="height: 40px;"></div>
                <div class="col-12 p-0 d-flex flex-column justify-content-between body_factura">
                    <div>
                        <table id="table" class="table mb-0 table-sm table-bordered" style="font-size: 10px;">
                            <thead>
                                <tr>
                                    <th style=" width: 4%;" scope="col">
                                    </th>
                                    <th scope="col">Descripcion</th>
                                    <th style="width: 10%;" scope="col">Cantidad</th>
                                    <th style="width: 10%;" scope="col">Precio Unitario</th>
                                    <th style="width: 10%;" scope="col">Descuentos</th>
                                    <th style="width: 10%;" scope="col">Tipo de IVA</th>
                                    <th style="width: 10%;" scope="col">Excento</th>
                                    <th style="width: 10%;" scope="col">5%</th>
                                    <th style="width: 10%;" scope="col">10%</th>
                                </tr>
                            </thead>
                            <tbody id="bodytable" class="table-group-divider">
                                <tr>
                                    <td>
                                    </td>
                                    <td><input type="text" name="descripcion[]" id="descripcion" class="inputbody"></td>
                                    <td><input type="number" name="cantidad[]" id="cantidad" class="inputbody cantidad" value="1"></td>
                                    <td><input type="text" name="precio_unit[]" id="precio" class="inputbody precio"></td>
                                    <td><input type="text" class="inputbody" readonly="" name="descuentos[]" value="0"></td>
                                    <td>
                                        <select class="inputbody tipo_iva" readonly="" name="tipo_iva[]" value="0">
                                            <option value="1">I.V.A 5%</option>
                                            <option value="2" selected>I.V.A 10%</option>
                                            <option value="3">EXCENTO</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="inputbody exenta" readonly="" name="exenta[]" value="0"></td>
                                    <td><input type="text" class="inputbody gravada5" name="gravada5[]" readonly="" value="0"></td>
                                    <td><input type="text" class="inputbody gravada10" name="gravada10[]" readonly="" value="0"></td>
                                </tr>
                            </tbody>

                        </table>
                        <i class="bx bx-plus m-0 btn btn-dark btn-sm" id="btnplus" style="height: 25px; font-size:10px"></i>
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
                                <div class="datosIVA" id="iva5">0</div>
                                <div class="datosIVA">10%</div>
                                <div class="datosIVA" id="iva10"></div>
                                <div class="datosIVA">Total Iva</div>
                                <div class="datostotal" id="totaliva">0</div>
                            </div>
                            <!-- SECCION OCULTA PARA ENVIAR VALORES A LA BASE DE DATOS -->
                            <!-- <input type="hidden" value="" name="totalfactura" id="totalfactura">
                            <input type="hidden" value="" name="sendiva" id="sendiva"> -->
                        </div>
                    </div>


                </div>

                <div class="ctnbtns bg-body-secondary">
                    <div class="btns">
                        <button type="submit" class="btn btn-dark  btn-lg" style="width: 100%;" name="insertcompra" id="insertcompra">Guardar</button>
                    </div>
                    <div class="btns">
                        <a href="../pages/dashboard.php" class="btn btn-secondary btn-lg" style="width: 100%;" name="insertclient" id="insertclient">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <footer class="ctnfooter">
        <?php
        include "../include/footer.php"; ?>
    </footer>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../scripts/compras.js"></script>
    <script src="../assets/js/compras.js"></script>
</body>

</html>