let form = document.getElementById('change_password'),
    eye_password = document.getElementById("eye_password"),
    new_password = document.getElementById("eye_new_password"),
    confirm_password = document.getElementById("eye_confirm_password"),
    input_new_password = document.getElementById('new_password'),
    btn_change_password = document.getElementById('btn_change_password'),
    input_confirm_password = document.getElementById('confirm_password');
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

btn_change_password.addEventListener("click", function (event) {
    event.preventDefault();
    const passActual = document.getElementById("pass-actual");
    if (passwordactual()) {
        passActual.focus();
        Swal.fire({
            icon: "warning",
            confirmButtonColor: "#212529",
            confirmButtonText: "Aceptar",
            text: "Ingresa tu contraseña actual",
            customClass: {
                popup: 'custom-swal'
            },
        })
        return;
    }
    if (!confirmPassword()) {
        Swal.fire({
            icon: "warning",
            confirmButtonColor: "#212529",
            confirmButtonText: "Aceptar",
            text: "Verifica tu nueva contraseña",
            customClass: {
                popup: 'custom-swal'
            },
        })
        return;
    }
    Swal.fire({
        showConfirmButton: false,
        text: "Procesando",
        allowOutsideClick: false,
        allowEscapeKey: false,
        timer: 1500,
        customClass: {
            popup: 'custom-swal'
        },
    });
    const formData = new FormData(form);
    fetch('../backend/changepassword.php', {
        method: 'POST',
        body: formData,
    })
        //PARA DEPURACIÓN
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
                    icon: "success",
                    confirmButtonColor: "#212529",
                    confirmButtonText: "Aceptar",
                    text: data.message || "Excelente",
                    customClass: {
                        popup: 'custom-swal'
                    },
                    willClose: () => {
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: "warning",
                    confirmButtonColor: "#212529",
                    confirmButtonText: "Aceptar",
                    text: data.message || "Ocurrió un error",
                    customClass: {
                        popup: 'custom-swal'
                    },
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
                customClass: {
                    popup: 'custom-swal'
                },
            });
        });

});