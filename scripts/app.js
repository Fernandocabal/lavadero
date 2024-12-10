let eyes = document.getElementById('eyes'),
    password = document.getElementById('password'),
    formlogin = document.getElementById('formlogin'),
    usuario = document.getElementById('usuario');
//Paracompletar el campo de usuario con el último username logeado
window.onload = function () {
    var lastUser = localStorage.getItem('last_user');
    if (lastUser) {
        document.getElementById('usuario').value = lastUser;
    }
};
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
    var username = document.getElementById('usuario').value;
    localStorage.setItem('last_user', username);    //Paracompletar el campo de usuario con el último username logeado
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
    const formData = new FormData(formlogin);
    fetch('./backend/login.php', {
        method: 'POST',
        body: formData,
    })
        // .then(response => {
        //     return response.text(); // Cambiar a text() para ver la respuesta completa
        // })
        // .then(data => {
        //     console.log(data); // Mostrar la respuesta completa en la consola
        //     try {
        //         const jsonData = JSON.parse(data); // Intentar parsear a JSON
        //         // Procesar jsonData aquí
        //     } catch (error) {
        //         console.error('Error al parsear JSON:', error);
        //     }
        // })
        // .catch(error => {
        //     console.error('Error en la petición:', error);
        // });
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
