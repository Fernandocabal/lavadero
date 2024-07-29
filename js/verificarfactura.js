let fechaactual = document.getElementById('fechaactual');
setInterval(() => {
    let date = new Date();
    let datenow = date.toLocaleString();
    fechaactual.textContent = datenow
}, 1000);