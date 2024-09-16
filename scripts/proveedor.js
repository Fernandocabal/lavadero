let id_proveedor = document.getElementById('id_proveedor'),
    nameproveedor = document.getElementById('nameproveedor'),
    emailproveedor = document.getElementById('emailproveedor'),
    telfproveedor = document.getElementById('telfproveedor'),
    direccion = document.getElementById('edit_direccion_proveedor'),
    selectciudad = document.getElementById('edit_ciudad_proveedor'),
    rucproveedor = document.getElementById('rucproveedor'),
    form_edit = document.getElementById('form_edit'),
    savedit = document.getElementById('savedit');
async function get(id) {
    const url = `../backend/jsonproveedor.php?action=select&id=${encodeURIComponent(id)}`;
    try {
        const response = await fetch(url, {
            method: 'GET',
        });
        const data = await response.json();
        console.log('Datos recibidos:', data);
        id_proveedor.value = data.id_proveedor
        nameproveedor.value = data.nombre_proveedor;
        rucproveedor.value = data.ruc_proveedor;
        direccion.value = data.direccion_proveedor;
        telfproveedor.value = data.tel_proveedor;
        emailproveedor.value = data.email_proveedor;
        const optionValue = data.id_ciudad;
        for (let i = 0; i < selectciudad.options.length; i++) {
            const option = selectciudad.options[i];
            if (option.value == optionValue) {
                option.selected = true;
                break;
            }
        }
        return data;
    } catch (error) {
        console.error('Error al realizar la solicitud:', error);
        return null;
    }
}
async function borrar(id) {
    const result = await Swal.fire({
        title: "Desea Eliminar este proveedor?",
        text: "No los podrá recuperar",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#212529",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Si eliminar"
    });

    if (result.isConfirmed) {
        try {
            const url = `../backend/jsonproveedor.php?action=delete&id=${encodeURIComponent(id)}`;
            const response = await fetch(url, {
                method: 'GET',
            });
            const data = await response.json();
            if (data.success) {
                Swal.fire({
                    title: 'Eliminado!',
                    text: 'El registro ha sido eliminado.',
                    icon: 'success',
                    confirmButtonColor: "#212529",
                    confirmButtonText: "Aceptar",
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(result => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });

            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'No se ha podido eliminar el registro',
                    icon: 'error',
                    confirmButtonColor: "#212529",
                    confirmButtonText: "Aceptar"
                });
            }
        } catch (error) {
            console.error('Error al realizar la solicitud:', error);
            Swal.fire(
                'Error!',
                'Ocurrió un error al intentar eliminar el registro.',
                'error'
            );
        }
    }

}
savedit.addEventListener('click', () => {
    const formData = new FormData(form_edit);
    formData.append('action', 'update');
    fetch('../backend/jsonproveedor.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Actualizado',
                    text: 'Datos guardados correctamente',
                    icon: 'success',
                    confirmButtonColor: "#212529",
                    confirmButtonText: "Aceptar",
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(result => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
            } else {
                Swal.fire(
                    'Error!',
                    data.message || 'No se pudo procesar el registro.',
                    'error'
                );
            }
        }).catch((error) => {
            console.error('Error:', error);
            Swal.fire(
                'Error!',
                'Ocurrió un error al intentar procesar el registro.',
                'error'
            );
        });
});