let form = document.getElementById('change_password'),
    eye_password = document.getElementById("eye_password"),
    new_password = document.getElementById("eye_new_password"),
    confirm_password = document.getElementById("eye_confirm_password"),
    input_new_password = document.getElementById('new_password'),
    btn_change_password = document.getElementById('btn_change_password'),
    input_confirm_password = document.getElementById('confirm_password'),
    btn_change_empresa = document.getElementById('btn_change_empresa');
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
