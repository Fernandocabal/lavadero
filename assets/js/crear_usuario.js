let form = document.getElementById('form_create_user'),
    input_name = document.getElementById('nombre'),
    user_documento = document.getElementById('documento'),
    usernickname = document.getElementById('usernickname'),
    input_lastname = document.getElementById('apellido'),
    input_password = document.getElementById('password'),
    shufle = document.getElementById('shufle'),
    btn_create_user = document.getElementById('btn_create_user');
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
    input.addEventListener('input', function () {
        let value = this.value.replace(/[^0-9-]/g, '');
        this.value = value;
    });
}
removeSpaces(user_documento);
//funcion para crear nickname a partir del nombre y el apellido
function createnickname(input_name, input_lastname) {
    const firstname = input_name.value.split(' ')[0].toLowerCase();
    const firstlastname = input_lastname.value.split(' ')[0].toLowerCase();
    usernickname.value = firstname + "_" + firstlastname;
}
input_name.addEventListener('input', () => {
    createnickname(input_name, input_lastname);
});
input_lastname.addEventListener('input', () => {
    createnickname(input_name, input_lastname);
});

//Funcion para generar contraseña random
function randompassword() {
    const iconshufle = document.getElementById('iconshufle');
    iconshufle.classList.add('active');
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let password = '';
    for (let i = 0; i < 8; i++) { // Genera una contraseña de 8 caracteres
        const randomIndex = Math.floor(Math.random() * characters.length);
        password += characters[randomIndex];
    }
    input_password.value = password;
    setTimeout(() => {
        iconshufle.classList.remove('active');
    }, 500);
}
shufle.addEventListener('click', randompassword);



