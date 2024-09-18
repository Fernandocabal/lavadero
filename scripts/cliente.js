let id_cliente = document.getElementById('id_cliente'),
    name_client_edit = document.getElementById('name_client_edit'),
    lastname_client_edit = document.getElementById('lastname_client_edit'),
    edit_email_client = document.getElementById('edit_email_client'),
    edit_telf_client = document.getElementById('edit_telf_client'),
    edit_direccion_client = document.getElementById('edit_direccion_client'),
    selectciudad = document.getElementById('edit_ciudad_client'),
    nro_docu_edit = document.getElementById('nro_docu_edit'),
    form_edit = document.getElementById('form_edit'),
    forminsertclient = document.getElementById('forminsertclient'),
    inputname = document.getElementById('inputname'),
    inputlastname = document.getElementById('inputlastname'),
    inputdocumento = document.getElementById('inputdocumento'),
    inputemail = document.getElementById("inputemail"),
    inputphone = document.getElementById("inputphone"),
    inputdireccion = document.getElementById("direccion"),
    inputCity = document.getElementById("inputCity"),
    btnregistrar = document.getElementById('insertclient'),
    savedit = document.getElementById('savedit');

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
    const regex = /^[a-zA-Z\u00C0-\u017F\s]{3,24}$/;
    const name = inputname.value;
    if (!regex.test(name)) {
        return true;
    } else {
        return false;
    }
};
function validarci() {
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
    const url = `../backend/jsoncliente.php?action=select&id=${encodeURIComponent(id)}`;
    try {
        const response = await fetch(url, {
            method: 'GET',
        });
        const data = await response.json();
        console.log('Datos recibidos:', data);
        id_cliente.value = data.id_cliente;
        lastname_client_edit.value = data.apellidos;
        name_client_edit.value = data.nombres;
        nro_docu_edit.value = data.nroci;
        edit_direccion_client.value = data.direccion;
        edit_telf_client.value = data.phonenumber;
        edit_email_client.value = data.email;
        const optionValue = data.ciudad;
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
            const url = `../backend/jsoncliente.php?action=delete&id=${encodeURIComponent(id)}`;
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
            Swal.fire({
                title: 'Error!',
                text: 'Ocurrió un error al intentar eliminar el registro.',
                icon: 'error',
                confirmButtonColor: "#212529",
                confirmButtonText: "Aceptar"
            });
        }
    }

}
savedit.addEventListener('click', () => {
    const formData = new FormData(form_edit);
    formData.append('action', 'update');
    fetch('../backend/jsoncliente.php', {
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
                Swal.fire({
                    title: 'Error!',
                    text: data.message || 'No se pudo procesar el registro.',
                    icon: 'error',
                    confirmButtonColor: "#212529",
                    confirmButtonText: "Aceptar"
                });
            }
        }).catch((error) => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Ocurrió un error al intentar procesar el registro.',
                icon: 'error',
                confirmButtonColor: "#212529",
                confirmButtonText: "Aceptar"
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
    if (validarci()) {
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
    const formData = new FormData(forminsertclient);
    formData.append('action', 'insert');
    fetch('../backend/jsoncliente.php', {
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
                    allowEscapeKey: false
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
                    confirmButtonText: "Aceptar"
                });
            }
        }).catch((error) => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Ocurrió un error al intentar procesar el registro.',
                icon: 'error',
                confirmButtonColor: "#212529",
                confirmButtonText: "Aceptar"
            });
        });
})
inputname.addEventListener('keyup', function () {
    if (validarname()) {
        inputname.classList.add("is-invalid");
        inputname.classList.remove("is-valid");
    } else {
        inputname.classList.add("is-valid");
        inputname.classList.remove("is-invalid");
    }
})
inputdocumento.addEventListener('keyup', function () {
    if (validarci()) {
        inputdocumento.classList.add("is-invalid");
        inputdocumento.classList.remove("is-valid");
    } else {
        inputdocumento.classList.add("is-valid");
        inputdocumento.classList.remove("is-invalid");
    }
})

// inputphone.addEventListener('keyup', function () {
//     if (validarphone()) {
//         inputphone.classList.remove("is-invalid");
//         inputphone.classList.add("is-valid");
//     } else {
//         inputphone.classList.remove("is-valid");
//         inputphone.classList.add("is-invalid");
//     }
// })
inputdireccion.addEventListener('keyup', function () {
    if (validardireccion()) {
        inputdireccion.classList.remove("is-valid");
        inputdireccion.classList.add("is-invalid");
    } else {
        inputdireccion.classList.remove("is-invalid");
        inputdireccion.classList.add("is-valid");
    }
})  