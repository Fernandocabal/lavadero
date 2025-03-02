let spinner = document.getElementById("spinner"),
    hamburicon = document.getElementById("hamburicon"),
    navartop = document.getElementById("top"),
    time = document.getElementById("time"),
    idelete = document.getElementById("idelete");

if (!sessionStorage.getItem("spinnerShown")) {
    window.addEventListener("load", function () {
        setTimeout(() => {
            spinner.classList.add("ocultar");
            sessionStorage.setItem("spinnerShown", "true");
        }, 2000);
    });
} else {
    spinner.classList.add("ocultar");
}

// Actualizar el reloj cada segundo
setInterval(() => {
    let date = new Date();
    let datenow = date.toLocaleString();
    time.textContent = datenow;
}, 1000);


