let subtotalTotal = document.getElementById('subtotaltotal'),
    totaloperacion = document.getElementById('totaloperacion'),
    totalguaranies = document.getElementById('totalguaranies'),
    totalfactura = document.getElementById('totalfactura'),
    sendiva = document.getElementById('sendiva'),
    iva10 = document.getElementById('iva10'),
    totaliva = document.getElementById('totaliva'),
    btnaddrows = document.getElementById('btnplus'),
    bodytable = document.getElementById('bodytable'),
    btndelete = document.getElementById('btndelete');
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
        const subtotal = row.querySelector('.subtotal');

        if (subtotal && precio) {
            subtotal.value = cantidad.value * precio.value;
        }
        calcularTotal();
        calculariva();
    }
    if (event.target.classList.contains('precio')) {
        const row = event.target.closest('tr');
        const precio = event.target;
        const cantidad = row.querySelector('.cantidad');
        const subtotal = row.querySelector('.subtotal');

        if (subtotal && precio) {
            subtotal.value = cantidad.value * precio.value;
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
    preciounit.name = 'precio[]';
    preciounit.classList = 'inputbody precio';
    columnutiraio.appendChild(preciounit);

    const columndescuento = document.createElement('td');
    const descuento = document.createElement('input');
    descuento.type = 'text';
    descuento.value = '0';
    descuento.classList = 'inputbody';
    descuento.readOnly = true;
    columndescuento.appendChild(descuento);

    const columnexentas = document.createElement('td');
    const exentas = document.createElement('input');
    exentas.type = 'text';
    exentas.value = '0';
    exentas.classList = 'inputbody';
    exentas.readOnly = true;
    columnexentas.appendChild(exentas);

    const column5 = document.createElement('td');
    const cincoporciento = document.createElement('input');
    cincoporciento.type = 'text';
    cincoporciento.value = '0';
    cincoporciento.classList = 'inputbody';
    cincoporciento.readOnly = true;
    column5.appendChild(cincoporciento);

    const column10 = document.createElement('td');
    const diezporciento = document.createElement('input');
    diezporciento.type = 'text';
    diezporciento.value = '';
    diezporciento.classList = 'inputbody subtotal'
    diezporciento.readOnly = true;
    column10.appendChild(diezporciento);

    newRow.appendChild(columnicondelete);
    newRow.appendChild(columndescripcion);
    newRow.appendChild(columncantidad);
    newRow.appendChild(columnutiraio);
    newRow.appendChild(columndescuento);
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
function calcularTotal() {
    let subtotales = document.querySelectorAll('.subtotal');
    let total = 0;

    for (const subtotal of subtotales) {
        total += parseFloat(subtotal.value) || 0;
    }
    subtotalTotal.textContent = total;
    totaloperacion.textContent = total;
    totalguaranies.textContent = total;
    totalfactura.value = total;

}

function calculariva() {
    const valor = totalguaranies.textContent;
    const intvalor = parseInt(valor);
    const iva = intvalor / 11;
    const ivaredondeado = Math.round(iva)
    totaliva.textContent = ivaredondeado;
    iva10.textContent = ivaredondeado;
    sendiva.value = ivaredondeado;
}