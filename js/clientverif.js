let inputname = document.getElementById('inputname'),
    inputlastname = document.getElementById('inputlastname'),
    inputdocumento = document.getElementById('inputdocumento'),
    inputemail = document.getElementById("inputemail"),
    inputphone = document.getElementById("inputphone"),
    inputdireccion = document.getElementById("direccion"),
    inputCity = document.getElementById("inputCity"),
    btnregistrar = document.getElementById("insertclient"),
    forminsertclient = document.getElementById("forminsertclient"),
    form_edit_client = document.getElementById("form_edit_client");

function validardireccion() {
    const regex = /^[a-zA-Z\u00C0-\u017F\p{L}0-9\s\p]{3,24}$/;
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
    let cilargor = inputdocumento.value.length,
        civalor = inputdocumento.value,
        expre = /^\d{5,9}[-]?\d{1}/;
    if (!expre.test(civalor)) {
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

document.addEventListener("DOMContentLoaded", function () {

    forminsertclient.addEventListener("submit", function (evento) {

        if (validarname()) {
            evento.preventDefault();
            inputname.classList.add("is-invalid");
            inputname.classList.remove("is-valid");
            inputname.focus();
            return;
        }
        if (validarci()) {
            evento.preventDefault();
            inputdocumento.classList.remove("is-valid");
            inputdocumento.classList.add("is-invalid");
            inputdocumento.focus();
            return;
        }
        if (validardireccion()) {
            evento.preventDefault();
            inputdireccion.classList.remove("is-valid");
            inputdireccion.classList.add("is-invalid");
            inputdireccion.focus();
            return;
        }
        if (validarciudad()) {
            evento.preventDefault();
            inputCity.classList.remove("is-valid");
            inputCity.classList.add("is-invalid");
            inputCity.focus();
            return;
        }
        this.submit();

    })
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


