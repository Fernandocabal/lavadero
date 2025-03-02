let form = document.getElementById('form_create_user'),
    input_name = document.getElementById('nombre'),
    user_documento = document.getElementById('documento'),
    usernickname = document.getElementById('usernickname'),
    input_lastname = document.getElementById('apellido'),
    input_password = document.getElementById('password'),
    inputemail = document.getElementById('inputemail'),
    shufle = document.getElementById('shufle'),
    input_empresa = document.getElementById('select_nombre_empresa'),
    input_sucursal = document.getElementById('select_sucursal'),
    input_caja = document.getElementById('select_caja'),
    btn_create_user = document.getElementById('btn_create_user'),
    modal_registrar = new bootstrap.Modal(document.getElementById('modal_registrar')),
    modal_verificar = new bootstrap.Modal(document.getElementById('modal_verificar'));

//funcion para no permitir numeros en el nombre y apellido
function removeNonLetters(input) {
    input.addEventListener('keyup', function () {
        let value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ ]/g, '');
        value = value.replace(/^ /, '');
        this.value = value;
    });
}
removeNonLetters(input_name);
removeNonLetters(input_lastname);

//funcion para no permitir letras en el numero de documento
function removeSpaces(input) {
    input.addEventListener('keyup', function () {
        let value = this.value.replace(/[^0-9-]/g, '');
        this.value = value;
    });
}
removeSpaces(user_documento);

//funcion para crear nickname a partir del nombre y el apellido
function normalizeText(text) {
    return text.normalize("NFD").replace(/[\u0300-\u036f]/g, "").replace(/[^a-zA-Z]/g, "");
}
function createnickname(input_name, input_lastname) {
    const firstname = normalizeText(input_name.value.split(' ')[0].toLowerCase());
    const firstlastname = normalizeText(input_lastname.value.split(' ')[0].toLowerCase());
    usernickname.value = firstname + "_" + firstlastname;
}

//Funcion para generar contraseña random
function randompassword() {
    const iconshufle = document.getElementById('iconshufle');
    iconshufle.classList.add('active');
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789#$%&/()?@';
    let password = '';
    for (let i = 0; i < 16; i++) { // Genera una contraseña de 16 caracteres
        const randomIndex = Math.floor(Math.random() * characters.length);
        password += characters[randomIndex];
    }
    input_password.value = password;

    const event = new Event('input'); // Crea el evento input
    input_password.dispatchEvent(event); // Dispara el evento en el campo
    setTimeout(() => {
        iconshufle.classList.remove('active');
    }, 500);
}
shufle.addEventListener('click', randompassword);

btn_create_user.addEventListener('click', () => {
    const nombreValido = validarCampo(input_name, 3);
    const apellidoValido = validarCampo(input_lastname, 3);
    const emailvalido = validarEmail(inputemail);
    const documentovalido = validardocumento(user_documento, 3);
    const passwordvalido = validarpassword(input_password, 5);
    const empresavalido = validarselectempresa(input_empresa, 1);
    const sucursalvalido = validarselectempresa(input_sucursal, 1);
    const cajavalido = validarselectempresa(input_caja, 1);
    if (nombreValido && apellidoValido && emailvalido && documentovalido && passwordvalido && empresavalido && sucursalvalido && cajavalido) {
        const modalnombre = document.getElementById('modalnombre');
        const modalapellido = document.getElementById('modalapellido');
        const modalnick = document.getElementById('modalnick');
        const modaldocumento = document.getElementById('modaldocumento');
        const modalemail = document.getElementById('modalemail');
        const modalpass = document.getElementById('modalpass');
        const select_modalempresa = document.getElementById('select_modalempresa');
        const select_modalsucursal = document.getElementById('select_modalsucursal');
        const select_modalcaja = document.getElementById('select_modalcaja');
        const textoSeleccionadoEmpresa = input_empresa.options[input_empresa.selectedIndex].text;
        const textoSeleccionadoSucursal = input_sucursal.options[input_sucursal.selectedIndex].text;
        const textoSeleccionadoCaja = input_caja.options[input_caja.selectedIndex].text;
        modal_verificar.show();
        modal_registrar.hide();
        modalnombre.value = input_name.value;
        modalapellido.value = input_lastname.value;
        modalnick.value = usernickname.value;
        modaldocumento.value = user_documento.value;
        modalemail.value = inputemail.value;
        modalpass.value = input_password.value;
        select_modalempresa.value = textoSeleccionadoEmpresa;
        select_modalsucursal.value = textoSeleccionadoSucursal;
        select_modalcaja.value = textoSeleccionadoCaja;
    }
});
function validarCampo(campo, minLength) {
    if (campo.value.trim().length >= minLength) {
        campo.classList.remove('is-invalid');
        campo.classList.add('is-valid');
        btn_create_user.disabled = false;
        return true;
    } else {
        campo.classList.remove('is-valid');
        campo.classList.add('is-invalid');
        btn_create_user.disabled = true;
        return false;
    }
}
// Validar Documento
function validardocumento(campo, minLength) {
    if (campo.value.trim().length >= minLength) {
        campo.classList.remove('is-invalid');
        campo.classList.add('is-valid');
        btn_create_user.disabled = false;
        return true;

    } else {
        campo.classList.remove('is-valid');
        campo.classList.add('is-invalid');
        btn_create_user.disabled = true;
        return false;
    }
};
// Función para validar un email
function validarEmail(campo) {

    const valorEmail = campo.value.trim();

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;// Expresión regular para validar email
    if (emailRegex.test(valorEmail)) {
        campo.classList.remove('is-invalid');
        campo.classList.add('is-valid');
        btn_create_user.disabled = false;
        return true;
    } else {
        campo.classList.remove('is-valid');
        campo.classList.add('is-invalid');
        btn_create_user.disabled = true;
        return false;
    }
}
//validar contraseña
function validarpassword(campo, minLength) {
    if (campo.value.trim().length >= minLength) {
        campo.classList.remove('is-invalid');
        campo.classList.add('is-valid');
        btn_create_user.disabled = false;
        return true;

    } else {
        campo.classList.remove('is-valid');
        campo.classList.add('is-invalid');
        btn_create_user.disabled = true;
        return false;
    }
}
function validarselectempresa(selectElement, minLength) {
    const selectedValue = selectElement.value.trim();

    // Si el valor seleccionado no es vacío o es diferente del valor por defecto
    if (selectedValue.length >= minLength && selectedValue !== "") {
        selectElement.classList.remove('is-invalid');
        selectElement.classList.add('is-valid');
        btn_create_user.disabled = false; // Habilitar el botón si la validación es correcta
        return true;
    } else {
        selectElement.classList.remove('is-valid');
        selectElement.classList.add('is-invalid');
        btn_create_user.disabled = true; // Deshabilitar el botón si la validación falla
        return false;
    }

}

input_name.addEventListener('input', () => {
    createnickname(input_name, input_lastname);
    validarCampo(input_name, 3);
});
input_lastname.addEventListener('input', () => {
    createnickname(input_name, input_lastname);
    validarCampo(input_lastname, 3);
});
inputemail.addEventListener('input', () => {
    validarEmail(inputemail);

});
user_documento.addEventListener('input', () => {
    validardocumento(user_documento, 3);
})
input_password.addEventListener('input', () => {
    validarpassword(input_password, 5);
})
input_empresa.addEventListener('change', () => {
    validarselectempresa(input_empresa, 1);
})
input_sucursal.addEventListener('change', () => {
    validarselectempresa(input_sucursal, 1);
})
input_caja.addEventListener('change', () => {
    validarselectempresa(input_caja, 1);
})