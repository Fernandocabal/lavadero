<?php
include "../connet/conexion.php";
session_start();
$nombre = $_SESSION["nombre"];
$apellido = $_SESSION["apellido"];
$id_tipo = $_SESSION["id_tipo"];
if (empty($_SESSION["nombre"]) and empty($_SESSION["apellido"])) {
    header("location:../index.php");
}
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
    <title>Facturación</title>
</head>

<body class="contentdash">
    <header class="ctnheader">
        <?php
        include "../componetes/header.php";
        ?>
    </header>
    <div class="ctnpage">
        <div class="ctnfact" id="targetcenter">
            <form action="" method="post" class="row" id="formfactura">
                <?php
                include "../action/insertfactura.php";
                ?>
                <div class="col-12 m-0 titlefact">
                    <div class="col-md-6 d-grid mx-auto">
                        <p class="col-12 display-10 d-flex justify-content-center">
                            Datos de factura
                        </p>
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-around m-0 mb-3 p-0 headerfact">
                    <div class="datosfactura">
                        <div class="form-label mb-0 lablefact">N° de Factura</div>
                        <div type="text" class="inputform"><?php include "../componetes/viewnrofactura.php"; ?></div>
                        <div class="form-label mb-0 lablefact">Timbrado</div>
                        <div type="date" class="inputform"><?php echo $nro_timbrado; ?></div>
                    </div>
                    <div class="datosfactura">
                        <div class="form-label mb-0 lablefact">Fecha</div>
                        <div type="date" id="fechaactual" class="inputform"></div>
                    </div>
                    <div class="datosfactura">
                        <div class="form-label mb-0 lablefact">Nombre Cliente: </div>
                        <select type="text" id="nombres" name="nombres" class="form-select">
                            <option> </option>
                            <?php
                            include "../action/selectclient.php";
                            ?>
                        </select>
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
                    <div class="datosfactura">
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
                <div class="col-12 mb-3 d-flex flex-column justify-content-between" style="border: 1px solid red; height:500px; font-size:10px;">
                    <div>
                        <table class="table mb-0 table-sm table-striped table-hover table-bordered" style="font-size: 10px;">
                            <thead>
                                <tr>
                                    <th style="width: 10%;" scope="col">Cantidad</th>
                                    <th scope="col">Descripcion</th>
                                    <th style="width: 10%;" scope="col">Precio Unitario</th>
                                    <th style="width: 10%;" scope="col">Descuentos</th>
                                    <th style="width: 10%;" scope="col">Exentas</th>
                                    <th style="width: 10%;" scope="col">5%</th>
                                    <th style="width: 10%;" scope="col">10%</th>
                                </tr>
                            </thead>
                            <tbody id="bodytable" class="table-group-divider">
                                <tr>
                                    <td><input type="text" name="cantidad[]" value="1" class="inputform"> </td>
                                    <td><input type="text" name="descripcion[]" class="inputform"></td>
                                    <td><input type="text" id="precio" name="precio[]" class="inputform precio"></td>
                                    <td><input type="text" class="inputform"></td>
                                    <td><input type="text" class="inputform"></td>
                                    <td><input type="text" class="inputform"></td>
                                    <td>
                                        <input class="inputform subtotal" readonly>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div id="btnaddrows" class="btn btn-sm m-0 p-0 btn-dark" style="width: 25px;">+</div>
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
                                <div class="datostotal" id="totaloperacion">El total Obvio</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="basederecha d-flex justify-content-center align-items-center">
                                <div>
                                    Total en guaraníes
                                </div>
                            </div>
                            <div class="d-flex justify-content-end baseizquierda">
                                <div class="datostotal" id="totalguaranies" name="totaloperacion">El total Obvio</div>
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
                                <input class="datosIVA" id="iva10" value="0">
                                <div class="datosIVA">Total Iva</div>
                                <div class="datostotal" id="totaliva">El total Obvio</div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-6 d-grid">
                    <div class="col-md-6 mx-auto ctnbtns">
                        <button type="submit" class="btn btn-dark  btn-lg" style="width: 100%;" name="insertfactura" id="insertfactura">Imprimir</button>
                    </div>
                </div>
                <div class="col-md-6 d-grid">
                    <div class="col-md-6 d-grid mx-auto ctnbtns">
                        <a href="../pages/recepcionvh.php" class="btn btn-secondary btn-lg" style="width: 100%;" name="insertclient" id="insertclient">Cancelar</a>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <footer class="ctnfooter">
        <?php
        include "../componetes/footer.php"; ?>
    </footer>

    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {

            $(document).ready(function() {
                var tbody = $('#bodytable');
                var button = $('#btnaddrows');

                button.click(function() {
                    var newRow = tbody.find('tr').first().clone();
                    newRow.find('input').val(''); // Limpia los valores de los inputs
                    tbody.append(newRow);
                });
            });

            $('#nombres').select2({
                placeholder: "Busca por nombre o CI",
            });
            $('#nombres').on('select2:select', function(e) {
                let data = e.params.data;
                $.ajax({
                    type: 'POST',
                    url: '../componetes/obtener_datos_cliente.php',
                    data: {
                        id: data['id']
                    },
                    success: function(response) {
                        if (response) {
                            let responseobjet = JSON.parse(response)
                            $('#nroci').val(responseobjet.nroci);
                            $('#direccion').val(responseobjet.direccion);
                            $('#phonenumber').val(responseobjet.phonenumber);
                            $('#email').val(responseobjet.email);
                        } else {
                            console.error("Respuesta del servidor inválida:", response);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error fetching client data:", textStatus, errorThrown);
                    }
                });
            });
        });
    </script>
    <script>
        let subtotalTotal = document.getElementById('subtotaltotal'),
            totaloperacion = document.getElementById('totaloperacion'),
            totalguaranies = document.getElementById('totalguaranies'),
            iva10 = document.getElementById('iva10'),
            totaliva = document.getElementById('totaliva'),
            subt = '';

        function calcularTotal() {
            let subtotales = document.querySelectorAll('.subtotal'); // Actualizar la lista cada vez
            let total = 0;

            subtotales.forEach(element => {
                total += parseFloat(element.value);
            });

            subtotalTotal.textContent = total;
            totaloperacion.textContent = total;
            totalguaranies.textContent = total;

        }

        function calculariva() {
            let valor = totalguaranies.textContent;
            const intvalor = parseInt(valor);
            const iva = intvalor * 0.1;
            totaliva.textContent = parseInt(iva);
            iva10.value = parseInt(iva);
            // console.log(iva)
        }

        // Delegar el evento a un elemento padre común
        document.querySelector('tbody').addEventListener('keyup', (event) => {
            if (event.target.classList.contains('precio')) {
                const valor = event.target.value;
                const subtotal = event.target.closest('tr').querySelector('.subtotal');
                if (subtotal) {
                    subtotal.value = valor;

                }

                calcularTotal();
                calculariva();

            }

            // let contar = inputsubtotal.length;

            // for (let i = 0; i < contar; i++) {
            //     const element = inputsubtotal[i];
            //     const valor = element.value;
            //     const valorint = parseInt(valor);
            //     subt += valorint;
            //     subtotal.textContent = subt;

            // }
        });
    </script>
    <script src="../js/verificarfactura.js"></script>
</body>

</html>