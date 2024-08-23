let subtotalTotal = document.getElementById('subtotaltotal'),
    totaloperacion = document.getElementById('totaloperacion'),
    totalguaranies = document.getElementById('totalguaranies'),
    totalfactura = document.getElementById('totalfactura'),
    sendiva = document.getElementById('sendiva'),
    iva10 = document.getElementById('iva10'),
    totaliva = document.getElementById('totaliva'),
    btnaddservice = document.getElementById('addservice'),
    formfactura = document.getElementById('formfactura'),
    btninsertfactura = document.getElementById('insertfactura'),
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
    totalfactura.value = total;

}

function calculariva() {
    let valor = totalguaranies.textContent;
    const intvalor = parseInt(valor);
    const iva = intvalor / 11;
    const ivaredondeado = Math.round(iva)
    totaliva.textContent = ivaredondeado;
    iva10.textContent = ivaredondeado;
    sendiva.value = ivaredondeado;
}
btninsertfactura.addEventListener('click', (evento) => {
    evento.preventDefault();
    const nroci = document.getElementById('nroci');
    if (nroci.value == 0) {
        Swal.fire({
            title: '¡Atención!',
            icon: 'warning',
            text: 'Por favor selecciona un cliente',
            confirmButtonText: 'Aceptar'
        });
        nroci.focus();
    } else {
        const formData = new FormData(formfactura);
        fetch('../action/insertfactura.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(result => {
                        if (result.isConfirmed) {
                            window.location.href = `../componetes/facturafpdf.php?id=${data.id}`;
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: error,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            });
    }
});

btnaddservice.addEventListener('click', (e) => {
    e.preventDefault();
    const valueselect = document.getElementById('selectservice').value;
    const xhr = new XMLHttpRequest();

    xhr.open('POST', '../componetes/datos_productos.php', true);

    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Crear los datos a enviar
    const data = `idproducto=${valueselect}`;

    xhr.onload = function () {
        if (xhr.status === 200) {
            // La solicitud fue exitosa
            const cliente = JSON.parse(xhr.responseText);
            crearFilaTabla(cliente);
            console.log(xhr.responseText);
        } else {

            console.error('Error al realizar la solicitud:', xhr.statusText);
        }
    };
    xhr.send(data);

    function crearFilaTabla(cliente) {


        const table = document.getElementById('table');
        const tableBody = table.querySelector('tbody');

        const newRow = document.createElement('tr');

        const columndescripcion = document.createElement('td');
        const descripcion = document.createElement('input');
        descripcion.type = 'text';
        descripcion.value = cliente.producto || "No se encontró descripción";
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
        preciounit.value = cliente.precio;
        preciounit.name = 'precio[]';
        preciounit.classList = 'inputbody precio'
        columnutiraio.appendChild(preciounit);

        const columndescuento = document.createElement('td');
        const descuento = document.createElement('input');
        descuento.type = 'text';
        descuento.value = 'HOLAS';
        descuento.classList = 'inputbody'
        columndescuento.appendChild(descuento);

        const columnexentas = document.createElement('td');
        const exentas = document.createElement('input');
        exentas.type = 'text';
        exentas.value = 'HOLAS';
        exentas.classList = 'inputbody'
        columnexentas.appendChild(exentas);

        const column5 = document.createElement('td');
        const cincoporciento = document.createElement('input');
        cincoporciento.type = 'text';
        cincoporciento.value = 'HOLAS';
        cincoporciento.classList = 'inputbody'
        column5.appendChild(cincoporciento);

        const column10 = document.createElement('td');
        const diezporciento = document.createElement('input');
        diezporciento.type = 'text';
        diezporciento.value = cliente.precio;
        diezporciento.classList = 'inputbody subtotal'
        diezporciento.readOnly = true;
        column10.appendChild(diezporciento);

        newRow.appendChild(columndescripcion);
        newRow.appendChild(columncantidad);
        newRow.appendChild(columnutiraio);
        newRow.appendChild(columndescuento);
        newRow.appendChild(columnexentas);
        newRow.appendChild(column5);
        newRow.appendChild(column10);
        tableBody.appendChild(newRow);
    }
});

// Delegar el evento a un elemento padre común
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
});

//Sección de select 2

$(document).ready(function () {

    $('#nombres').select2({
        placeholder: "Busca por nombre o CI",
        width: '100%'
    });
    $('#nombres').on('select2:select', function (e) {
        let data = e.params.data;
        $.ajax({
            type: 'POST',
            url: '../componetes/obtener_datos_cliente.php',
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