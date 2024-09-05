<?php
include "../connet/conexion.php";
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
    <link rel="stylesheet" href="../css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../node_modules/select2/css/select2.min.css" rel="stylesheet" />
    <script src="../node_modules/select2/js/select2.min.js"></script>
    <script src="../node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="icon" href="../img/Logo.png">
    <title>Carga factura</title>
</head>

<body class="contentdash">
    <header class="ctnheader">
        <?php
        include "../componentes/header.php";
        ?>
    </header>
    <div class="ctnpage">
        <form class="ctncompras">
            <div class="col-12 m-0 titlefact">
                <div class="col-md-6 d-grid mx-auto">
                    <p class="col-12 display-8 d-flex justify-content-center">
                        Datos de factura
                    </p>
                </div>
            </div>
            <div class="headercompras">
                <div class="groupfacturas">
                    <label for="fechafactura">Fecha factura</label>
                    <input type="text" class="inputbody" id="fechafactura">
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
                    <label for="proveedor">R.U.C Proveedor</label>
                    <input type="text" class="inputbody" id="proveedor">
                    <label for="timbrado">Timbrado</label>
                    <input type="text" id="timbrado" class="inputbody">
                </div>
                <div class="groupfacturas">
                    <label for="nombreproveedor">Nombre de proveedor</label>
                    <input type="text" class="inputbody" id="nombreproveedor">
                    <label for="nrofactura">Numero de factura</label>
                    <input type="text" class="inputbody" id="nrofactura" maxlength="15" value="001-001-0000001">
                    <label for="typedoc">Tipo de documento</label>
                    <select class="form-select form-select-sm" name="typedoc" id="typedoc">
                        <option value="">Contado</option>
                        <option value="">Credito</option>
                        <option value="">Nota de credito</option>
                    </select>
                </div>
                <div class="groupfacturas">
                    <label for="conceptodecompra">Concepto de compra</label>
                    <input type="text" class="inputbody" id="conceptodecompra">
                    <label for="moneda">Moneda</label>
                    <select class="form-select form-select-sm" name="typedoc" id="moneda">
                        <option value="1">Guaraníes</option>
                    </select>
                    <label for="origen">Origen del pago</label>
                    <select class="form-select form-select-sm" name="typedoc" id="origen">
                        <option value="1">Caja chica</option>
                        <option value="2">Transferencia Bancaria</option>
                    </select>
                </div>
            </div>
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
                                <th style="width: 10%;" scope="col">Exentas</th>
                                <th style="width: 10%;" scope="col">5%</th>
                                <th style="width: 10%;" scope="col">10%</th>
                            </tr>
                        </thead>
                        <tbody id="bodytable" class="table-group-divider">
                            <tr>
                                <td><i class="bx bx-trash btn btn-danger btn-sm" style="height: 25px; font-size:10px"></i></td>
                                <td><input type="text" name="" id="" class="inputbody"></td>
                                <td><input type="number" name="" id="" class="inputbody"></td>
                                <td><input type="text" name="" id="" class="inputbody"></td>
                                <td><input type="text" class="inputbody" readonly=""></td>
                                <td><input type="text" class="inputbody" readonly=""></td>
                                <td><input type="text" class="inputbody" readonly=""></td>
                                <td><input type="text" class="inputbody subtotal" readonly=""></td>
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

            <div class="ctnbtns bg-body-secondary">
                <div class="btns">
                    <button type="submit" class="btn btn-dark  btn-lg" style="width: 100%;" name="insertfactura" id="insertfactura">Guardar</button>
                </div>
                <div class="btns">
                    <a href="../pages/dashboard.php" class="btn btn-secondary btn-lg" style="width: 100%;" name="insertclient" id="insertclient">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
    <footer class="ctnfooter">
        <?php
        include "../componentes/footer.php"; ?>
    </footer>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>