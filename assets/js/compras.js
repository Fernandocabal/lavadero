let subtotalTotal = document.getElementById('subtotaltotal'),
    totaloperacion = document.getElementById('totaloperacion'),
    totalguaranies = document.getElementById('totalguaranies'),
    totalfactura = document.getElementById('totalfactura'),
    sendiva = document.getElementById('sendiva'),
    iva10 = document.getElementById('iva10'),
    iva5 = document.getElementById('iva5'),
    totaliva = document.getElementById('totaliva'),
    btnaddrows = document.getElementById('btnplus'),
    bodytable = document.getElementById('bodytable'),
    btndelete = document.getElementById('btndelete'),
    nrofactura = document.getElementById('nrofactura'),
    rucproveedor = document.getElementById('rucproveedor'),
    timbrado = document.getElementById('timbrado');


timbrado.addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
});
nrofactura.addEventListener('input', function () {
    let value = this.value.replace(/[^0-9-]/g, '');
    if (value.length > 3 && value.charAt(3) !== '-') {
        value = value.slice(0, 3) + '-' + value.slice(3);
    }
    if (value.length > 7 && value.charAt(7) !== '-') {
        value = value.slice(0, 7) + '-' + value.slice(7);
    }
    if (value.length > 16) {
        value = value.slice(0, 16);
    }
    this.value = value;
});

btnaddrows.addEventListener('click', () => {
    addrows();
    calcularTotal();
    calculariva();

})
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
    if (event.target.classList.contains('precio')) {
        const row = event.target.closest('tr');
        const precio = event.target;
        const tipo_iva = row.querySelector('.tipo_iva');
        const exenta = row.querySelector('.exenta');
        const gravada5 = row.querySelector('.gravada5');
        const gravada10 = row.querySelector('.gravada10');
        const cantidad = row.querySelector('.cantidad');
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
    if (event.target.classList.contains('tipo_iva')) {
        const row = event.target.closest('tr');
        const tipo_iva = event.target;
        const precio = row.querySelector('.precio');
        const exenta = row.querySelector('.exenta');
        const gravada5 = row.querySelector('.gravada5');
        const gravada10 = row.querySelector('.gravada10');
        const cantidad = row.querySelector('.cantidad');
        if (tipo_iva.value == 1) {
            gravada5.value = cantidad.value * precio.value;
            gravada10.value = 0;
            exenta.value = 0;
        } else if (tipo_iva.value == 2) {
            gravada10.value = cantidad.value * precio.value;
            gravada5.value = 0;
            exenta.value = 0;
        } else if (tipo_iva.value == 3) {
            exenta.value = cantidad.value * precio.value;
            gravada10.value = 0;
            gravada5.value = 0;
        }
        calcularTotal();
        calculariva();
    }
});
function addrows() {
    const table = document.getElementById('table');
    const tableBody = table.querySelector('tbody');

    const newRow = document.createElement('tr');
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
    descripcion.value = '';
    descripcion.name = 'descripcion[]';
    descripcion.classList = 'inputbody';
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
    preciounit.value = '';
    preciounit.name = 'precio_unit[]';
    preciounit.classList = 'inputbody precio';
    columnutiraio.appendChild(preciounit);

    const columndescuento = document.createElement('td');
    const descuento = document.createElement('input');
    descuento.type = 'text';
    descuento.value = '0';
    descuento.classList = 'inputbody';
    descuento.name = 'descuentos[]';
    descuento.readOnly = true;
    columndescuento.appendChild(descuento);

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
    select_iva.appendChild(options1);
    select_iva.appendChild(options2);
    select_iva.appendChild(options3);
    tipo_iva.appendChild(select_iva);

    const columexentas = document.createElement('td');
    const exentas = document.createElement('input');
    exentas.type = 'text';
    exentas.value = '0';
    exentas.classList = 'inputbody exenta';
    exentas.name = 'exenta[]';
    exentas.readOnly = true;
    columexentas.appendChild(exentas);

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
    diezporciento.value = '0';
    diezporciento.classList = 'inputbody gravada10'
    diezporciento.name = 'gravada10[]';
    diezporciento.readOnly = true;
    column10.appendChild(diezporciento);

    newRow.appendChild(columnicondelete);
    newRow.appendChild(columndescripcion);
    newRow.appendChild(columncantidad);
    newRow.appendChild(columnutiraio);
    newRow.appendChild(columndescuento);
    newRow.appendChild(tipo_iva);
    newRow.appendChild(columexentas);
    newRow.appendChild(column5);
    newRow.appendChild(column10);
    tableBody.appendChild(newRow);

    icondelete.addEventListener('click', () => {
        tableBody.removeChild(newRow);
        calcularTotal();
        calculariva();
    });

}
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