let id_proveedor = document.getElementById('id_proveedor'),
    nameproveedor = document.getElementById('nameproveedor'),
    emailproveedor = document.getElementById('emailproveedor'),
    telfproveedor = document.getElementById('telfproveedor'),
    direccion = document.getElementById('edit_direccion_proveedor'),
    selectciudad = document.getElementById('edit_ciudad_proveedor'),
    rucproveedor = document.getElementById('rucproveedor'),
    form_edit = document.getElementById('form_edit'),
    form_insert = document.getElementById('form_insert'),
    inputname = document.getElementById('inputname'),
    inputdocumento = document.getElementById('inputdocumento'),
    inputemail = document.getElementById("inputemail"),
    inputphone = document.getElementById("inputphone"),
    inputdireccion = document.getElementById("direccion"),
    inputCity = document.getElementById("inputCity"),
    btnregistrar = document.getElementById('insertclient'),
    savedit = document.getElementById('savedit');

inputdocumento.addEventListener('input', function () {
    let value = this.value.replace(/[^0-9-]/g, '');
    this.value = value;
});
rucproveedor.addEventListener('input', function () {
    let value = this.value.replace(/[^0-9-]/g, '');
    this.value = value;
});
inputphone.addEventListener('input', function () {
    let value = this.value.replace(/[^0-9+]/g, '');
    this.value = value;
})

function validardireccion() {
    const regex = /^[a-zA-Z\u00C0-\u017F\p{L}0-9\s\p]{3,30}$/;
    const name = inputdireccion.value;
    if (!regex.test(name)) {
        return true;
    } else {
        return false;
    }
};
function validarname() {
    const regex = /^[a-zA-Z\u00C0-\u017F\s.,]{3,24}$/;
    const name = inputname.value;
    if (!regex.test(name)) {
        return true;
    } else {
        return false;
    }
};
function validar_ruc() {
    let rucvalue = inputdocumento.value,
        expre = /^\d{5,9}[-]?\d{1}/;
    if (!expre.test(rucvalue)) {
        return true;
    } else {
        return false;
    }
}
function validarcorreo() {
    const correx = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    const correo = inputemail.value;
    if (!correx.test(correo)) {
        return false;
    } else {
        return true;
    }
}
function validarphone() {
    const regex = /^\+?[0-9]{10}$/;
    const name = inputphone.value;
    if (!regex.test(name)) {
        return false;
    } else {
        return true;
    }
};
function validarciudad() {
    if (inputCity.selectedIndex === 0) {
        return true;
    } else {
        return false;
    }
};
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
        confirmButtonText: "Si eliminar",
        customClass: {
            popup: 'custom-swal'
        },
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
                    allowEscapeKey: false,
                    customClass: {
                        popup: 'custom-swal'
                    },
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
                    confirmButtonText: "Aceptar",
                    customClass: {
                        popup: 'custom-swal'
                    },
                });
            }
        } catch (error) {
            console.error('Error al realizar la solicitud:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Ocurrió un error al intentar eliminar el registro.',
                icon: 'error',
                confirmButtonColor: "#212529",
                confirmButtonText: "Aceptar",
                customClass: {
                    popup: 'custom-swal'
                },
            });
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
                    allowEscapeKey: false,
                    customClass: {
                        popup: 'custom-swal'
                    },
                }).then(result => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message || 'No se pudo procesar el registro.',
                    icon: 'error',
                    confirmButtonColor: "#212529",
                    confirmButtonText: "Aceptar",
                    customClass: {
                        popup: 'custom-swal'
                    },
                });
            }
        }).catch((error) => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Ocurrió un error al intentar procesar el registro.',
                icon: 'error',
                confirmButtonColor: "#212529",
                confirmButtonText: "Aceptar",
                customClass: {
                    popup: 'custom-swal'
                },
            });
        });
});
btnregistrar.addEventListener('click', () => {
    if (validarname()) {
        inputname.classList.add("is-invalid");
        inputname.classList.remove("is-valid");
        inputname.focus();
        return;
    }
    if (validar_ruc()) {
        inputdocumento.classList.remove("is-valid");
        inputdocumento.classList.add("is-invalid");
        inputdocumento.focus();
        return;
    }
    if (validardireccion()) {
        inputdireccion.classList.remove("is-valid");
        inputdireccion.classList.add("is-invalid");
        inputdireccion.focus();
        return;
    }
    if (validarciudad()) {
        inputCity.classList.remove("is-valid");
        inputCity.classList.add("is-invalid");
        inputCity.focus();
        return;
    }
    const formData = new FormData(form_insert);
    formData.append('action', 'insert');
    fetch('../backend/jsonproveedor.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Registrado',
                    text: 'Datos guardados correctamente',
                    icon: 'success',
                    confirmButtonColor: "#212529",
                    confirmButtonText: "Aceptar",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    customClass: {
                        popup: 'custom-swal'
                    },
                }).then(result => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message || 'No se pudo procesar el registro.',
                    icon: 'error',
                    confirmButtonColor: "#212529",
                    confirmButtonText: "Aceptar",
                    customClass: {
                        popup: 'custom-swal'
                    },
                });
            }
        }).catch((error) => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Ocurrió un error al intentar procesar el registro.',
                icon: 'error',
                confirmButtonColor: "#212529",
                confirmButtonText: "Aceptar",
                customClass: {
                    popup: 'custom-swal'
                },
            });
        });
})