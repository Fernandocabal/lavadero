let form = document.getElementById('change_password'),
    eye_password = document.getElementById("eye_password"),
    new_password = document.getElementById("eye_new_password"),
    confirm_password = document.getElementById("eye_confirm_password"),
    input_new_password = document.getElementById('new_password'),
    btn_change_password = document.getElementById('btn_change_password'),
    input_confirm_password = document.getElementById('confirm_password'),
    select_empresa = document.getElementById('select_nombre_empresa');
function togglePassword(inputId, iconId) {
    const passwordInput = document.getElementById(inputId);
    const icon = document.getElementById(iconId).querySelector('i');

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.add("bx-hide");
        icon.classList.remove("bx-show");

    } else {
        passwordInput.type = "password";
        icon.classList.add("bx-show");
        icon.classList.remove("bx-hide");

    }
    setTimeout(() => {
        passwordInput.focus();
    }, 10);
}
eye_password.addEventListener("click", function () {
    togglePassword("pass-actual", "eye_password");
});

new_password.addEventListener("click", function () {
    togglePassword("new_password", "eye_new_password");
});

confirm_password.addEventListener("click", function () {
    togglePassword("confirm_password", "eye_confirm_password");
});
function passwordactual() {
    const passActual = document.getElementById("pass-actual").value;
    return passActual === "";
}
function confirmPassword() {
    const newpassword = document.getElementById('new_password').value;
    const confirmpass = document.getElementById('confirm_password').value;
    const mjserror = document.getElementById('mensaje_error_password');
    if (newpassword === confirmpass && newpassword !== "") {
        mjserror.innerText = 'Correcto';
        mjserror.classList.add('active', 'text-success');
        mjserror.classList.remove('text-danger');
        return true;
    } else if (newpassword === "" || confirmpass === "") {
        mjserror.innerText = 'Por favor, ingresa y confirma la nueva contraseña';
        mjserror.classList.add('active', 'text-danger');
        mjserror.classList.remove('text-success');
        return false;
    } else {
        mjserror.innerText = '¡Las contraseñas no coinciden!';
        mjserror.classList.add('active', 'text-danger');
        mjserror.classList.remove('text-success');
        return false;
    }
}
function removeSpaces(input) {
    input.addEventListener('input', function () {
        let value = this.value.replace(/\s+/g, ''); // Elimina todos los espacios
        this.value = value;
    });
}
removeSpaces(input_new_password);
removeSpaces(input_confirm_password);
input_confirm_password.addEventListener("keyup", confirmPassword);
//Sección de select 2

$(document).ready(function () {
    $('#select_sucursal').select2({
        placeholder: "Sucursal",
        width: '100%',
        // dropdownCssClass: 'select2-bootstrap-5'
    });
    $('#select_nombre_empresa').select2({
        placeholder: "Selecciones una empresa",
        width: '100%',
        // dropdownCssClass: 'select2-bootstrap-5'
    });
    $('#select_caja').select2({
        placeholder: "Caja",
        width: '100%',
        // dropdownCssClass: 'select2-bootstrap-5'
    });
    $('#select_nombre_empresa').on('select2:select', function (e) {
        let data = e.params.data;
        $.ajax({
            type: 'POST',
            url: '../backend/jsonsucursal.php',
            data: {
                tipo: 'sucursal',
                id: data['id']
            },
            success: function (response) {
                console.log('Respuesta completa del servidor:', response);
                if (response) {
                    console.log('Datos de sucursales:', response.sucursales);
                    populateSucursalSelect(response.sucursales);

                } else {
                    console.error("Respuesta del servidor inválida:", response);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Error trayendo datos de la base de datos: ", textStatus, errorThrown);
            }
        });
    });
    $('#select_sucursal').on('select2:select', function (e) {
        let data = e.params.data;
        $.ajax({
            type: 'POST',
            url: '../backend/jsonsucursal.php',
            data: {
                tipo: 'caja',
                id: data['id']
            },
            success: function (response) {
                let parsedResponse = typeof response === 'string' ? JSON.parse(response) : response;
                console.log('Respuesta de cajas:', parsedResponse.cajas);

                if (parsedResponse && parsedResponse.cajas) {
                    populateCajaSelect(parsedResponse.cajas);
                } else {
                    console.error("No se encontraron cajas.");
                }
            }
        });
    });
    function populateSucursalSelect(data) {
        $('#select_sucursal').empty().select2({
            placeholder: "Seleccione una sucursal",
        });
        if (data && Array.isArray(data) && data.length > 0) {
            data.forEach(item => {
                $('#select_sucursal').append(
                    new Option(item.nombre, item.id_sucursal)
                );
            });
        } else {
            console.warn("No se encontraron datos para las sucursales.");
        }

        $('#select_sucursal').select2({ placeholder: "Seleccione una sucursal" }); // Re-inicializar Select2
    }
    function populateCajaSelect(data) {
        $('#select_caja').empty().select2({
            placeholder: "Seleccione una caja",
        });

        if (data && Array.isArray(data) && data.length > 0) {
            data.forEach(item => {
                $('#select_caja').append(
                    new Option(item.prefijo, item.id_caja)
                );
            });
        } else {
            console.warn("No se encontraron datos para las cajas.");
        }

        $('#select_caja').select2({ placeholder: "Seleccione una caja" });
    }
});
