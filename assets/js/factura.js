let subtotalTotal = document.getElementById('subtotaltotal'),
    totaloperacion = document.getElementById('totaloperacion'),
    totalguaranies = document.getElementById('totalguaranies'),
    totalfactura = document.getElementById('totalfactura'),
    sendiva = document.getElementById('sendiva'),
    iva5 = document.getElementById('iva5'),
    iva10 = document.getElementById('iva10'),
    totaliva = document.getElementById('totaliva'),
    btnaddservice = document.getElementById('addservice'),
    nrofactura = document.getElementById('nro_factura'),
    timbrado = document.getElementById('nrotimbrado'),
    fecha_inicio = document.getElementById('fecha_inicio'),
    fecha_vencimiento = document.getElementById('fecha_vencimiento'),
    subt = '';
//Seccion para depurar los datos en el 
//Modal de añadir timbrado y numeracion
//funcion para no permitir letras en el numero de timbrado
function limpiarYValidarCampo(campo, minLength, maxLength) {
    let value = campo.value.replace(/[^0-9]/g, '');

    if (value.length > maxLength) {
        value = value.slice(0, maxLength);
    }

    campo.value = value;
    if (value.length >= minLength) {
        campo.classList.remove('is-invalid');
        campo.classList.add('is-valid');
        btn_insert_timbrado.disabled = false;
        return true;
    } else {
        campo.classList.remove('is-valid');
        campo.classList.add('is-invalid');
        btn_insert_timbrado.disabled = true;
        return false;
    }
}

timbrado.addEventListener('input', () => {
    limpiarYValidarCampo(timbrado, 7, 7);
});

fecha_vencimiento.addEventListener('blur', function () {
    const hoy = new Date();
    const fechaHoy = hoy.toISOString().split('T')[0];
    const fechaIngresada = fecha_vencimiento.value;
    if (fechaIngresada < fechaHoy) {
        fecha_vencimiento.value = fechaHoy;
    }
})

nrofactura.addEventListener('input', function () {
    let value = this.value.replace(/[^0-9-]/g, '');
    if (value.length > 3 && value.charAt(3) !== '-') {
        value = value.slice(0, 3) + '-' + value.slice(3);
    }
    if (value.length > 7 && value.charAt(7) !== '-') {
        value = value.slice(0, 7) + '-' + value.slice(7);
    }
    if (value.length > 15) {
        value = value.slice(0, 15);
    }
    this.value = value;
});

//Fin seccion modal y depuración

function calcularTotal() {
    let gravada5 = document.querySelectorAll('.gravada5'),
        gravada10 = document.querySelectorAll('.gravada10'),
        totalexentas = document.querySelectorAll('.exenta');
    let totalgravada5 = 0;
    let totalgravada10 = 0;
    let totalexentasValue = 0;

    for (const gravada of gravada5) {
        totalgravada5 += parseFloat(gravada.value) || 0;
    }
    for (const gravada of gravada10) {
        totalgravada10 += parseFloat(gravada.value) || 0;
    }
    for (const exenta of totalexentas) {
        totalexentasValue += parseFloat(exenta.value) || 0;
    }
    subtotalTotal.textContent = totalexentasValue + totalgravada5 + totalgravada10;
    totaloperacion.textContent = totalexentasValue + totalgravada5 + totalgravada10;
    totalguaranies.textContent = totalexentasValue + totalgravada5 + totalgravada10;
    // totalfactura.value = total;

}

function calculariva() {
    let gravada5 = document.querySelectorAll('.gravada5'),
        gravada10 = document.querySelectorAll('.gravada10');
    let totalgravada5 = 0;
    let totalgravada10 = 0;
    for (const gravada of gravada5) {
        totalgravada5 += parseFloat(gravada.value) || 0;
    }
    for (const gravada of gravada10) {
        totalgravada10 += parseFloat(gravada.value) || 0;
    }
    const cincoporciento = Math.round(totalgravada5 / 21);
    const diezporciento = Math.round(totalgravada10 / 11);
    totaliva.textContent = cincoporciento + diezporciento;
    iva5.textContent = cincoporciento;
    iva10.textContent = diezporciento;
    // sendiva.value = ivaredondeado;
}
//Boton para añadir el servicio a la factura
btnaddservice.addEventListener('click', (e) => {
    e.preventDefault();
    const table = document.getElementById('table');
    const tableBody = table.querySelector('tbody');
    const filas = tableBody.querySelectorAll('tr');

    if (filas.length >= 10) {
        Swal.fire({
            title: '¡Atención!',
            text: 'Solo se admiten 10 elementos por factura.',
            icon: 'warning',
            confirmButtonColor: "#212529",
            confirmButtonText: 'Aceptar',
            customClass: {
                popup: 'custom-swal'
            },
        });
        return;
    } else if (selectservice.value == 0) {
        selectservice.focus();
    } else {
        const valueselect = document.getElementById('selectservice').value;
        fetch('../backend/datos_productos.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'idproducto': valueselect
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la solicitud: ' + response.statusText);
                }
                return response.json();
            })

            .then(producto => {
                // Verificar si el producto ya está en la tabla
                if (esProductoRepetido(producto.id_productos)) {
                    Swal.fire({
                        title: '¡Evite duplicados!',
                        text: 'Este producto ya está incluida en la factura',
                        icon: 'warning',
                        confirmButtonColor: "#212529",
                        confirmButtonText: 'Aceptar',
                        customClass: {
                            popup: 'custom-swal'
                        },
                    });
                    return;
                }
                crearFilaTabla(producto);
                calcularTotal();
                calculariva();
            })
            .catch(error => {
                console.error('Error al realizar la solicitud:', error);
            });

        function esProductoRepetido(idProducto) {
            const table = document.getElementById('table');
            const tableBody = table.querySelector('tbody');
            const filas = tableBody.querySelectorAll('tr');
            for (const fila of filas) {
                const idElemento = fila.dataset.id;
                if (idElemento == idProducto) {
                    return true; // Producto repetido
                }
            }
            return false; // Producto no repetido
        }

        function crearFilaTabla(producto) {


            const table = document.getElementById('table');
            const tableBody = table.querySelector('tbody');

            const newRow = document.createElement('tr');
            newRow.dataset.id = producto.id_productos;

            const columnicondelete = document.createElement('td');
            const icondelete = document.createElement('i');
            icondelete.name = 'icondelete[]';
            icondelete.classList = 'bx bx-trash btn btn-danger btn-sm';
            icondelete.readOnly = true;
            icondelete.style = 'height: 25px; font-size:10px';
            columnicondelete.appendChild(icondelete);

            const columndescripcion = document.createElement('td');
            const descripcion = document.createElement('input');
            descripcion.type = 'text';
            descripcion.value = producto.producto || "No se encontró descripción";
            descripcion.name = 'descripcion[]';
            descripcion.classList = 'inputbody';
            descripcion.readOnly = true;
            columndescripcion.appendChild(descripcion);

            const columncantidad = document.createElement('td');
            const cantidad = document.createElement('input');
            cantidad.type = 'number';
            cantidad.value = 1;
            cantidad.name = 'cantidad[]';
            cantidad.classList = 'inputbody cantidad'
            columncantidad.appendChild(cantidad);

            const columnutiraio = document.createElement('td');
            const preciounit = document.createElement('input');
            preciounit.type = 'text';
            preciounit.value = producto.precio;
            preciounit.name = 'precio[]';
            preciounit.classList = 'inputbody precio';
            preciounit.readOnly = true;
            columnutiraio.appendChild(preciounit);

            const columndescuento = document.createElement('td');
            const descuento = document.createElement('input');
            descuento.type = 'text';
            descuento.value = '0';
            descuento.classList = 'inputbody descuentos';
            descuento.name = 'descuento[]';
            descuento.readOnly = true;
            columndescuento.appendChild(descuento);

            const columnexentas = document.createElement('td');
            const exentas = document.createElement('input');
            exentas.type = 'text';
            exentas.value = '0';
            exentas.classList = 'inputbody exenta';
            exentas.name = 'exenta[]';
            exentas.readOnly = true;
            columnexentas.appendChild(exentas);

            const tipo_iva = document.createElement('td');
            const select_iva = document.createElement('select');
            const options1 = document.createElement('option');
            const options2 = document.createElement('option');
            const options3 = document.createElement('option');
            select_iva.classList = 'inputbody tipo_iva';
            select_iva.name = 'tipo_iva[]';
            options1.value = '1';
            options1.textContent = 'I.V.A 5%';
            options2.value = '2';
            options2.selected = true;
            options2.textContent = 'I.V.A 10%';
            options3.value = '3';
            options3.textContent = 'EXCENTO';
            // select_iva.appendChild(options1);
            select_iva.appendChild(options2);
            // select_iva.appendChild(options3);
            tipo_iva.appendChild(select_iva);

            const column5 = document.createElement('td');
            const cincoporciento = document.createElement('input');
            cincoporciento.type = 'text';
            cincoporciento.value = '0';
            cincoporciento.classList = 'inputbody gravada5';
            cincoporciento.name = 'gravada5[]';
            cincoporciento.readOnly = true;
            column5.appendChild(cincoporciento);

            const column10 = document.createElement('td');
            const diezporciento = document.createElement('input');
            diezporciento.type = 'text';
            diezporciento.value = producto.precio;
            diezporciento.classList = 'inputbody gravada10';
            diezporciento.name = 'gravada10[]';
            diezporciento.readOnly = true;
            column10.appendChild(diezporciento);

            newRow.appendChild(columnicondelete);
            newRow.appendChild(columndescripcion);
            newRow.appendChild(columncantidad);
            newRow.appendChild(columnutiraio);
            newRow.appendChild(columndescuento);
            newRow.appendChild(tipo_iva);
            newRow.appendChild(columnexentas);
            newRow.appendChild(column5);
            newRow.appendChild(column10);
            tableBody.appendChild(newRow);

            icondelete.addEventListener('click', () => {
                tableBody.removeChild(newRow);
                calcularTotal();
                calculariva();
            });
        }
    }


});

document.querySelector('tbody').addEventListener('change', (event) => {

    if (event.target.classList.contains('cantidad')) {
        const row = event.target.closest('tr');
        const cantidad = event.target;
        const precio = row.querySelector('.precio');
        const tipo_iva = row.querySelector('.tipo_iva');
        const exenta = row.querySelector('.exenta');
        const gravada5 = row.querySelector('.gravada5');
        const gravada10 = row.querySelector('.gravada10');
        if (tipo_iva.value == 1) {
            gravada5.value = cantidad.value * precio.value;
            gravada10.value = 0;
        } else if (tipo_iva.value == 2) {
            gravada10.value = cantidad.value * precio.value;
            gravada5.value = 0;
        } else if (tipo_iva.value == 3) {
            exenta.value = cantidad.value * precio.value;
            gravada10.value = 0;
            gravada5.value = 0;
        }
        calcularTotal();
        calculariva();
    }
});

//Sección de select 2

$(document).ready(function () {

    $('#nombres').select2({
        placeholder: "Busca por nombre o CI",
        width: '100%',
        theme: 'bootstrap-5'
    });
    $('#nombres').on('select2:select', function (e) {
        let data = e.params.data;
        $.ajax({
            type: 'POST',
            url: '../backend/obtener_datos_cliente.php',
            data: {
                id: data['id']
            },
            success: function (response) {
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
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Error trayendo datos de la base de datos: ", textStatus, errorThrown);
            }
        });
    });
});