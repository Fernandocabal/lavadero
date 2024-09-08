let
    spinner = document.getElementById("spinner"),
    hamburicon = document.getElementById("hamburicon"),
    navartop = document.getElementById("top"),
    time = document.getElementById("time"),
    idelete = document.getElementById("idelete");

window.addEventListener("load", function (event) {
    setTimeout(() => {
        spinner.classList.add("ocultar");
    }, 2000);

});
setInterval(() => {
    let date = new Date();
    let datenow = date.toLocaleString();
    time.textContent = datenow
}, 1000);

