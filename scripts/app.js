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

formlogin.addEventListener("submit", function (event) {
    event.preventDefault();
    if (vericarusuario()) {

        usuario.focus();
        Swal.fire({
            icon: "error",
            confirmButtonColor: "#212529",
            confirmButtonText: "Aceptar",
            text: "Favor completa los datos",
        })
        return;
    }
    if (vericarpassword()) {
        password.focus();
        Swal.fire({
            icon: "error",
            confirmButtonColor: "#212529",
            confirmButtonText: "Aceptar",
            text: "Favor completa los datos",
        })
        return;
    }
    // this.submit();
    const formData = new FormData(formlogin);
    fetch('./backend/verificar.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    showConfirmButton: false,
                    text: "Verificando",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    timer: 1500,
                    customClass: {
                        popup: 'custom-swal'
                    },
                    willClose: () => {
                        window.location.href = data.redirect;
                    }
                });
                // window.location.href = data.redirect;
            } else {
                Swal.fire({
                    icon: "warning",
                    confirmButtonColor: "#212529",
                    confirmButtonText: "Aceptar",
                    text: data.message || "Ocurrió un error",
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: "error",
                confirmButtonColor: "#212529",
                confirmButtonText: "Aceptar",
                text: 'Ocurrió un error al enviar los datos',
            });
        });

});


eyes.addEventListener("click", ver);
