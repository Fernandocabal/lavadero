let eyes = document.getElementById('eyes'),
    password = document.getElementById('password'),
    formlogin = document.getElementById('formlogin'),
    usuario = document.getElementById('usuario');
function ver() {
    if (password.type === "password") {
        password.type = "text";
        eyes.classList.add("bx-hide");
        eyes.classList.remove("bx-show");
        password.focus();
    } else {
        password.type = "password";
        eyes.classList.add("bx-show");
        eyes.classList.remove("bx-hide");
        password.focus();
    }
};
function vericarusuario() {
    let value = usuario.value;
    if (value.length === 0) {
        return true;
    } else {
        return false;
    }
}
function vericarpassword() {
    let value = password.value;
    if (value.length === 0) {
        return true;
    } else {
        return false;
    }
}
document.addEventListener("DOMContentLoaded", function () {
    formlogin.addEventListener("submit", function (event) {
        if (vericarusuario()) {
            event.preventDefault();
            usuario.focus();
            Swal.fire({
                icon: "error",
                text: "Favor completa los datos",
            })
            return;
        }
        if (vericarpassword()) {
            event.preventDefault();
            password.focus();
            Swal.fire({
                icon: "error",
                text: "Favor completa los datos",
            })
            return;
        }
        this.submit();


    })
});

eyes.addEventListener("click", ver);
